<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	$annoprotocollo = $_SESSION['annoprotocollo'];
	if (!is_numeric($annoprotocollo))
		{
		echo "Errore nella definizione dell'anno"; 
		exit; 
		}

	include 'class/Log.obj.inc';
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
	$quota = $_POST['quota'];
	
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

	if(isset($_POST['autoparco'])) {
		$autoparco = 1;
	}
	else {
		$autoparco = 0;
	}

	if(isset($_POST['co'])) {
		$co = 1;
	}
	else {
		$co = 0;
	}

	if(isset($_POST['contabilita'])) {
		$contabilita = 1;
	}
	else {
		$contabilita = 0;
	}

	//eventuale settaggio del primo numero del nuovo protocollo
	if( isset($_POST['primoprotocollo']) and is_numeric($_POST['primoprotocollo']))  {
		$primoprotocollo= $_POST['primoprotocollo'];
	}

	try {
   		$connessione->beginTransaction();
		$lettereannoprotocollo="lettere".$annoprotocollo;
		$query = $connessione->prepare("SELECT count(*) from $lettereannoprotocollo"); 
		$query->execute();
		$connessione->commit();
	} 	
	//gestione dell'eventuale errore della connessione
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
	}

	$risultati = $query->fetchAll();
	$res_count=$risultati[0];
	$contalettere= $res_count[0] +1 ;

	if ($contalettere == 1) { 
		try {
	   		$connessione->beginTransaction();
			$lettereannoprotocollo="lettere".$annoprotocollo;
			$query = $connessione->prepare("ALTER TABLE $lettereannoprotocollo AUTO_INCREMENT = $primoprotocollo"); 
			$query->execute();
			$connessione->commit();
		} 
		//gestione dell'eventuale errore della connessione
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
			$connessione->rollBack();
			exit();
		}
	}

	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("update defaultsettings 
				set defaultsettings.version = :version, 
				defaultsettings.email = :email, 
				defaultsettings.nomeapplicativo=:nomeapplicativo, 
				defaultsettings.paginaprincipale = :paginaprincipale , 
				defaultsettings.protocollomaxfilesize = :protocollomaxfilesize , 
				defaultsettings.fotomaxfilesize = :fotomaxfilesize,  
				defaultsettings.annoprotocollo = :annoprotocollo, 
				defaultsettings.headerdescription = :headerdescription, 
				defaultsettings.sede = :sede, 
				defaultsettings.denominazione = :denominazione, 
				defaultsettings.vertice = :vertice, 
				defaultsettings.inizio = :inizio, 
				quota = :quota, 
				defaultsettings.anagrafica = :anagrafica, 
				defaultsettings.protocollo = :protocollo, 
				defaultsettings.documenti = :documenti, 
				defaultsettings.lettere = :lettere, 
				defaultsettings.magazzino = :magazzino, 
				defaultsettings.ambulatorio = :ambulatorio, 
				defaultsettings.contabilita = :contabilita");

		$query->bindParam(':version', $version);
		$query->bindParam(':email', $email);
		$query->bindParam(':nomeapplicativo', $nomeapplicativo);
		$query->bindParam(':paginaprincipale', $paginaprincipale);
		$query->bindParam(':protocollomaxfilesize', $protocollomaxfilesize);
		$query->bindParam(':fotomaxfilesize', $fotomaxfilesize);
		$query->bindParam(':annoprotocollo', $annoprotocollo);
		$query->bindParam(':headerdescription', $headerdescription);
		$query->bindParam(':sede', $sede);
		$query->bindParam(':denominazione', $denominazione);
		$query->bindParam(':vertice', $vertice);
		$query->bindParam(':inizio', $inizio);
		$query->bindParam(':quota', $quota);
		$query->bindParam(':anagrafica', $anagrafica);
		$query->bindParam(':protocollo', $protocollo);
		$query->bindParam(':documenti', $documenti);
		$query->bindParam(':lettere', $lettere);
		$query->bindParam(':magazzino', $magazzino);
		$query->bindParam(':ambulatorio', $ambulatorio);
		$query->bindParam(':contabilita', $contabilita);
		$query->execute();
		$connessione->commit();
	} 
	//gestione dell'eventuale errore della connessione
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
		$connessione->rollBack();
		exit;
	}

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
	$_SESSION['quota'] = $quota;
	$_SESSION['mod_anagrafica'] = $anagrafica;
	$_SESSION['mod_protocollo'] = $protocollo;
	$_SESSION['mod_documenti'] = $documenti;
	$_SESSION['mod_lettere'] = $lettere;
	$_SESSION['mod_magazzino'] = $magazzino;
	$_SESSION['mod_ambulatorio'] = $ambulatorio;
	$_SESSION['mod_contabilita'] = $contabilita;

?>

<script language = "javascript">
	window.location="login0.php?corpus=advancedsettings&update=success"; 
</script>