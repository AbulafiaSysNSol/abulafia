<?php 
	$attributo=$_POST['descrizione'];
	$inserimento=mysql_query("insert into attributi values('', '$attributo')");
	if($inserimento) {
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="login0.php?corpus=attributi&add=ok"; else window.location="login0.php?corpus=attributi&add=ok"
		</SCRIPT>
		<?php
	}
	else {
	?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="login0.php?corpus=attributi&add=no"; else window.location="login0.php?corpus=attributi&add=no"
		</SCRIPT>
	<?php 
	}
?>
