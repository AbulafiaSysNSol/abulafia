<?php

	session_start();
	
	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}
	
	include '../db-connessione-include.php';

	$idlettera = $_GET['idlettera'];
	$idanagrafica = $_GET['idanagrafica'];
	$attributo = $_GET['attributo'];
	
	$update = mysql_query(" UPDATE comp_destinatari SET attributo = '$attributo' WHERE idanagrafica = $idanagrafica AND idlettera = $idlettera "); 

?>
