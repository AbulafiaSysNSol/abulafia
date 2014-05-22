<?php

$id = $_GET['id'];
$cancellazione=mysql_query("delete from pratiche where id='$id' limit 1");
if ($cancellazione) {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&canc=ok"; else window.location="login0.php?corpus=pratiche&canc=ok"
	</SCRIPT>
	<?php
}
else {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&canc=no"; else window.location="login0.php?corpus=pratiche&canc=no"
	</SCRIPT>
	<?php
}

?>
