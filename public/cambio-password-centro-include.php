<?php $loginid=$_SESSION['loginid'];?>	

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" bgcolor="red"><b>Cambia Password</b></h3>
  </div>
  <div class="panel-body">
     <?php
    if( isset($_GET['pass']) && $_GET['pass'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-4">
	<div class="alert alert-success">Password modifcata!</div></div></div>
	<?php
   }
    if( isset($_GET['pass']) && $_GET['pass'] == "leng") {
	?>
	<div class="row">
	<div class="col-sm-4">
	<div class="alert alert-danger">La password deve contenere almeno 6 caratteri</div></div></div>
	<?php
   }
    if( isset($_GET['pass']) && $_GET['pass'] == "empty") {
	?>
	<div class="row">
	<div class="col-sm-4">
	<div class="alert alert-danger">Assicurati di aver compilato tutti i campi</div></div></div>
	<?php
   }
    if( isset($_GET['pass']) && $_GET['pass'] == "old") {
	?>
	<div class="row">
	<div class="col-sm-4">
	<div class="alert alert-danger">La password attuale non è corretta!</div></div></div>
	<?php
   }
    if( isset($_GET['pass']) && $_GET['pass'] == "nomatch") {
	?>
	<div class="row">
	<div class="col-sm-4">
	<div class="alert alert-danger">Le due password non coincidono</div></div></div>
	<?php
   }
   ?>
 
 <center><div class="alert alert-info"><i class="fa fa-lock"></i> Ti consigliamo di inserire una password che contenga <b>almeno 6 caratteri</b> e che sia composta da <b>lettere e numeri.</b></div></center>
    <form action="login0.php?corpus=cambio-password2" method="post" role="form">
  <div class="form-group">
    <label><i class="fa fa-key"></i> Password attuale:</label>
	<div class="row">
	<div class="col-sm-3">
		<input class="form-control input-sm" size="40" type="password" name="vecchiapassword" />
	</div>
	</div>
  </div>
  <div class="form-group">
    <label><i class="fa fa-key"></i> Nuova password:</label>
	<div class="row">
	<div class="col-sm-3">
		<input class="form-control input-sm" size="40" type="password" name="nuovapassword1" />
	</div>
	</div>
  </div>
  <div class="form-group">
    <label><i class="fa fa-key"></i> Ripeti nuova password:</label>
	<div class="row">
	<div class="col-sm-3">
		<input class="form-control input-sm" size="40" type="password" name="nuovapassword2" />
	</div>
	</div>
  </div>
  <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-check"></i> Cambia Password</button>
</form>
</div>
</div>