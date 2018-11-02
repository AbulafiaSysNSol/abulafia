<html>

	<head>
	  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
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
	</head>

	<body>
		<?php

			session_start();
			
			if ($_SESSION['auth'] < 1 ) {
				header("Location: index.php?s=1");
				exit(); 
			}

			function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
				require_once "class/" . $class_name.".obj.inc";
			}

			include '../db-connessione-include.php'; //connessione al db-server
				
			$id = $_GET['id'];
			$a = new Anagrafica();
			$c = new Calendario();
			$info = $a->infoAssistito($id);
			
		?>

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-info"></i> Info Assistito</strong></h3>
			</div>
				
			<div class="panel-body">

				<div class="row">
					<div class="col-sm-4">
                       	Nome:<br>
                       	<label><?php echo ucwords($info['nome']); ?></label>
                   	</div>

                    <div class="col-sm-4">
                       	Cognome:<br>
                      	<label><?php echo ucwords($info['cognome']); ?></label>
                    </div>

                    <div class="col-sm-4">
                       	Codice Fiscale:<br>
                       	<label><?php echo strtoupper($info['codicefiscale']); ?></label>
                    </div>
                </div>
                <br>
                <div class="row">
					<div class="col-sm-4">
                       	Luogo di nascita:<br>
                       	<label><?php echo ucwords($info['luogonascita']); ?></label>
                   	</div>

                    <div class="col-sm-4">
                       	Data di Nascita:<br>
                      	<label><?php echo $c->dataSlash($info['datanascita']); ?></label>
                    </div>
                </div>
                <br>
                <div class="row">
					<div class="col-sm-4">
                       	Residente in:<br>
                       	<label><?php echo ucwords($info['residenzacitta']); ?></label>
                   	</div>

                    <div class="col-sm-4">
                       	Via/Viale/Piazza:<br>
                      	<label><?php echo ucwords($info['residenzavia']); ?></label>
                    </div>

                    <div class="col-sm-4">
                       	Numero Civico:<br>
                       	<label><?php echo ucwords($info['residenzanumero']); ?></label>
                    </div>
                </div>
							
			</div>
		</div>

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-heartbeat"></i> Accessi in Ambulatorio</strong></h3>
			</div>
				
			<div class="panel-body">
				<center><div class="alert alert-warning"><i class="fa fa-info-circle"></i> Nessun accesso registrato per l'anagrafica selezionata.</div></center>
			</div>
		</div>

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-file-text-o"></i> Certificati Rilasciati</strong></h3>
			</div>
				
			<div class="panel-body">
				<center><div class="alert alert-warning"><i class="fa fa-info-circle"></i> Nessun certificato emesso per l'anagrafica selezionata.</div></center>		
			</div>
		</div>
	
	</body>
</html>