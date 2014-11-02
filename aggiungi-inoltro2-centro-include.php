<?php

	$calendario = new Calendario();

	$idlettera = $_GET['id'];
	$anno = $_GET['anno'];
	$email = $_POST['email'];
	$data = $_POST['data'];
	$datains = $calendario->dataDB($data);
	$userid = $_SESSION['loginid'];
	$insert = mysql_query("INSERT INTO mailsend VALUES ( '', '$userid', '$email', '$datains', '$idlettera', '$anno')");
	
	if($insert) {
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="login0.php?corpus=dettagli-protocollo&id=<?php echo $idlettera;?>&anno=<?php echo $anno;?>&inoltro=ok"; else window.location="login0.php?corpus=dettagli-protocollo&id=<?php echo $idlettera;?>&anno=<?php echo $anno;?>&inoltro=ok"
		</SCRIPT>
		<?php
	}
	else {
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="login0.php?corpus=dettagli-protocollo&id=<?php echo $idlettera;?>&anno=<?php echo $anno;?>&inoltro=fail"; else window.location="login0.php?corpus=dettagli-protocollo&id=<?php echo $idlettera;?>&anno=<?php echo $anno;?>&inoltro=fail"
		</SCRIPT>
		<?php
	}
?>