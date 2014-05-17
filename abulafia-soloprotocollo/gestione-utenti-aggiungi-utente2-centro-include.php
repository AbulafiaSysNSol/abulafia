<?php 
	$id=$_GET['id'];
	$nome=$_GET['nome'];
	$cognome=$_GET['cognome'];
	
	$nomenuovoutente= strlower($nome.'.'.$cognome);
	$passwordnuovoutente= md5($nomenuovoutente);
	$nuovoutente=mysql_query("insert into users values('$id',0,'$nomenuovoutente', '$passwordnuovoutente')");
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=gestione-utenti"; 
	else 
		window.location="login0.php?corpus=gestione-utenti";
</SCRIPT>