<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b>Impostazioni Server SMTP</b></h3>
	</div>
	
	<div class="panel-body">

		<form action="login0.php?corpus=server-mail2" method="post" role="form">
			  <div class="form-group">
				<label><i class="fa fa-envelope-o"></i> Indirizzo Email:</label>
				<div class="row">
					<div class="col-xs-4">
						<input class="form-control input-sm" type="text" name="username" />
					</div>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label><i class="fa fa-key"></i> Password:</label>
				<div class="row">
					<div class="col-xs-4">
						<input class="form-control input-sm" type="password" name="password" />
					</div>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label><i class="fa fa-key"></i> Server SMTP:</label>
				<div class="row">
					<div class="col-xs-4">
						<input class="form-control input-sm" type="smtp" name="smtp" />
					</div>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label><i class="fa fa-key"></i> Porta:</label>
				<div class="row">
					<div class="col-xs-1">
						<input class="form-control input-sm" type="text" name="porta" />
					</div>
				</div>
			  </div>
			  
			    <div class="form-group">
				<label><i class="fa fa-key"></i> Protocollo:</label>
				<div class="row">
					<div class="col-xs-1">
						<input class="form-control input-sm" type="text" name="protocollo" />
					</div>
				</div>
			  </div>
			  <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check"></i> Salva Impostazioni</button>
		</form>
	</div>
</div>