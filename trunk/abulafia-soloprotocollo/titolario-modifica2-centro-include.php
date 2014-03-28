<?php

$id = $_GET['id'];
$codice = $_POST['codice'];
$descrizione = $_POST['descrizione'];
$update=mysql_query("update titolario set codice='$codice', descrizione='$descrizione' where id='$id' ");
if ($update) {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=titolario&mod=ok"; else window.location="login0.php?corpus=titolario&mod=ok"
	</SCRIPT>
	<?php
}
else {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=titolario&mod=no"; else window.location="login0.php?corpus=titolario&mod=no"
	</SCRIPT>
	<?php
}

?>
