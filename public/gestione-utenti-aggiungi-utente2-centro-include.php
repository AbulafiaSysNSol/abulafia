<?php 
	$id = $_GET['id'];
	$nome = str_replace("'","",$_GET['nome']);
	$cognome = str_replace("'","",$_GET['cognome']);
	
	$nomenuovoutente = strtolower($nome.'.'.$cognome);
	$passwordnuovoutente = md5($nomenuovoutente);
	$nuovoutente = mysql_query("INSERT INTO users VALUES('$id',0,'$nomenuovoutente', '$passwordnuovoutente', '', 0, 0, 0, 0, 0, 0, 0, 0, 0)");
	$setting = mysql_query("INSERT INTO usersettings VALUES('$id', 30, 'images/splash.jpg', '#DEFEB4', '#FFFFCC', '100%', '', '')");
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=gestione-utenti"; 
	else 
		window.location="login0.php?corpus=gestione-utenti";
</SCRIPT>