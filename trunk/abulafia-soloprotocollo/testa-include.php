<?php

include '../db-connessione-include.php'; //connessione al db-server

function __autoload ($class_name) //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
{ require_once $class_name.".obj.inc";
}
$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
$my_anagrafica= unserialize($_SESSION['my_anagrafica']);//deserializzazione 
$my_log= unserialize($_SESSION['my_log']);//deserializzazione 
$my_registroprotocollo= unserialize($_SESSION['my_registroprotocollo']);//deserializzazione 
$my_ricerca= unserialize($_SESSION['my_ricerca']);//deserializzazione 
$my_manuale= unserialize($_SESSION['my_manuale']);//deserializzazione 
$my_tabellahtml= unserialize($_SESSION['my_tabellahtml']);//deserializzazione 
$setting=mysql_query("select * from defaultsettings");
$setting2=mysql_fetch_array($setting);

$_SESSIONs['paginaprincipale'] = $setting2['paginaprincipale'];

if ($_SESSION['auth']< 1 ) {
echo 'Devi prima effettuare il login dalla<br>';
?> <a href="<?php echo $_SESSIONs['paginaprincipale'];?>"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
<?php 
exit() ; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $_SESSION['titolopagina'];?></title>
<meta name="keywords" content="<?php echo $_SESSION['keywords'];?>" />
<meta name="description" content="<?php echo $_SESSION['description'];?>" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="style.php"/>
</head>
<body>

<div id="outer">

	<div id="upbg"></div>

	<div id="inner">
<div id="header">
			<h1><span><?php echo $_SESSION['nomeapplicativo'];?><br></span>Versione <?php echo $_SESSION['version'];?><br></h1>
			<h2><br><?php echo $_SESSION['headerdescription'];?></h2>
		</div>
	
		<div id="splash"></div>




		
	
		<div id="menu">

			<ul>
				<li class="first"><a href="login0.php?corpus=home">Home</a></li>
				<li><a href="login0.php?corpus=protocollo">Protocollo</a></li>
                                <li><a href="login0.php?corpus=anagrafica">Anagrafica</a></li>
                                <li><a href="login0.php?corpus=ricerca">Ricerca</a></li>
				<li><a href="login0.php?corpus=aiuto">Aiuto</a></li>
                                <li><a href="login0.php?corpus=informazioni">Informazioni</a></li>
                                
				
			</ul>

		<div id="date"><?php //stampo la data odierna in alto a destra
				$my_calendario-> publadesso();
				echo $my_calendario->giorno.' '.$my_calendario->meseesteso.' '.$my_calendario->anno;
				?> 
		</div>

		</div>


<?php
include '../db-connessione-include.php'; //connessione al db-server

if ($_GET['corpus'] != 'cambioanno') 
	{ 
	$my_registroprotocollo -> publcontrolloanno (); //controllo della corrispondenza fra l'anno corrente e l'anno in uso dal db
	}
?>

