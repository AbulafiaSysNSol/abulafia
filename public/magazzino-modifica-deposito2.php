<?php
	include '../db-connessione-include.php';
	include 'class/Magazzino.obj.inc';
	$m = new Magazzino();
	$id = $_GET['id'];
	$prodotto = $_GET['prodotto'];
	$magazzino = $_GET['magazzino'];
	$settore = $_POST['settore'];
	$scortaminima = $_POST['scortaminima'];
	$riordino = $_POST['riordino'];
	$confezionamento = $_POST['confezionamento'];
	
	$res = $m->modificaDeposito($id, $settore, $scortaminima, $riordino, $confezionamento); 
	
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-depositi&edit=ok&magazzino=".$magazzino."&prodotto=".$prodotto);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>