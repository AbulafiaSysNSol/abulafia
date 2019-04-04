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
	$d = new Calendario();
	$tipologia = $_GET['tipologia'];
	$datadocumento=$d->dataDB($_POST['datadocumento']);
	$magazzino=$_POST['magazzino'];
	$riferimento=$_POST['riferimento'];
	$causale=$_POST['causale'];
	$datariferimento=$d->dataDB($_POST['datariferimento']);
	$note=$_POST['note'];

	$ins = $m->newDocument($datadocumento, $magazzino, $riferimento, $causale, $datariferimento, $note, $tipologia);
	$id = $connessione->lastInsertId();

	if($ins) {
		header("Location: login0.php?corpus=magazzino-documenti-carico-scarico-prodotti&id=$id&tipologia=$tipologia");
	}
	else {
		echo 'Errore nella registrazione dei dati<br><br>';
	}

?>
