<?php

	$id = $_GET['id'];
	$codice = $_POST['codice'];
	$descrizione = stripslashes($_POST['descrizione']);
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE titolario SET codice = :codice, descrizione = :descrizione WHERE id = :id "); 
		$query->bindParam(':codice', $codice);
		$query->bindParam(':descrizione', $descrizione);
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$up = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	   	$up = false;
	}

	if ($up) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATA POSIZIONE '. $id , 'OK' , 'NUOVO VALORE '. $codice . ' ' . $descrizione , $_SESSION['logname'], 'protocollo');
		?>
		<script language="javascript">
			window.location="login0.php?corpus=titolario&mod=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA POSIZIONE '. $id , 'FAILED' , 'VALORE '. $codice . ' ' . $descrizione , $_SESSION['logname'], 'protocollo');
		?>
		<script language="javascript">
			window.location="login0.php?corpus=titolario&mod=no";
		</script>
		<?php
	}

?>
