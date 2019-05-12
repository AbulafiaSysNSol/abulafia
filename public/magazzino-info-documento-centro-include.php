<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	
	$id = $_GET['id'];
	$m = new Magazzino();
	$c = new Calendario();
	$p = new Prodotto();
	$s = new Servizio();
	$documento = $m->getDocumentById($id);
			
?>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title"><strong><i class="fa fa-info fa-fw"></i> Info Documento</strong></h4>
		    </div>

			<div class="modal-body">
				<div class="panel panel-default">
													
					<div class="panel-body">

						<div class="row">

							<div class="col-sm-6">
				               	Documento N. 
				               	<label><?php echo ucwords($documento[0]); ?></label>
				               	del
				               	<label><?php echo $c->dataSlash($documento[1]); ?></label>
				           	</div>

					        <div class="col-sm-6">
					          	Riferimento:
					           	<label><?php echo strtoupper($documento[3]); ?></label>
					        	del:
					          	<label><?php echo $c->dataSlash($documento[5]); ?></label>
					        </div>
					        
				   		</div>

					    <br>

					    <div class="row">
						
					        <div class="col-sm-4">
					           Magazzino:<br>
					          	<label><?php echo $documento[2] . ' - ' . $s->getServizioById($documento[2]); ?></label>
					        </div>

					         <div class="col-sm-4">
					          	Causale:<br>
					          	<label><?php echo ucwords($documento[4]); ?></label>
					        </div>

					        <div class="col-sm-4">
					           	Note:<br>
					           	<label><?php echo ucwords($documento[6]); ?></label>
					       	</div>

					    </div>
					    <br>
					    <label><i class="fa fa-list-ul fa-fw"></i> Righe Documento:</label>
					    <table class="table table-condensed">
							<tr style="vertical-align: middle">
								<td><b>Cod.</b></td>
								<td><b>Descrizione</b></td>
								<td><b>Q.t&agrave;</b></td>
								<td><b>Nota</b></td>
								<td><b>Costo</b></td>
							</tr>
							<?php
							$res = $m->righeDocumento($id);
							$tot = 0;
							foreach($res as $val) {
								$prezzo = $p->getPrezzo($val['codice']) * $val['quantita'];
								$tot = $tot + $prezzo;
								?>
								<tr>
									<td style="vertical-align: middle"><?php echo $val['codice']; ?></td>
									<td style="vertical-align: middle"><?php echo strtoupper($val['descrizione']); ?></td>
									<td style="vertical-align: middle"><?php echo $val['quantita'] ?></td>
									<td style="vertical-align: middle"><?php echo $val[4]; ?></td>
									<td style="vertical-align: middle"><?php echo "&euro; " . number_format($prezzo, 2,",","."); ?></td>
								</tr>
							<?php
							}
							?>
							<tr>
								<td colspan = "4" style="vertical-align: middle; text-align: right;"><h4>Totale Documento: <b><?php echo "&euro; " . number_format($tot, 2,",","."); ?></b></h4></td>
							</tr>
						</table>

						<br>
						
						<center>
								<a class="btn btn-danger fancybox" data-fancybox-type="iframe" href="magazzino-documento-pdf.php?id=<?php echo $id; ?>"><i class="fa fa-fw fa-file-pdf-o"></i> Genera PDF</a>
						</center>

					</div>
				</div>

			</div>

		</div>
	</div>
</div>
<!--End Modal-->

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
  		window.location="?corpus=magazzino-documenti";
	})
</script>