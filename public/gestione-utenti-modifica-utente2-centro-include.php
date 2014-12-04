<?php 
	$id=$_GET['id'];
	$nuovapassword1=$_POST['nuovapassword1'];
	$nuovapassword2=$_POST['nuovapassword2'];
	$nuovapassword3 =MD5($nuovapassword1);
	$authlevel=$_POST['authlevel1'];
	$nomeutente=$_POST['nomeutente'];
	
	if(isset($_POST['admin'])) {
		$admin = $_POST['admin'];
	}
	else {
		$admin = 0;
	}

	if ($nuovapassword1 != $nuovapassword2) { 
		echo 'Errore: le due password nuove non coincidono'; 
		$errorecambiopassword= 1; 
	}	

	if (($nuovapassword1 !='') and ($nuovapassword2 !='')) { 
		$cambiopassword=mysql_query("update users set users.password='$nuovapassword3' where users.idanagrafica='$id' limit 1");
	}

	$update=mysql_query("update users set users.loginname='$nomeutente', users.auth='$authlevel', users.admin='$admin' where users.idanagrafica='$id' limit 1");

?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=gestione-utenti&mod=ok";
	else 
		window.location="login0.php?corpus=gestione-utenti&mod=ok";
</SCRIPT>