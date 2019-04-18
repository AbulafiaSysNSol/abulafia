<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-file-text-o fa-fw"></i> Documenti di Magazzino</strong></h3>
			</div>
			
			<div class="panel-body">

				<label><i class="fa fa-plus-circle fa-fw"></i> Crea Nuovo Documento:</label><br>
				<div align="left">
					<a href="?corpus=magazzino-documenti-carico-scarico&tipologia=carico"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus fa-fw"></i> Documento di Carico</button></a>
					<a href="?corpus=magazzino-documenti-carico-scarico&tipologia=scarico"><button type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus fa-fw"></i> Documento di Scarico</button></a>
					<!--<a href="#"><button type="button" class="btn btn-sm btn-info"><i class="fa fa-exchange"></i> Documento di Trasferimento</button></a>
					<a href="#"><button type="button" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Reso</button></a>
					<a href="#"><button type="button" class="btn btn-warning"><i class="fa fa-search"></i> Ricerca</button></a>-->
				</div>
				<br><br>
				
				<label><i class="fa fa-file-o fa-fw"></i> Documenti Emessi:</label><br>
				
				<script type="text/javascript" src="livesearch-ricerca-documenti.js" onLoad="showResult('','','','25')"></script>
				<form name="documenti" onSubmit="return false">
					<div class="row">
						<div class="col-sm-3">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-search fa-fw"></i></div><input placeholder="N. Documento" type="text" name="documento" class="form-control" onkeyup="showResult(this.value,magazzino.value,causale.value,risultati.value)">
							</div>
						</div>

						<div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-cube fa-fw"></i> Magazzino:</div>
								<select class="form-control" name="magazzino" onChange="showResult(documento.value,this.value,causale.value,risultati.value)">
									<option value="">Tutti i Magazzini</option>
									<?php
										$s = new Servizio();
										$res = $s->ricercaServizio('');
										foreach($res as $val)
										{
											?>
											<option value="<?php echo $val['codice']; ?>"><?php echo $val['descrizione']; ?></option>
											<?php
										}
									?>
								</select>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-bars fa-fw"></i> Causale:</div>
								<select class="form-control" name="causale" onChange="showResult(documento.value,magazzino.value,this.value,risultati.value)">
									<option value="">Tutte la causali</option>
									<option value="acquisto">Acquisto</option>
									<option value="rettifica+">Rettifica Inventario +</option>
									<option value="omaggio">Omaggio</option>
									<option value="prestito">Prestito</option>
									<option value="restituzione magazizno">Restituzione a Magazzino</option>
									<option value="distribuzione">Distribuzione</option>
									<option value="consumointerno">Consumo Interno</option>
									<option value="rettifica-">Rettifica Inventario -</option>
									<option value="ritiro">Ritiro dal Commercio</option>
									<option value="scaduti">Dispositivi Alterati o Scaduti</option>
									<option value="reso">Reso</option>
								</select>
							</div>
						</div>

						<div class="col-sm-2">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-list-ol fa-fw"></i> N. Ris.</div>
								<select class="form-control" name="risultati" onChange="showResult(documento.value,magazzino.value,causale.value,this.value)">
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
								</select>
							</div>
						</div>
					</div>
				</form>
				
				<br>
				<div id="livesearch">
					<!-- spazio riservato ai risultati live della ricerca -->
				</div>

			</div>
		</div>
	</div>
	
</div>