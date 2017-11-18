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
    <meta name="description" content="Abulafia - Protocollo Informatico dei Volontari C.R.I.">
    <meta name="author" content="Biagio Saitta & Alfio Musmarra">
    <meta name="keywords" content="abulafia, protocollo, informatico, volontari, croce rossa italiana, cri, segreteria">

    <title>Abulafia - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>

</head>

<body>

	<!-- JavaScript -->
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>
    

    <div class="container">

        <div class="row" style="margin-top:70px;">

            <div class="col-sm-3">
                <center><img src="images/logo-home.png" width="95%"></center>
            </div>

            <div id="loginbox" class="col-sm-6">                    
                <div class="panel panel-<?php if($_GET['err'] == 1) {echo 'danger';} else {echo 'info';} ?>" >
                    
                    <div class="panel-heading">
                        <div class="panel-title"><center><?php if($_GET['err'] == 1) {echo '<i class="fa fa-warning"></i>';} ?> Abulafia - Login <?php if($_GET['err'] == 1) {echo ' - Username o Password Errati';} ?></center></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
                            
                        <form id="loginform" class="form-horizontal" action="login1.php" method="post" role="form">
                            
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input id="login-username" type="text" class="form-control" name="userid" value="" placeholder="username or email">                                        
                            </div>
                                    
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                            </div>
                                            
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <center><button type="submit" class="btn btn-info btn-lg"><i class="fa fa-sign-in"></i> Login</center></button>
                                </div>
                            </div>
                            
                        </form>                      
                    </div>  
                </div>
        	</div>

            <div class="col-sm-3">
                <center><img src="images/logo-azienda.png" width="100%"></center>
            </div>
        </div>
    </div>

    <div class="container">
        <hr>
         <div class="row">
            <center>
                <div class="col-sm-12">
                    Abulafia is licensed under a: <a href="license.txt" target="_blank">GNU GPL V.3</a><br>
                    More info at: <a href="">http://www.abulafiaweb.it</a>
                    <br>
                    &copy; 2008 - 2017 <strong>Abulafia Sys'n'Sol</strong>
                    <br><br><br>
                </div>
            </center>
        </div>
    </div>

</body>

</html>
