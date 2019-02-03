<?php

	//passaggio variabili
	$id = $_GET['id'];
	$risultati_per_pagina = $_POST['risultatiperpagina'];
	$color1 = $_POST['color1'];
	$color2 = $_POST['color2'];
	$ins = $_POST['ins'];
	$mod = $_POST['mod'];

	$update=mysql_query("UPDATE usersettings SET risultatiperpagina='$risultati_per_pagina', primocoloretabellarisultati='$color1', secondocoloretabellarisultati='$color2', notificains = '$ins', notificamod = '$mod' WHERE idanagrafica='$id'");

	if (!$update) {
		?>
		<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
				window.location="login0.php?corpus=settings&update=error"; 
			else 
				window.location="login0.php?corpus=settings&update=error"
		</SCRIPT>
		<?php
	}
	else {
		$_SESSION['risultatiperpagina'] = $risultati_per_pagina;
		$_SESSION['primocoloretabellarisultati'] = $color1;
		$_SESSION['secondocoloretabellarisultati'] = $color2;
		$_SESSION['notificains'] = $ins;
		$_SESSION['notificamod'] = $mod;
	}
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=settings&update=success"; 
	else 
		window.location="login0.php?corpus=settings&update=success"
</SCRIPT>