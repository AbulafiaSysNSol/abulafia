<?php

	$id = $_GET['id'];

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM users WHERE idanagrafica = :id LIMIT 1"); 
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	exit();
	}

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM usersettings WHERE idanagrafica = :id LIMIT 1"); 
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	exit();
	}

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE anagrafica SET volontario = '0' WHERE idanagrafica = :id LIMIT 1"); 
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	exit();
	}

?>

<script language = "javascript">
	window.location="login0.php?corpus=gestione-utenti";
</script>