<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	$id = $_GET['id'];
	$s = new Servizio();
?>

<!-- Modal -->
	<form action="magazzino-assegna-prodotto2.php?id=<?php echo $id; ?>" method="POST">
		<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-arrow-right"></i> Assegna Prodotto a Magazzino/Servizio - Codice Prodotto <?php echo $id; ?></h4>
					</div>
	      
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-7">
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

								<div class="col-xs-5">
									<label>Settore:</label>
									<select class="form-control input-sm" name="settore">
										<option value="0">0 - SETTORE 0</option>
										<option value="1">1 - FARMACI</option>
										<option value="2">2 - SANITARI</option>
										<option value="3">3 - DISPOSITIVI MEDICI</option>
									</select>
								</div>
							</div>
							<br>
							
							<div class="row">
								<div class="col-xs-3">
									<label id="lblcognome">Scorta Minima:</label>
									<input type="text" class="form-control input-sm" name="scortaminima">
								</div>
							
								<div class="col-xs-2">
									<label id="lblnome">Riordino:</label>
									<input type="text" class="form-control input-sm" name="riordino">
								</div>
							
								<div class="col-xs-4">
									<label id="lblcognome">Giacenza Iniziale:</label>
									<input type="text" class="form-control input-sm" name="giacenzainiziale">
								</div>
							
								<div class="col-xs-2">
									<label id="lblcognome">Confezionamento:</label>
									<input type="text" class="form-control input-sm" name="confezionamento">
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