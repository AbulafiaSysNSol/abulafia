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
			<div class="col-xs-4">
				<h3><i class="fa fa-info"></i> Dettagli Protocollo</h3>
				<div class="row">
					<div class="col-md-11 col-md-offset-1">
						<?php
						echo '<ul>';
						echo '<li>Spedita/Ricevuta: <b>'. $dettagli['speditaricevuta'] . '</b></li>';
						echo '<li>Data della Lettera: <b>'. $calendario->dataSlash($dettagli['datalettera']) . '</b></li>';
						echo '<li>Mezzo di Trasmissione: <b>'. $dettagli['posizione'] . '</b></li>';
						echo '<li>Posizione: <b>'. $dettagli['riferimento'] . ' - ' . $my_lettera->getDescPosizione($dettagli['riferimento']) . '</b></li>';
						echo '<li>Pratica: <b>'. $my_lettera->getDescPratica($dettagli['pratica']) . '</b></li>';
						echo '<li>Note: <b>'. $dettagli['note'] . '</b></li>';
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
								<?php echo '<li><b>' . $valore['nome'] . '  ' . $valore['cognome'] . '</b></li>' ;?>
							</a>
							<?php
						}
						?>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="col-xs-2">
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
							<li><a href="login0.php?corpus=invia-newsletter&id=<?php echo $_GET['id'];?>"> <span class="glyphicon glyphicon-envelope"></span> Invia tramite Email</a></li>
							<li><a href="login0.php?corpus=protocollo2&from=crea" onClick="return confirm('ATTENZIONE: OPERAZIONE NON REVERSIBILE\n\nCreare nuovo numero di protocollo?');"><span class="glyphicon glyphicon-plus-sign"></span> Registra nuovo Protocollo</a></li>
						</ul>
					</div>
				</div>
			</div>
			
		</div>



<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dettagli Protocollo: <?php echo $id; ?></strong></h3>
	</div>
	
	<div class="panel-body">
		<?php 
		$my_lettera -> publdisplaylettera ($id, $anno); //richiamo del metodo "mostra" dell'oggetto Lettera
		?> 
	</div>
  
  	<div class="panel-heading">
		<h3 class="panel-title"><strong>Opzioni:</strong></h3>
	</div>
	
	<div class="panel-body">
		<a href="login0.php?corpus=modifica-protocollo&from=risultati&id=<?php echo $_GET['id'];?>"> <span class="glyphicon glyphicon-edit"></span> Modifica questo Protocollo</a></p>
		<a href="login0.php?corpus=invia-newsletter&id=<?php echo $_GET['id'];?>"> <span class="glyphicon glyphicon-envelope"></span> Invia tramite Email</a></p>					
		<a href="login0.php?corpus=protocollo2&from=crea" onClick="return confirm('ATTENZIONE: OPERAZIONE NON REVERSIBILE\n\nCreare nuovo numero di protocollo?');"><span class="glyphicon glyphicon-plus-sign"></span> Registra nuovo Protocollo</a>
	</div>
</div>