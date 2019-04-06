<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';
	include 'class/Servizio.obj.inc';
	$p = new Servizio();
	$codice = $_POST['codice'];
	$descrizione = $_POST['descrizione'];
	$indirizzo = $_POST['indirizzo'];
	$citta = $_POST['citta'];
	$cap = $_POST['cap'];
	$telefono = $_POST['telefono'];
	$email = $_POST['email'];
	$magazzino = $_POST['magazzino'];
	
	$res = $p -> inserisciServizio($codice, $descrizione, $indirizzo, $citta, $cap,$telefono, $email, $magazzino); 
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-aggiungi-servizio&insert=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>