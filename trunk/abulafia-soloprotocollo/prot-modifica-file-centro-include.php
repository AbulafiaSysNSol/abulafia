<?php

	include 'maledetti-apici-centro-include.php';

	$annoprotocollo = $_SESSION['annoprotocollo'];
	if(isset($_GET['from'])) {
		$from = $_GET['from'];
	}
	else {
		$from = '';
	}
	
	if ($from != 'modifica-protocollo') {				
		$target_path = "lettere$annoprotocollo/";
		$idlettera=$_GET['idlettera'];
		$target_path = $target_path . $idlettera.basename( $_FILES['uploadedfile']['name']); 
		$urlpdf=  addslashes($idlettera.basename( $_FILES['uploadedfile']['name'])); 
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			$inserisci=mysql_query("update lettere$annoprotocollo set urlpdf='$urlpdf' where idlettera ='$idlettera'");
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success"; else window.location="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success";
			</SCRIPT>
			<?php
		} 
		else {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error"; else window.location="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error";
			</SCRIPT>
			<?php
		}
	}
	else {
		$target_path = "lettere$annoprotocollo/";
		$idlettera=$_GET['idlettera'];
		$target_path = $target_path . $idlettera.basename( $_FILES['uploadedfile']['name']); 
		$urlpdf=  $idlettera.basename( $_FILES['uploadedfile']['name']); 

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-protocollo&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success"; else window.location="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success";
			</SCRIPT>
			<?php
		} 
		else {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-protocollo&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error"; else window.location="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error";
			</SCRIPT>
			<?php
		}
	}
?>
