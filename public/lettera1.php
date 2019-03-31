<?php
	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php'; //connessione al db-server
	include 'class/Calendario.obj.inc';
	
	$calendario = new Calendario();
	
	$data = $calendario->dataDB($_POST['data']);
	$allegati = $_POST['allegati'];
	$oggetto = addslashes($_POST['oggetto']);
	$testo = addslashes($_POST['message']);
	$ufficio = addslashes($_POST['ufficio']);
	$vista = 0;
	$firmata = 0;
	$insert = $_SESSION['loginid'];
	
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO comp_lettera VALUES ( '', '', '', :data, :oggetto, :testo, :allegati, :vista, :firmata, :insert, :ufficio)"); 
		$query->bindParam(':data', $data);
		$query->bindParam(':oggetto', $oggetto);
		$query->bindParam(':testo', $testo);
		$query->bindParam(':allegati', $allegati);
		$query->bindParam(':vista', $vista);
		$query->bindParam(':firmata', $firmata);
		$query->bindParam(':insert', $insert);
		$query->bindParam(':ufficio', $ufficio);
		$query->execute();
		$id = $connessione->lastInsertId();
		$connessione->commit();
		$insert = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$insert = false;
	}	
	
	if($insert) {
		header("Location: login0.php?corpus=lettera2&id=" . $id);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>