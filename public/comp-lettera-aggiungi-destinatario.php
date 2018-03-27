<?php
	
	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	$idanagrafica = $_GET['idanagrafica'];
	$idlettera = $_GET['idlettera'];
	$conoscenza = $_GET['conoscenza'];
	
	$insert = mysql_query(" INSERT INTO comp_destinatari VALUES ( '', '$idlettera', '$idanagrafica', '$conoscenza', 'Al', '', '') "); 
	
	if($insert) {
		header("Location: login0.php?corpus=lettera2&id=" . $idlettera);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>