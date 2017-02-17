<?php

	include '../db-connessione-include.php';

	$id = $_GET['id'];
	$num = $_GET['num'];
	$value = $_GET['value'];
	$riga = 'riga'.$num;
	
	$update = mysql_query(" UPDATE comp_destinatari SET $riga = '$value' WHERE id = $id "); 

?>