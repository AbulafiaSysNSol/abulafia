<?php

	//$annoprotocollo = $_SESSION['annoprotocollo'];
	$risultatiperpagina = $_SESSION['risultatiperpagina']; //acquisisce la variabile di sessione che stabilisce quanti risultati vengono mostrati in ogni pagina
	$currentpage = $_GET['currentpage'];

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
	if (!isset($_POST['annoricercaprotocollo'])) {
		$_POST['annoricercaprotocollo'] = $_SESSION['annoricercaprotocollo'];
	}
	if (!isset($_POST['anagraficatipologia'])) {
		if (isset($_GET['anagraficatipologia'])) {
			$_POST['anagraficatipologia']= $_GET['anagraficatipologia'];
		}
	}
	
	$logindatagruppo2=$_SESSION['gruppo']; //setta l'id del gruppo cui appartiene l'utente che ha fatto login

	if (isset($_POST['anagraficatipologia'])) {
		$filtro = $_POST['anagraficatipologia'];
	}

	$ordinerisultati = $_POST['ordinerisultati'];
	$cercato = $_POST['cercato']; //parola chiave da ricercare
	$nomecercato = NULL;

	if ($cercato != '') {
		if ( substr_count($cercato, "+") > 0) {
			list($cognomecercato, $nomecercato) = explode("+", $cercato);
		}
	}

	$tabella = $_POST['tabella'];
	$annoricercaprotocollo=$_POST['annoricercaprotocollo'];
	$_SESSION['annoricercaprotocollo']= $annoricercaprotocollo;
	if(isset($_POST['group1'])) { 
		$ordinerisultati= $_POST['group1'];
	}
	else {
		$ordinerisultati ='';
	}

	//scelta fra ricerca in anagrafica e protocollo

	//scelta 'anagrafica'
	if ($tabella == 'anagrafica') {
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
								FROM anagrafica $joinanagraficagruppo 
								where ((anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.nome='$nomecercato' 
								and anagrafica.cognome='$cognomecercato')) 
								and (anagrafica.tipologia='$filtro') 
								$filtroispettorigruppo )
								");//conteggio per divisione in pagine dei risultati
    			}
			else {
				$count = mysql_query(	"SELECT COUNT(*) 
								FROM anagrafica $joinanagraficagruppo 
								where ((anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%') 
								and (anagrafica.tipologia='$filtro') 
								$filtroispettorigruppo )
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
								and (anagrafica.tipologia='$filtro') 
								$filtroispettorigruppo ) 
								$ordinerisultati 
								limit $iniziorisultati , $risultatiperpagina 
								");
    			}
			else {
				$risultati= mysql_query("select distinct * 
								FROM anagrafica $joinanagraficagruppo 
								where ((anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%') 
								and (anagrafica.tipologia='$filtro') 
								$filtroispettorigruppo ) 
								$ordinerisultati 
								limit $iniziorisultati , $risultatiperpagina 
								");
    			}
		}

	
		$num_righe = mysql_num_rows($risultati);
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
					<td align="center"><b>Id</b></td>
					<td align="center"><b>Tipo</b></td>
					<td align="center"><b>Cognome</b></td>
					<td align="center"><b>Nome</b></td>
					<td align="center"><b>Data di Nascita</b></td>
					<td align="center"><b>Comune</b></td>
					<td align="center"><b>Prov.</b></td>
					<td align="center"><b>Codice Fiscale</b></td>
					<td align="center"><b>Opzioni</b></td>
				</tr>
				<?php
				while ($row = mysql_fetch_array($risultati)) {
					if ( $contatorelinee % 2 == 1 ) { 
						$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
					} //primo colore
					else { 
						$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
					} //secondo colore
					$contatorelinee = $contatorelinee + 1 ;
					?>
					<tr bgcolor=<?php echo $colorelinee; ?>>
						<td><?php echo $row['idanagrafica'];?></td>
						<td align="center" valign="middle"><?php echo $row['tipologia'];?></td>
						<td align="center" valign="middle"><?php echo $row['cognome'];?></td>
						<td align="center" valign="middle"><?php echo $row['nome'] ; ?> </td>
						<td align="center" valign="middle"><?php $data = $row['nascitadata'] ;
										list($anno, $mese, $giorno) = explode("-", $data);
										$data2 = "$giorno-$mese-$anno";
										echo "$data2" ;?>
						</td>
						<td align="center" valign="middle"><?php echo $row['nascitacomune'];?></td>
						<td align="center" valign="middle"><?php echo $row['nascitaprovincia'];?></td>
						<td align="center" valign="middle"><?php echo $row['codicefiscale'];?></td>
						<td align="center" width="150">
							<div class="btn-group btn-group-sm">
								<a class="btn btn-info" href="login0.php?corpus=dettagli-anagrafica
													&from=risultati
													&tabella=anagrafica
													&id=<?php echo $row['idanagrafica'];?>">
													Dettagli
								</a>
								<a class="btn btn-warning" 	href="login0.php?corpus=modifica-anagrafica
													&from=risultati
													&tabella=anagrafica
													&id=<?php echo $row['idanagrafica'];?>">
													Modifica
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
			echo "Non ci sono risultati con i filtri applicati."; 
			?> 
			<a href="login0.php?corpus=ricerca"><br><br>Effettua un'altra ricerca</a>
			<?php
		}

	}
	//fine scelta tabella = anagrafica
	
	//scelta tabella = lettere
	$my_file = new File(); //crea un nuovo oggetto 'file'

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
							$tabella.oggetto like '%$cercato%' 
							OR 
							$tabella.speditaricevuta like '%$cercato%' 
							OR 
							$tabella.note like '%$cercato%' 
							OR
							$tabella.posizione like '%$cercato%' 
							OR
							$tabella.datalettera like '$data')"
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
								$tabella.oggetto like '%$cercato%' 
								OR
								$tabella.speditaricevuta like '%$cercato%' 
								OR
								$tabella.note like '%$cercato%' 
								OR
								$tabella.posizione like '%$cercato%' 
								OR
								$tabella.datalettera like '$data')
								and
								($tabella.speditaricevuta!=''
								and
								$tabella.oggetto!='')
							$ordinerisultati 
							LIMIT
								$iniziorisultati , $risultatiperpagina
						");
		$num_righe = mysql_num_rows($risultati);
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
			
			<table class="table table-bordered">
				<tr align = "center">
					<td>N. Prot.</td>
					<td>Data Reg.</td>
					<td>Pos.</td>
					<td>Sped./Ric.</td>
					<td>Oggetto</td>
					<td>File</td>
					<td>Mitt./Dest.</td>
					<td>Opzioni</td>
				</tr>
			<?php
			
			while ($value = mysql_fetch_array($risultati)) { //elenco i risultati dell'array
				if ( $contatorelinee % 2 == 1 ) { 
					$colorelinee = $_SESSION['primocoloretabellarisultati'];
				} //primo colore
				else {
					$colorelinee = $_SESSION['secondocoloretabellarisultati']; 
				} //secondo colore
				$contatorelinee = $contatorelinee + 1 ;
				?>
				<tr align = "center" VALIGN="middle" bgcolor=<?php echo $colorelinee; ?> >
					<td><?php echo $value[0] ;?></td>
					<td> <?php $my_calendario->publdataitaliana($value[3],'/'); echo $my_calendario->dataitaliana ?></td>
					<td><?php echo $value[7] ;?></td>
					<td><?php echo $value[5] ;?></td>
					<td><?php echo $value[1] ;?></td>
					<td> 
					<?php
					$download = $my_file -> downloadlink($value[4], $value[0], $annoricercaprotocollo, '6');
						if ($download != "Nessun file associato") {
							echo $download;
						}
						else {
							echo "Nessun file associato";
						}
					?>
					</td>

					<td>
					<?php
					$mittenti= mysql_query("SELECT distinct * 
								from anagrafica, $joinletteremittenti 
								where $joinletteremittenti.idlettera = '$value[0]' 
								and anagrafica.idanagrafica=$joinletteremittenti.idanagrafica");
					while ($mittenti2=mysql_fetch_array($mittenti)) {
						$mittenti3=$mittenti2['nome'].' '.$mittenti2['cognome'];	
						?>	
						<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $mittenti2['idanagrafica'];?>"><?php echo $mittenti3; ?><br></a>
						<?php 
					}
					?>
					</td>
					<td width="150">
						<div class="btn-group btn-group-sm">
							<a class="btn btn-info" href="login0.php?corpus=dettagli-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>">Dettagli</a>
							<a class="btn btn-warning" href="login0.php?corpus=modifica-protocollo&from=risultati&tabella=anagrafica&id=<?php echo $value[0];?>">Modifica</a>
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
			echo "Nessun risultato trovato con i filtri di ricerca applicati."; 
			?> 
			<br><br><a href="login0.php?corpus=ricerca">Effettua un'altra ricerca</a><?php
		} 
	}
?>
