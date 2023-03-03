<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';
	include 'class/Prodotto.obj.inc';
	include 'class/Calendario.obj.inc';
	$p = new Prodotto();
	$c = new Calendario();
	$codiceprodotto = $_GET['id'];
	$magazzino = $_POST['magazzino'];
	$settore = $_POST['settore'];
	$scortaminima = $_POST['scortaminima'];
	$riordino = $_POST['riordino'];
	$giacenzainiziale = $_POST['giacenzainiziale'];
	$lotto = $_POST['lotto'];
	if ($_POST['scadenza'] == NULL) {
		$_POST['scadenza'] = "00/00/0000";
	}
	$scadenza = $c->dataDB($_POST['scadenza']);
	$confezionamento = $_POST['confezionamento'];
	
	$res = $p->assegnaProdotto($codiceprodotto, $magazzino, $settore, $scortaminima, $riordino, $giacenzainiziale, $lotto, $scadenza, $confezionamento); 
	
	if($res == 1) {
		header("Location: login0.php?corpus=magazzino-prodotti&insert=ok");
	}
	else if($res == "duplicate") {
		header("Location: login0.php?corpus=magazzino-prodotti&insert=duplicate");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>