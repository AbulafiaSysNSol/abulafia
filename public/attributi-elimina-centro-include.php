<?php

	$id = $_GET['id'];
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM attributi WHERE id = :id LIMIT 1"); 
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
		$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATO ATTRIBUTO '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'attributi');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=attributi&canc=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE ATTRIBUTO '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['logfile'],'attributi');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=attributi&canc=no";
		</script>
		<?php
	}

?>
