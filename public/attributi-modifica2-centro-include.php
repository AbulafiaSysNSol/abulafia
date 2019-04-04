<?php

	$id = $_GET['id'];
	$attributo = $_POST['descrizione'];
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE attributi SET attributo = :attributo WHERE id = :id"); 
		$query->bindParam(':attributo', $attributo);
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
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATO ATTRIBUTO '. $id , 'OK' , 'NUOVO VALORE '. $attributo , $_SESSION['logfile'],'attributi');
		?>
		<script language = "javascript">
			window.location = "login0.php?corpus=attributi&mod=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA ATTRIBUTO '. $id , 'FAILED' , 'VALORE '. $attributo , $_SESSION['logfile'],'attributi');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=attributi&mod=no";
		</script>
		<?php
	}

?>
