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
	$id = $_GET['id'];
	$codice = $_POST['codice'];
	$descrizione = $_POST['descrizione'];
	$indirizzo = $_POST['indirizzo'];
	$citta = $_POST['citta'];
	$cap = $_POST['cap'];
	$telefono = $_POST['telefono'];
	$email = $_POST['email'];
	$magazzino = $_POST['magazzino'];
	
	$res = $p->modificaServizio($id, $codice, $descrizione, $indirizzo, $citta, $cap,$telefono, $email, $magazzino); 
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-modifica-servizio&edit=ok&id=".$codice);
	}
	else {
		echo '<br><br>Errore nella registrazione dei dati: <br>';
	}
?>