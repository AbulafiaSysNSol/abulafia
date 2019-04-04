<?php
	
	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include 'class/Log.obj.inc';
	include '../db-connessione-include.php'; //connessione al db-server
	$idanagrafica = $_GET['idanagrafica'];
	$idlettera = $_GET['idlettera'];
	$conoscenza = $_GET['conoscenza'];
	
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM comp_destinatari WHERE idanagrafica = :idanagrafica AND idlettera = :idlettera AND conoscenza = :conoscenza  limit 1"); 
		$query->bindParam(':idanagrafica', $idanagrafica);
		$query->bindParam(':idlettera', $idlettera);
		$query->bindParam(':conoscenza', $conoscenza);
		$query->execute();
		$connessione->commit();
		$cancellazione = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$cancellazione = false;
	}
	
	if($cancellazione) {
		header("Location: login0.php?corpus=lettera2&id=" . $idlettera);
	}
	else {
		echo 'Errore nella cancellazione dei dati';
	}
	
?>