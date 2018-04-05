<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	$id = $_GET['id'];
	$a = new Anagrafica();
	$c = new Calendario();
	if ($id != $_SESSION['loginid']) {
		?>
		<script language="javascript">
			window.location="logout.php";
		</script>
		<?php
	}
?>

<!-- Modal -->
	<form action="aggiorna-profilo.php?id=<?php echo $id; ?>" method="POST" name="modaleprofilo">
		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Aggiorna il tuo account di Abulafia Web:</h4>
					</div>
	      
					<div class="modal-body">
						
						<label>Inserisci le informazioni mancanti per continuare ad utilizzare Abulafia Web:</label>

						<br><br>

						<div class="form-group">
							<label class="col-sm-4 control-label">Nome:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" class="form-control input-sm" name="nome" value="<?php echo $a->getNome($id); ?>" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Cognome:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" class="form-control input-sm" name="cognome" value="<?php echo $a->getCognome($id); ?>" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Data di Nascita:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" placeholder="gg/mm/aaaa" class="form-control input-sm" name="data" value="<?php echo $c->dataSlash($a->getData($id)); ?>" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Cod. Fiscale:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="text" minlength="16" maxlength="16" class="form-control input-sm" name="codicefiscale" value="<?php echo $a->getCodiceFiscale($id); ?>" required>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Email Principale:</label>
							<div class="row">
								<div class="col-sm-5">
									<input type="email" class="form-control input-sm" name="email" value="<?php echo $a->getEmail($id); ?>" required>
								</div>
							</div>
						</div>
					
					<br><label>N.B. Tutti i campi sono obbligatori.</label>

					</div>
			
					<div class="modal-footer">
						<a href="logout.php"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Aggiorna Informazioni</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
  		window.location="logout.php";
	})
</script>