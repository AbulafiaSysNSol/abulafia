<?php

	include '../db-connessione-include.php';

	$idlettera = $_GET['idlettera'];
	$idanagrafica = $_GET['idanagrafica'];
	$attributo = $_GET['attributo'];
	
	$update = mysql_query(" UPDATE comp_destinatari SET attributo = '$attributo' WHERE idanagrafica = $idanagrafica AND idlettera = $idlettera "); 

?>