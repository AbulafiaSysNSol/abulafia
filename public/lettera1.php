<?php
	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
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
	
	$insert = mysql_query(" INSERT INTO comp_lettera VALUES ( '', '', '', '$data', '$oggetto', '$testo', '$allegati', '$vista', '$firmata', '$insert', '$ufficio') ");
	echo mysql_error();
	$id=mysql_insert_id();
	
	if($insert) {
		header("Location: login0.php?corpus=lettera2&id=" . $id);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>