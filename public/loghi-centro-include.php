<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-picture-o fa-fw"></i> Logo e Intestazione:</strong></h3>
	</div>

	<div class="panel-body">
	
		<?php
			if( isset($_GET['logo']) && $_GET['logo'] == "epng") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger"><b><i class="fa fa-fw fa-warning"></i> Attenzione:</b> Il logo deve essere in formato <b>PNG</b></div>
				</div>
			</div>
			<?php
			}
		?>

		<?php
			if( isset($_GET['logo']) && $_GET['logo'] == "ok") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-success"><b><i class="fa fa-fw fa-check"></i></b> Modifiche apportate <b>con successo!</b></div>
				</div>
			</div>
			<?php
			}
		?>

		<?php
			if( isset($_GET['logo']) && $_GET['logo'] == "ejpg") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger"><b><i class="fa fa-fw fa-warning"></i> Attenzione:</b> L'intestazione deve essere in formato <b>JPEG</b></div>
				</div>
			</div>
			<?php
			}
		?>

		<?php
			if( isset($_GET['logo']) && $_GET['logo'] == "error") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger"><b><i class="fa fa-fw fa-warning"></i> Attenzione:</b> si &egrave; verificato un errore nella modifica. Riprovare in seguito o contattare il supporto.</div>
				</div>
			</div>
			<?php
			}
		?>
	
		<div class="row" style="text-align: center;">
			<div class="col-sm-4">
				<div class="alert alert-info">
					<label><i class="fa fa-fw fa-picture-o"></i> Logo (Dim. 285x297 px):</label><br><br>
					<img width="56%" src="images/logo-azienda.png">
					<form enctype="multipart/form-data" action="login0.php?corpus=modifica-logo" method="POST">
						<center><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['fotomaxfilesize'];?>" />
						<br><label><i class="fa fa-fw fa-edit"></i> Modifica Logo:</label>
						<br><small>N.B. l'immagine deve essere in formato PNG</small>
						<br><small><a href="images/logoexample.png" target="_blank">(scarica la griglia con le dimensioni ideali)</a></small><br><br>
						<input required name="uploadedfile" type="file" />
						<br><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-upload"></span> Upload</button></center>
					</form>
				</div>
			</div>

			<div class="col-sm-8">
				<div class="alert alert-success">
					<label><span class="glyphicon glyphicon-picture"></span> Intestazione (Dim. 1240x300 px):</label><br><br>
					<img width="100%" src="images/intestazione.jpg">
					<br><br>
					<form enctype="multipart/form-data" action="login0.php?corpus=modifica-intestazione" method="POST">
						<center><input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['fotomaxfilesize'];?>" />
						<br><label><i class="fa fa-fw fa-edit"></i> Modifica Intestazione:</label>
						<br><small>N.B. l'immagine deve essere in formato JPG</small>
						<br><small><a href="images/intestazioneexample.jpg" target="_blank">(scarica la griglia con le dimensioni ideali)</a></small><br><br>
						<input required name="uploadedfile" type="file" />
						<br><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-upload"></span> Upload</button></center>
					</form>
				</div>
			</div>
		</div>

	</div>

</div>