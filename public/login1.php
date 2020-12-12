<?php

	session_start(); //avvio della sessione per caricare le variabili

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}

	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	$my_calendario = new Calendario();//crea un nuovo oggetto
	$_SESSION['my_calendario'] = serialize($my_calendario); //serializzazione per passaggio alle variabili di sessione
	$logdirectory = "log/";
	$_SESSION['logdirectory'] = "log/";
	$logfile = 'general.log';
	$maillog = 'mail.log';
	$data = strftime("%d-%m-%Y /") . ' ' . date("g:i a");
	$userid = addslashes($_POST['userid']); // nome utente inserito nella form della pagina iniziale
	$usermd = md5($userid);
	$password = md5($_POST['password']); // password inserita nella form della pagina iniziale

	include '../db-connessione-include.php'; //connessione al db-server
	
	

	$my_log = new Log(); //crea un nuovo oggetto 'log'
	$_SESSION['my_log']= serialize($my_log); //serializzazione per passaggio alle variabili di sessione
	$my_registroprotocollo = new Registroprotocollo() ;//crea un nuovo oggetto
	$_SESSION['my_registroprotocollo'] = serialize($my_registroprotocollo); //serializzazione per passaggio alle variabili di sessione
	$my_anagrafica = new Anagrafica() ;//crea un nuovo oggetto
	$_SESSION['my_anagrafica'] = serialize($my_anagrafica); //serializzazione per passaggio alle variabili di sessione
	$my_ricerca = new Ricerca() ;//crea un nuovo oggetto
	$_SESSION['my_ricerca'] = serialize($my_ricerca); //serializzazione per passaggio alle variabili di sessione
	$my_tabellahtml = new Tabellahtml() ;//crea un nuovo oggetto
	$_SESSION['my_tabellahtml'] = serialize($my_tabellahtml); //serializzazione per passaggio alle variabili di sessione
	$my_manuale = new Manuale() ;//crea un nuovo oggetto
	$_SESSION['my_manuale'] = serialize($my_manuale); //serializzazione per passaggio alle variabili di sessione
	$my_database = new Database() ;//crea un nuovo oggetto
	$_SESSION['my_database'] = serialize($my_database); //serializzazione per passaggio alle variabili di sessione
	$my_lettera = new Lettera() ;//crea un nuovo oggetto
	$_SESSION['my_lettera'] = serialize($my_lettera); //serializzazione per passaggio alle variabili di sessione



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


//controllo login con PDO

	try 
		{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT count(*) 
						from users 
						where loginname=:userid 
						and password=:password '); 
		$query->bindParam(':userid', $userid);
		$query->bindParam(':password', $password);
		$query->execute();
		$connessione->commit();
		} 
		
		//gestione dell'eventuale errore della query
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
		}

	$risultati = $query->fetchAll();

//controllo della presenza di almeno un utente con user e passord indicati nella form di login
		
	

	if ($risultati[0][0] < 1 ) 
	{
		$my_log -> publscrivilog($userid, 'login', 'denied', $client, $logfile, 'access');
		$_SESSION['auth'] = 0 ;
		?>
		<script language = "javascript">
			window.location="index.php?err=1";
		</script>
		<?php 
		exit();
	}
	

	try 
	{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT * 
						from users 
						where loginname=:userid 
						'); 
		$query->bindParam(':userid', $userid);
		$query->execute();
		$connessione->commit();
	} 
	//gestione dell'eventuale errore della query
	catch (PDOException $errorePDO) 
	{ 
    		echo "Errore: " . $errorePDO->getMessage();
	}
	
	$logindata = $query->fetchAll();
	$logindata2 = $logindata[0];
	$idperricerca = $logindata2['idanagrafica']; //setta l'id dell'user che ha effettuato il login


	try 
	{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT * 
						from anagrafica 
						where idanagrafica=:idperricerca 
						'); 
		$query->bindParam(':idperricerca', $idperricerca);
		$query->execute();
		$connessione->commit();
	} 
	//gestione dell'eventuale errore della query
	catch (PDOException $errorePDO) 
	{ 
    		echo "Errore: " . $errorePDO->getMessage();
	}

	$logindata3 = $query->fetchAll();
	$logindata4=$logindata3[0];



	$_SESSION['loginurlfoto']= $logindata4['urlfoto']; //seleziona l'url della foto dell'user che ha fatto login
	$_SESSION['auth']= $logindata2['auth']; //livello di autorizzazione dell'utente, prelevato dal db
	$_SESSION['loginname'] = $logindata2['loginname']; //nome utente prelevato dalla tabella users
	$_SESSION['loginid']=$logindata2['idanagrafica']; //id prelevato dalla tabella users, identica a quella dell'anagrafica

	//caricamento dei settaggi personalizzati


	try 
		{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT *
						from usersettings
						where idanagrafica=:idperricerca
						'); 
		$query->bindParam(':idperricerca', $idperricerca);
		$query->execute();
		$connessione->commit();
		} 
		
		//gestione dell'eventuale errore della query
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
		}

	$settings = $query->fetchAll();
	$settings2=$settings[0];


	//assegnazione settaggi personali
	$_SESSION['risultatiperpagina'] = $settings2['risultatiperpagina'];
	$_SESSION['primocoloretabellarisultati'] = $settings2['primocoloretabellarisultati'];//primo colore delle righe che si alternano della tabella dei risultati della ricerca
	$_SESSION['secondocoloretabellarisultati'] = $settings2['secondocoloretabellarisultati'];//secondo colore delle righe che si alternano della tabella dei risultati della ricerca
	$_SESSION['larghezzatabellarisultati'] = $settings2['larghezzatabellarisultati']; //larghezza della tabella nella pagina dei risultati della ricerca
	$_SESSION['splash']= $settings2['splash'] ;
	$_SESSION['notificains'] = $settings2['notificains'];
	$_SESSION['notificamod'] = $settings2['notificamod'];
	
	//caricamento dei settaggi del software


	try 
		{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT distinct *
						from defaultsettings
						'); 
		$query->execute();
		$connessione->commit();
		} 
		
		//gestione dell'eventuale errore della connessione
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
		}

	$settings3 = $query->fetchAll();
	$settings4=$settings3[0];

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
	$_SESSION['mod_documenti'] = $settings4['documenti'];
	$_SESSION['mod_ambulatorio'] = $settings4['ambulatorio'];
	$_SESSION['mod_autoparco'] = $settings4['autoparco'];
	$_SESSION['mod_co'] = $settings4['co'];
	$_SESSION['signaturepath'] = $settings4['signaturepath'];
	
	//caricamento settaggi email


	try 
		{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT *
						from mailsettings
						'); 
		$query->execute();
		$connessione->commit();
		} 
		
		//gestione dell'eventuale errore della connessione
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
		}
	
	$settings5 = $query->fetchAll();
	$settings6=$settings5[0];

	//assegnazione settaggi email
	$_SESSION['usernamemail'] = $settings6['username'];
	$_SESSION['passwordmail'] = base64_decode($settings6['password']);
	if(isset($settings6['replyto'])) {
		$_SESSION['replyto'] = $settings6['replyto'];	
	}
	else {
		$_SESSION['replyto'] = $settings6['username'];
	}
	$_SESSION['smtp'] = $settings6['smtp'];
	$_SESSION['porta'] = $settings6['porta'];
	$_SESSION['protocolloemail'] = $settings6['protocollo'];
	$_SESSION['headermail'] = $settings6['headermail'];
	$_SESSION['footermail'] = $settings6['footermail'];
	
	//file di log
	$_SESSION['logfile'] = $logfile;
	$_SESSION['maillog'] = $maillog;
	//logfile unificato $_SESSION['historylog'] = $historylog;
	//logfile unificato $_SESSION['errorlog'] = $errorlog;
	$_SESSION['logdirectory'] = $logdirectory;

	$_SESSION['block'] = false;

	//fine del settaggio delle variabili di sessione e avvio del refresh automatico
	echo 'Loading, please wait ...<br><br>'; //nel caso che il login sia andato a buon fine

	//log degli accessi con esito positivo
	$my_log->publscrivilog($userid, 'login', 'ok', $client, $logfile, 'access' );

$connessione=null; //chiudo la connessione distruggendo l'oggetto PDO istanziato
?>



<script language="Javascript">
	window.location="login0.php?corpus=home&pass=<?php echo $pass; ?>&aggiornamento=null";
</script>
