<?php

	$id=$_GET['id'];
	$p = new Prodotto();
	$prodotto = $p->getInfo($id);

?>

<div class="row">
	
	<div class="col-xs-12">
		<div class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title"><strong><i class="fa fa-edit"></i> Modifica Prodotto - <?php echo $prodotto['codice']; ?></strong></h3>
				</div>
				
				<div class="panel-body">
				
					<form class="form-horizontal" role="form" name="modulo" method="post" action="magazzino-modifica-prodotto2.php">
						
						<input type="hidden" name="codice" value="<?php echo $prodotto['codice'] ?>">
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Descrizione Prodotto:</label>
							<div class="row">
								<div class="col-xs-8">
									<input type="text" class="form-control input-sm" name="descrizione" value="<?php echo $prodotto['descrizione']; ?>" required>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Prezzo:</label>
							<div class="row">
								<div class="col-xs-2">
									<div class="input-group">
										<input type="text" class="form-control input-sm" name="prezzo" value="<?php echo $prodotto['prezzo']; ?>"><div class="input-group-addon"><i class="fa fa-euro"></i></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Unità di Misura:</label>
							<div class="row">
								<div class="col-xs-2">
									<select class="form-control input-sm"  size=1 cols=4 NAME="unitadimisura">
										<option value="<?php echo $prodotto['unita_misura']; ?>"><?php echo $prodotto['unita_misura']; ?></option>
										<option value="PZ"> PZ </option>
										<option value="CPR"> CPR </option>
										<option Value="FL"> FL </option>
										<option value="FLC"> FLC </option>
										<option value="CFZ"> CFZ </option>
										<option value="LT"> LT </option>
										<option value="KG"> KG </option>
										<option value="BX"> BX </option>
										<option value="UNI"> UNI </option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Note:</label>
							<div class="row">
								<div class="col-xs-8">
									<input type="text" class="form-control input-sm" name="note" value="<?php echo $prodotto['note']; ?>">
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Codice a Barre:</label>
							<div class="row">
								<div class="col-xs-5">
									<input type="text" class="form-control input-sm" name="codicebarre" value="<?php echo $prodotto['codicebarre']; ?>">
								</div>
							</div>
						</div>
						
						<br>
						<div class="row">
							<div class="col-sm-2 col-sm-offset-3">
								<button class="btn btn-lg btn-warning" type="submit"><span class="glyphicon glyphicon-check"></span> Modifica</button>
							</div>
						</div>
					
					</form>
				
				</div>
		</div>
	</div>
	
</div>