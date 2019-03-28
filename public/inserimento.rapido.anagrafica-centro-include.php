<?php
	
	if(isset($_POST['nome'])) {
		$nome = $_POST['nome'];
	}
	else {
		$nome = '';
	}
	$cognome = $_POST['cognome'];
	$anagraficatipologia = $_POST['anagraficatipologia'];
	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("
							INSERT INTO 
								anagrafica 
							VALUES 
								('',:nome,:cognome,'','','','','','','','','','','','','',:anagraficatipologia, '0') 
						"); 
		$query->bindParam(':nome', $nome);
		$query->bindParam(':cognome', $cognome);
		$query->bindParam(':anagraficatipologia', $anagraficatipologia);
		$query->execute();
		$connessione->commit();
		$inserimento = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$inserimento = false;
	}	
	if(!$inserimento) {
		?>
		<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
				window.location="login0.php?corpus=protocollo2&insert=error"; 
			else 
				"login0.php?corpus=protocollo2&insert=error"
		</SCRIPT>
		<?php
	}
	$lastid = $connessione->lastInsertId();
?>

	<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&idanagrafica=<?php echo $lastid; ?>&from=aggiungi"; 
		else 
			"login0.php?corpus=protocollo2&idanagrafica=<?php echo $lastid; ?>&from=aggiungi"
	</SCRIPT>