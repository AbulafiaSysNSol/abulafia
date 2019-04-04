<?php

	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php';

	$idlettera = $_GET['idlettera'];
	$idanagrafica = $_GET['idanagrafica'];
	$attributo = $_GET['attributo'];
	
	$update = $connessione->query(" UPDATE comp_destinatari SET attributo = '$attributo' WHERE idanagrafica = $idanagrafica AND idlettera = $idlettera "); 

?>
