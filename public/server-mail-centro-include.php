<?php
	$e = new Mail();
	$imp = $e->getMail();
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-cogs"></i> <b>Impostazioni Server SMTP</b></h3>
	</div>
	
	<div class="panel-body">

		<form action="login0.php?corpus=server-mail2" method="post" role="form">
			  <div class="form-group">
				<label><i class="fa fa-at"></i> Indirizzo Email:</label>
				<div class="row">
					<div class="col-sm-4">
						<input class="form-control input-sm" type="text" value="<?php echo $imp[0]; ?>" name="username" required>
					</div>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label><i class="fa fa-key"></i> Password:</label>
				<div class="row">
					<div class="col-sm-4">
						<input class="form-control input-sm" type="password" value="<?php echo base64_decode($imp[1]); ?>" name="password" required>
					</div>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label><i class="fa fa-at"></i> Reply To (facoltativo):</label>
				<div class="row">
					<div class="col-sm-4">
						<input class="form-control input-sm" type="text" value="<?php echo $imp[5]; ?>" name="replyto" />
					</div>
				</div>
			  </div>

			  <div class="form-group">
				<label><i class="fa fa-cog"></i> Server SMTP:</label>
				<div class="row">
					<div class="col-sm-4">
						<input class="form-control input-sm" type="text" value="<?php echo $imp[2]; ?>" name="smtp" required>
					</div>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label><i class="fa fa-exchange"></i> Porta:</label>
				<div class="row">
					<div class="col-sm-2">
						<input class="form-control input-sm" type="text" value="<?php echo $imp[3]; ?>" name="porta" required>
					</div>
				</div>
			  </div>
			  
			    <div class="form-group">
				<label><i class="fa fa-envelope"></i> Protocollo:</label>
				<div class="row">
					<div class="col-sm-2">
						<input class="form-control input-sm" type="text" value="<?php echo $imp[4]; ?>" name="protocollo" required>
					</div>
				</div>
			  </div>
			  <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check"></i> Salva Impostazioni</button>
		</form>
	</div>
</div>