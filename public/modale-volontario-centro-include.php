<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<!-- Modal -->
	<form action="aggiungi-volontario.php" method="POST" name="modalevolontario">
		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-fw"></i> Inserisci Dati Volontario:</h4>
					</div>
	      
					<div class="modal-body">
						
						<div class="form-group">
							<label class="col-sm-4 control-label">Nome:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" class="form-control input-sm" name="nome" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Cognome:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" class="form-control input-sm" name="cognome" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Cod. Fiscale:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" minlength="16" maxlength="16" class="form-control input-sm" name="codicefiscale" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Email:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="email" class="form-control input-sm" name="email" required>
								</div>
							</div>
						</div>
					
					<br><label>N.B. Tutti i campi sono obbligatori.</label>

					</div>
			
					<div class="modal-footer">
						<a href="?corpus=co-volontari"><button type="button" class="btn btn-danger"><i class="fa fa-times fa-fw"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-success"><i class="fa fa-user-plus fa-fw"></i> Inserisci Volontario</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
  		window.location="?corpus=co-volontari";
	})
</script>