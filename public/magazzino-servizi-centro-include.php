<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-navicon"></i> Elenco Servizi</strong></h3>
			</div>
			
			<div class="panel-body">

				<?php
				if( isset($_GET['canc']) && $_GET['canc'] == "ok")
				{
					?>
					<div class="row">
					<div class="col-sm-12">
					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Servizio eliminato con successo!</div></div></div>
					<?php
				}
				
				if( isset($_GET['insert']) && $_GET['insert'] == "ok") 
				{
					?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-success"><i class="fa fa-check"></i> Magazzino/Servizio aggiunto <b>correttamente!</b></div>
						</div>
					</div>
					<?php
				}
				?>

				<div align="left">
					<a href="?corpus=magazzino-aggiungi-servizio"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Aggiungi Servizio</button></a><br><br>
				</div>

				<script type="text/javascript" src="livesearch-magazzino-ricerca-servizio.js" onLoad="showResult('')"></script>
				<form name="cercato" onSubmit="return false">
					<div class="input-group">
						<div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita il codice o la descrizione del servizio" type="text" name="valore" class="form-control" onkeyup="showResult(this.value)">
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