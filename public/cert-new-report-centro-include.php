
<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-external-link"></i> Genera Report delle Prestazioni Erogate in PDF</strong></h3>
		</div>
		
		<div class="panel-body">
		
			<div class="row">
				<center>
								
				<div class="col-sm-12">
					<i class="fa fa-calendar"></i> Seleziona Intervallo Dati:<br><br>
					<form class="form-inline" role="form" method="post" target="_blank" action="cert-report-prestazioni.php">
				
						Dal 
						<div class="form-group">
						<input name="datainizio" size="10" type="text" class="form-control input-sm datepickerProt" required>
						</div>
						al
						<div class="form-group">
						<input name="datafine" size="10" type="text" class="form-control input-sm datepickerProt" required>
						</div>
						<br><br>
						<button class="btn btn-danger" type="submit"><i class="fa fa-file-pdf-o"></i> Genera PDF</button>
					
					</form>
				</div>
				</center>
			</div>
			
		</div>
		
</div>