<?php
	
	$my_lettera = new Lettera();
	$ultimoid = $_GET['id'];
	$annoprotocollo = $_GET['anno'];
	$from = $_GET['from'];
	
?>

<div class="panel panel-default">
  <div class="panel-body">
   
	<div class="row">
		<div class="col-sm-12">
			<?php
			if($from != "modifica" OR $_SESSION['block']) {
				?>
				<div class="alert alert-success">
					<span class="glyphicon glyphicon-ok">
					</span> 
					Protocollo registrato <b>correttamente.</b>
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-success">
					<span class="glyphicon glyphicon-ok">
					</span> 
					Protocollo modificato <b>correttamente.</b>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-5">
			<h4><i class="fa fa-list"></i> Riepilogo:</h4>
			<?php 
				$my_lettera -> publdisplaylettera ($ultimoid, $annoprotocollo); //richiamo del metodo "mostra"
			?>
		</div>
		
		<div class="col-sm-5">
			<h4><i class="fa fa-cog"></i> Opzioni:</h4>
			<p>	<a href="login0.php?corpus=protocollo2
					&from=crea">
					<i class="fa fa-plus-square"></i> 
					Registrazione nuovo protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=dettagli-protocollo
					&id=<?php echo $ultimoid;?>&anno=<?php echo $annoprotocollo;?>"> 
					<span class="glyphicon glyphicon-info-sign">
					</span> 
					Dettagli protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=modifica-protocollo
					&from=risultati
					&id=<?php echo $ultimoid;?>
					&anno=<?php echo $annoprotocollo;?>"> 
					<span class="glyphicon glyphicon-edit">
					</span> 
					Modifica questo protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=invia-newsletter
					&id=<?php echo $ultimoid;?>
					&anno=<?php echo $annoprotocollo;?>"> 
					<span class="glyphicon glyphicon-envelope">
					</span> 
					Invia tramite email
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=aggiungi-inoltro
				&id=<?php echo $ultimoid;?>
				&anno=<?php echo $annoprotocollo;?>"> 
				<span class="glyphicon glyphicon-pencil">
				</span> 
				Aggiungi inoltro email manuale
				</a>
			</p>	
			<p>
				<a 	class="iframe" 
					data-fancybox-type="iframe" 
					href="stampa-barcode.php?id=<?php echo $ultimoid;?>&anno=<?php echo $annoprotocollo;?>"> 
					<span class="glyphicon glyphicon-barcode"></span> Stampa etichetta barcode
				</a>
			</p>
			<?php
			if(!$my_lettera->isSpedita($ultimoid, $annoprotocollo)) {
				?>
				<a href="stampa-protocollo.php?id=<?php echo $ultimoid; ?>
					&anno=<?php echo $annoprotocollo; ?>"
					target="_blank">
					<i class="fa fa-print">
					</i> 
					Stampa ricevuta Protocollo
				</a>
				<?php
			}
			?>
		</div>
	</div>
  </div>
</div>

<?php
	$_SESSION['block'] = false;
?>