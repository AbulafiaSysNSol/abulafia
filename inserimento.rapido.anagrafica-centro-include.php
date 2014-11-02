<?php
	
	if(isset($_POST['nome'])) {
		$nome = $_POST['nome'];
	}
	else {
		$nome = '';
	}
	$cognome = $_POST['cognome'];
	$anagraficatipologia = $_POST['anagraficatipologia'];
	$inserimento = mysql_query	("
							INSERT INTO 
								anagrafica 
							VALUES 
								('','$nome','$cognome','','','','','','','','','','','','','','$anagraficatipologia') 
						");
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
	$lastid=mysql_insert_id();
?>

	<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&idanagrafica=<?php echo $lastid; ?>&from=aggiungi"; 
		else 
			"login0.php?corpus=protocollo2&idanagrafica=<?php echo $lastid; ?>&from=aggiungi"
	</SCRIPT>