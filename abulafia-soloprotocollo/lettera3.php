<?php
	session_start();
	include '../db-connessione-include.php'; //connessione al db-server
	include 'class/Calendario.obj.inc';
	$id = $_GET['idlettera'];
	$from = $_GET['from'];
	
	$calendario = new Calendario();
	
	$data = $calendario->dataDB($_POST['data']);
	$allegati = $_POST['allegati'];
	$oggetto = addslashes($_POST['oggetto']);
	$testo = addslashes($_POST['message']);
	$vista = 0;
	$firmata = 0;
	$insert = $_SESSION['loginid'];
	
	$update = mysql_query(" UPDATE comp_lettera SET data = '$data', oggetto = '$oggetto', testo = '$testo', allegati = '$allegati' WHERE id = $id ");
	echo mysql_error();
	
	if($update) {
		header("Location: login0.php?corpus=".$from."&id=" . $id);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>