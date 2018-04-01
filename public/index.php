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

    <title>Abulafia Web - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
    
	<!-- Google Adsense
	  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-5144136285411668",
			enable_page_level_ads: true
		  });
		</script>
	End Google -->

</head>

<body>

	<!-- JavaScript -->
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/bootstrap.js"></script>
    

    <div class="container">

        <div class="row" style="margin-top:70px;">
	
            <?php
            if ($s) {
            ?>
            <center><div class="alert alert-warning"><b><i class="fa fa-warning"></i> Non hai effettuato l'accesso o la sessione &egrave; scaduta. Effettua nuovamente il login per utilizzare l'applicazione.</b></div></center>
            <?php
            }
            ?>

            <div class="col-sm-3">
                <center><img src="images/logo-home.png" width="95%"></center>
            </div>

            <div id="loginbox" class="col-sm-6">                    
                <div class="panel panel-<?php if($_GET['err'] == 1) {echo 'danger';} else {echo 'info';} ?>" >
                    
                    <div class="panel-heading">
                        <div class="panel-title"><center><?php if($_GET['err'] == 1) {echo '<i class="fa fa-warning"></i>';} ?> Abulafia Web - Login <?php if($_GET['err'] == 1) {echo ' - Username o Password Errati';} ?></center></div>
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
                    <h4>More info at: <a href="https://www.abulafiaweb.it">Abulafia Web - Smart Solutions</a></h4>
                    &copy; 2008 - 2018 <strong>Abulafia Sys'n'Sol</strong>
                    <br><br><br>
                </div>
            </center>
        </div>
    </div>
	
	<!--
	<center>
    	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	Home2
	<ins class="adsbygoogle"
	     style="display:inline-block;width:728px;height:90px"
	     data-ad-client="ca-pub-5144136285411668"
	     data-ad-slot="7478152501"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	</center>
	-->
	
</body>

</html>
