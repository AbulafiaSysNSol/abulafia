<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	$annoprotocollo = $_SESSION['annoprotocollo'];

	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI

	//passaggio variabili
	$nomeapplicativo = $_POST['nomeapplicativo'];
	$version= $_POST['version'];
	$email = $_POST['email'];
	$protocollomaxfilesize = $_POST['protocollomaxfilesize'];
	$fotomaxfilesize = $_POST['fotomaxfilesize'];
	$paginaprincipale = $_POST['paginaprincipale'];
	$headerdescription = $_POST['headerdescription'];
	$sede = $_POST['sede'];
	$denominazione = $_POST['denominazione'];
	$vertice = $_POST['vertice'];
	$inizio = $_POST['inizio'];
	
	if(isset($_POST['anagrafica'])) {
		$anagrafica = 1;
	}
	else {
		$anagrafica = 0;
	}

	if(isset($_POST['protocollo'])) {
		$protocollo = 1;
	}
	else {
		$protocollo = 0;
	}

	if(isset($_POST['documenti'])) {
		$documenti = 1;
	}
	else {
		$documenti = 0;
	}

	if(isset($_POST['lettere'])) {
		$lettere = 1;
	}
	else {
		$lettere = 0;
	}

	if(isset($_POST['magazzino'])) {
		$magazzino = 1;
	}
	else {
		$magazzino = 0;
	}


	if(isset($_POST['ambulatorio'])) {
		$ambulatorio = 1;
	}
	else {
		$ambulatorio = 0;
	}

	if(isset($_POST['contabilita'])) {
		$contabilita = 1;
	}
	else {
		$contabilita = 0;
	}

	//eventuale settaggio del primo numero del nuovo protocollo
	if(isset($_POST['primoprotocollo'])) {
		$primoprotocollo= $_POST['primoprotocollo'];
	}
	$contalettere=mysql_query("select count(*) from lettere$annoprotocollo");
	$res_count=mysql_fetch_row($contalettere);
	$contalettere= $res_count[0] +1 ;
	if ($contalettere == 1) { 
		$queryprimoprotocollo = mysql_query("ALTER TABLE lettere$annoprotocollo AUTO_INCREMENT = $primoprotocollo ");
		if (!$queryprimoprotocollo) { 
			echo 'Variazione del primo numero del protocollo NON RIUSCITA<br>'; 
			echo mysql_error(); exit();
			exit();
		}
	}

	$inserimento=mysql_query("update defaultsettings set defaultsettings.version = $version, defaultsettings.email = '$email', defaultsettings.nomeapplicativo='$nomeapplicativo', defaultsettings.paginaprincipale = '$paginaprincipale' , defaultsettings.protocollomaxfilesize = '$protocollomaxfilesize' , defaultsettings.fotomaxfilesize = '$fotomaxfilesize' ,  defaultsettings.annoprotocollo = '$annoprotocollo', defaultsettings.headerdescription = '$headerdescription', defaultsettings.sede = '$sede', defaultsettings.denominazione = '$denominazione', defaultsettings.vertice = '$vertice', defaultsettings.inizio = '$inizio', defaultsettings.anagrafica = '$anagrafica', defaultsettings.protocollo = '$protocollo', defaultsettings.documenti = '$documenti', defaultsettings.lettere = '$lettere', defaultsettings.magazzino = '$magazzino', defaultsettings.ambulatorio = '$ambulatorio', defaultsettings.contabilita = '$contabilita'");

	if (!$inserimento) {
		?>
		<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
				window.location="login0.php?corpus=advancedsettings&update=error"; 
			else 
				window.location="login0.php?corpus=advancedsettings&update=error";
		</SCRIPT> 
		<?php
		echo mysql_error();
		exit();
	}
	else { 
		$_SESSION['version'] = $version; 
		$_SESSION['email'] = $email; 
		$_SESSION['nomeapplicativo'] = $nomeapplicativo; 
		$_SESSION['paginaprincipale']= $paginaprincipale; 
		$_SESSION['protocollomaxfilesize']= $protocollomaxfilesize; 
		$_SESSION['fotomaxfilesize']= $fotomaxfilesize; 
		$_SESSION['headerdescription']= $headerdescription;
		$_SESSION['sede'] = $sede;
		$_SESSION['denominazione'] = $denominazione;
		$_SESSION['vertice'] = $vertice;
		$_SESSION['inizio'] = $inizio;
		$_SESSION['mod_anagrafica'] = $anagrafica;
		$_SESSION['mod_protocollo'] = $protocollo;
		$_SESSION['mod_documenti'] = $documenti;
		$_SESSION['mod_lettere'] = $lettere;
		$_SESSION['mod_magazzino'] = $magazzino;
		$_SESSION['mod_ambulatorio'] = $ambulatorio;
		$_SESSION['mod_contabilita'] = $contabilita;
	}
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=advancedsettings&update=success"; 
	else 
		window.location="login0.php?corpus=advancedsettings&update=success";
</SCRIPT>
