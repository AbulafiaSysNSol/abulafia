<?php

    session_start();
    
    if (isset($_SESSION['auth']) && $_SESSION['auth'] > 1 ) {
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
    <meta name="description" content="Abulafia Web: Protocollo Informatico - Gestione Documentale - Gestione Magazzino">
    <meta name="author" content="Biagio Saitta & Alfio Musmarra">
    <meta name="keywords" content="abulafia web, smart solutions, protocollo informatico, gestione documentale, gestione magazzino">

    <title>Abulafia Web - Recupera Password</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mobile.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>

</head>

<body>

	<!-- JavaScript -->
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>
    

    <div class="container">

        <div class="row">

            <div class="col-sm-3">
                <center><div class="logodesktop"><img src="images/logo-home.png" width="270"></div></center>
            </div>

            <div id="loginbox" class="col-sm-6">   
                <center>
                <div class="logomobile"><img src="images/logo-home.png" width="44%"></div>
                <div class="logomobile"><img src="images/logo-azienda.png" width="48%"></div>          
                </center>
                <div class="panel panel-<?php if($_GET['err'] == 1) {echo 'danger';} else {echo 'warning';} ?>" >

                    <div class="panel-heading">
                        <div class="panel-title">
                            <center><?php if($_GET['err'] == 1) {echo '<i class="fa fa-warning"></i>';} ?>Recupera Password<br><?php if($_GET['err'] == 1) {echo 'Utente non trovato, controlla i dati inseriti!';} ?></center>
                        </div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
                            
                        <form id="recoveryform" class="form-horizontal" action="password-recovery2.php" method="post" role="form">
                            
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="codicefiscale" type="text" minlength="16" maxlength="16" class="form-control" name="codicefiscale" value="" placeholder="inserisci il codice fiscale" required>                                        
                            </div>
                                    
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control" name="email" placeholder="inserisci l'indirizzo email" required>
                            </div>
                                            
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <center>
                                        <button type="submit" class="btn btn-warning btn-lg"><i class="fa fa-check"></i> Convalida Dati</button>
                                         <br><br><a href="index.php"><i class="fa fa-arrow-left"></i> Torna al Login</a>
                                    </center>
                                </div>
                            </div>
                            
                        </form>                      
                    </div>  
                </div>
        	</div>

            <div class="col-sm-3">
                <center><div class="logodesktop"><img src="images/logo-azienda.png" width="100%"></div></center>
            </div>
	    
        </div>

        <div class="row">
            <center>
                <div class="col-sm-12">
                    <div><h4><a href="https://www.abulafiaweb.it">Abulafia Web - Smart Solutions</a></h4></div>
                    <div><small>&copy; 2008 - <?php echo date("Y"); ?> <strong>Abulafia Sys'n'Sol</strong><small></div>
                    <br><br><br>
                </div>
            </center>
        </div>
    
    </div>
	
</body>

</html>