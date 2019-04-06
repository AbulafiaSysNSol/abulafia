<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';
	include 'class/Prodotto.obj.inc';
	$p = new Prodotto();
	$codiceprodotto = $_GET['id'];
	$magazzino = $_POST['magazzino'];
	$settore = $_POST['settore'];
	$scortaminima = $_POST['scortaminima'];
	$riordino = $_POST['riordino'];
	$giacenzainiziale = $_POST['giacenzainiziale'];
	$confezionamento = $_POST['confezionamento'];
	
	$res = $p->assegnaProdotto($codiceprodotto, $magazzino, $settore, $scortaminima, $riordino, $giacenzainiziale, $confezionamento); 
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-prodotti&insert=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>