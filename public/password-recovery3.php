<?php

    session_start();

    include '../db-connessione-include.php';
    include 'maledetti-apici-centro-include.php';
    
    if (isset($_SESSION['auth']) && $_SESSION['auth'] > 1 ) {
        header("Location: login0.php?corpus=home");
    }

	if(!isset($_GET['err'])) {
		$_GET['err'] = 0;
	}

    $token = $_GET['token'];
    $data = time();

    $recovery = mysql_query("SELECT * FROM passwordrecovery WHERE token = '$token' ");
    $recovery2 = mysql_fetch_array($recovery);
    $idutente = $recovery2['utente'];
    $datains = $recovery2['timestamp'];

    if(($data - $datains) > 86400) {
        ?>
        <script>
            window.location="index.php?expire=1";
        </script>
        <?php
        exit();
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
                <center><div class="logodesktop"><img src="images/logo-home.png" width="95%"></div></center>
            </div>

            <div id="loginbox" class="col-sm-6">   
                <center>
                <div class="logomobile"><img src="images/logo-home.png" width="44%"></div>
                <div class="logomobile"><img src="images/logo-azienda.png" width="48%"></div>          
                </center>
                <div class="panel panel-<?php if($_GET['err'] == 1) {echo 'danger';} else {echo 'success';} ?>" >

                    <div class="panel-heading">
                        <div class="panel-title">
                            <center><?php if($_GET['err'] == 1) {echo '<i class="fa fa-warning"></i>';} ?> Abulafia Web - Modifica Password<br></center>
                        </div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
                            
                        <form name="changepass" class="form-horizontal" method="post" role="form">

                            <input type="hidden" name="idutente" value="<?php echo $idutente; ?>">
                            
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="pass1" type="password" minlength="6" class="form-control" name="pass1" value="" placeholder="inserisci la nuova password" required>
                            </div>
                                    
                            <div style="margin-bottom: 25px" class="input-group <?php if($_GET['err'] == 1) {echo 'has-error';} ?>">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="pass2" type="password" minlength="6" class="form-control" name="pass2" placeholder="inserisci nuovamente la password" required>
                            </div>
                                            
                            <div style="margin-top:10px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <center>
                                        <button type="button" onClick="Controllo();" class="btn btn-success btn-lg"><i class="fa fa-check"></i> Modifica Password</button>
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
                    <h4><a href="https://www.abulafiaweb.it">Abulafia Web - Smart Solutions</a></h4>
                    &copy; 2008 - 2018 <strong>Abulafia Sys'n'Sol</strong>
                    <br><br><br>
                </div>
            </center>
        </div>
    
    </div>
	
</body>

</html>

<script>
 function Controllo() 
  {
    var pass1 = document.changepass.pass1.value;
    var pass2 = document.changepass.pass2.value;
 
    if (pass1 != pass2) {
        alert("Attenzione: le due password non coincidono");
        document.changepass.pass1.focus();
        return false;
    }
    else if((pass1 == "") || (pass1 == "undefined") || (pass1.length < 6)) {
        alert("Attenzione: inserire almeno 6 caratteri");
        document.changepass.pass1.focus();
    }
    else {
        document.changepass.action = "password-recovery4.php";
        document.changepass.submit();
      }
  }
</script> 