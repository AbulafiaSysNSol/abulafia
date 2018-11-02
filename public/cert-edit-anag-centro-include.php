<?php

	$id = $_GET['id'];
	$a = new Anagrafica();
	$c = new Calendario();
	$info = $a->infoAssistito($id);
	
	if( isset($_GET['edit']) && $_GET['edit'] == "ok") {
		?>
		<div class="row">
			<div class="col-sm-12">
				<center><div class="alert alert-success"><i class="fa fa-check"></i> Anagrafica aggiornata <b>correttamente!</b></div></center>
			</div>
		</div>
		<?php
	}
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-user-plus"></i> Modifica di un Assistito</strong></h3>
	</div>
		
	<div class="panel-body">

		<form class="form-horizontal" action="cert-edit-anag2.php" role="form" name="modulo" method="post" >
						
			<input type="hidden" name="id" value="<?php echo $id; ?>">

			<div class="form-group">
				<div class="row">
					
					<label class="col-sm-2 control-label">Nome:</label>
					<div class="col-sm-2">
						<input type="text" value="<?php echo $info['nome']; ?>" class="form-control input-sm" name="nome" required>
					</div>

					<label class="col-sm-1 control-label">Cognome:</label>
					<div class="col-sm-2">
						<input type="text" value="<?php echo $info['cognome']; ?>" class="form-control input-sm" name="cognome" required>
					</div>

					<label class="col-sm-2 control-label">Codice Fiscale:</label>
					<div class="col-sm-2">
						<input type="text" value="<?php echo $info['codicefiscale']; ?>" class="form-control input-sm" name="codicefiscale" required>
					</div>
				
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					
					<label class="col-sm-2 control-label">Nato a:</label>
					<div class="col-sm-3">
						<input type="text" value="<?php echo $info['luogonascita']; ?>" class="form-control input-sm" name="cittanascita" required>
					</div>

					<label class="col-sm-1 control-label">il:</label>
					<div class="col-sm-2">
						<input type="text" value="<?php echo $c->dataSlash($info['datanascita']); ?>" class="form-control input-sm datepickerAnag" name="datanascita" required>
					</div>
				
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					
					<label class="col-sm-2 control-label">Residente a:</label>
					<div class="col-sm-3">
						<input type="text" value="<?php echo $info['residenzacitta']; ?>" class="form-control input-sm" name="residenzacitta" required>
					</div>

					<label class="col-sm-1 control-label">Via/Piazza:</label>
					<div class="col-sm-3">
						<input type="text" value="<?php echo $info['residenzavia']; ?>" class="form-control input-sm" name="residenzavia" required>
					</div>

					<label class="col-sm-1 control-label">N:</label>
					<div class="col-sm-1">
						<input type="text" value="<?php echo $info['residenzanumero']; ?>" class="form-control input-sm" name="residenzanumero" required>
					</div>
				
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					
					<label class="col-sm-2 control-label">Documento:</label>
					<div class="col-sm-3">
						<select class="form-control input-sm" name="documento">
							<option value="cartaidentita" <?php if($info['documento'] == 'cartaidentita') echo 'selected'; ?> > Carta d'identi&agrave;</option>
							<OPTION value="patente" <?php if($info['documento'] == 'patente') echo 'selected'; ?> > Patente di guida</option>
							<OPTION value="passaporto" <?php if($info['documento'] == 'passaporto') echo 'selected'; ?> > Passaporto</option>
						</select>
					</div>

					<label class="col-sm-1 control-label">N:</label>
					<div class="col-sm-3">
						<input type="text" value="<?php echo $info['documentonumero']; ?>" class="form-control input-sm" name="documentonumero" required>
					</div>
				
				</div>
			</div>
						
			<br>
			<div class="row">
				<center>
					<button type="submit" class="btn btn-warning btn-lg"><i class="fa fa-edit"></i> Modifica</button>
				</center>
			</div>
		
		</form>
				
	</div>
</div>