<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><b>Segnalazione errori</b></h3>
		</div>
		<div class="panel-body">
			
			<div class="row">
			<div class="col-xs-5">
			<div class="form-group">
			<form action="login0.php?corpus=segnala-bug2&idanagrafica=<?php echo $_SESSION['loginid'];?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="mittente" value="informatica@cricatania.it">
			Pagina in cui si e' riscontrato l'errore:<br>
			<input required class="form-control" type="text" name="pagina-errore" value="" />
			<br>Descrizione dell'errore:<br>
			<textarea required class="form-control" cols="23" rows="4" name="messaggio"></textarea>
			<br><input class="btn btn-primary" type="submit" value="Invia" />
			</form>
			</div>
			</div>
			</div>
			
			<h5>Tutte le segnalazioni verranno vagliate. Si verra' avvisati via e-mail quando l'errore sara' stato corretto.</h5>
		</div>

</div>

