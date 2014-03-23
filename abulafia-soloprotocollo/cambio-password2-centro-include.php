<?php 
$loginid=$_SESSION['loginid'];
$vecchiapassword=$_POST['vecchiapassword'];
$nuovapassword1=$_POST['nuovapassword1'];
$nuovapassword2=$_POST['nuovapassword2'];
$errorecambiopassword= 0;
$controllodb = mysql_query("select distinct * from users where idanagrafica='$loginid'");
$controllodb2 = mysql_fetch_array($controllodb);
$nuovapassword3 =MD5($nuovapassword1);
?>


<?php if ($nuovapassword1 != $nuovapassword2) { 
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=cambio-password&pass=nomatch"; else window.location="login0.php?corpus=cambio-password&pass=nomatch"
	</SCRIPT>
<?php 
$errorecambiopassword= 1; }	

if (($nuovapassword1 =='') or ($nuovapassword2 =='') or ($vecchiapassword =='')) { 
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=cambio-password&pass=empty"; else window.location="login0.php?corpus=cambio-password&pass=empty"
	</SCRIPT>
<?php 
$errorecambiopassword= 1;}

if (strlen($nuovapassword1) < 6) { 
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=cambio-password&pass=leng"; else window.location="login0.php?corpus=cambio-password&pass=leng"
	</SCRIPT>
<?php 
$errorecambiopassword= 1;}

if (md5($vecchiapassword) === $controllodb2['password']) {}
else {
?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=cambio-password&pass=old"; else window.location="login0.php?corpus=cambio-password&pass=old"
	</SCRIPT>
<?php 
$errorecambiopassword= 1;} 

if ($errorecambiopassword == 0) { $inserimento=mysql_query("update users set users.password='$nuovapassword3' where users.idanagrafica='$loginid' limit 1"); ?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=cambio-password&pass=ok"; else window.location="login0.php?corpus=cambio-password&pass=ok"
</SCRIPT>
<?php }
?>
