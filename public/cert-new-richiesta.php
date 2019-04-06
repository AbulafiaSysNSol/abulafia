<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	$idvisita = $_POST['idvisita'];
	$idanagrafica = $_POST['idanagrafica'];

	$c = new Calendario();

	$tipo = $_POST['tipocertificato'];
	$idrichiedente = $_SESSION['loginid'];
	$data = date("Y-m-d", time());

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO cert_richieste VALUES (null, :idanagrafica, :idvisita, :tipo, :data, :idrichiedente, '0', '0', '0')"); 
		$query->bindParam(':idanagrafica', $idanagrafica);
		$query->bindParam(':idvisita', $idvisita);
		$query->bindParam(':tipo', $tipo);
		$query->bindParam(':data', $data);
		$query->bindParam(':idrichiedente', $idrichiedente);
		$query->execute();
		$connessione->commit();
		$insert = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$insert = false;
	}
	
	if($insert) {
		header("Location: login0.php?corpus=cert-search-anag&richiesta=ok");
	}
	
?>