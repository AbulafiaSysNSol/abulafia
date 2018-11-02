<?php

    session_start();
    
    if (isset($_SESSION['auth']) && $_SESSION['auth'] > 1 ) {
        header("Location: login0.php?corpus=home");
    }

	if(!isset($_GET['err'])) {
		$_GET['err'] = 0;
	}

    if(!isset($_GET['s'])) {
        $s = 0;
    }
    else {
        $s = $_GET['s'];
    }

    if(!isset($_GET['recovery'])) {
        $recovery = 0;
    }
    else {
        $recovery = $_GET['recovery'];
    }

    if(!isset($_GET['expire'])) {
        $expire = 0;
    }
    else {
        $expire = $_GET['expire'];
    }

    if(isset($_GET['change'])) {
        $change = $_GET['change'];
    }
    else {
        $change = "";
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

    <title>Abulafia Web - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mobile.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>

</head>

<body>

	<!-- JavaScript -->
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>
    

    <div class="container">

        <div class="row">
	
            <?php
            if ($s) {
                ?>
                <center><div class="alert alert-warning"><b><i class="fa fa-warning"></i> Non hai effettuato l'accesso o la sessione &egrave; scaduta. Effettua nuovamente il login per utilizzare l'applicazione.</b></div></center>
                <?php
            }

            if ($recovery) {
                ?>
                <center><div class="alert alert-info"><b><i class="fa fa-check"></i> Ti abbiamo inviato un'email con un link per resettare la password. Ricordati di controllare anche la posta indesiderata.</b></div></center>
                <?php
            }

            if ($expire) {
                ?>
                <center><div class="alert alert-danger"><b><i class="fa fa-warning"></i> Il link per resettare la password &egrave; scaduto. Esegui nuovamente la procedura per il ripristino della password.</b></div></center>
                <?php
            }

            if ($change == "error") {
                ?>
                <center><div class="alert alert-danger"><b><i class="fa fa-warning"></i> Si &egrave; verificato un problema con il cambio password. Esegui nuovamente la procedura per il ripristino della password.</b></div></center>
                <?php
            }

            if ($change == "ok") {
                ?>
                <center><div class="alert alert-success"><b><i class="fa fa-check"></i> Cambio password andato a buon fine. Effettua l'accesso con la nuova password.</b></div></center>
                <?php
            }
            ?>

            <div class="col-sm-3">
                <center><div class="logodesktop"><img src="images/logo-home.png" width="95%"></div></center>
            </div>

            <div id="loginbox" class="col-sm-6">   
                <center>
                <div class="logomobile"><img src="images/logo-home.png" width="44%"></div>
                <div class="logomobile"><img src="images/logo-azienda.png" width="48%"></div>          
                </center>
                <div class="panel panel-<?php if($_GET['err'] == 1) {echo 'danger';} else {echo 'info';} ?>" >

                    <div class="panel-heading">
                        <div class="panel-title">
                            <center><?php if($_GET['err'] == 1) {echo '<i class="fa fa-warning"></i>';} ?> Abulafia Web - Login <?php if($_GET['err'] == 1) {echo ' - Username o Password Errati';} ?></center>
                        </div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
                            
                        <form id="loginform" class="form-horizontal" action="login1.php" method="post" role="form">
                            
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="userid" value="" placeholder="username" required>                                        
                            </div>
                                    
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password" placeholder="password" required>
                            </div>
                                            
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <center><button type="submit" class="btn btn-info btn-lg"><i class="fa fa-sign-in"></i> Login</button>
                                    <br><br><a href="password-recovery.php">Hai dimenticato la password?</a></center>
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
                    <h4><a href="https://www.abulafiaweb.it">Abulafia Web - Smart Solutions</a></h4>
                    &copy; 2008 - 2018 <strong>Abulafia Sys'n'Sol</strong>
                    <br><br><br>
                </div>
            </center>
        </div>
	
    </div>

</body>

</html>