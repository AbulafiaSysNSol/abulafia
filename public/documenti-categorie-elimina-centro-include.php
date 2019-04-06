<?php

	$id = $_GET['id'];

	
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM categorie WHERE id = :id LIMIT 1"); 
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
	
	if ($cancellazione) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATA CATEGORIA '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'categorie');
		?>
		<script language="javascript">
			window.location="?corpus=documenti-categorie&canc=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE POSIZIONE '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['logfile'], 'categorie');
		?>
		<script language="javascript">
			window.location="?corpus=documenti-categorie&canc=no";
		</script>
		<?php
	}

?>
