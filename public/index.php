<?php

    session_start();
    
    if ($_SESSION['auth'] > 1 ) {
        header("Location: login0.php?corpus=home");
    }

	if(!isset($_GET['err'])) {
		$_GET['err'] = 0;
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Abulafia - Protocollo Informatico dei Volontari C.R.I.">
    <meta name="author" content="Biagio Saitta & Alfio Musmarra">
    <meta name="keywords" content="abulafia, protocollo, informatico, volontari, croce rossa italiana, cri, segreteria">

    <title>Abulafia - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
    <!-- Custom Google Web Font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <!-- Add custom CSS here -->
    <link href="css/landing-page.css" rel="stylesheet">

</head>

<body>

	<!-- JavaScript -->
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>
    
    <div class="intro-header">
	
	<div class="login">
		<div class="row">
			<div class="col-sm-12">
				<?php if($_GET['err'] == 1) {echo '<div class="danger"><i class="fa fa-warning"></i> Attenzione: username o password errati.</div><br>';} ?>
				<form class="form-inline" action="login1.php" method="post" role="form">
					<label>Username: </label>
					<div class="form-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">			
						<input type="text" class="form-control input-sm" name="userid" placeholder="username">
					</div>
					
					<label>Password: </label>
					<div class="form-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
						<input type="password" class="form-control input-sm" name="password" placeholder="password">
					</div>
				
					<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Accedi</button>
				</form>
			</div>
		</div>
	</div>
        
	<div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <div class="intro-message">
                        <h1>Abulafia</h1>
                        <h3>Gestione delle Segreterie e dei Magazzini</h3>
                        <hr class="intro-divider">
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-sm-5 col-sm-7">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Saper conservare, saper ritrovare.
                        </h2>
                    <p class="lead">
			Si evolvono gli uffici, pubblici e privati, per stare al passo con i tempi e con le rinnovate esigenze di gestione amministrativa e del personale.
			Abulafia vuole essere un piccolo contributo, aperto a chiunque abbia voglia di suggerire 
			miglioramenti, per la gestione degli affari correnti delle segreterie dei volontari della CRI.
		</p>
	        </div>
                <div class="col-sm-5 col-sm-offset-2 col-sm-5">
                    <img class="img-responsive" src="img/ritrovare.png">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    <div class="content-section-b">

        <div class="container">

            <div class="row">
                <div class="col-sm-5 col-sm-offset-1 col-sm-push-6  col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">Semplice, Veloce, Efficiente.</h2>
                    <p class="lead">Archivia ordinatamente tutta la corrispondenza in entrata e in uscita, con possibilit&agrave; di gestione titolario e pratiche. 
					Ricerca veloce fra la corrispondenza registrata con gli allegati a portata di click!</p>
                </div>
                <div class="col-sm-5 col-sm-pull-5  col-sm-6">
                    <img class="img-responsive" src="img/lettera.png">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-b -->
    
	<div class="banner">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<center><h3>Per info e supporto: abulafia@cricatania.it</h3><center>
				</div>
			</div>
		</div>
		<!-- /.container -->
	</div>
	<!-- /.banner -->

	<div class="container">
		<hr>
		 <div class="row">
			<center>
				<div class="col-sm-12">
					Abulafia is licensed under a: <a href="license.txt" target="_blank">GNU GPL V.3</a><br>
					&copy; 2008 - 2017 <strong>Abulafia Sys'n'Sol</strong>
					<br><br>
				</div>
			</center>
		</div>
	</div>
	
</body>

</html>
