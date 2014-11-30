<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-bug"></i> Segnalazione errori</b></h3>
		</div>
		<div class="panel-body">
			
			<div class="row">
			<div class="col-xs-5">
			<div class="form-group">
			<form action="login0.php?corpus=segnala-bug2&idanagrafica=<?php echo $_SESSION['loginid'];?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="mittente" value="informatica@cricatania.it">
			<i class="fa fa-file-code-o"></i> Pagina in cui si e' riscontrato l'errore:<br>
			<input required class="form-control" type="text" name="pagina-errore" value="" />
			<br><i class="fa fa-pencil-square-o"></i> Descrizione dell'errore:<br>
			<textarea required class="form-control" rows="6" name="messaggio"></textarea>
			<br>
			<button class="btn btn-success" type="submit">Invia Segnalazione <i class="fa fa-mail-forward"></i></button>
			</form>
			</div>
			</div>
			</div>
			
			<h5><b>N.B.</b> tutte le segnalazioni verranno vagliate. Si verra' avvisati via e-mail quando l'errore sara' stato corretto.</h5>
		</div>

</div>

