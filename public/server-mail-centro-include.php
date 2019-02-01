<?php
	$e = new Mail();
	$imp = $e->getMail();
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-envelope-o"></i> <b>Impostazioni Email:</b></h3>
	</div>
	
	<div class="panel-body">

		<form action="login0.php?corpus=server-mail2" method="post" role="form">

			<div class="row">
				<div class="col-sm-4">
					<center><h3><i class="fa fa-fw fa-user-circle-o"></i> Impostazioni Account:</h3><br></center>

					  <div class="form-group">
						<label><i class="fa fa-fw fa-at"></i> Indirizzo Email:</label>
						<div class="row">
							<div class="col-sm-11">
								<input class="form-control input-sm" type="text" value="<?php echo $imp[0]; ?>" name="username">
							</div>
						</div>
					  </div>
					  
					  <div class="form-group">
						<label><i class="fa fa-fw fa-key"></i> Password:</label>
						<div class="row">
							<div class="col-sm-11">
								<input class="form-control input-sm" type="password" value="<?php echo base64_decode($imp[1]); ?>" name="password">
							</div>
						</div>
					  </div>
					  
					  <div class="form-group">
						<label><i class="fa fa-fw fa-at"></i> Reply To (facoltativo):</label>
						<div class="row">
							<div class="col-sm-11">
								<input class="form-control input-sm" type="text" value="<?php echo $imp[5]; ?>" name="replyto" />
							</div>
						</div>
					  </div>
				</div>

				<div class="col-sm-4">
					<center><h3><i class="fa fa-fw fa-paper-plane-o"></i> Impostazioni Server:</h3><br></center>

					  <div class="form-group">
						<label><i class="fa fa-fw fa-cog"></i> Server SMTP:</label>
						<div class="row">
							<div class="col-sm-11">
								<input class="form-control input-sm" type="text" value="<?php echo $imp[2]; ?>" name="smtp">
							</div>
						</div>
					  </div>
					  
					  <div class="form-group">
						<label><i class="fa fa-fw fa-exchange"></i> Porta:</label>
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control input-sm" type="text" value="<?php echo $imp[3]; ?>" name="porta">
							</div>
						</div>
					  </div>
					  
					   <div class="form-group">
						<label><i class="fa fa-fw fa-envelope"></i> Protocollo SMTP:</label>
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control input-sm" type="text" value="<?php echo $imp[4]; ?>" name="protocollo">
							</div>
						</div>
					  </div>
				</div>

				<div class="col-sm-4">
					<center><h3><i class="fa fa-fw fa-file-text-o"></i> Header e Firma:</h3><br></center>

					<div class="form-group">
						<label><i class="fa fa-fw fa-header"></i> Intestazione Email:</label>
						<div class="row">
							<div class="col-sm-11">
								<textarea rows="3" class="form-control input-sm" name="headermail"><?php echo stripslashes(strip_tags($imp[6])); ?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label><i class="fa fa-fw fa-pencil"></i> Firma:</label>
						<div class="row">
							<div class="col-sm-11">
								<textarea rows="3" class="form-control input-sm" name="footermail"><?php echo stripslashes(strip_tags($imp[7])); ?></textarea>
							</div>
						</div>
					</div>			
				</div>
			</div>

			 <br><center><button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check"></i> Salva Impostazioni</button></center>
		
		</form>
	</div>
</div>