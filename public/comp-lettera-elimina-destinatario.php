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
	
	$cancellazione=mysql_query("DELETE FROM comp_destinatari WHERE idanagrafica='$idanagrafica' AND idlettera='$idlettera' AND conoscenza = $conoscenza  limit 1");
	
	if($cancellazione) {
		header("Location: login0.php?corpus=lettera2&id=" . $idlettera);
	}
	else {
		echo 'Errore nella cancellazione dei dati';
	}
?>