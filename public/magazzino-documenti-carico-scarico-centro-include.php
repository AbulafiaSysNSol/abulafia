<?php
	$tipologia = $_GET['tipologia'];
?>

<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-plus"></i> Nuovo Documento di <?php echo strtoupper($tipologia); ?></strong></h3>
			</div>
			
			<div class="panel-body">
				    	<form class="form-horizontal" role="form" name="testata" method="post" action="magazzino-documenti-carico-scarico2.php?tipologia=<?php echo $tipologia; ?>">						
							<div class="form-group">
								<label class="col-sm-2 control-label">Documento num. </label>
								<div class="row">
									<div class="col-sm-2">
										<input type="text" class="form-control input-sm" name="numero" disabled>
									</div>
									<label class="col-sm-1 control-label"> del </label>
									<div class="col-sm-2">
										<input type="text" class="form-control input-sm datepickerProt" name="datadocumento" value="<?php echo date('d/m/Y'); ?>">
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
										<select class="form-control input-sm" name="magazzino">
											<?php
												$s = new Servizio();
												$res = $s->ricercaServizio('');
												foreach($res as $val) {
													?>
													<option value="<?php echo $val['codice']; ?>"><?php echo strtoupper($val['codice'] . ' - ' . $val['descrizione']); ?></option>
													<?php
												}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Causale</label>
								<div class="row">
									<div class="col-sm-2">
										<select class="form-control input-sm" name="causale">
											<?php
											if ($tipologia == 'carico') {
												?>
												<option value="acquisto">Acquisto</option>
												<option value="rettifica +">Rettifica Inventario +</option>
												<option value="omaggio">Omaggio</option>
												<option value="prestito">Prestito</option>
												<option value="restituzione magazizno">Restituzione a Magazzino</option>
												<?php
											}
											else {
												?>
												<option value="distribuzione">Distribuzione</option>
												<option value="rettifica -">Rettifica Inventario -</option>
												<option value="ritiro">Ritiro dal Commercio</option>
												<option value="scaduti">Dispositivi Alterati o Scaduti</option>
												<option value="reso">Reso</option>
												<?php
											}
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
									<button class="btn btn-primary" ><i class="fa fa-save"></i> Salva e inserisci prodotti <i class="fa fa-arrow-right"></i></button>
								</div>
							</div>
						</form>

			</div>
		</div>
	</div>
	
</div>