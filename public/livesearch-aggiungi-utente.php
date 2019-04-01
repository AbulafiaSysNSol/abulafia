<?php

	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}


	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q = $_GET['q'];
	$sql = $connessione->query("SELECT * FROM anagrafica WHERE ((cognome like '%$q%') OR (idanagrafica = '$q')) and tipologia='persona' limit 15");

	while($row = $sql->fetch()) {
		echo "<br>";?>
		<a href="login0.php?corpus=gestione-utenti-aggiungi-utente2&id=<?php echo $row['idanagrafica'];?>&cognome=<?php echo str_replace("\'", "",$row['cognome']);?>&nome=<?php echo str_replace("\'","",$row['nome']);?>">
		<?php echo stripslashes($row['cognome'].' '.$row['nome']);?></a>
		<?php echo "<br>";
	}

	$connessione = null;

?>