<?php

	$idpratica = $_GET['id'];
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
	
	$count = mysql_query(	
						"SELECT 
							COUNT(*) 
						FROM 
							$tabella
						WHERE 
							$tabella.pratica = $idpratica"
						);
	//conteggio per divisione in pagine dei risultati
	$res_count = mysql_fetch_row($count);//conteggio per divisione in pagine dei risultati
	$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
	$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso
	$iniziorisultati = $_GET['iniziorisultati'];
	$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
	$risultati = mysql_query("	
						SELECT 
							* 
						FROM 
							$tabella
						WHERE 
							$tabella.pratica = $idpratica
						ORDER BY
							$tabella.idlettera DESC
						LIMIT
							$iniziorisultati , $risultatiperpagina
					");
	$num_righe = mysql_num_rows($risultati);
	?>
	<center>
	<div class="row">
		<div class="col-xs-12">
			Anno di ricerca corrispondenza:
			<SELECT id="annoricerca" class="form-inline input-sm" name="annoricercaprotocollo" onChange="change()">
			<?php
				$esistenzatabella1=mysql_query("show tables like 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
				$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
				$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
				while ($esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM)) {
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
			<a href="login0.php?corpus=corrispondenza-anagrafica&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $paginaprecedente; ?>&id=<?php echo $idanagrafica; ?>&currentpage=<?php echo $previouspage; ?>">&laquo;</a>
			</li>
			<?php 
		} 
		
		$i = 0;
		do {
			$pagina = $i * $risultatiperpagina;
			$currentpage = $_GET['currentpage'];
			?>
			<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=corrispondenza-anagrafica&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $pagina; ?>&id=<?php echo $idanagrafica; ?>&currentpage=<?php  echo $i+1; ?>"><?php echo $i+1 ?></a></li>
			<?php
			$i++;
		} while ($i < $tot_pages);
		
		if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
			$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
			$nextpage = $currentpage + 1;
			?> 				
			<li>
			<a href="login0.php?corpus=corrispondenza-anagrafica&iniziorisultati=<?php echo $paginasuccessiva; ?>&anno=<?php echo $annoricercaprotocollo; ?>&id=<?php echo $idanagrafica; ?>&currentpage=<?php echo $nextpage ;?>">&raquo;</a>
			</li>
			<?php 
		}
		
		?>
		</ul>
		<br>
		
		<table class="table table-bordered">
			<tr align = "center">
				<td style="vertical-align: middle"></td>
				<td style="vertical-align: middle">N. Prot.</td>
				<td style="vertical-align: middle">Data Reg.</td>
				<td style="vertical-align: middle">Pos.</td>
				<td style="vertical-align: middle">Oggetto</td>
				<td style="vertical-align: middle">File</td>
				<td style="vertical-align: middle">Mitt./Dest.</td>
				<td style="vertical-align: middle" width="200">Opzioni</td>
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
						$download = $my_file->downloadlink($valore[2], $value[0], $annoricercaprotocollo, '14'); //richiamo del metodo "downloadlink" dell'oggetto file
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
						<a class="btn btn-primary iframe" data-fancybox-type="iframe" href="inoltro-email.php?id=<?php echo $value[0];?>&anno=<?php echo $annoricercaprotocollo;?>"><i class="fa fa-paper-plane"></i></a>
						<?php if($value[5] == 'ricevuta') { ?><a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Stampa ricevuta" href="stampa-protocollo.php?id=<?php echo $value[0]; ?>&anno=<?php echo $annoricercaprotocollo; ?>" target="_blank"><i class="fa fa-print"></i></a> <?php } ?>
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
				<a href="login0.php?corpus=corrispondenza-anagrafica&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $paginaprecedente; ?>&id=<?php echo $idanagrafica; ?>&currentpage=<?php echo $previouspage; ?>">&laquo;</a>
				</li>
				<?php 
			} 
			
			$i = 0;
			do {
				$pagina = $i * $risultatiperpagina;
				$currentpage = $_GET['currentpage'];
				?>
				<li <?php if( ($i+1) == $currentpage) { echo "class=\"active\""; } ?>><a href="login0.php?corpus=corrispondenza-anagrafica&anno=<?php echo $annoricercaprotocollo; ?>&iniziorisultati=<?php echo $pagina; ?>&id=<?php echo $idanagrafica; ?>&currentpage=<?php  echo $i+1; ?>"><?php echo $i+1 ?></a></li>
				<?php
				$i++;
			} while ($i < $tot_pages);
			
			if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
				$paginasuccessiva = $iniziorisultati + $risultatiperpagina;
				$nextpage = $currentpage + 1;
				?> 				
				<li>
				<a href="login0.php?corpus=corrispondenza-anagrafica&iniziorisultati=<?php echo $paginasuccessiva; ?>&id=<?php echo $idanagrafica; ?>&anno=<?php echo $annoricercaprotocollo; ?>&currentpage=<?php echo $nextpage ;?>">&raquo;</a>
				</li>
				<?php 
			}
			
			?>
			</ul>
			<?php
			//fine controllo pagine avanti-indietro
		}
		else {
			echo "<br><center><div class=\"alert alert-danger\"><b><i class=\"fa fa-warning\"></i> Nessuna</b> corrispondenza trovata con la pratica per l'anno selezionato. Provare a variare l'anno di ricerca.</div></center>"; 
			?> 
			<a href="login0.php?corpus=pratiche"><i class="fa fa-reply"></i> Torna alle pratiche </a> o <a href="login0.php?corpus=ricerca">vai alla pagina di ricerca <i class="fa fa-search"></i></a><br><?php
		} 
?>

<script language="javascript">
 <!--
function change() {
	var anno = document.getElementById("annoricerca").value;
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=corrispondenza-pratica&iniziorisultati=0&id=<?php echo $idpratica; ?>&anno="+anno+"&currentpage=1"; 
	else 
	window.location="login0.php?corpus=corrispondenza-pratica&iniziorisultati=0&id=<?php echo $idpratica; ?>&anno="+anno+"&currentpage=1";
}
 //-->
</script> 