<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
	if(!isset($_GET['err'])) {
		$_GET['err'] = 0;
	}
?>
<html>
<head>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<!-- META -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
 <!-- META -->
  
  <!-- CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="css/grid.css" rel="stylesheet">
  <!-- CSS -->  
  
  <!-- JS -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- JS -->
  
<title>Abulafia - Login</title>

</head>

<body>

<div class="row">
	<div class="col-md-8 col-md-offset-2">		
		
		<div class="container-login">
			<center>
				<div class="well"><label><h1 class="paneltitle">Abulafia</h1></label><br>Gestione delle segreterie dei Volontari della CRI</div>
				<?php
					if($_GET['err'] == 1) {
						?>
						<div class="row">
							<div class="col-xs-12">
								<div class="alert alert-danger"> <span class="glyphicon glyphicon-remove"></span> Username o password errati</div>
							</div>
						</div>
						<?php
					}
				?>
			</center>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><span class="glyphicon glyphicon-inbox"></span> <strong>Abulafia: saper conservare, saper ritrovare.</strong></h3>
							</div>
					
							<div class="panel-body">
								<div style="text-align: justify">
									Si evolvono gli uffici, pubblici e privati, per stare al passo con i tempi e con le rinnovate esigenze di gestione amministrativa e del personale.
									<br>Abulafia vuole essere un piccolo contributo, aperto a chiunque abbia voglia di suggerire 
									miglioramenti, per la gestione degli affari correnti delle segreterie dei volontari della CRI.
									<br><br>Chiunque fosse interessato al progetto, puo' contattare l'amministratore del sito all'indirizzo email <strong>informatica@cricatania.it</strong> <span class="glyphicon glyphicon-envelope"></span>
								</div>
								<div class="text-right">
									<small>03 dicembre 2008</small>
								</div>
							</div>
						</div>
					</div>
			<center>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><b><span class="glyphicon glyphicon-log-in"></span> Login</b></h3>
							</div>
								
							<div class="panel-body">
								Per accedere al sistema, inserisci username e password:<br><br>
			 
								<form action="login1.php" method="post" role="form">
									<div class="form-group">
										<label>Username:</label>
										<div class="row">
											<div class="col-md-8 col-md-offset-2">
												<input type="text" class="form-control" name="userid" placeholder="username">
											</div>
										</div>
									</div>
										
									<div class="form-group">
										<label>Password:</label>
										<div class="row center">
											<div class="col-md-8 col-md-offset-2">
												<input type="password" class="form-control" name="password" placeholder="password">
											</div>
										</div>
									</div>
			  
									<button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span> Accedi</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</center>
			<center>
				<small>
					Abulafia is licensed under a: <a href="license.txt" target="_blank">GNU GPL V.3</a><br />
					&copy; 2008 - 2014 <strong>Abulafia Sys'n'Sol</strong>
				</small>
			</center>
		</div>
	</div>
</div>

</body>
</html>