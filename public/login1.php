<?php

	session_start(); //avvio della sessione per caricare le variabili

	include '../db-connessione-include.php'; //connessione al db-server
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$my_calendario= new Calendario;//crea un nuovo oggetto
	$_SESSION['my_calendario']= serialize($my_calendario); //serializzazione per passaggio alle variabili di sessione
	$my_log = new Log(); //crea un nuovo oggetto 'log'
	$_SESSION['my_log']= serialize($my_log); //serializzazione per passaggio alle variabili di sessione
	$my_registroprotocollo = new Registroprotocollo ;//crea un nuovo oggetto
	$_SESSION['my_registroprotocollo'] = serialize($my_registroprotocollo); //serializzazione per passaggio alle variabili di sessione
	$my_anagrafica = new Anagrafica ;//crea un nuovo oggetto
	$_SESSION['my_anagrafica'] = serialize($my_anagrafica); //serializzazione per passaggio alle variabili di sessione
	$my_ricerca = new Ricerca ;//crea un nuovo oggetto
	$_SESSION['my_ricerca'] = serialize($my_ricerca); //serializzazione per passaggio alle variabili di sessione
	$my_tabellahtml = new Tabellahtml ;//crea un nuovo oggetto
	$_SESSION['my_tabellahtml'] = serialize($my_tabellahtml); //serializzazione per passaggio alle variabili di sessione
	$my_manuale = new Manuale ;//crea un nuovo oggetto
	$_SESSION['my_manuale'] = serialize($my_manuale); //serializzazione per passaggio alle variabili di sessione
	$my_database = new Database ;//crea un nuovo oggetto
	$_SESSION['my_database'] = serialize($my_database); //serializzazione per passaggio alle variabili di sessione

	$logdirectory="log/";
	$_SESSION['logdirectory'] = "log/";
	$errorlog='error.log';
	$logfile='access.log';
	$maillog='mail.log';
	$historylog = 'history.log';
	$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");
	$userid = addslashes($_POST['userid']); // nome utente inserito nella form della pagina iniziale
	$usermd = md5($userid);
	$password = md5($_POST['password']); // password inserita nella form della pagina iniziale

	if ($usermd == $password) {
		$pass = 1;
	}
	else {
		$pass = 0;
	}
	$host = 'localhost'; 
	$ip = $_SERVER['REMOTE_ADDR']; //indirizzo ip di chi effettua il login
	$_SESSION['ip'] = $ip;
	if ($_SERVER['HTTP_USER_AGENT'] == '') { 
		$client='No info, maybe localhost?';
	}
	else { 
		$client = $_SERVER['HTTP_USER_AGENT'];
	}
	$client=$ip.' - '.$client;
	


	$login=$verificaconnessione->query("SELECT count(*) from users where loginname='$userid' and password='$password'"); //controllo della correttezza di username e password
	$login2 = $login->fetch_array();
	if ($login2[0] < 1 ) {
		$my_log -> publscrivilog($userid, 'login', 'denied', $client , $logfile);
		$_SESSION['auth']= 0 ;
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
		window.location="index.php?err=1"; else window.location="index.php?err=1";
		</SCRIPT>
		<?php 
		exit();
	}
	
	//inizio settaggio delle variabili di sessione
	$logindata=$verificaconnessione->query("select * from users where loginname='$userid'");
	$logindata2=$logindata->fetch_array();
	$idperricerca=$logindata2['idanagrafica']; //setta l'id dell'user che ha effettuato il login
	$logindata3=$verificaconnessione->query("select * from anagrafica where idanagrafica='$idperricerca'");
	$logindata4=$logindata3->fetch_array(); //le ultime due righe estraggono dal db gli altri dati dell'utente che ha fatto login
	$_SESSION['loginurlfoto']= $logindata4['urlfoto']; //seleziona l'url della foto dell'user che ha fatto login
	$_SESSION['auth']= $logindata2['auth']; //livello di autorizzazione dell'utente, prelevato dal db
	$_SESSION['loginname'] = $logindata2['loginname']; //nome utente prelevato dalla tabella users
	$_SESSION['loginid']=$logindata2['idanagrafica']; //id prelevato dalla tabella users, identica a quella dell'anagrafica

	//caricamento dei settaggi personalizzati
	$settings=$verificaconnessione->query("SELECT * FROM usersettings WHERE idanagrafica='$idperricerca'");
	$settings2=$settings->fetch_array();
	//assegnazione settaggi personali
	$_SESSION['risultatiperpagina'] = $settings2['risultatiperpagina'];
	$_SESSION['primocoloretabellarisultati'] = $settings2['primocoloretabellarisultati'];//primo colore delle righe che si alternano della tabella dei risultati della ricerca
	$_SESSION['secondocoloretabellarisultati'] = $settings2['secondocoloretabellarisultati'];//secondo colore delle righe che si alternano della tabella dei risultati della ricerca
	$_SESSION['larghezzatabellarisultati'] = $settings2['larghezzatabellarisultati']; //larghezza della tabella nella pagina dei risultati della ricerca
	$_SESSION['splash']= $settings2['splash'] ;
	$_SESSION['notificains'] = $settings2['notificains'];
	$_SESSION['notificamod'] = $settings2['notificamod'];
	
	//caricamento dei settaggi del software
	$settings3=$verificaconnessione->query("select distinct * from defaultsettings");
	$settings4=$settings3->fetch_array();
	//assegnazione settaggi del software
	$_SESSION['keywords'] = $settings4['keywords'];
	$_SESSION['description'] = $settings4['description'];
	$_SESSION['annoprotocollo'] = $settings4['annoprotocollo'];
	$_SESSION['annoricercaprotocollo'] = $settings4['annoprotocollo'];
	$_SESSION['paginaprincipale'] = $settings4['paginaprincipale'];
	$_SESSION['headerdescription'] = $settings4['headerdescription'];
	$_SESSION['titolopagina'] = $settings4['titolopagina'];
	$_SESSION['version']= $settings4['version']; //versione del software attualmente in uso
	$_SESSION['email']=$settings4['email']; //email del webmaster
	$_SESSION['nomeapplicativo']=$settings4['nomeapplicativo']; //nome del software attualmente in uso
	$_SESSION['fotomaxfilesize'] = $settings4['fotomaxfilesize']; //limite massimo di upload per le foto dell'anagrafica
	$_SESSION['protocollomaxfilesize'] = $settings4['protocollomaxfilesize']; //limite massimo di upload per gli allegati del protocollo
	$_SESSION['sede'] = $settings4['sede'];
	$_SESSION['denominazione'] = $settings4['denominazione'];
	$_SESSION['vertice'] = $settings4['vertice'];
	$_SESSION['inizio'] = $settings4['inizio'];
	$_SESSION['quota'] = $settings4['quota'];
	$_SESSION['mod_anagrafica'] = $settings4['anagrafica'];
	$_SESSION['mod_protocollo'] = $settings4['protocollo'];
	$_SESSION['mod_lettere'] = $settings4['lettere'];
	$_SESSION['mod_magazzino'] = $settings4['magazzino'];
	$_SESSION['mod_contabilita'] = $settings4['contabilita'];
	
	//caricamento settaggi email
	$settings5=$verificaconnessione->query("select distinct * from mailsettings");
	$settings6=$settings5->fetch_array();
	//assegnazione settaggi email
	$_SESSION['usernamemail'] = $settings6['username'];
	$_SESSION['passwordmail'] = base64_decode($settings6['password']);
	$_SESSION['smtp'] = $settings6['smtp'];
	$_SESSION['porta'] = $settings6['porta'];
	$_SESSION['protocolloemail'] = $settings6['protocollo'];
	$_SESSION['headermail'] = $settings6['headermail'];
	$_SESSION['footermail'] = $settings6['footermail'];
	
	//file di log
	$_SESSION['logfile'] = $logfile;
	$_SESSION['maillog'] = $maillog;
	$_SESSION['historylog'] = $historylog;
	$_SESSION['errorlog'] = $errorlog;
	$_SESSION['logdirectory'] = $logdirectory;

	$_SESSION['block'] = false;

	//fine del settaggio delle variabili di sessione e avvio del refresh automatico
	echo 'Loading, please wait ...<br><br>'; //nel caso che il login sia andato a buon fine

	//log degli accessi con esito positivo
	$my_log -> publscrivilog($userid, 'login', 'ok', $client, $logfile );

	mysqli_close($verificaconnessione);//chiude le connessioni al database
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=home&pass=<?php echo $pass; ?>&aggiornamento=null";
	else 
		window.location="login0.php?corpus=home&pass=<?php echo $pass; ?>&aggiornamento=null";
</SCRIPT>
