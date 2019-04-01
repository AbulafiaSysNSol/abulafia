<?php 

	$owner = $_SESSION['loginid'];
	$descrizione = $_POST['descrizione'];

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO categorie VALUES(null, :descrizione, :owner)"); 
		$query->bindParam(':descrizione', $descrizione);
		$query->bindParam(':owner', $owner);
		$query->execute();
		$connessione->commit();
		$inserimento = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$inserimento = false;
	}	

	if($inserimento) {
		?>
		<script language="javascript">
			window.location="?corpus=documenti-categorie&add=ok";
		</script>
		<?php
	}

	else {
		?>
		<script language="javascript">
			window.location="?corpus=documenti-categorie&add=no";
		</script>
		<?php 
	}

?>