<div class="row">
	<div class="col-xs-9">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-navicon"></i> Prodotti Registrati</strong></h3>
			</div>
			
			<div class="panel-body">

				<script type="text/javascript" src="livesearch-farm-ricerca-prodotto.js" onLoad="showResult('')"></script>
				<form name="cercato" onSubmit="return false">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita il codice o la descrizione del prodotto" type="text" name="valore" class="form-control" onkeyup="showResult(this.value)">
					</div>
				</form>
				<br>
				<div id="livesearch">
				<!-- spazio riservato ai risultati live della ricerca -->
				</div>
			</div>
		</div>
	</div>
	
	<?php include "farm-menu.php"; ?>
	
</div>