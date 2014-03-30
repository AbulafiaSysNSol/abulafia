<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Stampa registro di protocollo</strong></h3>
		</div>
		
		<div class="panel-body">
		
		<?php
		 if($_GET['noresult'] == 1) {
		?>
		<div class="row">
		<div class="col-xs-12">
		<div class="alert alert-danger">Nessun risultato trovato. Provare a variare i parametri di ricerca.</div></div></div>
		<?php
		}
		?>	
			<div class="row">
			
				<div class="col-xs-4">
					Stampa intervallo numerico:<br><br>
					<form class="form-inline" role="form" method="post" action="login0.php?corpus=stampa-registro2&search=num">
				
						Dal n. 
						<div class="form-group">
						<input name="numeroinizio" size="2" type="text" class="form-control">
						</div>
						al n.
						<div class="form-group">
						<input name="numerofine" size="2" type="text" class="form-control">
						</div>
						<br><br>
						<button class="btn btn-primary" type="submit">Stampa</button>
					
					</form>
				</div>
				
				<div class="col-xs-4">
					Stampa intervallo temporale:<br><br>
					<form class="form-inline" role="form" method="post" action="login0.php?corpus=stampa-registro2&search=date">
				
						Dal 
						<div class="form-group">
						<input name="datainizio" size="10" type="text" class="form-control datepicker">
						</div>
						al
						<div class="form-group">
						<input name="datafine" size="10" type="text" class="form-control datepicker">
						</div>
						<br><br>
						<button class="btn btn-primary" type="submit">Stampa</button>
					
					</form>
				</div>
			
			</div>
			
		</div>
		
</div>