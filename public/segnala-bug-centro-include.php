<div class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><b><i class="fa fa-bug"></i> Segnalazione errori</b></h3>
		</div>
		
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-5">
					<div class="form-group">
						<form action="login0.php?corpus=segnala-bug2&idanagrafica=<?php echo $_SESSION['loginid'];?>" method="POST" enctype="multipart/form-data">
							<i class="fa fa-file-code-o"></i> Pagina in cui si e' riscontrato l'errore:<br>
							<input required id="pag" class="form-control" type="text" name="pagina-errore" value="" />
							<br><i class="fa fa-pencil-square-o"></i> Descrizione dell'errore:<br>
							<textarea required id="mess" class="form-control" rows="6" name="messaggio"></textarea>
							<br>
							<button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Invio email in corso..." class="btn btn-success" type="submit">Invia Segnalazione <i class="fa fa-mail-forward"></i></button>
						</form>
					</div>
				</div>
			</div>
			
			<h5><b>N.B.</b> tutte le segnalazioni verranno vagliate. Si verra' avvisati via e-mail quando l'errore sara' stato corretto.</h5>
		</div>

</div>

<script>
	$("#buttonl").click(function() {
		var $btn = $(this);
		var pag = document.getElementById("pag").value;
		var mess = document.getElementById("mess").value;
		if ((pag == "") || (pag == "undefined") || (mess == "") || (mess == "undefined")) {
			return;
		}
		else {
			$btn.button('loading');
		}
	});
</script>
