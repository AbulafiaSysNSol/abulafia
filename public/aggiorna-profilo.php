<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';
	include 'class/Anagrafica.obj.inc';
	include 'class/Calendario.obj.inc';
	$a = new Anagrafica();
	$c = new Calendario();
	$id = $_GET['id'];
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	$data = $c->dataDB($_POST['data']);
	$luogonascita = $_POST['luogonascita'];
	$codicefiscale = $_POST['codicefiscale'];
	$email = $_POST['email'];
	if(isset($_POST['terminiecondizioni'])) {
		$terminiecondizioni = 1;
	}
	else {
		$terminiecondizioni = 0;
	}
	
	$res = $a->a($id, $nome, $cognome, $data, $luogonascita, $codicefiscale, $email, $terminiecondizioni); 
	
	if($res) {
		header("Location: login0.php?corpus=home&profile=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>
