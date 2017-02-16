<?php
	$s = new Servizio();
?>

<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-suitcase"></i> Elenco Depositi</strong></h3>
			</div>
			
			<div class="panel-body">

				<?php
					 if( isset($_GET['insert']) && $_GET['insert'] == "ok") {
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-success"><i class="fa fa-check"></i> Prodotto assegnato <b>correttamente!</b></div>
						</div>
					</div>
					<?php
					}
				?>

				<?php
					 if( isset($_GET['edit']) && $_GET['edit'] == "ok") {
						$magazzino = $_GET['magazzino'];
						$prodotto = $_GET['prodotto'];
						$edit = true;
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-success"><i class="fa fa-check"></i> Deposito modificato <b>correttamente!</b></div>
						</div>
					</div>
					<?php
					}
				?>

				<div align="left">
					<a href="#"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Nuovo Deposito</button></a>
					<a href="#"><button type="button" class="btn btn-warning"><i class="fa fa-search"></i> Ricerca Avanzata</button></a>
					<br><br>
				</div>

				<script type="text/javascript" src="livesearch-magazzino-ricerca-deposito.js" <?php if($edit) { ?> onLoad="showResult('<?php echo $prodotto; ?>','<?php echo $magazzino; ?>')" <?php } else { ?>onLoad="showResult('','')" <?php } ?> ></script>
				<form name="cercato" onSubmit="return false">
					<div class="row">
						<div class="col-md-6">
							<div class="input-group">
								<div class="input-group-addon">Magazzino/Servizio:</div>
								<select class="form-control input" name="mag" onchange="showResult(desc.value,this.value)">
									<option value="">TUTTI I MAGAZZINI/SETTORI</option>
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
						</div>
						
						<div class="col-md-6">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita il codice o la descrizione del prodotto" type="text" name="desc" class="form-control" onkeyup="showResult(this.value,mag.value)">
							</div>
						</div>
					</div>
				</form>
				<br>
				<div id="livesearch">
					<!-- spazio riservato ai risultati live della ricerca -->
				</div>
			</div>
		</div>
	</div>
	
</div>