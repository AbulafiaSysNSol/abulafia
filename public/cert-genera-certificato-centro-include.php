<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	$idanagrafica = $_GET['idanagrafica'];
	$idvisita = $_GET['idvisita'];
	$a = new Anagrafica();
	$c = new Calendario();
	$v = new Ambulatorio();
	$info = $a->infoAssistito($idanagrafica);
	$visita = $v->getVisita($idvisita);
?>

<!-- Modal -->
	<form action="cert-new-certificato.php" method="POST" name="modalecertificato">
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-file-pdf-o fa-fw"></i> Genera Certificato Medico: 
							<b><?php echo ucwords($info['nome']) . ' ' . ucwords($info['cognome']) 
							 . ' (' . ucwords($info['luogonascita']) .', ' . $c->dataSlash($info['datanascita']) .')'; ?></b>
						</h4>
					</div>
	      
					<div class="modal-body">
						
						<div class="row">
							<h4>
							<div class="col-sm-4">
								Medico: <label><?php echo $a->getNome($_SESSION['loginid']) . ' ' . $a->getCognome($_SESSION['loginid']); ?></label>
							</div>
							<div class="col-sm-4">
								Data Visita: <label><?php echo $c->dataSlash($visita['data']); ?></label>
							</div>
							<div class="col-sm-4">
								Ora Visita: <label><?php echo $c->oraOM($visita['ora']); ?></label>
							</div>
							</h4>
						</div>
						
						<hr>

						<input type="hidden" name="idanagrafica" value="<?php echo $idanagrafica; ?>">
						<input type="hidden" name="idvisita" value="<?php echo $idvisita; ?>">

		    			<div class="row form-inline">				
							<div class="col-sm-12 form-inline">
								<label>Modello Certificato: &nbsp</label>
								<select class="form-control input-sm" name="tipocertificato">
									<option value="generico"> Certificato Generico</option>
									<OPTION value="ps"> Invio Pronto Soccorso</option>	
								</select>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6">
								<label>Anamnesi:</label>
								<textarea class="form-control" rows="3" disabled><?php echo strip_tags($visita['anamnesi']); ?></textarea>
								<div class="row">
									<div class="col-sm-12 form-inline">
										<input type="checkbox" class="form-control input-sm" name="incanamnesi">
										Includi nel certificato.
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<label>Sospetto Diagnostico:</label>
								<textarea class="form-control" rows="3" disabled><?php echo strip_tags($visita['diagnosi']); ?></textarea>
								<div class="row">
									<div class="col-sm-12 form-inline">
										<input type="checkbox" class="form-control input-sm" name="incdiagnosi">
										Includi nel certificato.
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6">
								<label>Terapia Effettuata:</label>
								<textarea class="form-control" rows="3" disabled><?php echo strip_tags($visita['terapia']); ?></textarea>
								<div class="row">
									<div class="col-sm-12 form-inline">
										<input type="checkbox" class="form-control input-sm" name="incterapia">
										Includi nel certificato.
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<label>Note:</label>
								<textarea class="form-control" rows="3" disabled><?php echo strip_tags($visita['note']); ?></textarea>
								<div class="row">
									<div class="col-sm-12 form-inline">
										<input type="checkbox" class="form-control input-sm" name="incnote">
										Includi nel certificato.
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-12">
								<label>Testo Libero:</label>
								<textarea class="form-control" rows="4" name="testocertificato"></textarea>
							</div>
						</div>

					</div>
			
					<div class="modal-footer">
						<a href="?corpus=cert-search-anag"><button type="button" class="btn btn-danger"><i class="fa fa-fw fa-times"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-info"><i class="fa fa-fw fa-file-text-o"></i> Anteprima Certificato</button></a>
						<button type="submit" class="btn btn-success"><i class="fa fa-fw fa-save"></i> Salva Certificato</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
  		window.location="?corpus=cert-search-anag";
	})
</script>