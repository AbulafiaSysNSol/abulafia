<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-plus"></i> Nuovo Documento di Carico</strong></h3>
			</div>
			
			<div class="panel-body">
				
				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#testata">Testata</a></li>
					<li><a data-toggle="tab" href="#righe">Righe</a></li>
				</ul>

				<div class="tab-content">
				  	<div id="testata" class="tab-pane fade in active">
				    	<br>   	
				    	<form class="form-horizontal" role="form" name="testata" method="post" >						
							<div class="form-group">
								<label class="col-sm-2 control-label">Documento num. </label>
								<div class="row">
									<div class="col-sm-2">
										<input type="text" class="form-control input-sm" name="numero" disabled>
									</div>
									<label class="col-sm-1 control-label"> del </label>
									<div class="col-sm-2">
										<input type="text" class="form-control input-sm datepickerProt" name="data" value="<?php echo date('d/m/Y'); ?>">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Riferimento </label>
								<div class="row">
									<div class="col-sm-2">
										<input type="text" class="form-control input-sm" name="riferimento">
									</div>
									<label class="col-sm-1 control-label"> del </label>
									<div class="col-sm-2">
										<input type="text" class="form-control input-sm datepickerProt" name="datariferimento" value="<?php echo date('d/m/Y'); ?>">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Magazzino/Servizio </label>
								<div class="row">
									<div class="col-sm-5">
										<input type="text" class="form-control input-sm" name="magazzino">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Causale</label>
								<div class="row">
									<div class="col-sm-4">
										
										<select class="form-control input-sm" name="causale">
											<?php
												/*$res = $s->ricercaServizio('');
												foreach($res as $val) {
													?>
													<option value="<?php echo $val['codice']; ?>"><?php echo strtoupper($val['descrizione']); ?></option>
													<?php
												}*/
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Note </label>
								<div class="row">
									<div class="col-sm-5">
										<input type="text" class="form-control input-sm" name="note">
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-2 col-sm-offset-2">
									<button class="btn btn-primary" onClick="Controllo()"><i class="fa fa-save"></i> Salva</button>
								</div>
							</div>
						</form>


				  	</div>

				  	<div id="righe" class="tab-pane fade">
				    	<br>
				    	
				  	</div>
				</div>
			</div>
		</div>
	</div>
	
</div>