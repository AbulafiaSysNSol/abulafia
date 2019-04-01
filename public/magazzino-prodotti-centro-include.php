<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-navicon"></i> Prodotti Registrati</strong></h3>
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

					if( isset($_GET['canc']) && $_GET['canc'] == "ok") {
					?>
					<div class="row">
					<div class="col-sm-12">
					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Prodotto eliminato con successo!</div></div></div>
					<?php
					}
					
					if( isset($_GET['canc']) && $_GET['canc'] == "no") {
						?>
						<div class="row">
						<div class="col-sm-12">
						<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella cancellazione del prodotto</div></div></div>
						<?php
					}
				?>

				<div align="left">
					<a href="?corpus=magazzino-aggiungi-prodotto"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Aggiungi Prodotto</button></a><br><br>
				</div>

				<script type="text/javascript" src="livesearch-magazzino-ricerca-prodotto.js" onLoad="showResult('','ORDER BY descrizione ASC','25')"></script>
				<form name="cercato" onSubmit="return false">
					<div class="row">
						<div class="col-sm-5">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita il codice, la descrizione o il codice a barre del prodotto" type="text" name="valore" class="form-control" onkeyup="showResult(this.value,ordine.value,numero.value)">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-sort"></i> Ordine:</div>
								<select class="form-control" name="ordine" onChange="showResult(valore.value,this.value,numero.value)">
									<option value="ORDER BY descrizione ASC"></i><i class="fa fa-sort-alpha-asc"></i> ALFABETICO</option>
									<option value="ORDER BY codice ASC"><i class="fa fa-sort-numeric-asc"></i> CODICE CRESCENTE</option>
									<option value="ORDER BY codice DESC"><i class="fa fa-sort-numeric-desc"></i> CODICE DECRESCENTE</option>
									<option value="ORDER BY prezzo ASC"><i class="fa fa-sort-amount-asc"></i> PREZZO CRESCENTE</option>
									<option value="ORDER BY prezzo DESC"><i class="fa fa-sort-amount-desc"></i> PREZZO DECRESCENTE</option>
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-list-ol"></i> N. Risultati:</div>
								<select class="form-control" name="numero" onChange="showResult(valore.value,ordine.value,this.value)">
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
									<option value="200">200</option>
									<option value="300">300</option>
								</select>
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