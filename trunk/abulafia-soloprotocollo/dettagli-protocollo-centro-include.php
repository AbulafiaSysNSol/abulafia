<?php
	$my_lettera = new Lettera(); //crea un nuovo oggetto 'lettera'
	$id = $_GET['id'];
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dettagli Protocollo: <?php echo $id; ?></strong></h3>
	</div>
	
	<div class="panel-body">
		<?php 
		$my_lettera -> publdisplaylettera ($id, $_SESSION['annoricercaprotocollo']); //richiamo del metodo "mostra" dell'oggetto Lettera
		?> 
	</div>
  
  	<div class="panel-heading">
		<h3 class="panel-title"><strong>Opzioni:</strong></h3>
	</div>
	
	<div class="panel-body">
		<p><a href="login0.php?corpus=modifica-protocollo&from=risultati&id=<?php echo $_GET['id'];?>"> <span class="glyphicon glyphicon-edit"></span> Modifica questo Protocollo</a></p>
		<p><a href="login0.php?corpus=invia-newsletter&id=<?php echo $_GET['id'];?>"> <span class="glyphicon glyphicon-envelope"></span> Invia tramite Email</a></p>					
		<p><a href="login0.php?corpus=protocollo"> <span class="glyphicon glyphicon-plus-sign"></span> Registra nuovo Protocollo</a></p>
	</div>
</div>