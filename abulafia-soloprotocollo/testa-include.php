<?php

include '../db-connessione-include.php'; //connessione al db-server
include 'maledetti-apici-centro-include.php';

function __autoload ($class_name) //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
{ require_once "class/" . $class_name.".obj.inc";
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
<title><?php echo $_SESSION['nomeapplicativo'] . ' ' . $_SESSION['version'];?></title>
<meta name="keywords" content="<?php echo $_SESSION['keywords'];?>" />
<meta name="description" content="<?php echo $_SESSION['description'];?>" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="style.php"/>
<!-- META -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <!-- META -->
  
  <!-- CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <!-- CSS -->  
  
  <!-- JS -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- JS -->
</head>


<body>
<div class="row">
  <div class="col-md-10 col-md-offset-1">
  
	 <div class="row">
		 <div class="col-md-12">
			<div class="page-header">
			<table border="0" width="100%"><tr><td>
			<h2><?php echo $_SESSION['nomeapplicativo'] .' ' . $_SESSION['version'] . ' <br><small>'. $_SESSION['headerdescription'];?></small></h2></td> 
			<td align="right"><img src="<?php echo $_SESSION['splash']; ?>"></td></tr></table>
			</div>
		 </div>
	</div>
	  
	<nav class="navbar navbar-default" role="navigation">

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
		<li><a href="login0.php?corpus=home">Home</a></li>
		<li><a href="login0.php?corpus=protocollo">Protocollo</a></li>
		<li><a href="login0.php?corpus=anagrafica">Anagrafica</a></li>
		<li><a href="login0.php?corpus=ricerca">Ricerca</a></li>
		<li><a href="login0.php?corpus=aiuto">F.A.Q.</a></li>
		<li><a href="login0.php?corpus=informazioni">Informazioni</a></li>
	      </ul>

	      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Logged as <strong><?php echo $_SESSION['loginname'];?></strong> <b class="caret"></b></a>
		  <ul class="dropdown-menu">
		    <li><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>">Cambia Password</a></li>
		    <li><a href="login0.php?corpus=segnala-bug">Segnala un Errore</a></li>
		    <li><a href="login0.php?corpus=settings">Impostazioni</a></li>
		    <?php if ($_SESSION['auth'] > 50) {?>
		    <li class="divider"></li>
		    <li><a href="login0.php?corpus=titolario">Titolario</a></li>
		    <li><a href="login0.php?corpus=gestione-utenti">Gestione degli Utenti</a></li>
		    <li><a href="login0.php?corpus=advancedsettings">Advanced Settings</a></li>
		    <li><a href="download.php?lud=access.log&est=log">Scarica il log degli accessi</a></li>
		    <li><a href="login0.php?corpus=log-mail">Visualizza il log delle mail</a></li>
		    <?php } ?>
		    <li class="divider"></li>
		    <li><a href="logout.php">Logout</a></li>
		  </ul>
		</li>
	    </div><!-- /.navbar-collapse -->
	</nav>


<?php


if ($_GET['corpus'] != 'cambioanno') 
	{ 
	$my_registroprotocollo -> publcontrolloanno (); //controllo della corrispondenza fra l'anno corrente e l'anno in uso dal db
	}
?>

