<?php
	
	$id = $_GET['id'];
	$anno = $_GET['anno'];
	
?>

<div class="row">
	<div class="col-md-8">
		<h3><i class="fa fa-paper-plane-o"></i> Aggiungi inoltro Protocollo <b><?php echo $id; ?></b>:</h3>
		<br>
		<form action="login0.php?corpus=aggiungi-inoltro2&id=<?php echo $id; ?>&anno=<?php echo $anno; ?>" method="post">
			<div class="form-group">
				<i class="fa fa-envelope-o"></i> indirizzo email:
				<div class="row">
					<div class="col-xs-5">
						<input type="text" class="form-control input-sm" name="email" required>
					</div>
				</div>
				<br>
				<i class="fa fa-calendar"></i> data invio:
				<div class="row">
					<div class="col-xs-3">
						<input type="text" class="form-control input-sm datepickerProt" name="data" required>
					</div>
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Aggiungi</button>
				</div>
			</div>
		</form>
	</div>
</div>