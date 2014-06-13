<?php

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	include 'maledetti-apici-centro-include.php';

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
	$my_anagrafica= unserialize($_SESSION['my_anagrafica']);//deserializzazione 
	$my_log= unserialize($_SESSION['my_log']);//deserializzazione 
	$my_registroprotocollo= unserialize($_SESSION['my_registroprotocollo']);//deserializzazione 
	$my_ricerca= unserialize($_SESSION['my_ricerca']);//deserializzazione 
	$my_manuale= unserialize($_SESSION['my_manuale']);//deserializzazione 
	$my_tabellahtml= unserialize($_SESSION['my_tabellahtml']);//deserializzazione 
	$my_database= unserialize($_SESSION['my_database']);//deserializzazione 
	$setting=mysql_query("select * from defaultsettings");
	$setting2=mysql_fetch_array($setting);

	$_SESSIONs['paginaprincipale'] = $setting2['paginaprincipale'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $_SESSION['nomeapplicativo'] . ' ' . $_SESSION['version'];?></title>
<meta name="keywords" content="<?php echo $_SESSION['keywords'];?>" />
<meta name="description" content="<?php echo $_SESSION['description'];?>" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="style.php"/>

  <!-- META -->
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <!-- META -->
  
  <!-- CSS -->
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.10.4.custom.css"></link>
  <link href="css/grid.css" rel="stylesheet">
  <!-- CSS -->  
  
  <!-- JS -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery-1.10.4.custom.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-i18n.js"></script>
  <!-- JS -->
  
  <script type="text/javascript">
	$(function(){
	     $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );
	     $('.datepicker').datepicker( { changeMonth: true, changeYear: true });
	     $('.datepickerAnag').datepicker( { changeMonth: true, changeYear: true, yearRange: "-100:+0" }); 
	     $('.datepickerProt').datepicker( { changeMonth: true, changeYear: true, maxDate: "today" });
	});
</script>
  
  <!-- Fancybox -->
	<script type="text/javascript" src="js/fancy/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="js/fancy/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/fancy/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<link rel="stylesheet" type="text/css" href="js/fancy/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="js/fancy/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="js/fancy/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript" src="js/fancy/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<!-- End Fancybox -->

<script type="text/javascript">
		$(function() {
			$('.fancybox').fancybox();

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

		});
  </script>
  
  <style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>
  
</head>


<body>
  
  <div class="container">
	 <div class="row">
		 <div class="col-md-12">
			<div class="page-header">
			<table border="0" width="100%">
			<tr>
			<td><img width="60" src="images/abulafia logo-scont.png"></td>
			<td><h2><?php echo $_SESSION['nomeapplicativo'] .' ' . $_SESSION['version'] . ' <br><small>'. $_SESSION['headerdescription'];?></small></h2></td> 
			<td align="right"><img src="<?php echo $_SESSION['splash']; ?>"></td>
			</tr>
			</table>
			</div>
		 </div>
	</div>
	
	<nav class="navbar navbar-default" role="navigation">

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
		<li <?php if($_GET['corpus'] == 'home') { echo 'class="active"'; }?>><a href="login0.php?corpus=home"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				
		<li class="dropdown <?php if($_GET['corpus'] == 'protocollo' OR $_GET['corpus']=='titolario' OR $_GET['corpus']=='titolario-modifica' OR $_GET['corpus']=='stampa-registro' OR $_GET['corpus'] == 'protocollo2') { echo ' active'; }?>">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book"></i> Protocollo <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="login0.php?corpus=protocollo2&from=crea" onClick="return confirm('ATTENZIONE: OPERAZIONE NON REVERSIBILE\n\nCreare nuovo numero di protocollo?');" ><span class="glyphicon glyphicon-plus"></span> Crea nuovo numero progressivo</a></li>
				<li><a href="login0.php?corpus=titolario"><span class="glyphicon glyphicon-list"></span> Gestione titolario</a></li>
				<li><a href="login0.php?corpus=pratiche"><i class="fa fa-tags"></i> Gestione pratiche</a></li>
				<li><a href="login0.php?corpus=stampa-registro"><span class="glyphicon glyphicon-print"></span> Stampa il registro</a></li>
			</ul>
		</li>
		
		<li <?php if($_GET['corpus'] == 'anagrafica') { echo 'class="active"'; }?>><a href="login0.php?corpus=anagrafica"><span class="glyphicon glyphicon-user"></span> Anagrafica</a></li>
		<li <?php if($_GET['corpus'] == 'ricerca' OR $_GET['corpus']=='risultati') { echo 'class="active"'; }?>><a href="login0.php?corpus=ricerca"><span class="glyphicon glyphicon-search"></span> Ricerca</a></li>
		<li <?php if($_GET['corpus'] == 'aiuto') { echo 'class="active"'; }?>><a href="login0.php?corpus=aiuto"><span class="glyphicon glyphicon-question-sign"></span> F.A.Q.</a></li>
		<li <?php if($_GET['corpus'] == 'informazioni') { echo 'class="active"'; }?>><a href="login0.php?corpus=informazioni"><span class="glyphicon glyphicon-info-sign"></span> Informazioni</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Logged as <strong><?php echo $_SESSION['loginname'];?></strong> <b class="caret"></b></a>
		<ul class="dropdown-menu">
		<li><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>"><span class="glyphicon glyphicon-edit"></span> Cambia Password</a></li>
		<li><a href="login0.php?corpus=segnala-bug"><span class="glyphicon glyphicon-warning-sign"></span> Segnala un Errore</a></li>
		<li><a href="login0.php?corpus=settings"><span class="glyphicon glyphicon-cog"></span> Impostazioni</a></li>
		<?php 
			if ($_SESSION['auth'] > 80) {
				?>
				<li class="divider"></li>
				<li><a href="login0.php?corpus=gestione-utenti"><i class="fa fa-users"></i> Gestione degli Utenti</a></li>
				<li><a href="login0.php?corpus=advancedsettings"><span class="glyphicon glyphicon-wrench"></span> Advanced Settings</a></li>
				<li><a href="download.php?lud=log/access.log&est=log"><span class="glyphicon glyphicon-download"></span> Scarica il log degli accessi</a></li>
				<li><a href="login0.php?corpus=log-mail"><span class="glyphicon glyphicon-envelope"></span> Visualizza il log delle mail</a></li>
				<li><a href="login0.php?corpus=history"><span class="glyphicon glyphicon-time"></span> Visualizza il log delle azioni</a></li>
				<li><a href="login0.php?corpus=backup"><span class="glyphicon glyphicon-floppy-save"></span> Backup</a></li>
				<?php
			}
		?>
		<li class="divider"></li>
		<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
		</ul>
		</li>
	    </div><!-- /.navbar-collapse -->
	</nav>
<?php
	if ($_GET['corpus'] != 'cambioanno') { 
		$my_registroprotocollo->publcontrolloanno (); //controllo della corrispondenza fra l'anno corrente e l'anno in uso dal db
	}
?>