<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';
	include 'class/Anagrafica.obj.inc';
	$a = new Anagrafica();
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	$codicefiscale = $_POST['codicefiscale'];
	$email = $_POST['email'];
	
	$inserimentovolontario = $a->nuovoVolontario($nome, $cognome, $codicefiscale, $email); 
	
	if($inserimentovolontario) {
		header("Location: login0.php?corpus=co-volontari&insert=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>
