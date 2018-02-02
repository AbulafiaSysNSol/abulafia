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
	$my_lettera= unserialize($_SESSION['my_lettera']);//deserializzazione 
	$setting=mysql_query("select * from defaultsettings");
	$setting2=mysql_fetch_array($setting);

	$_SESSIONs['paginaprincipale'] = $setting2['paginaprincipale'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>

<script>
function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	var file = _("uploadedfile").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("uoloadedfile", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "login0.php?corpus=prot-modifica-file");
	ajax.send(formdata);
}
function progressHandler(event){
	_("loaded_n_total").innerHTML = "Caricati "+(event.loaded/1000)+" KB si "+(event.total/1000);
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent)+"% caricato... attendi il completamento";
}
function completeHandler(event){
	_("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
}
function errorHandler(event){
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	_("status").innerHTML = "Upload Aborted";
}
</script>

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5144136285411668",
    enable_page_level_ads: true
  });
</script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $_SESSION['nomeapplicativo'] . ' ' . $_SESSION['version'];?></title>
<meta name="keywords" content="abulafia, protocollo, informatico, volontari, croce rossa italiana, cri, segreteria" />
<meta name="description" content="Abulafia - Protocollo Informatico dei Volontari C.R.I." />
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

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editor",
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    nonbreaking_force_tab: true,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
    fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt 54pt 72pt",
    plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: "bold underline italic strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
    toolbar2: "table | subscript superscript charmap | link image | paste | preview visualblocks visualchars code"
 });
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editorMail",
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
    plugins: [
		'paste'
    ],
    toolbar: "bold underline italic strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
 });
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editorOgg",
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
     plugins: [
		'paste'
    ],
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
		<div class="row">
			<div class="col-sm-1">
				<center><img width="60" src="images/abulafia logo-scont.png"></center>
			</div>
			<div class="col-sm-7">
				<h2><?php echo $_SESSION['nomeapplicativo'] .' ' . $_SESSION['version'] . ' <br><small>'. $_SESSION['headerdescription'];?></small></h2> 
			</div>
			<div class="col-sm-4" align="center" valign="middle">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- AbuHeader -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:320px;height:100px"
				     data-ad-client="ca-pub-5144136285411668"
				     data-ad-slot="5521587909"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
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
					<li <?php if($_GET['corpus'] == 'home') { echo 'class="active"'; }?>><a href="login0.php?corpus=home"><i class="fa fa-home"></i> Home</a></li>
					
					<?php if($_SESSION['mod_anagrafica'] && $anag->isAnagrafica($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'anagrafica' OR $_GET['corpus']=='ricerca-anagrafica') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user fa-fw"></i> Anagrafica <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=anagrafica"><i class="fa fa-plus fa-fw"></i> Inserisci nuova anagrafica</a></li>
								<li><a href="login0.php?corpus=ricerca-anagrafica"><i class="fa fa-search fa-fw"></i></span> Ricerca in anagrafica</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_protocollo'] && $anag->isProtocollo($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'protocollo' OR $_GET['corpus']=='titolario' OR $_GET['corpus']=='titolario-modifica' OR $_GET['corpus']=='stampa-registro' OR $_GET['corpus'] == 'protocollo2') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book"></i> Protocollo <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=protocollo2&from=crea"><i class="fa fa-plus fa-fw"></i></span> Crea nuovo numero progressivo</a></li>
								<li><a href="login0.php?corpus=ricerca-protocollo"><i class="fa fa-search fa-fw"></i> Ricerca nel protocollo</a></li>
								<li><a href="login0.php?corpus=titolario"><i class="fa fa-list fa-fw"></i> Gestione titolario</a></li>
								<li><a href="login0.php?corpus=pratiche"><i class="fa fa-tags fa-fw"></i> Gestione pratiche</a></li>
								<li><a href="login0.php?corpus=stampa-registro"><i class="fa fa-file-pdf-o fa-fw"></i> Esporta registro in PDF</a></li>
							</ul>
						</li>
					<?php } ?>


					<?php
					if($_SESSION['mod_lettere'] && $anag->isLettere($_SESSION['loginid'])) {
						$user = $_SESSION['loginid'];
						if($anag->isAdmin($_SESSION['loginid'])) {
							$query = mysql_query("SELECT COUNT(*) FROM comp_lettera WHERE (vista = 1 OR vista = 2) AND firmata = 0");
						}
						else {
							$query = mysql_query("SELECT COUNT(*) FROM comp_lettera, joinpersoneuffici WHERE (vista = 1 OR vista = 2) AND firmata = 0 AND joinpersoneuffici.ufficio = comp_lettera.ufficio AND joinpersoneuffici.utente = $user");
						}
						$num = mysql_fetch_row($query);
						$prot = mysql_query("SELECT COUNT(*) FROM comp_lettera WHERE firmata = 1 AND protocollo = 0");
						$protocollare = mysql_fetch_row($prot);
						?>
						<li class="dropdown <?php if($_GET['corpus'] == 'lettera' OR $_GET['corpus']=='lettera2' OR $_GET['corpus']=='elenco-lettere' OR $_GET['corpus']=='elenco-lettere-firma') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php 
									if($protocollare[0] > 0) {
										echo '<span class="badge alert-success"><i class="fa fa-exclamation"></i></span>';
									}
									else {
										echo '<i class="fa fa-file-text-o"></i>';
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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cubes"></i> Magazzino <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?corpus=magazzino-prodotti"><i class="fa fa-asterisk fa-fw"></i> Prodotti</a></li>
								<li><a href="?corpus=magazzino-servizi"><i class="fa fa-building-o fa-fw"></i> Servizi</a></li>
								<li><a href="?corpus=magazzino-depositi"><i class="fa fa-suitcase fa-fw"></i> Depositi</a></li>
								<li><a href="?corpus=magazzino-documenti"><i class="fa fa-file-text-o fa-fw"></i> Documenti di Magazzino</a></li>
								<li class="divider"></li>
								<li><a href="?corpus=magazzino-settori"><i class="fa fa-list-ul fa-fw"></i> Settori</a></li>
								<!--<li><a href="?corpus=magazzino-causali"><i class="fa fa-list-ul fa-fw"></i> Causali</a></li>
								<li><a href="#"><i class="fa fa-pencil-square-o"></i> Richieste</a></li>
								<li><a href="#"><i class="fa fa-truck"></i> Ordini</a></li> -->
							</ul>
						</li>
					<?php } ?>
					
				</ul>
		   
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Logged as <strong><?php echo $_SESSION['loginname'];?></strong> <b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">OPZIONI</li>
							<li><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>"><i class="fa fa-edit fa-fw"></i> Cambia Password</a></li>
							<li><a href="login0.php?corpus=segnala-bug"><i class="fa fa-warning fa-fw"></i> Segnala un Errore</a></li>
							<li><a href="login0.php?corpus=feedback"><i class="fa fa-thumbs-o-up fa-fw"></i> Invia Feedback</a></li>
							<li><a href="login0.php?corpus=settings"><i class="fa fa-cog fa-fw"></i> Impostazioni</a></li>
							<li><a href="login0.php?corpus=server-mail"><i class="fa fa-envelope-o fa-fw"></i> Impostazioni Server Mail</a></li>
							<li><a href="login0.php?corpus=statistiche"><i class="fa fa-bar-chart fa-fw"></i> Statistiche</a></li>
							<li><a href="http://wiki.abulafia.cricatania.it" target="_blank"><i class="fa fa-wikipedia-w fa-fw"></i> Wiki</a></li>
							<?php 
								if ($_SESSION['auth'] > 95) {
									?>
									<li class="divider"></li>
									<li role="presentation" class="dropdown-header">ADVANCED</li>
									<li><a href="login0.php?corpus=gestione-utenti"><i class="fa fa-users fa-fw"></i> Gestione degli Utenti</a></li>
									<li><a href="login0.php?corpus=advancedsettings"><i class="fa fa-cogs fa-fw"></i> Advanced Settings</a></li>
									<li><a href="login0.php?corpus=diagnostica"><i class="fa fa-wrench fa-fw"></i> Diagnostica</a></li>
									<li class="divider"></li>
									<li role="presentation" class="dropdown-header">LOG</li>
									<li><a href="login0.php?corpus=access-log"><i class="fa fa-key fa-fw"></i> Visualizza il log degli accessi</a></li>
									<li><a href="login0.php?corpus=log-mail"><i class="fa fa-envelope-o fa-fw"></i> Visualizza il log delle mail</a></li>
									<li><a href="login0.php?corpus=history"><i class="fa fa-clock-o fa-fw"></i> Visualizza il log delle azioni</a></li>
									<?php
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
		$my_registroprotocollo->publcontrolloanno (); //controllo della corrispondenza fra l'anno corrente e l'anno in uso dal db
	}
?>