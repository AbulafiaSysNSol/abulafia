<?php

	//$annoprotocollo = $_SESSION['annoprotocollo'];
	$risultatiperpagina = $_SESSION['risultatiperpagina']; //acquisisce la variabile di sessione che stabilisce quanti risultati vengono mostrati in ogni pagina
	$currentpage = $_GET['currentpage'];
	$my_calendario = new Calendario();

	// se non settate da una form di invio, le seguenti variabili prendono valore da GET o da SESSION
	if (!isset($_POST['cercato'])) {
		$_POST['cercato'] = $_GET['cercato'];
	} 
	if (!isset($_POST['ordinerisultati'])) {
		$_POST['ordinerisultati'] = "anagrafica";
	}
	if (!isset($_POST['tabella'])) {
		$_POST['tabella'] = $_GET['tabella'];
	}
	if (isset($_POST['annoricercaprotocollo'])) {
		$annoricercaprotocollo = $_POST['annoricercaprotocollo'];
		$_SESSION['annoricercaprotocollo'] = $_POST['annoricercaprotocollo'];
	}
	if (!isset($_POST['annoricercaprotocollo'])) {
		$annoricercaprotocollo = $_SESSION['annoricercaprotocollo'];
	}
	if (!isset($_POST['anagraficatipologia'])) {
		if (isset($_GET['anagraficatipologia'])) {
			$_POST['anagraficatipologia']= $_GET['anagraficatipologia'];
		}
	}
	if (isset($_POST['anagraficatipologia'])) {
		$filtro = $_POST['anagraficatipologia'];
	}
	
	//filtri aggiuntivi
	$sped = '';
	$pos = '';
	$prat = '';
	$dataricercadb = "";
	if(isset($_POST['speditaricevuta'])) {
		$speditaricevuta = $_POST['speditaricevuta'];
		if($speditaricevuta == "") {
			$sped = '';
		}
		if($speditaricevuta == "sped") {
			$sped = " AND speditaricevuta = 'spedita' ";
		}
		if($speditaricevuta == "ric") {
			$sped = " AND speditaricevuta = 'ricevuta' ";
		}
	}
	if(isset($_POST['posizione'])) {
		$posizione = $_POST['posizione'];
		if($posizione == "") {
			$pos = '';
		}
		else {
			$pos = " AND riferimento = '$posizione' ";
		}
	}
	if(isset($_POST['pratica'])) {
		$pratica = $_POST['pratica'];
		if($pratica == "") {
			$prat = '';
		}
		else {
			$prat = " AND pratica = '$pratica' ";
		}
	}
	if( (isset($_POST['data1'])) && ($_POST['data1'] != "") && ($_POST['data2'] != "") ) {
		$data1 = $_POST['data1'];
		$data2 = $_POST['data2'];
		$datainizio = $my_calendario->dataDB($data1);
		$datafine = $my_calendario->dataDB($data2);
		$dataricercadb = " AND dataregistrazione BETWEEN '$datainizio' AND '$datafine' ";
	}
	else {
		$dataricercadb = "";
	}
	
	$ordinerisultati = $_POST['ordinerisultati'];
	$cercato = $_POST['cercato']; //parola chiave da ricercare
	$nomecercato = NULL;

	$tabella = $_POST['tabella'];
	
	if(isset($_POST['group1'])) { 
		$ordinerisultati= $_POST['group1'];
	}
	else {
		$ordinerisultati ='';
	}

	//scelta fra ricerca in anagrafica e protocollo

	//scelta 'anagrafica'
	if ($tabella == 'anagrafica') {
	
		if ($cercato != '') {
			if ( substr_count($cercato, "+") > 0) {
				list($cognomecercato, $nomecercato) = explode("+", $cercato);
			}
		}
	
		if ($ordinerisultati == 'alfabetico') { 
			$_SESSION['ordinerisultati'] = 'order by anagrafica.cognome, anagrafica.nome';
		}
		if ($ordinerisultati == 'cronologico') { 
			$_SESSION['ordinerisultati'] = 'order by anagrafica.idanagrafica';
		}
		if ($ordinerisultati == 'cron-inverso') { 
			$_SESSION['ordinerisultati'] = 'order by anagrafica.idanagrafica desc';
		}

		if ($filtro == 'anagrafica.tipologia') {
			if($nomecercato != NULL) { 
				$count = mysql_query(	"SELECT COUNT(*) 
								FROM anagrafica 
								where (anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.cognome ='$cognomecercato' 
								and anagrafica.nome='$nomecercato'))
								"); //conteggio per divisione in pagine dei risultati
    			}
			else {
				$count = mysql_query(	"SELECT COUNT(*) 
								FROM anagrafica 
								where (anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%')
								"); //conteggio per divisione in pagine dei risultati
			}
		}
		else {
			if($nomecercato != NULL) { 
				$count = mysql_query(	"SELECT COUNT(*) 
								FROM anagrafica
								where ((anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.nome='$nomecercato' 
								and anagrafica.cognome='$cognomecercato')) 
								and (anagrafica.tipologia='$filtro'))
								");//conteggio per divisione in pagine dei risultati
    			}
			else {
				$count = mysql_query(	"SELECT COUNT(*) 
								FROM anagrafica
								where ((anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%') 
								and (anagrafica.tipologia='$filtro'))
								");//conteggio per divisione in pagine dei risultati
    			}
		}

		
		$res_count = mysql_fetch_row($count);//conteggio per divisione in pagine dei risultati
		$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
		$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati la frazione arrotondata per eccesso
		$iniziorisultati = $_GET['iniziorisultati'];
		$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
		$ordinerisultati=$_SESSION['ordinerisultati']; //acquisisce la scelta fra ordine alfabetico cronologico o cronologico inverso nella presentazione dei risultati

		if($filtro == 'anagrafica.tipologia') {  //se la ricerca in anagrafica è su 'nessun filtro'	
			if($nomecercato != NULL) { 
				$risultati= mysql_query("select distinct * 
								FROM anagrafica 
								where (anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.nome='$nomecercato' 
								and anagrafica.cognome='$cognomecercato')) 
								$ordinerisultati limit $iniziorisultati , $risultatiperpagina 
								");
    			}
			else {
				$risultati= mysql_query("select distinct * 
								FROM anagrafica 
								where (anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%') 
								$ordinerisultati limit $iniziorisultati , $risultatiperpagina 
								");
    			}
		}
		else { //se la ricerca in anagrafica è impostata con un qualche filtro per tipologia
			if($nomecercato != NULL) { 
				$risultati= mysql_query("select distinct * 
								FROM anagrafica $joinanagraficagruppo 
								where ((anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.nome='$nomecercato' 
								and anagrafica.cognome='$cognomecercato')) 
								and (anagrafica.tipologia='$filtro')) 
								$ordinerisultati 
								limit $iniziorisultati , $risultatiperpagina 
								");
    			}
			else {
				$risultati= mysql_query("select distinct * 
								FROM anagrafica
								where ((anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%') 
								and (anagrafica.tipologia='$filtro')) 
								$ordinerisultati 
								limit $iniziorisultati , $risultatiperpagina 
								");
    			}
		}

	
		$num_righe = mysql_num_rows($risultati);
		$my_log -> publscrivilog( $_SESSION['loginname'], 'EFFETTUATA RICERCA IN ANAGRAFICA' , 'OK' , 'VALORE CERCATO '.$cercato, $_SESSION['historylog']);
		if  ($num_righe > 0) {
			echo "Numero di risultati trovati: <b>$tot_records</b><br>"; 
			?>
			<ul class="pagination">
			<?php
			
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage= $currentpage - 1;
				?> 
				<li>
					<a href="login0.php?corpus=risultati
					&iniziorisultati=<?php echo $paginaprecedente ;?>
					&cercato=<?php echo $cercato; ?>
					&tabella=<?php echo $tabella; ?>
					&currentpage=<?php  echo $previouspage; ?>
					&anagraficatipologia=<?php echo $filtro; ?>">
					&laquo;
					</a>
				</li>
				<?php 
			} 
			
			$i = 0;
			do {
				$pagina = $i * $risultatiperpagina;
				$currentpage = $_GET['currentpage'];
				?>
				<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $pagina; ?>&cercato=<?php echo $cercato; ?>&tabella=<?php echo $tabella; ?>&currentpage=<?php  echo $i+1; ?>&anagraficatipologia=<?php echo $filtro; ?>"><?php echo $i+1 ?></a></li>
				<?php
				$i++;
			} while ($i < $tot_pages);

			if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
				$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
				$nextpage= $currentpage + 1;
				?> 
				<li>
					<a href="login0.php?corpus=risultati
					&iniziorisultati=<?php  echo $paginasuccessiva; ?>
					&cercato=<?php echo $cercato; ?>
					&tabella=<?php echo $tabella; ?>
					&currentpage=<?php  echo $nextpage; ?>
					&anagraficatipologia=<?php echo $filtro; ?>">
					&raquo;
					</a>
				</li>
				<?php 
			}
			?>
			</ul>
			
			<br>
			
			<table class="table table-bordered">
				<tr>
					<td style="vertical-align: middle" align="center"><b>Id</b></td>
					<td style="vertical-align: middle" align="center"><b>Tipo</b></td>
					<td style="vertical-align: middle" align="center"><b>Cognome</b></td>
					<td style="vertical-align: middle" align="center"><b>Nome</b></td>
					<td style="vertical-align: middle" align="center"><b>Data di Nascita</b></td>
					<td style="vertical-align: middle" align="center"><b>Comune</b></td>
					<td style="vertical-align: middle" align="center"><b>Prov.</b></td>
					<td style="vertical-align: middle" align="center"><b>Codice Fiscale</b></td>
					<td width="150" style="vertical-align: middle" align="center"><b>Opzioni</b></td>
				</tr>
				<?php
				while ($row = mysql_fetch_array($risultati)) {
					$row = array_map('stripslashes', $row);
					if ( $contatorelinee % 2 == 1 ) { 
						$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
					} //primo colore
					else { 
						$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
					} //secondo colore
					$contatorelinee = $contatorelinee + 1 ;
					?>
					<tr bgcolor=<?php echo $colorelinee; ?>>
						<td style="vertical-align: middle" align="center"><?php echo $row['idanagrafica'];?></td>
						<td style="vertical-align: middle" align="center"><?php echo ucwords($row['tipologia']);?></td>
						<td style="vertical-align: middle" align="center"><?php echo $row['cognome'];?></td>
						<td style="vertical-align: middle" align="center"><?php echo $row['nome'] ; ?> </td>
						<td style="vertical-align: middle" align="center"><?php echo $my_calendario->publdataitaliana($row['nascitadata'], '/');?></td>
						<td style="vertical-align: middle" align="center"><?php echo $row['nascitacomune'];?></td>
						<td style="vertical-align: middle" align="center"><?php echo $row['nascitaprovincia'];?></td>
						<td style="vertical-align: middle" align="center"><?php echo $row['codicefiscale'];?></td>
						<td nowrap style="vertical-align: middle" align="center">
							<div class="btn-group btn-group-sm">
								<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Dettagli anagrafica" href="login0.php?corpus=dettagli-anagrafica
													&from=risultati
													&tabella=anagrafica
													&id=<?php echo $row['idanagrafica'];?>">
													<span class="glyphicon glyphicon-info-sign"></span>
								</a>
								<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica anagrafica" 	href="login0.php?corpus=modifica-anagrafica
													&from=risultati
													&tabella=anagrafica
													&id=<?php echo $row['idanagrafica'];?>">
													<span class="glyphicon glyphicon-pencil"></span>
								</a>
								<a class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Visualizza corrispondenza anagrafica" 	href="login0.php?corpus=corrispondenza-anagrafica
													&currentpage=1&iniziorisultati=0
													&id=<?php echo $row['idanagrafica'];?>">
													<i class="fa fa-exchange"></i>
								</a>
							</div>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
			
			<?php
			//controllo per pagina avanti-indietro
			if( ($filtro != 'persona') and ($filtro != 'carica') and ($filtro != 'ente')) {
				$filtro = 'anagrafica.tipologia';
			}
			
			?>
			<ul class="pagination">
			<?php
			
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage= $currentpage - 1;
				?> 
				<li>
					<a href="login0.php?corpus=risultati
					&iniziorisultati=<?php echo $paginaprecedente ;?>
					&cercato=<?php echo $cercato; ?>
					&tabella=<?php echo $tabella; ?>
					&currentpage=<?php  echo $previouspage; ?>
					&anagraficatipologia=<?php echo $filtro; ?>">
					&laquo;
					</a>
				</li>
				<?php 
			} 
			
			$i = 0;
			do {
				$pagina = $i * $risultatiperpagina;
				$currentpage = $_GET['currentpage'];
				?>
				<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $pagina; ?>&cercato=<?php echo $cercato; ?>&tabella=<?php echo $tabella; ?>&currentpage=<?php  echo $i+1; ?>&anagraficatipologia=<?php echo $filtro; ?>"><?php echo $i+1 ?></a></li>
				<?php
				$i++;
			} while ($i < $tot_pages);

			if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
				$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
				$nextpage= $currentpage + 1;
				?> 
				<li>
					<a href="login0.php?corpus=risultati
					&iniziorisultati=<?php  echo $paginasuccessiva; ?>
					&cercato=<?php echo $cercato; ?>
					&tabella=<?php echo $tabella; ?>
					&currentpage=<?php  echo $nextpage; ?>
					&anagraficatipologia=<?php echo $filtro; ?>">
					&raquo;
					</a>
				</li>
				<?php 
			}
			?>
			</ul>
			<?php
			//fine controllo pagine avanti-indietro
		}
		else {
			?>
			<h4><div align="center" class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <b>Nessun</b> risultato trovato con i filtri di ricerca selezionati.</div></h4>
			<a href="login0.php?corpus=ricerca-anagrafica"><i class="fa fa-arrow-left"></i> Torna alla pagina di ricerca</a>
			<?php
		}

	}
	//fine scelta tabella = anagrafica
	
	//scelta tabella = lettere
	$my_file = new File(); //crea un nuovo oggetto 'file'
	$my_lettera = new Lettera();

	$data = explode("/", $cercato);
	if( isset($data[0]) && isset($data[1]) && isset($data[2])) { 
		$data = $data[2].'-'.$data[1].'-'.$data[0];
	}
	else {
		$data='';
	}

	if ($tabella == 'lettere') {
		$tabella= $tabella.$annoricercaprotocollo;
		$joinletteremittenti= 'joinletteremittenti'.$annoricercaprotocollo;
		
		//ricerca parole non continue
		$cercato2='';
		$cercato3='';
		if ($cercato != '') {
			if ( substr_count($cercato, " ") > 0) {
				$parolaspezzata = explode(" ", $cercato);
				$i=1;
				foreach($parolaspezzata as $value) {
					if($i == 1) {
						$cercato2 = " OR ( $tabella.oggetto like '%".$value."%' ";
						$cercato3 = " OR ( $tabella.note like '%".$value."%' ";
					}
					else {
						$cercato2 = $cercato2 . " AND $tabella.oggetto like '%".$value."%' ";
						$cercato3 = $cercato3 . " AND $tabella.note like '%".$value."%' ";
					}
					$i++;
				}
				$cercato2 = $cercato2 . " )";
				$cercato3 = $cercato3 . " )";
			}
			else {
				$cercato2='';
				$cercato3='';
			}
		}
		
		if ($ordinerisultati == 'alfabetico') { 
			$_SESSION['ordinerisultati'] = 'order by '.$tabella.'.oggetto';
		}
		if ($ordinerisultati == 'cronologico') { 
			$_SESSION['ordinerisultati'] = 'order by '.$tabella.'.idlettera';
		}
		if ($ordinerisultati == 'cron-inverso') { 
			$_SESSION['ordinerisultati'] = 'order by '.$tabella.'.idlettera desc';
		}
		$count = mysql_query(	
						"SELECT 
							COUNT(*) 
						FROM 
							$tabella
						WHERE 
							($tabella.idlettera like '%$cercato%' 
							OR 
								($tabella.oggetto like '%$cercato%'
								$cercato2)
							OR 
								($tabella.note like '%$cercato%' 
								$cercato3)
							OR
							$tabella.datalettera like '$data')
							AND
								($tabella.speditaricevuta!=''
								AND
								$tabella.oggetto!='')
							$sped
							$pos
							$prat
							$dataricercadb
							"
						);
						
		//conteggio per divisione in pagine dei risultati
		$res_count = mysql_fetch_row($count);//conteggio per divisione in pagine dei risultati
		$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
		$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso
		$iniziorisultati = $_GET['iniziorisultati'];
		$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
		$ordinerisultati=$_SESSION['ordinerisultati'];
		$risultati = mysql_query("	
							SELECT  DISTINCT 
								* 
							FROM 
								$tabella
							WHERE
								($tabella.idlettera like '%$cercato%' 
								OR 
									($tabella.oggetto like '%$cercato%'
									$cercato2)
								OR 
									($tabella.note like '%$cercato%' 
									$cercato3)
								OR
								$tabella.datalettera like '$data')
								AND
									($tabella.speditaricevuta!=''
									AND
									$tabella.oggetto!='')
							$sped
							$pos
							$prat
							$dataricercadb
							$ordinerisultati 
							LIMIT
								$iniziorisultati , $risultatiperpagina
						");
		$num_righe = mysql_num_rows($risultati);
		$my_log -> publscrivilog( $_SESSION['loginname'], 'EFFETTUATA RICERCA IN PROTOCOLLO' , 'OK' , 'VALORE CERCATO '.$cercato, $_SESSION['historylog']);
		if  ($num_righe > 0 ) {
			echo "Numero di risultati trovati: <b>$tot_records</b><br>"; 
			
			?>
			<ul class="pagination">
			<?php

			//controllo per pagina avanti-indietro
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage= $currentpage - 1;
				?> 
				<li>
				<a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $paginaprecedente; ?>&cercato=<?php echo $cercato ;?>&tabella=lettere&currentpage=<?php echo $previouspage; ?>">&laquo;</a>
				</li>
				<?php 
			} 
			
			$i = 0;
			do {
				$pagina = $i * $risultatiperpagina;
				$currentpage = $_GET['currentpage'];
				?>
				<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $pagina; ?>&cercato=<?php echo $cercato; ?>&tabella=lettere&currentpage=<?php  echo $i+1; ?>"><?php echo $i+1 ?></a></li>
				<?php
				$i++;
			} while ($i < $tot_pages);
			
			if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
				$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
				$nextpage = $currentpage + 1;
				?> 				
				<li>
				<a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $paginasuccessiva; ?>&cercato=<?php echo $cercato; ?>&tabella=lettere&currentpage=<?php echo $nextpage ;?>">&raquo;</a>
				</li>
				<?php 
			}
			
			?>
			</ul>
			<br>
			<!--<center>
			<div class="alert alert-warning"><b><i class="fa fa-warning"></i> Attenzione:</b> al momento la funzione "qrcode" potrebbe non funzionare su tutti gli allegati.</div>
			</center>
			-->
			<table class="table table-bordered">
				<tr align = "center">
					<td style="vertical-align: middle"></td>
					<td style="vertical-align: middle">Prot.</td>
					<td style="vertical-align: middle">Data Reg.</td>
					<td style="vertical-align: middle">Pos.</td>
					<td style="vertical-align: middle">Oggetto</td>
					<td style="vertical-align: middle">File</td>
					<td style="vertical-align: middle">Mitt./Dest.</td>
					<td style="vertical-align: middle" width="240">Opzioni</td>
				</tr>
			<?php
			
			while ($value = mysql_fetch_array($risultati)) { //elenco i risultati dell'array
				$value = array_map('stripslashes', $value);
				if ( $contatorelinee % 2 == 1 ) { 
					$colorelinee = $_SESSION['primocoloretabellarisultati'];
				} //primo colore
				else {
					$colorelinee = $_SESSION['secondocoloretabellarisultati']; 
				} //secondo colore
				$contatorelinee = $contatorelinee + 1 ;
				?>
				<tr align = "center" bgcolor=<?php echo $colorelinee; ?> >
					<td style="vertical-align: middle"><?php if($value[5] == 'spedita') { echo'<h3><i class="fa fa-level-up"></i></h3>'; } else { echo '<h3><i class="fa fa-level-down"></i></h3>'; } ;?></td>
					<td style="vertical-align: middle"><?php echo $value[0] ;?></td>
					<td style="vertical-align: middle"> <?php $my_calendario->publdataitaliana($value[3],'/'); echo $my_calendario->dataitaliana ?></td>
					<td style="vertical-align: middle"><?php echo $value[7] ;?></td>
					<td style="vertical-align: middle"><?php echo $value[1] ;?></td>
					<td nowrap style="vertical-align: middle"> 
					
					<?php
					$file = false;
					$urlfile= $my_lettera->cercaAllegati($value[0], $annoricercaprotocollo);
					if ($urlfile) {
						foreach ($urlfile as $valore) {
							$download = $my_file->downloadlink($valore[2], $value[0], $annoricercaprotocollo, '4'); //richiamo del metodo "downloadlink" dell'oggetto file
							$file = true;
							echo $download.' - <a class="fancybox" data-fancybox-type="iframe" href="lettere'.$annoricercaprotocollo.'/'.$value[0].'/'.$valore[2].'"><i class="fa fa-eye"></i></a><br>';
						}
					}
					else {
						echo "Nessun file associato";
					}
					
					?>
					</td>

					<td style="vertical-align: middle">
					<?php
					$mittenti= mysql_query("SELECT distinct * 
								from anagrafica, $joinletteremittenti 
								where $joinletteremittenti.idlettera = '$value[0]' 
								and anagrafica.idanagrafica=$joinletteremittenti.idanagrafica");
					while ($mittenti2=mysql_fetch_array($mittenti)) {
						$mittenti2 = array_map('stripslashes', $mittenti2);
						$mittenti3=$mittenti2['nome'].' '.$mittenti2['cognome'];	
						?>	
						<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $mittenti2['idanagrafica'];?>"><?php echo $mittenti3; ?><br></a>
						<?php 
					}
					?>
					</td>
					<td nowrap style="vertical-align: middle">
						<div class="btn-group btn-group-sm">
							<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Dettagli protocollo" href="login0.php?corpus=dettagli-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>"><span class="glyphicon glyphicon-info-sign"></span></a>
							<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica protocollo" href="login0.php?corpus=modifica-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>"><span class="glyphicon glyphicon-pencil"></span></a>
							<?php
							if($file) {
								?>
								<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Invia tramite email" href="login0.php?corpus=invia-newsletter&id=<?php echo $value[0];?>&anno=<?php echo $annoricercaprotocollo;?>"><span class="glyphicon glyphicon-envelope"></span></a>
								<!-- <a class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Imprimi qrcode sugli allegati" href="barcode-centro-include.php?id=<?php //echo $value[0];?>&anno=<?php //echo $annoricercaprotocollo;?>" target="_BLANK"><span class="glyphicon glyphicon-qrcode"></span></a> -->
								<?php
							}
							?>
							<a class="btn btn-primary iframe" data-toggle="tooltip" data-placement="left" title="Inoltro email" data-fancybox-type="iframe" href="inoltro-email.php?id=<?php echo $value[0];?>&anno=<?php echo $annoricercaprotocollo;?>"><i class="fa fa-paper-plane"></i></a>
							<?php if($value[5] == 'ricevuta') { ?><a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Stampa ricevuta" href="stampa-protocollo.php?id=<?php echo $value[0]; ?>&anno=<?php echo $annoricercaprotocollo; ?>" target="_blank"><i class="fa fa-print"></i></a> <?php } ?>
							<a class="btn btn-info iframe" data-toggle="tooltip" data-placement="left" title="Stampa etichetta barcode" data-fancybox-type="iframe" href="stampa-barcode.php?id=<?php echo $value[0];?>&anno=<?php echo $annoricercaprotocollo;?>"> <span class="glyphicon glyphicon-barcode"></span></a>
						</div>
					</td>		
				</tr>
				<?php
			}
			?>
			</table>

			<ul class="pagination">
			<?php

			//controllo per pagina avanti-indietro
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage= $currentpage - 1;
				?> 
				<li>
				<a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $paginaprecedente; ?>&cercato=<?php echo $cercato ;?>&tabella=lettere&currentpage=<?php echo $previouspage; ?>">&laquo;</a>
				</li>
				<?php 
			} 
			
			$i = 0;
			do {
				$pagina = $i * $risultatiperpagina;
				$currentpage = $_GET['currentpage'];
				?>
				<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $pagina; ?>&cercato=<?php echo $cercato; ?>&tabella=lettere&currentpage=<?php  echo $i+1; ?>"><?php echo $i+1 ?></a></li>
				<?php
				$i++;
			} while ($i < $tot_pages);
			
			if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
				$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
				$nextpage = $currentpage + 1;
				?> 				
				<li>
				<a href="login0.php?corpus=risultati&iniziorisultati=<?php echo $paginasuccessiva; ?>&cercato=<?php echo $cercato; ?>&tabella=lettere&currentpage=<?php echo $nextpage ;?>">&raquo;</a>
				</li>
				<?php 
			}
			
			?>
			</ul>
			<?php
			//fine controllo pagine avanti-indietro
		}
		else {
			?> 
			<h4><div align="center" class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <b>Nessun</b> risultato trovato con i filtri di ricerca selezionati.</div></h4>
			<a href="login0.php?corpus=ricerca-protocollo"><i class="fa fa-arrow-left"></i> Torna alla pagina di ricerca</a><?php
		} 
	}
?>
