<?php

	$id = $_GET['id'];
	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("DELETE FROM titolario WHERE id = :id LIMIT 1"); 
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$canc = true;
	}	 
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
    	$connessione->rollBack();
    	$canc = false;
	}
	
	if ($canc) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATA POSIZIONE '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'protocollo');
		?>
		<script language="javascript">
			window.location="login0.php?corpus=titolario&canc=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE POSIZIONE '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['logfile'], 'protocollo');
		?>
		<script language="javascript">
			window.location="login0.php?corpus=titolario&canc=no";
		</script>
		<?php
	}

?>
