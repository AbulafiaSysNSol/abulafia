<?php

$id = $_GET['id'];
$descrizione = $_POST['descrizione'];
$update=mysql_query("update pratiche set descrizione='$descrizione' where id='$id' ");
if ($update) {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&mod=ok"; else window.location="login0.php?corpus=pratiche&mod=ok"
	</SCRIPT>
	<?php
}
else {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&mod=no"; else window.location="login0.php?corpus=pratiche&mod=no"
	</SCRIPT>
	<?php
}

?>
