<?php 
	
	$m = new Magazzino();
	$owner=$_SESSION['loginid'];
	$descrizione=$_POST['descrizione'];
	$res = $m->insertSettore($descrizione, $owner);
	
	if($res) {
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="login0.php?corpus=magazzino-settori&add=ok"; else window.location="login0.php?corpus=magazzino-settori&add=ok"
		</SCRIPT>
		<?php
	}
	else {
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="login0.php?corpus=magazzino-settori&add=no"; else window.location="login0.php?corpus=magazzino-settori&add=no"
		</SCRIPT>
		<?php 
	}
?>