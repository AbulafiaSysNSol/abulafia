<?php 

	$attributo = $_POST['descrizione'];
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO attributi VALUES(null, :attributo)"); 
		$query->bindParam(':attributo', $attributo);
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
		<script language = "javascript">
			window.location="login0.php?corpus=attributi&add=ok";
		</script>
		<?php
	}
	else {
	?>
		<script language = "javascript">
			window.location="login0.php?corpus=attributi&add=no";
		</script>
	<?php 
	}

?>