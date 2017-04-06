<?php
	
	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}

	include '../db-connessione-include.php';

	$id = $_GET['id'];
	$num = $_GET['num'];
	$value = $_GET['value'];
	$riga = 'riga'.$num;
	
	$update = mysql_query(" UPDATE comp_destinatari SET $riga = '$value' WHERE id = $id "); 

?>