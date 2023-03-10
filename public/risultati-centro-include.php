<?php

	//$annoprotocollo = $_SESSION['annoprotocollo'];
	$risultatiperpagina = $_SESSION['risultatiperpagina']; //acquisisce la variabile di sessione che stabilisce quanti risultati vengono mostrati in ogni pagina
	$currentpage = $_GET['currentpage'];
	$my_calendario = new Calendario();
	$a = new Anagrafica();

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

	// FILTRO RICERCA PROTOCOLLO SPEDITO O RICEVUTO
	if(isset($_POST['speditaricevuta'])) {
		$speditaricevuta = $_POST['speditaricevuta'];
		$_SESSION['ricspedric'] = $_POST['speditaricevuta'];
	}
	else {
		$speditaricevuta = $_SESSION['ricspedric'];
	}
	if($speditaricevuta == "") {
		$sped = '';
	}
	if($speditaricevuta == "sped") {
		$sped = " AND speditaricevuta = 'spedita' ";
	}
	if($speditaricevuta == "ric") {
		$sped = " AND speditaricevuta = 'ricevuta' ";
	}

	// FILTRO RICERCA PROTOCOLLO POSIZIONE
	if(isset($_POST['posizione'])) {
		$posizione = $_POST['posizione'];
		if($posizione == "") {
			$pos = '';
		}
		else {
			$pos = " AND riferimento = '$posizione' ";
		}
	}

	// FILTRO RICERCA PROTOCOLLO PRATICA
	if(isset($_POST['pratica'])) {
		$pratica = $_POST['pratica'];
		if($pratica == "") {
			$prat = '';
		}
		else {
			$prat = " AND pratica = '$pratica' ";
		}
	}

	// FILTRO RICERCA PROTOCOLLO NOTE
	if(isset($_POST['note'])) {
		$notice = $_POST['note'];
		$_SESSION['ricnote'] = $_POST['note'];
	}
	else {
		$notice = $_SESSION['ricnote'];
	}
	if($notice == "") {
		$note = '';
	}
	else {
		$note = " AND note LIKE '%$notice%' ";
	}

	// FILTRO RICERCA PROTOCOLLO INTERVALLO DI DATE
	if( (isset($_POST['data1'])) && ($_POST['data1'] != "") && ($_POST['data2'] != "") ) {
		$data1 = $_POST['data1'];
		$_SESSION['ricdal'] = $_POST['data1'];
		$data2 = $_POST['data2'];
		$_SESSION['rical'] = $_POST['data2'];
		$datainizio = $my_calendario->dataDB($data1);
		$datafine = $my_calendario->dataDB($data2);
		$dataricercadb = " AND dataregistrazione BETWEEN '$datainizio' AND '$datafine' ";
	}
	else if(isset($_SESSION['ricdal'])) {
		$data1 = $_SESSION['ricdal'];
		$data2 = $_SESSION['rical'];
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
				$count = $connessione->query("SELECT COUNT(*) 
								FROM anagrafica 
								where (anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.cognome ='$cognomecercato' 
								and anagrafica.nome='$nomecercato'))
								"); //conteggio per divisione in pagine dei risultati
    			}
			else {
				$count = $connessione->query("SELECT COUNT(*) 
								FROM anagrafica 
								where (anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%')
								"); //conteggio per divisione in pagine dei risultati
			}
		}
		else {
			if($nomecercato != NULL) { 
				$count = $connessione->query("SELECT COUNT(*) 
								FROM anagrafica
								where ((anagrafica.idanagrafica = '$cercato' 
								or (anagrafica.nome='$nomecercato' 
								and anagrafica.cognome='$cognomecercato')) 
								and (anagrafica.tipologia='$filtro'))
								");//conteggio per divisione in pagine dei risultati
    			}
			else {
				$count = $connessione->query("SELECT COUNT(*) 
								FROM anagrafica
								where ((anagrafica.idanagrafica = '$cercato' 
								or anagrafica.nome like '%$cercato%' 
								or anagrafica.cognome like '%$cercato%') 
								and (anagrafica.tipologia='$filtro'))
								");//conteggio per divisione in pagine dei risultati
    			}
		}

		
		$res_count = $count->fetch();//conteggio per divisione in pagine dei risultati
		$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
		$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati la frazione arrotondata per eccesso
		$iniziorisultati = $_GET['iniziorisultati'];
		$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
		$ordinerisultati=$_SESSION['ordinerisultati']; //acquisisce la scelta fra ordine alfabetico cronologico o cronologico inverso nella presentazione dei risultati

		if($filtro == 'anagrafica.tipologia') {  //se la ricerca in anagrafica è su 'nessun filtro'	
			if($nomecercato != NULL) { 
				$risultati= $connessione->query("SELECT DISTINCT * 
								FROM anagrafica 
								WHERE (anagrafica.idanagrafica = '$cercato' 
								OR (anagrafica.nome='$nomecercato' 
								AND anagrafica.cognome='$cognomecercato')) 
								$ordinerisultati LIMIT $iniziorisultati , $risultatiperpagina 
								");
    			}
			else {
				$risultati= $connessione->query("SELECT DISTINCT * 
								FROM anagrafica 
								WHERE (anagrafica.idanagrafica = '$cercato' 
								OR anagrafica.nome LIKE '%$cercato%' 
								OR anagrafica.cognome LIKE '%$cercato%') 
								$ordinerisultati LIMIT $iniziorisultati , $risultatiperpagina 
								");
    			}
		}
		else { //se la ricerca in anagrafica è impostata con un qualche filtro per tipologia
			if($nomecercato != NULL) { 
				$risultati= $connessione->query("SELECT DISTINCT * 
								FROM anagrafica $joinanagraficagruppo 
								WHERE ((anagrafica.idanagrafica = '$cercato' 
								OR (anagrafica.nome='$nomecercato' 
								AND anagrafica.cognome='$cognomecercato')) 
								AND (anagrafica.tipologia='$filtro')) 
								$ordinerisultati 
								LIMIT $iniziorisultati , $risultatiperpagina 
								");
    			}
			else {
				$risultati= $connessione->query("SELECT DISTINCT * 
								FROM anagrafica
								WHERE ((anagrafica.idanagrafica = '$cercato' 
								OR anagrafica.nome LIKE '%$cercato%' 
								OR anagrafica.cognome LIKE '%$cercato%') 
								AND (anagrafica.tipologia='$filtro')) 
								$ordinerisultati 
								LIMIT $iniziorisultati , $risultatiperpagina 
								");
    			}
		}

	
		$num_righe = $risultati->rowCount();
		$my_log -> publscrivilog( $_SESSION['loginname'], 'EFFETTUATA RICERCA IN ANAGRAFICA' , 'OK' , 'VALORE CERCATO '.$cercato, $_SESSION['logfile'], 'anagrafica');
		if  ($num_righe > 0) {
			echo "Numero di risultati trovati: <b>$tot_records</b><br>"; 
			?>
			<ul class="pagination">
			<?php
			
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage = $currentpage - 1;
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
				$nextpage = $currentpage + 1;
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
			
			<div id="no-more-tables">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td style="vertical-align: middle" align="center"><b>Id</b></td>
							<td style="vertical-align: middle" align="center"><b>Tipo</b></td>
							<td style="vertical-align: middle" align="center"><b>Cognome/Rag. Sociale</b></td>
							<td style="vertical-align: middle" align="center"><b>Nome</b></td>
							<td style="vertical-align: middle" align="center"><b>Cod. Fiscale/P. Iva</b></td>
							<td width="150" style="vertical-align: middle" align="center"><b>Opzioni</b></td>
						</tr>
					</thead>

					<?php
					while ($row = $risultati->fetch()) {
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
							<?php
								if($row['tipologia'] == 'persona')
								{
									$den = "Cognome";
									$cod = "Cod. Fiscale";
								}
								else
								{
									$den = "Denominazione";
									$cod = "P. Iva";
								}
							?>
							<td data-title="Id" style="vertical-align: middle" align="left"><?php echo $row['idanagrafica'];?></td>
							<td data-title="Tipo" style="vertical-align: middle" align="left"><?php echo ucwords($row['tipologia']);?></td>
							<td data-title="<?php echo $den; ?>" style="vertical-align: middle" align="left"><?php echo $row['cognome'];?></td>
							<td data-title="Nome" style="vertical-align: middle" align="left"><?php echo $row['nome'] ; ?> </td>
							<td data-title="<?php echo $cod; ?>" style="vertical-align: middle" align="left"><?php echo $row['codicefiscale'];?></td>
							<td data-title="Opzioni" nowrap style="vertical-align: middle" align="center">
								<div class="btn-group btn-group-sm">
									<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Dettagli anagrafica" href="login0.php?corpus=dettagli-anagrafica
														&from=risultati
														&tabella=anagrafica
														&id=<?php echo $row['idanagrafica'];?>">
														<span class="glyphicon glyphicon-info-sign"></span>
									</a>
									<?php 
									if (!$a->isUser($row['idanagrafica'])) {
										?>
										<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica anagrafica" 	href="login0.php?corpus=modifica-anagrafica
															&from=risultati
															&tabella=anagrafica
															&id=<?php echo $row['idanagrafica'];?>">
															<span class="glyphicon glyphicon-pencil"></span>
										</a>
										<?php
									}
									?>
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
			</div>
			
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
				$previouspage = $currentpage - 1;
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
				$nextpage = $currentpage + 1;
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
	
	/*
	--- SCELTA TABELLA LETTERE ---
	*/

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
		$tabella = $tabella.$annoricercaprotocollo;
		$joinletteremittenti = 'joinletteremittenti'.$annoricercaprotocollo;
		$joinlettereinserimento = 'joinlettereinserimento'.$annoricercaprotocollo;
		$jointabelle = $tabella . '.idlettera = ' . $joinlettereinserimento . '.idlettera';

		// FILTRO RICERCA PROTOCOLLO UTENTE CHE HA REGISTRATO LA LETTERA
		if(isset($_POST['registratore'])) {
			$registratore = $_POST['registratore'];
			$_SESSIONE['ricreg'] = $_POST['registratore'];
			
		}
		else {
			$registratore = $_SESSION['ricreg'];
		}
		if($registratore == "") {
			$reg = '';
		}
		else {
			$reg = " AND $joinlettereinserimento.idinser = '$registratore' ";
		}
		
		// RICERCA PAROLE NON CONTINUE
		$cercato2 = '';
		$cercato3 = '';
		if ($cercato != '') {
			if ( substr_count($cercato, " ") > 0) {
				$parolaspezzata = explode(" ", $cercato);
				$i = 1;
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
				$cercato2 = '';
				$cercato3 = '';
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
		$count = $connessione->query("
						SELECT COUNT(*) 
						FROM $tabella, $joinlettereinserimento
						WHERE 	($tabella.idlettera like '%$cercato%' 
								OR 
								($tabella.oggetto like '%$cercato%' $cercato2)
								OR 
								($tabella.note like '%$cercato%' $cercato3)
								OR
								$tabella.datalettera like '$data')
								AND
								($tabella.speditaricevuta!=''
								AND
								$tabella.oggetto!='')
								AND 
								$jointabelle
								$sped
								$pos
								$prat
								$note
								$reg
								$dataricercadb
						");
						
		//conteggio per divisione in pagine dei risultati
		$res_count = $count->fetch();//conteggio per divisione in pagine dei risultati
		$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
		$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso
		$iniziorisultati = $_GET['iniziorisultati'];
		$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
		$ordinerisultati = $_SESSION['ordinerisultati'];
		$risultati = $connessione->query("	
							SELECT  DISTINCT * 
							FROM $tabella, $joinlettereinserimento
							WHERE 	($tabella.idlettera like '%$cercato%' 
									OR 
									($tabella.oggetto like '%$cercato%' $cercato2)
									OR 
									($tabella.note like '%$cercato%' $cercato3)
									OR
									$tabella.datalettera like '$data')
									AND
									($tabella.speditaricevuta!=''
									AND
									$tabella.oggetto!='')
									AND 
									$jointabelle
									$sped
									$pos
									$prat
									$note
									$reg
									$dataricercadb
									$ordinerisultati 
							LIMIT $iniziorisultati , $risultatiperpagina
						");
		$num_righe = $risultati->rowCount();
		$my_log -> publscrivilog( $_SESSION['loginname'], 'EFFETTUATA RICERCA IN PROTOCOLLO' , 'OK' , 'VALORE CERCATO '.$cercato, $_SESSION['logfile'], 'anagrafica');
		if  ($num_righe > 0 ) {
			echo "Numero di risultati trovati: <b>$tot_records</b><br>"; 
			
			?>
			<ul class="pagination">
			<?php

			//controllo per pagina avanti-indietro
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage = $currentpage - 1;
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
			<div id="no-more-tables">
				<table class="table table-bordered">
					<thead>
						<tr align = "center">
							<td nowrap style="vertical-align: middle">N.</td>
							<td style="vertical-align: middle">Data</td>
							<td style="vertical-align: middle">Oggetto</td>
							<td style="vertical-align: middle">Allegati</td>
							<td style="vertical-align: middle">Mitt./Dest.</td>
							<td style="vertical-align: middle">Opzioni</td>
						</tr>
					</thead>
				<?php
				
				while ($value = $risultati->fetch()) { //elenco i risultati dell'array
					$value = array_map('stripslashes', $value);
					if ( $contatorelinee % 2 == 1 ) { 
						$colorelinee = $_SESSION['primocoloretabellarisultati'];
					} //primo colore
					else {
						$colorelinee = $_SESSION['secondocoloretabellarisultati']; 
					} //secondo colore
					$contatorelinee = $contatorelinee + 1 ;

					if($value[5] == 'spedita') { 
						$icon = '<i class="fa fa-arrow-up fa-fw"></i> '; 
					} 
					else { 
						$icon = '<i class="fa fa-arrow-down fa-fw"></i> '; 
					}

					?>
					<tr bgcolor=<?php echo $colorelinee; ?> >
						<td nowrap data-title="N." style="vertical-align: middle"><?php echo $icon . ' ' . $value[0]; ?></td>
						<td data-title="Data" style="vertical-align: middle"> <?php $my_calendario->publdataitaliana($value[3],'/'); echo $my_calendario->dataitaliana ?></td>
						<td data-title="Oggetto" style="vertical-align: middle"><?php echo stripslashes($value[1]) ;?></td>
						<td data-title="Allegati" nowrap style="vertical-align: middle"> 
						
						<?php
						$file = false;
						$urlfile= $my_lettera->cercaAllegati($value[0], $annoricercaprotocollo);
						if ($urlfile) {
							foreach ($urlfile as $valore) {
								$download = $my_file->downloadlink($valore[2], $value[0], $annoricercaprotocollo, '5'); //richiamo del metodo "downloadlink" dell'oggetto file
								$file = true;
								echo $download;
							}
						}
						else {
							echo "Nessun file associato";
						}
						
						?>
						</td>

						<td data-title="Mitt./Dest." style="vertical-align: middle">
						<?php
						$mittenti = $connessione->query("SELECT DISTINCT * 
									FROM anagrafica, $joinletteremittenti 
									WHERE $joinletteremittenti.idlettera = '$value[0]' 
									AND anagrafica.idanagrafica=$joinletteremittenti.idanagrafica");
						while ($mittenti2 = $mittenti->fetch()) {
							$mittenti2 = array_map('stripslashes', $mittenti2);
							$mittenti3 = $mittenti2['nome'].' '.$mittenti2['cognome'];	
							?>	
							<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $mittenti2['idanagrafica'];?>"><?php echo '- ' .$mittenti3; ?><br></a>
							<?php 
						}
						?>
						</td>
						<td data-title="Opzioni" style="vertical-align: middle; text-align: center;">
							<div class="btn-group-vertical btn-group-sm">
								<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Dettagli Protocollo" href="login0.php?corpus=dettagli-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>"><i class="fa fa-info-circle fa-fw"></i> Dettagli</a>
								<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica Protocollo" href="login0.php?corpus=modifica-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>"><i class="fa fa-edit fa-fw"></i> Modifica</a>
							</div>
						</td>		
					</tr>
					<?php
				}
				?>
				</table>
			</div>

			<ul class="pagination">
			<?php

			//controllo per pagina avanti-indietro
			if ($iniziorisultati > 0) {
				$paginaprecedente = $iniziorisultati - $risultatiperpagina;
				$previouspage = $currentpage - 1;
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
