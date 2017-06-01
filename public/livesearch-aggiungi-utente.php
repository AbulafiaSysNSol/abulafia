<?php

	session_start();
	
	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}


	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	$sql=mysql_query("SELECT * FROM anagrafica WHERE ((cognome like '%$q%') OR (idanagrafica = '$q')) and tipologia='persona' limit 15");

	while($row = mysql_fetch_array($sql)) {
		echo "<br>";?>
		<a href="login0.php?corpus=gestione-utenti-aggiungi-utente2&id=<?php echo $row['idanagrafica'];?>&cognome=<?php echo $row['cognome'];?>&nome=<?php echo $row['nome'];?>">
		<?php echo $row['cognome'].' '.$row['nome'];?></a>
		<?php echo "<br>";
	}

	mysql_close ($verificaconnessione);

?>