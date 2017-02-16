<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	$id = $_GET['id'];
	$s = new Servizio();
	$m = new Magazzino();
	$p = new Prodotto();
	$info = $m->getDepositoById($id);
?>

<!-- Modal -->
	<form action="magazzino-modifica-deposito2.php?id=<?php echo $id; ?>&magazzino=<?php echo $info['codicemagazzino']; ?>&prodotto=<?php echo $info['idprodotto']; ?>" method="POST">
		<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<a href="?corpus=magazzino-depositi"><button type="button" class="close">&times;</button></a>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modifica Deposito:</h4>
						<br>
						<center>
							<h5>
								<b><?php echo $info['codicemagazzino']; ?> - <?php echo $s->getServizioById($info['codicemagazzino']); ?> / 
								<?php echo $info['idprodotto']; ?> - <?php echo strtoupper($p->getProdottoById($info['idprodotto'])); ?></b>
							</h5>
						</center>
					</div>
	      
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								
								<div class="col-sm-7">
									<label>Settore:</label>
									<select class="form-control input-sm" name="settore">
										<option value="<?php echo $info['settore']; ?>"><?php echo $info['settore'] . ' - ' . $m->getSettoreById($info['settore']); ?></option>
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

								<div class="col-sm-5">
									<label>Giacenza Iniziale:</label>
									<input type="text" value="<?php echo $info['giacenzainiziale']; ?>" class="form-control input-sm" name="giacenzainiziale" disabled>
								</div>

							</div>
							<br>
							
							<div class="row">
							
								<div class="col-sm-4">
									<label>Scorta Minima:</label>
									<input type="text" value="<?php echo $info['scortaminima']; ?>" class="form-control input-sm" name="scortaminima">
								</div>
							
								<div class="col-sm-4">
									<label>Riordino:</label>
									<input type="text" value="<?php echo $info['puntoriordino']; ?>" class="form-control input-sm" name="riordino">
								</div>
							
								<div class="col-sm-4">
									<label>Confezionamento:</label>
									<input type="text" value="<?php echo $info['confezionamento']; ?>" class="form-control input-sm" name="confezionamento">
								</div>
							
							</div>
						</div>
					</div>
			
					<div class="modal-footer">
						<a href="?corpus=magazzino-depositi"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> Modifica</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->