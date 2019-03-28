<?php
	
	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	$idanagrafica = $_GET['idanagrafica'];
	$idlettera = $_GET['idlettera'];
	$conoscenza = $_GET['conoscenza'];
	
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO comp_destinatari VALUES (null, :idlettera, :idanagrafica, :conoscenza, 'Al', '', '')"); 
		$query->bindParam(':idlettera', $idlettera);
		$query->bindParam(':idanagrafica', $idanagrafica);
		$query->bindParam(':conoscenza', $conoscenza);
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
		header("Location: login0.php?corpus=lettera2&id=" . $idlettera);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
	
?>