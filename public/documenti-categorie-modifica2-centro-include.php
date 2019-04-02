<?php

	$id = $_GET['id'];
	$descrizione = $_POST['descrizione'];

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE categorie SET categoria = :descrizione where id = :id"); 
		$query->bindParam(':descrizione', $descrizione);
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$update = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$update = false;
	}	

	if ($update) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATA CATEGORIA '. $id , 'OK' , 'NUOVO VALORE '. $descrizione , $_SESSION['logname'], 'categorie');
		?>
		<script language="javascript">
			window.location="?corpus=documenti-categorie&mod=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA CATEGORIA '. $id , 'FAILED' , 'VALORE '. $descrizione , $_SESSION['logname'], 'categorie');
		?>
		<script language="javascript">
			window.location="?corpus=documenti-categorie&mod=no";
		</script>
		<?php
	}

?>
