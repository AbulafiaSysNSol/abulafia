<?php
	$id = $_GET['id'];
	$s = new Servizio();
	$info = $s->getInfo($id);
?>

<div class="row">
	
	<div class="col-sm-12">
		<div class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title"><strong><i class="fa fa-edit"></i> Modifica Servizio - <?php echo $info[0]['codice'] . ' ' . $info[0]['descrizione']; ?> </strong></h3>
				</div>
				
				<div class="panel-body">
					
					<?php
					 if( isset($_GET['edit']) && $_GET['edit'] == "ok") {
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-success"><i class="fa fa-check"></i> Servizio modificato <b>correttamente!</b></div>
						</div>
					</div>
					<?php
					}
					?>
				
					<form class="form-horizontal" role="form" name="modulo" method="post" action="magazzino-modifica-servizio2.php?id=<?php echo $info[0]['codice'];?>">

						<div class="form-group">
							<label class="col-sm-3 control-label">Codice Servizio*:</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="text" class="form-control input-sm" name="codice" value="<?php echo $info[0]['codice']; ?>" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Descrizione Servizio:</label>
							<div class="row">
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" name="descrizione" value="<?php echo $info[0]['descrizione']; ?>" required>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Indirizzo:</label>
							<div class="row">
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" name="indirizzo" value="<?php echo $info[0]['indirizzo']; ?>">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Citt&agrave;:</label>
							<div class="row">
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="citta" value="<?php echo $info[0]['citta']; ?>">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">CAP:</label>
							<div class="row">
								<div class="col-sm-2">
									<input type="text" class="form-control input-sm" name="cap" value="<?php echo $info[0]['cap']; ?>">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Telefono:</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="text" class="form-control input-sm" name="telefono" value="<?php echo $info[0]['telefono']; ?>">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Email:</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="text" class="form-control input-sm" name="email" value="<?php echo $info[0]['telefono']; ?>">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Magazzino:</label>
							<div class="row">
								<div class="col-sm-3">
									<input style="vertical-align: middle" type="checkbox" name="magazzino" value="1" <?php if($info[0]['magazzino']) { echo 'checked'; } ?>>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-5 control-label">*N.B.: il codice del servizio deve essere univoco.</label>
						</div>
						
						<br>
						<div class="row">
							<div class="col-sm-2 col-sm-offset-3">
								<button class="btn btn-lg btn-warning" type="submit"><i class="fa fa-edit"></i> Modifica</button>
							</div>
						</div>
					
					</form>
				
				</div>
		</div>
	</div>
	
</div>