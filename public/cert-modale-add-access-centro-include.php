<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	$id = $_GET['id'];
	$a = new Anagrafica();
	$c = new Calendario();
	$info = $a->infoAssistito($id);
?>

<!-- Modal -->
	<form action="cert-add-access.php?" method="POST" name="modaleaccesso">
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">
							<i class="fa fa-medkit"></i> Inserisci Visita Ambulatoriale: 
							<b><?php echo ucwords($info['nome']) . ' ' . ucwords($info['cognome']) 
							 . ' (' . ucwords($info['luogonascita']) .', ' . $c->dataSlash($info['datanascita']) .')'; ?></b>
						</h4>
					</div>
	      
					<div class="modal-body">
						
						<h4>Medico: <label><?php echo $a->getNome($_SESSION['loginid']) . ' ' . $a->getCognome($_SESSION['loginid']); ?></label></h4>
						
						<hr>

						<input type="hidden" name="idanagrafica" value="<?php echo $id; ?>">
						<input type="hidden" name="idmedico" value="<?php echo $_SESSION['loginid']; ?>">

		    			<div class="row form-inline">				
							<div class="col-sm-4 form-inline">
								<label>Data: </label>
								<input type="text" class="form-control input-sm datepickerProt" name="data" placeholder="formato gg/mm/aaaa" required>
							</div>

							<div class="col-sm-4 form-inline">
								<label>Ora: </label>
								<input type="text" class="form-control input-sm" name="ora" placeholder="formato hh:mm" required>
							</div>
							<div class="col-sm-4 form-inline">
								<label>Dipendente Aeroportuale: </label>
								<input type="checkbox" class="form-control input-sm" name="dipendente">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6">
								<label>Anamnesi:</label>
								<textarea class="form-control" rows="5" name="anamnesi" required></textarea>
							</div>
							<div class="col-sm-6">
								<label>Sospetto Diagnostico:</label>
								<textarea class="form-control" rows="5" name="diagnosi" required></textarea>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6">
								<label>Terapia Effettuata:</label>
								<textarea class="form-control" rows="4" name="terapia"></textarea>
							</div>
							<div class="col-sm-6">
								<label>Note:</label>
								<textarea class="form-control" rows="4" name="note"></textarea>
							</div>
						</div>
						<br>
						<div class="row form-inline">				
							<div class="col-sm-4 form-inline">
								<label>Intervento 118: </label>
								<input type="checkbox" class="form-control input-sm" name="intervento">
							</div>
						</div>

					</div>
			
					<div class="modal-footer">
						<a href="?corpus=cert-search-anag"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Inserisci</button>
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