<?php

	$idposizione = $_GET['id'];
	$risultatiperpagina = $_SESSION['risultatiperpagina']; //acquisisce la variabile di sessione che stabilisce quanti risultati vengono mostrati in ogni pagina
	$currentpage = $_GET['currentpage'];
	
	if(isset($_GET['anno'])) {
		$annoricercaprotocollo=$_GET['anno'];
		$_SESSION['annoricercaprotocollo'] = $_GET['anno'];
	}
	else {
		$annoricercaprotocollo=$_SESSION['annoprotocollo'];
		$_SESSION['annoricercaprotocollo'] = $_SESSION['annoprotocollo'];
	}
	
	$my_file = new File(); //crea un nuovo oggetto 'file'
	$my_lettera = new Lettera();

	$tabella= 'lettere'.$annoricercaprotocollo;
	$joinletteremittenti= 'joinletteremittenti'.$annoricercaprotocollo;
	
	$count = $connessione->query(	
						"SELECT 
							COUNT(*) 
						FROM 
							$tabella
						WHERE 
							$tabella.riferimento = '$idposizione'"
						);
	//conteggio per divisione in pagine dei risultati
	$res_count = $count->fetch();//conteggio per divisione in pagine dei risultati
	$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
	$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso
	$iniziorisultati = $_GET['iniziorisultati'];
	$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
	$risultati = $connessione->query("	
						SELECT 
							* 
						FROM 
							$tabella
						WHERE 
							$tabella.riferimento = '$idposizione'
						ORDER BY
							$tabella.idlettera DESC
						LIMIT
							$iniziorisultati , $risultatiperpagina
					");
	$num_righe = $risultati->rowCount();
	?>
	<center>
	<div class="row">
		<div class="col-sm-12">
			Anno di ricerca corrispondenza:
			<SELECT id="annoricerca" class="form-inline input-sm" name="annoricercaprotocollo" onChange="change()">
			<?php
				$esistenzatabella1 = $connessione->query("SHOW TABLES LIKE 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
				$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
				$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
				while ($esistenzatabella11 = $esistenzatabella1->fetch()) {
					if ('lettere'.$annoricercaprotocollo == $esistenzatabella11[0]) { 
						$selected='selected'; 
					}
					else { 
						$selected ='';
					}
					$annoprotocollo= explode("lettere", $esistenzatabella11[0]);
					?>
					<OPTION value="<?php echo $annoprotocollo[1] ;?>" <?php echo $selected ;?>> <?php echo $annoprotocollo[1].' ' ;?></OPTION>
					<?php
				}
			?>
			</SELECT>
		</div>
	</div>
	</center>
	<br>
	<?php
	
	if  ($num_righe > 0 ) {
		echo "Numero di corrispondenze trovate: <b>$tot_records</b><br>"; 
		
		?>
		<ul class="pagination">
		<?php
			//controllo per pagina avanti-indietro
		if ($iniziorisultati > 0) {
			$paginaprecedente = $iniziorisultati - $risultatiperpagina;
			$previouspage= $currentpage - 1;
			?> 
			<li>
			<a href="login0.php?corpus=corrispondenza-titolario&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $paginaprecedente; ?>&id=<?php echo $idposizione; ?>&currentpage=<?php echo $previouspage; ?>">&laquo;</a>
			</li>
			<?php 
		} 
		
		$i = 0;
		do {
			$pagina = $i * $risultatiperpagina;
			$currentpage = $_GET['currentpage'];
			?>
			<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=corrispondenza-titolario&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $pagina; ?>&id=<?php echo $idposizione; ?>&currentpage=<?php  echo $i+1; ?>"><?php echo $i+1 ?></a></li>
			<?php
			$i++;
		} while ($i < $tot_pages);
		
		if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
			$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
			$nextpage = $currentpage + 1;
			?> 				
			<li>
			<a href="login0.php?corpus=corrispondenza-titolario&iniziorisultati=<?php echo $paginasuccessiva; ?>&anno=<?php echo $annoricercaprotocollo; ?>&id=<?php echo $idposizione; ?>&currentpage=<?php echo $nextpage ;?>">&raquo;</a>
			</li>
			<?php 
		}
		
		?>
		</ul>
		<br>
		
		<div id="no-more-tables">
			<table class="table table-bordered">
				<thead>
					<tr align = "center">
						<td style="vertical-align: middle">N. Prot.</td>
						<td style="vertical-align: middle">Data Reg.</td>
						<td style="vertical-align: middle">Oggetto</td>
						<td style="vertical-align: middle">Allegati</td>
						<td style="vertical-align: middle">Mitt./Dest.</td>
						<td style="vertical-align: middle" width="240">Opzioni</td>
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
				<tr align = "center" bgcolor=<?php echo $colorelinee; ?> >
					<td data-title="N." style="vertical-align: middle"><?php echo $icon . ' ' . $value[0] ;?></td>
					<td data-title="Data" style="vertical-align: middle"> <?php $my_calendario->publdataitaliana($value[3],'/'); echo $my_calendario->dataitaliana ?></td>
					<td data-title="Oggetto" style="vertical-align: middle"><?php echo $value[1] ;?></td>
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
						
					<td data-title="Mitt./Dest" style="vertical-align: middle">
						<?php
						$mittenti= $connessione->query("SELECT distinct * 
									from anagrafica, $joinletteremittenti 
									where $joinletteremittenti.idlettera = '$value[0]' 
									and anagrafica.idanagrafica=$joinletteremittenti.idanagrafica");
						while ($mittenti2 = $mittenti->fetch()) {
							$mittenti2 = array_map('stripslashes', $mittenti2);
							$mittenti3 = $mittenti2['nome'].' '.$mittenti2['cognome'];	
							?>	
							<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $mittenti2['idanagrafica'];?>"><?php echo $mittenti3; ?><br></a>
							<?php 
						}
						?>
					</td>

					<td data-title="Opzioni" nowrap style="vertical-align: middle">
						<div class="btn-group-vertical btn-group-sm">
							<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Dettagli protocollo" href="login0.php?corpus=dettagli-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>"><i class="fa fa-info-circle fa-fw"></i> Dettagli</a>
							<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica protocollo" href="login0.php?corpus=modifica-protocollo&from=risultati&tabella=protocollo&id=<?php echo $value[0];?>"><i class="fa fa-edit fa-fw"></i> Modifica</a>
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
				$previouspage= $currentpage - 1;
				?> 
				<li>
				<a href="login0.php?corpus=corrispondenza-titolario&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $paginaprecedente; ?>&id=<?php echo $idposizione; ?>&currentpage=<?php echo $previouspage; ?>">&laquo;</a>
				</li>
				<?php 
			} 
			
			$i = 0;
			do {
				$pagina = $i * $risultatiperpagina;
				$currentpage = $_GET['currentpage'];
				?>
				<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=corrispondenza-anagrafica&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $pagina; ?>&id=<?php echo $idposizione; ?>&currentpage=<?php  echo $i+1; ?>"><?php echo $i+1 ?></a></li>
				<?php
				$i++;
			} while ($i < $tot_pages);
			
			if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
				$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
				$nextpage = $currentpage + 1;
				?> 				
				<li>
				<a href="login0.php?corpus=corrispondenza-titolario&iniziorisultati=<?php echo $paginasuccessiva; ?>&id=<?php echo $idposizione; ?>&anno=<?php echo $annoricercaprotocollo; ?>&currentpage=<?php echo $nextpage ;?>">&raquo;</a>
				</li>
				<?php 
			}
			
			?>
			</ul>
			<?php
			//fine controllo pagine avanti-indietro
		}
		else {
			echo "<br><center><div class=\"alert alert-danger\"><b><i class=\"fa fa-warning\"></i> Nessuna</b> corrispondenza trovata con la posizione per l'anno selezionato. Provare a variare l'anno di ricerca.</div></center>"; 
			?> 
			<a href="login0.php?corpus=titolario"><i class="fa fa-reply"></i> Torna al titolario </a> o <a href="login0.php?corpus=ricerca">vai alla pagina di ricerca <i class="fa fa-search"></i></a><br><?php
		} 
?>

<script language="javascript">
 <!--
function change() {
	var anno = document.getElementById("annoricerca").value;
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=corrispondenza-titolario&iniziorisultati=0&id=<?php echo $idposizione; ?>&anno="+anno+"&currentpage=1"; 
	else 
	window.location="login0.php?corpus=corrispondenza-titolario&iniziorisultati=0&id=<?php echo $idposizione; ?>&anno="+anno+"&currentpage=1";
}
 //-->
</script> 