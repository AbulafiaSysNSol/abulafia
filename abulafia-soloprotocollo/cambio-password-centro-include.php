<?php $loginid=$_SESSION['loginid'];?>	

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" bgcolor="red"><b>Cambia Password</b></h3>
  </div>
  <div class="panel-body">
     <?php
    if($_GET['pass'] == "ok") {
	?>
	<div class="row">
	<div class="col-xs-4">
	<div class="alert alert-success">Password modifcata!</div></div></div>
	<?php
   }
    if($_GET['pass'] == "leng") {
	?>
	<div class="row">
	<div class="col-xs-4">
	<div class="alert alert-danger">La password deve contenere almeno 6 caratteri</div></div></div>
	<?php
   }
    if($_GET['pass'] == "empty") {
	?>
	<div class="row">
	<div class="col-xs-4">
	<div class="alert alert-danger">Assicurati di aver compilato tutti i campi</div></div></div>
	<?php
   }
    if($_GET['pass'] == "old") {
	?>
	<div class="row">
	<div class="col-xs-4">
	<div class="alert alert-danger">La password attuale non è corretta!</div></div></div>
	<?php
   }
    if($_GET['pass'] == "nomatch") {
	?>
	<div class="row">
	<div class="col-xs-4">
	<div class="alert alert-danger">Le due password non coincidono</div></div></div>
	<?php
   }
   ?>
 
    <form action="login0.php?corpus=cambio-password2" method="post" role="form">
  <div class="form-group">
    <label>Password attuale:</label>
	<div class="row">
	<div class="col-xs-4">
		<input class="form-control" size="40" type="password" name="vecchiapassword" />
	</div>
	</div>
  </div>
  <div class="form-group">
    <label>Nuova password:</label>
	<div class="row">
	<div class="col-xs-4">
		<input class="form-control" size="40" type="password" name="nuovapassword1" />
	</div>
	</div>
  </div>
  <div class="form-group">
    <label>Ripeti nuova password:</label>
	<div class="row">
	<div class="col-xs-4">
		<input class="form-control" size="40" type="password" name="nuovapassword2" />
	</div>
	</div>
  </div>
  <button type="submit" class="btn btn-default">Modifica</button>
</form>
</div>
</div>