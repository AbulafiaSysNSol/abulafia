<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php
	
	$id = $_GET['id'];
	$a = new Anagrafica();
	$c = new Calendario();
	$amb = new Ambulatorio();
	$info = $a->infoAssistito($id);
			
?>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-body">
				<div class="panel panel-default">
						
					<div class="panel-heading">
						<h3 class="panel-title"><strong><i class="fa fa-info fa-fw"></i> Info Assistito</strong></h3>
					</div>
								
					<div class="panel-body">

						<div class="row">
							<div class="col-sm-4">
				               	Nome:<br>
				               	<label><?php echo ucwords($info['nome']); ?></label>
				           	</div>

					        <div class="col-sm-4">
					          	Cognome:<br>
					          	<label><?php echo ucwords($info['cognome']); ?></label>
					        </div>

					        <div class="col-sm-4">
					          	Codice Fiscale:<br>
					           	<label><?php echo strtoupper($info['codicefiscale']); ?></label>
					        </div>
				   		</div>
					    <br>
					    <div class="row">
							<div class="col-sm-4">
					          	Luogo di nascita:<br>
					          	<label><?php echo ucwords($info['luogonascita']); ?></label>
					       	</div>

					        <div class="col-sm-4">
					          	Data di Nascita:<br>
					          	<label><?php echo $c->dataSlash($info['datanascita']); ?></label>
					        </div>

					        <div class="col-sm-4">
					           	Cittadinanza:<br>
					           	<label>
					      		<?php 
					           		if($info['cittadinanza'] == "it") { echo 'Italiana'; }
					          		if($info['cittadinanza'] == "ee") { echo 'Estera'; } 
					      		?>
					          	</label>
					        </div>
					    </div>
					    <br>
					    <div class="row">
							<div class="col-sm-4">
					           	Residente in:<br>
					           	<label><?php echo ucwords($info['residenzacitta']); ?></label>
					       	</div>

					        <div class="col-sm-4">
					          	Via/Viale/Piazza:<br>
						       	<label><?php echo ucwords($info['residenzavia']); ?></label>
					        </div>

					        <div class="col-sm-4">
					           	Numero Civico:<br>
					           	<label><?php echo ucwords($info['residenzanumero']); ?></label>
					        </div>
					    </div>
											
					</div>
				</div>

				<div class="panel panel-default">
							
					<div class="panel-heading">
						<h3 class="panel-title"><strong><i class="fa fa-heartbeat fa-fw"></i> Accessi in Ambulatorio</strong></h3>
					</div>
							
					<div class="panel-body">
						<?php 
						if($amb->countAccessi($id) == 0) {
							?>	
							<div>
								<center><div class="alert alert-warning"><i class="fa fa-info-circle"></i> Nessun accesso registrato per l'anagrafica selezionata.</div></center>
							</div>
							<?php
						}
						else {
							?>
							<div class="row">
								<div class="col-sm-12">
				                    <table class="table table-condensed">
										<tr>
											<td><b>Data</b></td>
											<td><b>Ora</b></td>
											<td><b>Anamnesi</b></td>
											<td><b>Diagnosi</b></td>
											<td><b>Terapia</b></td>
											<td align="center"><b>Opzioni</b></td>
										</tr>
										<?php
										$visita = $amb->getAccessi($id);
										foreach ($visita as $val) {
											echo '<tr>';
											echo '<td>' . $c->dataSlash($val['data']) . '</td>';
											echo '<td>' . $c->oraOM($val['ora']) . '</td>';
											echo '<td>' . $val['anamnesi'] . '</td>';
											echo '<td>' . $val['diagnosi'] . '</td>';
											echo '<td>' . $val['terapia'] . '</td>';
											?> <td align="center">
													<a class="btn btn-primary btn-xs btn-info" href="login0.php?corpus=cert-genera-certificato&idanagrafica=<?php echo $id; ?>&idvisita=<?php echo $val['id']; ?>" data-toggle="modal">
													<i class="fa fa-file-pdf-o fa-fw"></i> Certificato</a>
												</td> <?php
											echo '</tr>'; 
										}
										?>
									</table>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<a href="?corpus=cert-search-anag"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Chiudi</button></a>
			</div>

		</div>
	</div>
</div>
<!--End Modal-->

<script type="text/javascript">
    $('#myModal').on('hidden.bs.modal', function (e) {
  		window.location="?corpus=cert-search-anag";
	})
</script>