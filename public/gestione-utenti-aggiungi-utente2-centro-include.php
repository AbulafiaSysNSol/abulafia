<?php 

	$id = $_GET['id'];
	$nome = str_replace("'","",$_GET['nome']);
	$cognome = str_replace("'","",$_GET['cognome']);	
	$nomenuovoutente = strtolower($nome.'.'.$cognome);
	$passwordnuovoutente = md5($nomenuovoutente);

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO users VALUES(:id, 0, :nomenuovoutente, :passwordnuovoutente, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)"); 
		$query->bindParam(':id', $id);
		$query->bindParam(':nomenuovoutente', $nomenuovoutente);
		$query->bindParam(':passwordnuovoutente', $passwordnuovoutente);
		$query->execute();
		$connessione->commit();
		$nuovoutente = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$nuovoutente = false;
	 	exit();
	}	

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO usersettings VALUES(:id, 30, '', '#DEFEB4', '#FFFFCC', '100%', '0', '0')"); 
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$setting = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$setting = false;
	 	exit();
	}	
?>

<script language = "javascript"> 
	window.location="login0.php?corpus=gestione-utenti";
</script>