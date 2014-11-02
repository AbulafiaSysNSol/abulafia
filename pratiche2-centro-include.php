<?php 
$owner=$_SESSION['loginid'];
$descrizione=$_POST['descrizione'];

if ($descrizione =="") { 
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&add=no"; else window.location="login0.php?corpus=pratiche&add=no"
	</SCRIPT>
<?php 
exit();
}
$my_database=unserialize($_SESSION['my_database']);
if ($my_database->controllaEsistenza($descrizione, 'pratiche', 'descrizione') == True)
	{
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&add=duplicato"; else window.location="login0.php?corpus=pratiche&add=duplicato"
	</SCRIPT>
	<?php 
	exit();
	}

$inserimento=mysql_query("insert into pratiche values('', '$descrizione', '$owner')");
if($inserimento) {
?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=pratiche&add=ok"; else window.location="login0.php?corpus=pratiche&add=ok"
</SCRIPT>
<?php
}
else {
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=pratiche&add=no"; else window.location="login0.php?corpus=pratiche&add=no"
	</SCRIPT>
<?php 
}
?>
