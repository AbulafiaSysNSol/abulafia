<?php
	$id = $_GET['idlettera'];
	$from = $_GET['from'];
	$dett = $connessione->query("SELECT * FROM comp_lettera WHERE id = $id");
	$dettagli = $dett->fetch();
	$calendario = new Calendario();
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><span class="glyphicon glyphicon-pencil"></span> Componi Lettera - Modifica dettagli lettera <?php echo $id; ?></b></h3>
	</div>
	
	<div class="panel-body">
		
		<div class="form-group">
			<form id="login_form" action="lettera3.php?idlettera=<?php echo $id; ?>&from=<?php echo $from; ?>" method="POST" enctype="multipart/form-data">	
				<div class="row">
					<div class="col-sm-8">
						<h5><i class="fa fa-file-text-o"></i> Testo della lettera:</h5>
						<textarea id="editor" class="form-control" rows="20" name="message"><?php echo $dettagli['testo']; ?></textarea>
					</div>
				
					<div class="col-sm-4">
						<h5><i class="fa fa-certificate"></i> Oggetto:</h5>
						<textarea id="editorOgg" class="form-control" rows="2" type="text" name="oggetto"><?php echo $dettagli['oggetto']; ?></textarea>		
						<br>
						<h5><i class="fa fa-calendar"></i> Data della lettera:</h5>
						<input required type="text" class="form-control input-sm datepickerProt" name="data" value="<?php echo $calendario->dataSlash($dettagli['data']); ?>">
						<br>
						<h5><i class="fa fa-paperclip"></i> Numero allegati:</h5>
						<input type="text" class="form-control input-sm" name="allegati" value="<?php echo $dettagli['allegati']; ?>">
						<br>
						<h5><i class="fa fa-pencil"></i> Firmatario:</h5>
						<select class="form-control input-sm" name="ufficio">
							<?php
								$uffici = $my_lettera->getUffici();
								foreach($uffici as $uff) {
									if($uff[0] == $dettagli['ufficio']) { 
										$selected = ' selected';
									}
									else {
										$selected ='';
									}
									echo '<option value='.$uff[0].$selected.'>' . $my_lettera->getDescUfficio($uff[0]) . '</option>';
								}
							?>
						</select>
						<br><br>
						<button class="btn btn-success btn-lg" type="submit"><i class="fa fa-save"></i> Salva Cambiamenti <i class="fa fa-arrow-right"></i></button>
					</div>
				</div>					
			</form>
		</div>
	</div>

</div>

