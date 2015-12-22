<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><span class="glyphicon glyphicon-pencil"></span> Componi Lettera - STEP 1: Dettagli lettera</b></h3>
	</div>
	
	<div class="panel-body">
		
		<div class="form-group">
			<form id="login_form" action="lettera1.php" method="POST" enctype="multipart/form-data">	
				<div class="row">
					<div class="col-sm-8">
						<h5><i class="fa fa-file-text-o"></i> Testo della lettera:</h5>
						<textarea id="editor" class="form-control" rows="17" name="message"></textarea>
					</div>
				
					<div class="col-sm-4">
						<h5><i class="fa fa-certificate"></i> Oggetto:</h5>
						<textarea id="editorOgg" class="form-control" rows="2" type="text" name="oggetto"></textarea>		
						<br>
						<h5><i class="fa fa-calendar"></i> Data della lettera:</h5>
						<input required type="text" class="form-control input-sm datepickerProt" name="data">
						<br>
						<h5><i class="fa fa-paperclip"></i> Numero allegati:</h5>
						<input type="text" class="form-control input-sm" name="allegati">
						<br><br>
						<button class="btn btn-success btn-lg" type="submit"><i class="fa fa-save"></i> Salva e inserisci i destinatari <i class="fa fa-arrow-right"></i></button>
					</div>
				</div>					
			</form>
		</div>
	</div>

</div>

