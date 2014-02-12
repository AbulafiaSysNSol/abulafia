<?php

session_start(); //avvio della sessione per caricare le variabili

function __autoload ($class_name) //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
{ require_once $class_name.".obj.inc";
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

$logfile='access.log';
$maillog='mail.log';
$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");
$userid = $_POST['userid']; // nome utente inserito nella form della pagina iniziale
$password = md5($_POST['password']); // password inserita nella form della pagina iniziale
$host = 'localhost'; 
$ip = $_SERVER['REMOTE_ADDR']; //indirizzo ip di chi effettua il login
if ($_SERVER['HTTP_USER_AGENT'] ==''){ $client='No info, maybe localhost?';}
else { $client = $_SERVER['HTTP_USER_AGENT'];}
$client=$ip.' - '.$client;
include '../db-connessione-include.php'; //connessione al db-server

include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI




$login=mysql_query(
			"SELECT count(*) 
			from users 
			where loginname='$userid' and password='$password'");               //controllo della correttezza di username e password
$login2 = mysql_fetch_array($login);
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
}
//inizio settaggio delle variabili di sessione

$logindata=mysql_query("
select * 
from users 
where loginname='$userid'");

$logindata2=mysql_fetch_array($logindata);
$idperricerca=$logindata2['idanagrafica']; //setta l'id dell'user che ha effettuato il login
$logindata3=mysql_query("select * from anagrafica where idanagrafica='$idperricerca'");
$logindata4=mysql_fetch_array($logindata3); //le ultime due righe estraggono dal db gli altri dati dell'utente che ha fatto login
$_SESSION['loginurlfoto']= $logindata4['urlfoto']; //seleziona l'url della foto dell'user che ha fatto login
$_SESSION['auth']= $logindata2['auth']; //livello di autorizzazione dell'utente, prelevato dal db
$_SESSION['loginname'] = $logindata2['loginname']; //nome utente prelevato dalla tabella users
$_SESSION['loginid']=$logindata2['idanagrafica']; //id prelevato dalla tabella users, identica a quella dell'anagrafica
$logindatagruppo=mysql_query("select * from joinanagraficagruppo where idanagrafica='$idperricerca' and datafine='0000-00-00'");
$logindatagruppo2=mysql_fetch_array($logindatagruppo);
$_SESSION['gruppo']=$logindatagruppo2['idgruppo'];
if ($_SESSION['gruppo'] == '') {$_SESSION['gruppo']== 0;}


//caricamento dei settaggi personalizzati
$settings=mysql_query("
select count(*) 
from defaultsettings 
where idanagrafica='$idperricerca'");
$settings2=mysql_fetch_row($settings);
if ($settings2[0] <1){$idperricerca2=1;}
else {$idperricerca2 =  $idperricerca;}
$settings3=mysql_query("select distinct * from defaultsettings where idanagrafica ='$idperricerca2'");
$settings4=mysql_fetch_array($settings3);

$settings5=mysql_query("select distinct * from mailsettings");
$settings6=mysql_fetch_array($settings5);

$_SESSION['keywords'] = $settings4['keywords'];
$_SESSION['description'] = $settings4['description'];
$_SESSION['annoprotocollo'] = $settings4['annoprotocollo'];
$_SESSION['paginaprincipale'] = $settings4['paginaprincipale'];
$_SESSION['headerdescription'] = $settings4['headerdescription'];
$_SESSION['titolopagina'] = $settings4['titolopagina'];
$_SESSION['host'] = $settings4['host'];
$_SESSION['version']= $settings4['version'];; //versione del software attualmente in uso
$_SESSION['email']=$settings4['email'];; //email del webmaster
$_SESSION['nomeapplicativo']=$settings4['nomeapplicativo'];; //nome del software attualmente in uso
$_SESSION['risultatiperpagina'] = $settings4['risultatiperpagina'] ;
$_SESSION['fotomaxfilesize'] = $settings4['fotomaxfilesize'] ; //limite massimo di upload per le foto dell'anagrafica
$_SESSION['protocollomaxfilesize'] = $settings4['protocollomaxfilesize'] ; //limite massimo di upload per gli allegati del protocollo
$_SESSION['larghezzatabellarisultati'] = $settings4['larghezzatabellarisultati'] ; //larghezza della tabella nella pagina dei risultati della ricerca
$_SESSION['primocoloretabellarisultati'] = $settings4['primocoloretabellarisultati'];//primo colore delle righe che si alternano della tabella dei risultati della ricerca
$_SESSION['secondocoloretabellarisultati'] = $settings4['secondocoloretabellarisultati'] ;//secondo colore delle righe che si alternano della tabella dei risultati della ricerca
$_SESSION['fototargetpath']= $settings4['fototargetpath'] ; //percorso relativo per l'upload delle foto dell'anagrafica
$_SESSION['splash']= $settings4['splash'] ; //percorso relativo per lo splash in alto a destra
//fine caricamento dei settaggi personalizzati

$_SESSION['mittente'] = $settings6['mittente'];
$_SESSION['headermail'] = $settings6['headermail'];
$_SESSION['footermail'] = $settings6['footermail'];
$_SESSION['logfile'] = $logfile;
$_SESSION['maillog'] = $maillog;

//fine del settaggio delle variabili di sessione e avvio del refresh automatico
echo 'Login effettuato<br><br>'; //nel caso che il login sia andato a buon fine

//log degli accessi con esito positivo
$my_log -> publscrivilog($userid, 'login', 'ok', $client, $logfile );


?> <a href="login0.php?corpus=home"><?php echo 'Accedi al programma'; ?></a>
<?php 
//exit();
?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=home"; else window.location="login0.php?corpus=home";
</SCRIPT>
