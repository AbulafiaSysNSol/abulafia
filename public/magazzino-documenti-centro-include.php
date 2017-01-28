<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-file-text-o"></i> Documenti di Magazzino</strong></h3>
			</div>
			
			<div class="panel-body">

				<div align="left">
					<a href="?corpus=magazzino-documenti-carico-scarico&tipologia=carico"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Carico</button></a>
					<a href="?corpus=magazzino-documenti-carico-scarico&tipologia=scarico"><button type="button" class="btn btn-danger"><i class="fa fa-minus"></i> Scarico</button></a>
					<a href="#"><button type="button" class="btn btn-info"><i class="fa fa-exchange"></i> Trasferimento</button></a>
					<a href="#"><button type="button" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Reso</button></a>
					<a href="#"><button type="button" class="btn btn-warning"><i class="fa fa-search"></i> Ricerca</button></a>
				</div>
				<br><br>
				
				<label>Ultimi documenti emessi:</label><br><br>
				<table class="table table-bordered" width="100%">
					<tr>
						<td>Num. Doc.</td><td>Data</td><td>Magazzino</td><td>Causale</td><td>Opzioni</td>	
					</tr>

					<?php
						$contatorelinee = 0;
						$a = new Anagrafica();
						$admin = $a->isAdmin($_SESSION['loginid']);
						$m = new Magazzino();
						$s = new Servizio();
						$c = new Calendario();
						$res = $m->getDocument(20);
						foreach($res as $val) {
							if ( $val['tipologia'] == 'carico' ) { 
								$colorelinee = '#BEFFD3'; 
							}
							else { 
								$colorelinee = '#FAA9A9'; 
							}
							?>
							<tr bgcolor= <?php echo $colorelinee;?> >
								<td style="vertical-align: middle"><?php echo $val['id']; ?></td>
								<td style="vertical-align: middle"><?php echo $c->dataSlash($val['datadocumento']); ?></td>
								<td style="vertical-align: middle"><?php echo $val['magazzino'] . ' - ' . $s->getServizioById($val['magazzino']); ?></td>
								<td style="vertical-align: middle" align="center"><?php echo strtoupper($val['causale']); ?></td>
								<td align="center" nowrap style="vertical-align: middle">
									<div class="btn-group btn-group-sm" role="group">
										<a class="btn btn-info" href=""><i class="fa fa-info fa-fw"></i></a>
										<a class="btn btn-warning" href="?corpus=magazzino-documenti-carico-scarico-prodotti&id=<?php echo $val['id']; ?>&tipologia=<?php echo $val['tipologia']; ?>"><i class="fa fa-pencil fa-fw"></i></a>
										<?php if($admin) { ?>	
											<a class="btn btn-danger" href=""><i class="fa fa-trash fa-fw"></i></a>
										<?php } ?>
										<!--<a class="btn btn-primary" href=""><i class="fa fa-envelope-o fa-fw"></i></a>-->
										<!--<a class="btn btn-danger" href=""><i class="fa fa-file-pdf-o fa-fw"></i></a>-->
									</div>
								</td>		
							</tr>
						<?php
						}
					?>		
				</table>		

			</div>
		</div>
	</div>
	
</div>