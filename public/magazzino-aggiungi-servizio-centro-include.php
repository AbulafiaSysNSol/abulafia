<div class="row">
	
	<div class="col-sm-12">
		<div class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title"><strong><i class="fa fa-plus-circle"></i> Aggiungi Servizio</strong></h3>
				</div>
				
				<div class="panel-body">
					
					<?php
					 if( isset($_GET['insert']) && $_GET['insert'] == "ok") {
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-success"><i class="fa fa-check"></i> Servizio registrato <b>correttamente!</b></div>
						</div>
					</div>
					<?php
					}
					?>
				
					<form class="form-horizontal" role="form" name="modulo" method="post" action="magazzino-aggiungi-servizio2.php">

						<div class="form-group">
							<label class="col-sm-3 control-label">Codice Servizio*:</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="text" class="form-control input-sm" name="codice" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Descrizione Servizio:</label>
							<div class="row">
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" name="descrizione" required>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Indirizzo:</label>
							<div class="row">
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" name="indirizzo">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Città:</label>
							<div class="row">
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm" name="citta">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">CAP:</label>
							<div class="row">
								<div class="col-sm-2">
									<input type="text" class="form-control input-sm" name="cap">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Telefono:</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="text" class="form-control input-sm" name="telefono">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Email:</label>
							<div class="row">
								<div class="col-sm-3">
									<input type="text" class="form-control input-sm" name="email">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Magazzino:</label>
							<div class="row">
								<div class="col-sm-3">
									<input style="vertical-align: middle" type="checkbox" name="magazzino" value="1">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-5 control-label">*N.B.: il codice del servizio deve essere univoco.</label>
						</div>
						
						<br>
						<div class="row">
							<div class="col-sm-2 col-sm-offset-3">
								<button class="btn btn-lg btn-success" type="submit"><span class="glyphicon glyphicon-check"></span> Inserisci</button>
							</div>
						</div>
					
					</form>
				
				</div>
		</div>
	</div>
	
</div>