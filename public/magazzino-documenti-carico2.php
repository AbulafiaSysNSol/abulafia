<?php 

	include '../db-connessione-include.php';
	include 'class/Magazzino.obj.inc';
	include 'class/Calendario.obj.inc';
	$m = new Magazzino();
	$d = new Calendario();
	$datadocumento=$d->dataDB($_POST['datadocumento']);
	$magazzino=$_POST['magazzino'];
	$riferimento=$_POST['riferimento'];
	$causale=$_POST['causale'];
	$datariferimento=$d->dataDB($_POST['datariferimento']);
	$note=$_POST['note'];

	$ins = $m->newDocument($datadocumento, $magazzino, $riferimento, $causale, $datariferimento, $note);

	if($ins) {
		header("Location: login0.php?corpus=magazzino-documenti");
	}
	else {
		echo 'Errore nella registrazione dei dati<br><br>' . mysql_error();
	}

?>
