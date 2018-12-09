<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	$idvisita = $_POST['idvisita'];
	$idanagrafica = $_POST['idanagrafica'];

	$c = new Calendario();

	$tipo = $_POST['tipocertificato'];
	$idrichiedente = $_SESSION['loginid'];
	$data = date("Y-m-d", time());

	$insert = mysql_query("INSERT INTO cert_richieste VALUES ('', '$idanagrafica', '$idvisita', '$tipo', '$data', '$idrichiedente', '0', '0', '0')");
	
	if($insert) {
		header("Location: login0.php?corpus=cert-search-anag&richiesta=ok");
	}
	else {
		echo mysql_error();
	}
?>