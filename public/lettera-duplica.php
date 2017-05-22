<?php
	
	session_start();
	
	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}

	include '../db-connessione-include.php'; //connessione al db-server
	
	$lett = new Lettera();
	$id = $_GET['id'];
	
	$duplica = $lett->duplicaLettera($id);
	
	if($duplica) {
		header("Location: login0.php?corpus=elenco-lettere");
	}
	else {
		echo 'Errore nella duplicazione della lettera';
	}
?>