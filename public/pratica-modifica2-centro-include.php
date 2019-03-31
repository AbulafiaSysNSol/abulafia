<?php

	$id = $_GET['id'];
	$descrizione = $_POST['descrizione'];

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE pratiche SET descrizione = :descrizione where id = :id "); 
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
		?>
		<SCRIPT LANGUAGE="Javascript">
			window.location="login0.php?corpus=pratiche&mod=ok";
		</SCRIPT>
		<?php
	}
	else {
		?>
		<SCRIPT LANGUAGE="Javascript">
			window.location="login0.php?corpus=pratiche&mod=no";
		</SCRIPT>
		<?php
	}

?>
