<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php'; //connessione al db-server
	$idlettera = $_GET['idlettera'];
	
	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE comp_lettera SET vista = 1 WHERE id = :idlettera"); 
		$query->bindParam(':idlettera', $idlettera);
		$query->execute();
		$connessione->commit();
		$up = true;
	}	 
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
    	$connessione->rollBack();
    	$up = false;
	}

	if($up) {
		header("Location: login0.php?corpus=home&firma=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>