<?php
	$my_lettera = new Lettera(); //crea un nuovo oggetto 'lettera'
	$calendario = new Calendario();
	$id = $_GET['id'];
	
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

<hr>
	<center>
		<h2>
			<i class="fa fa-book"></i> Protocollo N. <b><?php echo $dettagli['idlettera']; ?></b> del <b><?php echo $calendario->dataSlash($dettagli['dataregistrazione']); ?></b>
		</h2>
		<h4>
			"<?php echo $dettagli['oggetto']; ?>"
		</h4>
	</center>
<hr>


		<div class="row">
			<div class="col-xs-3">
				<h3><i class="fa fa-info"></i> Dettagli Protocollo</h3>
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
			</div>
			
			<div class="col-xs-3">
				<h3><i class="fa fa-users"></i> Mittenti/Destinatari</h3>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul>
						<?php
						foreach($mittenti as $valore) {
							?>
							<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $valore['idanagrafica'];?>"> 
								<?php echo '<li>' . $valore['nome'] . '  ' . $valore['cognome'] . '</li>' ;?>
							</a>
							<?php
						}
						?>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="col-xs-3">
				<h3><i class="fa fa-files-o"></i> File Allegati</h3>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<?php
						$my_file = new File(); 					
						$urlfile= $my_lettera->cercaAllegati($dettagli['idlettera'], $anno);
						if ($urlfile) {
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
			</div>
			
			<div class="col-xs-3">
				<h3><i class="fa fa-cog"></i> Opzioni</h3>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<ul>
							<li><a href="login0.php?corpus=modifica-protocollo&from=risultati&id=<?php echo $_GET['id'];?>"> <span class="glyphicon glyphicon-edit"></span> Modifica questo Protocollo</a></li>
							<li><a href="login0.php?corpus=invia-newsletter&id=<?php echo $_GET['id'];?>&anno=<?php echo $anno;?>"> <span class="glyphicon glyphicon-envelope"></span> Invia tramite Email</a></li>
							<li><a href="login0.php?corpus=protocollo2&from=crea" onClick="return confirm('ATTENZIONE: OPERAZIONE NON REVERSIBILE\n\nCreare nuovo numero di protocollo?');"><span class="glyphicon glyphicon-plus-sign"></span> Registra nuovo Protocollo</a></li>
							<li><a href="login0.php?corpus=aggiungi-inoltro&id=<?php echo $_GET['id'];?>&anno=<?php echo $anno;?>"> <span class="glyphicon glyphicon-pencil"></span> Aggiungi inoltro email</a></li>
						</ul>
					</div>
				</div>
			</div>
			
		</div>
		
		<br>
		
		<div class="row">
			<div class="col-md-4">
				<h3><i class="fa fa-user"></i> Inserimento effettuato da:</h3>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
					<ul><li>
						<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $inserimento['idanagrafica'];?>"> 
						<?php echo $inserimento['nome'] . '  ' . $inserimento['cognome'] . '</a> il ' . $calendario->dataSlash($dettagli['dataregistrazione']);?>
					</li></ul>
					</div>
				</div>
				
				<h3><i class="fa fa-user"></i> Ultima modifica:</h3>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
					<ul><li>
						<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=
						<?php echo $modifica['idanagrafica'];?>"> 
						<?php echo $modifica['nome'] . '  ' . $modifica['cognome'] . '</a> il ' . $calendario->dataSlash($modifica['datamod']);?>
					</li></ul>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				<h3><i class="fa fa-paper-plane-o"></i> Protocollo inoltrato a:</h3>
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
			</div>
			</div>