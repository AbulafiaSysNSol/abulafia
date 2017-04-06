<?php

	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}
	
	include '../db-connessione-include.php';
	include 'class/Servizio.obj.inc';
	$p = new Servizio();
	$codice = $_POST['codice'];
	$descrizione = $_POST['descrizione'];
	$indirizzo = $_POST['indirizzo'];
	$citta = $_POST['citta'];
	$cap = $_POST['cap'];
	$telefono = $_POST['telefono'];
	$email = $_POST['email'];
	$magazzino = $_POST['magazzino'];
	
	$res = $p -> inserisciServizio($codice, $descrizione, $indirizzo, $citta, $cap,$telefono, $email, $magazzino); 
	
	if($res) {
		header("Location: login0.php?corpus=magazzino-aggiungi-servizio&insert=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>