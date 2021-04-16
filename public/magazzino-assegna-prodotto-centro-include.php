<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	$id = $_GET['id'];
	$s = new Servizio();
	$m = new Magazzino();
?>

<!-- Modal -->
	<form action="magazzino-assegna-prodotto2.php?id=<?php echo $id; ?>" method="POST">
		<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<a href="?corpus=magazzino-prodotti"><button type="button" class="close">&times;</button></a>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-arrow-right"></i> Assegna Prodotto a Magazzino/Servizio - Codice Prodotto <?php echo $id; ?></h4>
					</div>
	      
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-7">
									<label>Magazzino/Servizio:</label>
									<select class="form-control input-sm" name="magazzino">
										<?php
											$res = $s->ricercaServizio('');
											foreach($res as $val) {
												?>
												<option value="<?php echo $val['codice']; ?>"><?php echo strtoupper($val['descrizione']); ?></option>
												<?php
											}
										?>
									</select>
								</div>

								<div class="col-sm-5">
									<label>Settore:</label>
									<select class="form-control input-sm" name="settore">
										<?php
											$settori = $m->getSettori();
											foreach($settori as $val) {
												?>
												<option value="<?php echo $val['id']; ?>"><?php echo $val['id'] . ' - ' . $val['descrizione']; ?></option>
												<?php
											}
										?>
									</select>
								</div>
							</div>
							<br>
							
							<div class="row">
								<div class="col-sm-3">
									<label id="lblcognome">Scorta Minima:</label>
									<input type="text" value="0" class="form-control input-sm" name="scortaminima" required>
								</div>
							
								<div class="col-sm-2">
									<label id="lblnome">Riordino:</label>
									<input type="text" value="0" class="form-control input-sm" name="riordino" required>
								</div>
							
								<div class="col-sm-4">
									<label id="lblcognome">Giacenza Iniziale:</label>
									<input type="text" value="0" class="form-control input-sm" name="giacenzainiziale" required>
								</div>
							
								<div class="col-sm-2">
									<label id="lblcognome">Confezionamento:</label>
									<input type="text" value="0" class="form-control input-sm" name="confezionamento" required>
								</div>
							</div>
						</div>
					</div>
			
					<div class="modal-footer">
						<a href="?corpus=magazzino-prodotti"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Assegna</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
  		window.location="?corpus=magazzino-prodotti";
	})
</script>