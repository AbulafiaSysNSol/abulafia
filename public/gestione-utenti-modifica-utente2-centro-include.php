<?php 
	$id=$_GET['id'];
	$nuovapassword1=$_POST['nuovapassword1'];
	$nuovapassword2=$_POST['nuovapassword2'];
	$nuovapassword3 =MD5($nuovapassword1);
	$authlevel=$_POST['authlevel1'];
	$nomeutente=$_POST['nomeutente'];
	$email=$_POST['email'];
	
	if(isset($_POST['admin'])) {
		$admin = $_POST['admin'];
	}
	else {
		$admin = 0;
	}

	if(isset($_POST['anagrafica'])) {
		$anagrafica = $_POST['anagrafica'];
	}
	else {
		$anagrafica = 0;
	}

	if(isset($_POST['protocollo'])) {
		$protocollo = $_POST['protocollo'];
	}
	else {
		$protocollo = 0;
	}

	if(isset($_POST['lettere'])) {
		$lettere = $_POST['lettere'];
	}
	else {
		$lettere = 0;
	}

	if(isset($_POST['magazzino'])) {
		$magazzino = $_POST['magazzino'];
	}
	else {
		$magazzino = 0;
	}

	if(isset($_POST['contabilita'])) {
		$contabilita = $_POST['contabilita'];
	}
	else {
		$contabilita = 0;
	}

	if(isset($_POST['checkprofile'])) {
		$check = $_POST['checkprofile'];
	}
	else {
		$check = 0;
	}

	if ($nuovapassword1 != $nuovapassword2) { 
		echo 'Errore: le due password nuove non coincidono'; 
		$errorecambiopassword= 1; 
	}	

	if (($nuovapassword1 !='') and ($nuovapassword2 !='')) { 
		$cambiopassword=mysql_query("update users set users.password='$nuovapassword3' where users.idanagrafica='$id' limit 1");
	}

	$update=mysql_query("update users set users.loginname='$nomeutente', users.mainemail = '$email', users.auth='$authlevel', users.admin='$admin', users.anagrafica = '$anagrafica', users.protocollo = '$protocollo', users.lettere = '$lettere', users.magazzino = '$magazzino', users.contabilita = '$contabilita', users.updateprofile = '$check' where users.idanagrafica='$id' limit 1");

?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=gestione-utenti&mod=ok";
	else 
		window.location="login0.php?corpus=gestione-utenti&mod=ok";
</SCRIPT>