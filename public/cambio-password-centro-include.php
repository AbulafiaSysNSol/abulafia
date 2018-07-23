<?php $loginid=$_SESSION['loginid'];?>	

<div class="panel panel-default">
	<div class="panel-heading">
    	<h3 class="panel-title" bgcolor="red"><b>Cambia Password</b></h3>
  	</div>

  	<div class="panel-body">
    	<?php
    	if (isset($_GET['pass']) && $_GET['pass'] == "ok") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-success" align="center"><b><i class="fa fa-check"></i> Password modifcata corretamente!</b></div>
				</div>
			</div>
			<?php
   		}

    	if (isset($_GET['pass']) && $_GET['pass'] == "old") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" align="center"><b><i class="fa fa-exclamation-triangle"></i> La password attuale non è corretta!</b></div>
				</div>
			</div>
			<?php
   		}

    	if (isset($_GET['pass']) && $_GET['pass'] == "nomatch") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger" align="center"><b><i class="fa fa-exclamation-triangle"></i> Le due password non coincidono!</b></div>
				</div>
			</div>
			<?php
   		}
   		
   		?>
 
	 <center>
	 	<div class="alert alert-info"><i class="fa fa-lock"></i> Ti consigliamo di inserire una password che contenga <b>almeno 6 caratteri</b> e che sia composta da <b>lettere e numeri.</b></div>
	    <form action="login0.php?corpus=cambio-password2" method="post" role="form">
	  		<div class="form-group">
	    		<label><i class="fa fa-key"></i> Password attuale:</label>
				<div class="row">
					<div class="col-sm-2 col-sm-offset-5">
						<input class="form-control input-sm" type="password" name="vecchiapassword" required/>
					</div>
				</div>
	  		</div>
	  
	  		<div class="form-group">
	    		<label><i class="fa fa-key"></i> Nuova password:</label>
				<div class="row">
					<div class="col-sm-2 col-sm-offset-5">
						<input class="form-control input-sm" pattern=".{6,}" title="Minimo 6 caratteri" type="password" name="nuovapassword1" required/>
					</div>
				</div>
	  		</div>
	  
	  		<div class="form-group">
	    		<label><i class="fa fa-key"></i> Ripeti nuova password:</label>
				<div class="row">
					<div class="col-sm-2 col-sm-offset-5">
						<input class="form-control input-sm" pattern=".{6,}" title="Minimo 6 caratteri" type="password" name="nuovapassword2" required/>
					</div>
				</div>
	  		</div>
	  		
	  		<br><button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Cambia Password</button>
		</form>
	   </center>
 	</div>
</div>