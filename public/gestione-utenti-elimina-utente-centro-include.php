<?php

	$id = $_GET['id'];

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM users WHERE idanagrafica = :id LIMIT 1"); 
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$cancellazione = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$cancellazione = false;
	}	
	
	if (!$cancellazione) {
		echo 'Impossibile compiere l\'azione richiesta';  
		exit();
	}
?>

<script language = "javascript">
	window.location="login0.php?corpus=gestione-utenti";
</script>
