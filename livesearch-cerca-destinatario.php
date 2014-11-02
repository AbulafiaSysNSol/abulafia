<?php

	session_start();
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	$idlettera=$_GET['idlettera'];
	$conoscenza = $_GET['conoscenza'];
	
	$sql=mysql_query("SELECT * FROM anagrafica WHERE cognome LIKE '%$q%' limit 6");
	while($row = mysql_fetch_array($sql)) {
		$row = array_map('stripslashes', $row);
		?>
		<br>
		<a href="comp-lettera-aggiungi-destinatario.php?idanagrafica=<?php echo $row['idanagrafica'];?>&idlettera=<?php echo $idlettera;?>&conoscenza=<?php echo $conoscenza;?>">
			<span class="glyphicon glyphicon-plus-sign"></span> <?php echo $row['cognome'].' '.$row['nome'];?>
		</a>
		<br>
		<?php
	}

	mysql_close ($verificaconnessione);

?>
