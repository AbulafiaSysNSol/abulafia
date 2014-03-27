<?php 
$owner=$_SESSION['loginid'];
$codice=$_POST['codice'];
$descrizione=$_POST['descrizione'];

if (($codice == "") OR ($descrizione =="")) { 
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=titolario&add=no"; else window.location="login0.php?corpus=titolario&add=no"
	</SCRIPT>
<?php 
exit();
}
 
$inserimento=mysql_query("insert into titolario values('', '$codice', '$descrizione', '$owner')");
if($inserimento) {
?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=titolario&add=ok"; else window.location="login0.php?corpus=titolario&add=ok"
</SCRIPT>
<?php
}
else {
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=titolario&add=no"; else window.location="login0.php?corpus=titolario&add=no"
	</SCRIPT>
<?php 
}
?>
