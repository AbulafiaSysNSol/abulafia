<?php

	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}

	include '../db-connessione-include.php'; //connessione al db-server
	$idlettera = $_GET['idlettera'];
	
	$update = $verificaconnessione->query(" UPDATE comp_lettera SET vista = 1 WHERE id = $idlettera "); 
	
	if($update) {
		header("Location: login0.php?corpus=home&firma=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>
