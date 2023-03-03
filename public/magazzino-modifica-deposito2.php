<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';
	include 'class/Magazzino.obj.inc';
	include 'class/Calendario.obj.inc';
	$m = new Magazzino();
	$c = new Calendario();
	$id = $_GET['id'];
	$prodotto = $_GET['prodotto'];
	$magazzino = $_GET['magazzino'];
	$settore = $_POST['settore'];
	$scortaminima = $_POST['scortaminima'];
	$riordino = $_POST['riordino'];
	$confezionamento = $_POST['confezionamento'];
	$lotto = $_POST['lotto'];
	$scadenza = $c->dataDB($_POST['scadenza']);
	
	$res = $m->modificaDeposito($id, $settore, $scortaminima, $riordino, $confezionamento, $lotto, $scadenza); 
	
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-depositi&edit=ok&magazzino=".$magazzino."&prodotto=".$prodotto);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>