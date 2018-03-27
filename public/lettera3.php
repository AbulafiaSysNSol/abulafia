<?php
	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php'; //connessione al db-server
	include 'class/Calendario.obj.inc';
	$id = $_GET['idlettera'];
	$from = $_GET['from'];
	
	$calendario = new Calendario();
	
	$data = $calendario->dataDB($_POST['data']);
	$allegati = $_POST['allegati'];
	$oggetto = addslashes($_POST['oggetto']);
	$testo = addslashes($_POST['message']);
	$ufficio = addslashes($_POST['ufficio']);
	$vista = 0;
	$firmata = 0;
	$insert = $_SESSION['loginid'];
	
	$update = mysql_query(" UPDATE comp_lettera SET data = '$data', oggetto = '$oggetto', testo = '$testo', allegati = '$allegati', ufficio = '$ufficio' WHERE id = $id ");
	echo mysql_error();
	
	if($update) {
		header("Location: login0.php?corpus=".$from."&id=" . $id);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>