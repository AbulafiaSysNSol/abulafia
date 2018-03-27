<?php

	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	$idlettera = $_GET['id'];
	$from = $_GET['from'];
	
	$delete = mysql_query(" DELETE FROM comp_lettera WHERE id = $idlettera "); 
	
	if($delete) {
		header("Location: login0.php?corpus=".$from."&delete=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>