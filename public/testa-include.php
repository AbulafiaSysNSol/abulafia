 <?php

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	include 'maledetti-apici-centro-include.php';

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
	$my_anagrafica = unserialize($_SESSION['my_anagrafica']);//deserializzazione 
	$my_log = unserialize($_SESSION['my_log']);//deserializzazione 
	$my_registroprotocollo = unserialize($_SESSION['my_registroprotocollo']);//deserializzazione 
	$my_ricerca = unserialize($_SESSION['my_ricerca']);//deserializzazione 
	$my_manuale = unserialize($_SESSION['my_manuale']);//deserializzazione 
	$my_tabellahtml = unserialize($_SESSION['my_tabellahtml']);//deserializzazione 
	$my_database = unserialize($_SESSION['my_database']);//deserializzazione
	$my_lettera = unserialize($_SESSION['my_lettera']);//deserializzazione 
/*deprecato	$setting=mysq<l_query("select * from defaultsettings");
	$setting2=mysq<l_fetch_array($setting);
*/

	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT * FROM defaultsettings'); 
		$query->execute();
		$connessione->commit();
	} 
		
	//gestione dell'eventuale errore della connessione
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
	}
	
	$setting= $query->fetchAll();
	$setting2=$setting[0];

	$_SESSION['paginaprincipale'] = $setting2['paginaprincipale'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo 'Abulafia Web ' . $_SESSION['version'];?></title>
<meta name="keywords" content="abulafia web, protocollo informatico, gestione documentale, gestione magazzino" />
<meta name="description" content="Abulafia Web - Protocollo Informatico - Gestione Documentale - Gestione Magazzino" />
<meta name="author" content="Biagio Saitta & Alfio Musmarra" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="style.php"/>

  <!-- META -->
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <!-- META -->
  
  <!-- CSS -->
  <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.10.4.custom.css"></link>
  <link href="css/grid.css" rel="stylesheet">
  <!-- CSS -->  
  
  <!-- JS -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery-1.10.4.custom.js"></script>
  <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-i18n.js"></script>
  <script type="text/javascript" src="lib/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
  <!-- JS -->

  <!-- FULLCALENDAR -->
  <link rel='stylesheet' href='lib/fullcalendar/fullcalendar.css' />
  <script src='lib/fullcalendar/lib/moment.min.js'></script>
  <script src='lib/fullcalendar/fullcalendar.js'></script>
  <script src='lib/fullcalendar/locale/it.js'></script>
  <!-- FULLCALENDAR -->

  <script type="text/javascript">
  	$(function() {
	  	$('#calendar').fullCalendar({
 	 })
	});
  </script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editor",
    language: 'it',
    statusbar : false,
    menubar: true,
    promotion: false,
    forced_root_block: false,
    nonbreaking_force_tab: true,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
    fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt 54pt 72pt",
    plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak ysearchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern imagetools',
    toolbar1: "bold underline italic strikethrough forecolor backcolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent fontsizeselect",
    toolbar2: "table subscript superscript charmap link image preview visualblocks visualchars code"
 });
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editorMail",
    language: 'it',
    height: 350,
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
    plugins: 'paste',
    toolbar: "bold underline italic strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
 });
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editorOgg",
    language: 'it',
		height: 200,
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
     plugins: 'paste',
    toolbar: "bold underline italic strikethrough"
 });
</script>
  
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
			
			$(".iframe").fancybox({
				type: 'iframe',
				'padding' : 10,  
				'autoDimensions' : false,
				'width' : 500,
				'height' : 'auto'
			});

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
  
	<?php
		$anag = new Anagrafica();
	?>

  <div class="container">
	 
	 <div class="page-header">
		<div class="row" valign="middle">

			<div class="col-sm-3" style="padding-top: 15px;">
				<center><a href="?corpus=home"><img src="images/logo-strech.png" width="100%"></a></center>
			</div>
			
			<div class="col-sm-7" style="padding-top: 20px; padding-bottom: 30px;">
				<center>
					<h2><?php echo $_SESSION['nomeapplicativo']; ?></h2> 
					<h3><?php echo $_SESSION['headerdescription']; ?></h3> 
				</center>
			</div>

			<div class="col-sm-2 logodesktop" align="right" style="padding-top: 10px;">
				<center><a href="https://www.abulafiaweb.it" target="_blank"><img width="100" src="images/abulafia-logo-scont.png"></a>
				<br><small>Ver. <?php echo $_SESSION['version']; ?></small></center>
			</div>
			
		</div>
	</div>
	
	<nav class="navbar navbar-default" role="navigation">
		
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<center>Menu
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></center>
				</button>
			</div>
		
			<div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php if($_GET['corpus'] == 'home') { echo 'class="active"'; }?>><a href="login0.php?corpus=home"><i class="fa fa-dashboard fa-fw"></i> Dash</a></li>
					
					<?php if($_SESSION['mod_anagrafica'] && $anag->isAnagrafica($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'anagrafica' OR $_GET['corpus']=='ricerca-anagrafica') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-address-book-o fa-fw"></i> Anagrafica <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=anagrafica"><i class="fa fa-user-plus fa-fw"></i> Inserisci nuova anagrafica</a></li>
								<li><a href="login0.php?corpus=ricerca-anagrafica"><i class="fa fa-search fa-fw"></i></span> Ricerca in anagrafica</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_protocollo'] && $anag->isProtocollo($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'protocollo' OR $_GET['corpus']=='titolario' OR $_GET['corpus']=='titolario-modifica' OR $_GET['corpus']=='stampa-registro' OR $_GET['corpus'] == 'protocollo2') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book fa-fw"></i> Protocollo <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=protocollo2&from=crea"><i class="fa fa-plus fa-fw"></i></span> Crea nuovo numero progressivo</a></li>
								<li><a href="login0.php?corpus=ricerca-protocollo"><i class="fa fa-search fa-fw"></i> Ricerca nel protocollo</a></li>
								<li><a href="login0.php?corpus=titolario"><i class="fa fa-list fa-fw"></i> Gestione titolario</a></li>
								<li><a href="login0.php?corpus=pratiche"><i class="fa fa-tags fa-fw"></i> Gestione pratiche</a></li>
								<li><a href="login0.php?corpus=stampa-registro"><i class="fa fa-file-pdf-o fa-fw"></i> Esporta registro in PDF</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_documenti'] && $anag->isDocumenti($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'documenti' OR $_GET['corpus']=='documenti-nuovo') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-folder-o fa-fw"></i> Documenti <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=documenti-nuovo"><i class="fa fa-upload fa-fw"></i> Carica documento</a></li>
								<li><a href="login0.php?corpus=documenti-elenco"><i class="fa fa-search fa-fw"></i></span> Elenco documenti</a></li>
								<li><a href="login0.php?corpus=documenti-categorie"><i class="fa fa-th-large fa-fw"></i></span> Gestisci categorie</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php
					if($_SESSION['mod_lettere'] && $anag->isLettere($_SESSION['loginid'])) {
						$user = $_SESSION['loginid'];
						if($anag->isAdmin($_SESSION['loginid'])) {
							try {
   								$connessione->beginTransaction();
								$query = $connessione->prepare('SELECT COUNT(*) 
												FROM comp_lettera 
												WHERE (vista = 1 OR vista = 2) 
												AND firmata = 0');
								$query->execute();
								$connessione->commit();
							} 
		
							//gestione dell'eventuale errore della connessione
							catch (PDOException $errorePDO) { 
    							echo "Errore: " . $errorePDO->getMessage();
							}
						}
						else {
							try {
   								$connessione->beginTransaction();
								$query = $connessione->prepare('SELECT count(*) 
												FROM comp_lettera, joinpersoneuffici 
												WHERE (vista = 1 OR vista = 2) 
												AND firmata = 0 
												AND joinpersoneuffici.ufficio = comp_lettera.ufficio 
												AND joinpersoneuffici.utente = :user'); 
								$query->bindParam(':user', $user);
								$query->execute();
								$connessione->commit();
							} 
		
							//gestione dell'eventuale errore della connessione
							catch (PDOException $errorePDO) { 
    							echo "Errore: " . $errorePDO->getMessage();
							}
						}
						$risultati = $query->fetchAll();
						$num = $risultati[0];
						try 
						{
   							$connessione->beginTransaction();
							$query = $connessione->prepare('SELECT count(*) 
															FROM comp_lettera, joinpersoneuffici 
															WHERE firmata = 1 
															AND protocollo = 0');
							$query->execute();
							$connessione->commit();
						} 
						catch (PDOException $errorePDO) 
						{ 
    						echo "Errore: " . $errorePDO->getMessage();
						}						
						
						$risultati = $query->fetchAll();
						$protocollare = $risultati[0];
						$_SESSION['daprotocollare'] = $protocollare[0];
						?>
						<li class="dropdown <?php if($_GET['corpus'] == 'lettera' OR $_GET['corpus']=='lettera2' OR $_GET['corpus']=='elenco-lettere' OR $_GET['corpus']=='elenco-lettere-firma') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php 
									if($protocollare[0] > 0) {
										echo '<span class="badge alert-success"><i class="fa fa-exclamation fa-fw"></i></span>';
									}
									else {
										echo '<i class="fa fa-file-text-o fa-fw"></i>';
									}
								?>
								 Lettere
								<?php 
									if(($num[0] > 0) && ($_SESSION['auth']>=90)) {
										echo '<span class="badge alert-success">' . $num[0] . '</span>';
									}
								?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=lettera"><i class="fa fa-pencil fa-fw"></i> Scrivi lettera</a></li>
								<li><a href="login0.php?corpus=attributi"><i class="fa fa-font fa-fw"></i> Gestione Attributi</a></li>
								<li><a href="login0.php?corpus=elenco-lettere"><i class="fa fa-wrench fa-fw"></i> Lettere in Lavorazione <?php if($protocollare[0] > 0) { echo '<span class="badge alert-success">'. $protocollare[0] .' da protocollare!</span>'; } ?></a></li>
								<li><a href="login0.php?corpus=archivio-lettere"><i class="fa fa-archive fa-fw"></i> Lettere Archiviate</a></li>
								<?php 
									$_SESSION['dafirmare'] = $num[0]; 
									if(($num[0] > 0) && ($_SESSION['auth']>=90)) {
										echo '<li class="divider"></li>';
										echo '<li><a href="login0.php?corpus=elenco-lettere-firma"><i class="fa fa-pencil fa-fw"></i> Lettere da Firmare <span class="badge alert-success">' . $num[0] . '</span></a></li>';
									}
								?>
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_magazzino'] && $anag->isMagazzino($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'farm-magazzino' OR $_GET['corpus']=='farmacia') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cubes fa-fw"></i> Magazzino <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?corpus=magazzino-prodotti"><i class="fa fa-asterisk fa-fw"></i> Prodotti</a></li>
								<li><a href="?corpus=magazzino-servizi"><i class="fa fa-building-o fa-fw"></i> Servizi</a></li>
								<li><a href="?corpus=magazzino-depositi"><i class="fa fa-suitcase fa-fw"></i> Depositi</a></li>
								<li><a href="?corpus=magazzino-documenti"><i class="fa fa-file-text-o fa-fw"></i> Documenti</a></li>
								<li class="divider"></li>
								<li><a href="?corpus=magazzino-settori"><i class="fa fa-list-ul fa-fw"></i> Settori</a></li>
								<!--<li><a href="?corpus=magazzino-causali"><i class="fa fa-list-ul fa-fw"></i> Causali</a></li>
								<li><a href="#"><i class="fa fa-pencil-square-o"></i> Richieste</a></li>
								<li><a href="#"><i class="fa fa-truck"></i> Ordini</a></li> -->
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_ambulatorio'] && $anag->isAmbulatorio($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'cert' OR $_GET['corpus']=='cert-anag') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-medkit fa-fw"></i> Ambulatorio <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?corpus=cert-add-anag"><i class="fa fa-user-plus fa-fw"></i> Inserisci Assistito</a></li>
								<li><a href="?corpus=cert-search-anag"><i class="fa fa-search fa-fw"></i> Ricerca Assistito</a></li>
								<li><a href="?corpus=cert-search-visit"><i class="fa fa-list fa-fw"></i> Elenco Prestazioni</a></li>
								<li><a href="?corpus=cert-list-richieste"><i class="fa fa-medkit fa-fw"></i> Richieste Certificati</a></li>
								<li><a href="?corpus=cert-new-report"><i class="fa fa-file-pdf-o fa-fw"></i> Genera Report</a></li>
							</ul>
						</li>
					<?php } ?>
					
				</ul>
		   
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user fa-fw"></i> <strong><?php echo $_SESSION['loginname'];?></strong> <b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">OPZIONI</li>
							<li><a href="login0.php?corpus=settings"><i class="fa fa-cog fa-fw"></i> Impostazioni Utente</a></li>
							<li><a href="login0.php?corpus=server-mail"><i class="fa fa-envelope-o fa-fw"></i> Impostazioni Email</a></li>
							<li><a href="login0.php?corpus=statistiche"><i class="fa fa-bar-chart fa-fw"></i> Statistiche</a></li>
							<li><a href="https://www.abulafiaweb.it/#contact-section" target="_blank"><i class="fa fa-comment-o fa-fw"></i> Contattaci</a></li>
							<li><a href="https://abulafiaweb.freshdesk.com" target="_blank"><i class="fa fa-support fa-fw"></i> Portale Helpdesk</a></li>
							<?php 
								if ($_SESSION['auth'] >= 90) {
									?>
									<li class="divider"></li>
									<li role="presentation" class="dropdown-header">ADVANCED</li>
									<?php if($anag->isAdmin($_SESSION['loginid'])) { ?><li><a href="login0.php?corpus=gestione-utenti"><i class="fa fa-users fa-fw"></i> Gestione degli Utenti</a></li> <?php } ?>
									<?php if($anag->isAdmin($_SESSION['loginid'])) { ?><li><a href="login0.php?corpus=advancedsettings"><i class="fa fa-cogs fa-fw"></i> Advanced Settings</a></li> <?php } ?>
									<li><a href="login0.php?corpus=loghi"><i class="fa fa-picture-o fa-fw"></i> Logo e Intestazione</a></li>
									<li><a href="login0.php?corpus=backup"><i class="fa fa-cloud-download fa-fw"></i> Backup</a></li>
									<li><a href="login0.php?corpus=diagnostica"><i class="fa fa-wrench fa-fw"></i> Diagnostica</a></li>
									<?php if($anag->isAdmin($_SESSION['loginid'])) { ?>
										<li class="divider"></li>
										<li role="presentation" class="dropdown-header">LOG</li>
										<li><a href="login0.php?corpus=access-log"><i class="fa fa-sign-in fa-fw"></i> Accessi</a></li>
										<li><a href="login0.php?corpus=log-mail"><i class="fa fa-paper-plane-o fa-fw"></i> Email</a></li>
										<li><a href="login0.php?corpus=error-log"><i class="fa fa-exclamation-triangle fa-fw"></i> Errori</a></li>
										<li><a href="login0.php?corpus=history"><i class="fa fa-clock-o fa-fw"></i> Generale</a></li>
										<?php
									}
								}
							?>
							<li class="divider"></li>
							<li><a href="logout.php"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div> 
		</div>
	</nav>
	
<?php
	if ($_GET['corpus'] != 'cambioanno') { 
		$my_registroprotocollo->publcontrolloanno(); //controllo della corrispondenza fra l'anno corrente e l'anno in uso dal db
	}
?>
