<?php
	$my_lettera = new Lettera(); //crea un nuovo oggetto 'lettera'
	$calendario = new Calendario();
	$id = $_GET['id'];
	$_SESSION['block'] = false;
	
	if (isset($_GET['anno'])) {
		$anno = $_GET['anno'];
	}
	else {
		$anno = $_SESSION['annoricercaprotocollo'];
	}
	
	$dettagli = $my_lettera->getDettagli($id,$anno);
	$mittenti = $my_lettera->getMittenti($id,$anno);
	$inserimento = $my_lettera->getIns($id,$anno);
	$modifica = $my_lettera->getLastMod($id,$anno);
	$mailsend = $my_lettera->getMailSend($id, $anno);

	if (isset($_GET['inoltro']) AND $_GET['inoltro'] == 'ok') {
		echo '<div class="alert alert-success"><i class="fa fa-check"></i> Inoltro aggiunto con <b>successo!</b></div>';
	}
	
	if (isset($_GET['inoltro']) AND $_GET['inoltro'] == 'fail') {
		echo '<div class="alert alert-danger"><b><i class="fa fa-times"></i> Errore:</b> si e\' verificato un problema, inoltro non registrato. Riprovare o contattare l\'amministratore del sistema.</div>';
	}
?>

<div class="panel panel-default">		
		
	<div class="panel-body">

			<center>
				<h2>
					<i class="fa fa-book"></i> Protocollo N. <b><?php echo $dettagli['idlettera']; ?></b> del <b><?php echo $calendario->dataSlash($dettagli['dataregistrazione']); ?></b>
				</h2>
				<h4>
					"<?php echo $dettagli['oggetto']; ?>"
				</h4>
			</center>
		<hr>

		<div class="row smartphone">
			<div class="col-sm-3">
				<h3><i class="fa fa-info"></i> Dettagli Protocollo</h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<?php
						echo '<ul>';
						echo '<li>Spedita/Ricevuta: <b>'. $dettagli['speditaricevuta'] . '</b></li>';
						echo '<li>Data della Lettera: <b>'. $calendario->dataSlash($dettagli['datalettera']) . '</b></li>';
						if ($dettagli['posizione']) { echo '<li>Mezzo di Trasmissione: <b>'. $dettagli['posizione'] . '</b></li>'; }
						if ($dettagli['riferimento']) { echo '<li>Posizione: <b>'. $dettagli['riferimento'] . ' - ' . $my_lettera->getDescPosizione($dettagli['riferimento']) . '</b></li>'; }
						if ($dettagli['pratica']) { echo '<li>Pratica: <b>'. $my_lettera->getDescPratica($dettagli['pratica']) . '</b></li>'; }
						if ($dettagli['note']) { echo '<li>Note: <b>'. $dettagli['note'] . '</b></li>'; }
						echo '</ul>';
						?>	
					</div>
				</div>
				<br>
			</div>

			<div class="col-sm-3">
				<h3><i class="fa fa-users"></i> <?php if($dettagli['speditaricevuta'] == 'spedita') { echo 'Destinatari'; } else { echo 'Mittenti';} ?></h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul>
						<?php
						foreach($mittenti as $valore) {
							?>
							<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $valore['idanagrafica'];?>"> 
								<?php echo '<li>' . ucwords(stripslashes($valore['nome']) . '  ' . stripslashes($valore['cognome'])) . '</li>' ;?>
							</a>
							<?php
						}
						?>
						</ul>
					</div>
				</div>
				<br>
			</div>
			
			<div class="col-sm-3">
				<h3><i class="fa fa-folder-open-o"></i> File Allegati</h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<?php
						$file = false;
						$my_file = new File(); 					
						$urlfile= $my_lettera->cercaAllegati($dettagli['idlettera'], $anno);
						if ($urlfile) {
							$file = true;
							echo '<ul>';
							foreach ($urlfile as $valore) {
								$download = $my_file->downloadlink($valore[2], $dettagli['idlettera'], $anno, '30'); //richiamo del metodo "downloadlink" dell'oggetto file
								echo '<li>' . $download . '</li>';
							}
							echo '</ul>';
						}
						else {
							echo "Nessun file associato.";
						}
						?>
					</div>
				</div>
				<?php
					if ($urlfile) {
						?>
						<a href="zip.php?id=<?php echo $dettagli['idlettera']; ?>&anno=<?php echo $anno; ?>"><i class="fa fa-file-archive-o"></i> Scarica allegati come ZIP</a>
						<?php
					}
				?>
				<br><br>
			</div>
			
			<div class="col-sm-3">
				<h3><i class="fa fa-qrcode"></i> Codice QR</h3>
				<?php
					$path= 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
				?>
				<center><img src="<?php echo $path ?>"></center>
			</div>
			
		</div>
		
		<br>
		
		<div class="row smartphone">
			<div class="col-md-4">
				<h3><i class="fa fa-user"></i> Inserimento effettuato da:</h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						- <a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $inserimento['idanagrafica'];?>"> 
						<?php echo $inserimento['nome'] . '  ' . $inserimento['cognome'] . '</a> il ' . $calendario->dataSlash($dettagli['dataregistrazione']);?>
					</div>
				</div>
				
				<?php
				if($modifica['idanagrafica'] != 0) {
				?>
				<br><h3><i class="fa fa-user"></i> Ultima modifica:</h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						 - <a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=
						<?php echo $modifica['idanagrafica'];?>"> 
						<?php echo $modifica['nome'] . '  ' . $modifica['cognome'] . '</a> il ' . $calendario->dataSlash($modifica['datamod']);?>
					</div>
				</div>
				<?php
				}
				?>
				<br>
			</div>

			<div class="col-md-5">
				<h3><i class="fa fa-paper-plane-o"></i> Protocollo inoltrato a:</h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul>
						<?php
						if (!$mailsend) {
							echo '<li>Nessun inoltro per il protocollo selezionato</li>';
						}
						else {
							foreach($mailsend as $valore) {
								echo '<li><b>' . $valore['email'] . '</b> da  
								<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=' . $valore['idanagrafica'] . ' "> ' .
								$valore['nome'] . '  ' . $valore['cognome'] . '</a> il ' . $calendario->dataSlash($valore['data']);
							}
						}
						?>
						</ul>
					</div>
				</div>
				<br>
			</div>
			
			<div class="col-sm-3">
				<h3><i class="fa fa-cog"></i> Opzioni</h3><br>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						
							<a href="login0.php?corpus=modifica-protocollo&from=risultati&id=<?php echo $_GET['id'];?>&anno=<?php echo $anno; ?>"> <i class="fa fa-edit fa-fw"></i> Modifica questo Protocollo</a><br>
							<?php if($file) { ?>
								<a href="login0.php?corpus=invia-newsletter&id=<?php echo $_GET['id'];?>&anno=<?php echo $anno;?>"> <i class="fa fa-envelope-o fa-fw"></i> Invia tramite Email</a><br>
								<a href="login0.php?corpus=aggiungi-inoltro&id=<?php echo $_GET['id'];?>&anno=<?php echo $anno;?>"> <i class="fa fa-pencil fa-fw"></i> Aggiungi inoltro email</a><br>
							<?php
								}
								if($dettagli['speditaricevuta'] == 'ricevuta') { ?><a href="stampa-protocollo.php?id=<?php echo $id; ?>&anno=<?php echo $anno; ?>" target="_blank"><i class="fa fa-print fa-fw"></i> Stampa ricevuta Protocollo</a><br><?php } ?>
							<a class="iframe" data-fancybox-type="iframe" href="stampa-barcode.php?id=<?php echo $id;?>&anno=<?php echo $anno;?>"> <i class="fa fa-barcode fa-fw"></i> Stampa etichetta barcode</a><br>
							<a href="login0.php?corpus=protocollo2&from=crea"><i class="fa fa-plus-circle fa-fw"></i> Registra nuovo Protocollo</a><br>
						
					</div>
				</div>
			</div>
		</div>
		
		<?php
		if($modifica['idanagrafica'] != 0) {
			$anagrafica = new Anagrafica();
			$query = $connessione->query("SELECT * FROM storico_modifiche, lettere$anno WHERE storico_modifiche.protocollo ='$id' AND storico_modifiche.anno ='$anno' AND lettere$anno.idlettera = storico_modifiche.protocollo ORDER BY id");
			?>
			<br>
			<div class="row smartphone">
				<div class="col-sm-12">

					<h3><span class="glyphicon glyphicon-time"></span> Storico delle modifiche:</h3><br>
			
					<table class="table table-bordered">
						<tr>
							<td style="vertical-align: middle" align="center" >Data</td>
							<td style="vertical-align: middle" align="center" >Utente</td>
							<td style="vertical-align: middle" align="center" >Modifica</td>
							<td style="vertical-align: middle" align="center" >Valore precedente</td>
							<td style="vertical-align: middle" align="center" >Valore attuale</td>
						</tr>
						<?php
							while($mod = $query->fetch()) {
								?>
								<tr bgcolor="<?php echo $mod['color']; ?>">
									<td style="vertical-align: middle" align="center" ><?php echo date('d/m/Y H:i',$mod['time']); ?></td>
									<td style="vertical-align: middle" align="center" ><?php echo $anagrafica->getName($mod['user']); ?></td>
									<td style="vertical-align: middle" align="center" ><?php echo $mod['modifica']; ?></td>
									<td style="vertical-align: middle" align="center" ><?php echo stripslashes($mod['prima']); ?></td>
									<td style="vertical-align: middle" align="center" ><?php echo stripslashes($mod['dopo']); ?></td>
								</tr>
								<?php
							}
						?>
					</table>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>