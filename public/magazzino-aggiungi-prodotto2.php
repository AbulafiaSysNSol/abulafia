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
	$descrizione = $_POST['descrizione'];
	if($_POST['prezzo'] == '') {
		$prezzo = 0;
	}
	else {
		$prezzo = str_replace(',','.',$_POST['prezzo']);
	}
	$note = $_POST['note'];
	$unita = $_POST['unitadimisura'];
	$barcode = $_POST['codicebarre'];
	
	$res = $p -> inserisciProdotto($descrizione, $prezzo, $note, $unita,$barcode); 
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-aggiungi-prodotto&insert=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>