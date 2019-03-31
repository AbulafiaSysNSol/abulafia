<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-archive"></i> Elenco lettere archiviate:</strong></h3>
	</div>

	<div class="panel-body">
	
		<?php
			if (isset($_GET['from']) &&($_GET['from'] == 'nessuna-lettera')) {
			?>
				<center><div class="alert alert-info"><i class="fa fa-check"></i> Non ci sono lettere da <b>firmare!</b></div></center>
			<?php
			}
		?>
		
		<?php
			if (isset($_GET['delete']) &&($_GET['delete'] == 'ok')) {
			?>
				<center><div class="alert alert-danger"><i class="fa fa-check"></i> Lettera cancellata <b>correttamente!</b></div></center>
			<?php
			}
		?>
		
		<script type="text/javascript" src="livesearch-ricerca-lettere.js" onLoad="showResult('','25')"></script>
		<form name="cercato" onSubmit="return false">
			<div class="row">
				<div class="col-sm-9">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita l'oggetto o l'id della lettera" type="text" name="valore" class="form-control" onkeyup="showResult(this.value,numero.value)">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-list-ol"></i> N. Risultati:</div>
						<select class="form-control" name="numero" onChange="showResult(valore.value,this.value)">
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
	