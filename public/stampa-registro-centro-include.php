<?php
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO STAMPA REGISTRO' , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
?>

<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-external-link"></i> Esporta Registro di Protocollo in PDF</strong></h3>
		</div>
		
		<div class="panel-body">
		
		<?php
		 if( isset($_GET['noresult']) && $_GET['noresult'] == 1) {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-danger"><b><i class="fa fa-exclamation-triangle"></i> Nessun risultato trovato.</b> Provare a variare i parametri di ricerca.</div></div></div>
		<?php
		}
		?>	
		
		<?php
		 if( isset($_GET['noresult']) && $_GET['noresult'] == 2) {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-danger"><b><i class="fa fa-exclamation-triangle"></i> Errore:</b> indicare date di ricerca appartenenti allo stesso anno.</div></div></div>
		<?php
		}
		?>
			<div class="row">
				<center>
				<div class="col-sm-3">
					<i class="fa fa-calendar-o"></i> Stampa registro giornaliero:<br><br>
					<form class="form-inline" role="form" method="post" target="_BLANK" action="stampa-registro2-centro-include.php?search=day">
				
						Giorno:
						<div class="form-group">
						<input name="day" size="10" type="text" class="form-control input-sm datepickerProt" required>
						</div>
						<br><br>
						<button class="btn btn-danger" type="submit"><i class="fa fa-file-pdf-o"></i> Genera PDF</button>
					
					</form>
				</div>
				
				<div class="col-sm-5">
					<i class="fa fa-list-ol"></i> Stampa intervallo numerico:<br><br>
					<form class="form-inline" role="form" method="post" target="_BLANK" action="stampa-registro2-centro-include.php?search=num">
				
						Dal n. 
						<div class="form-group">
						<input name="numeroinizio" size="2" type="text" class="form-control input-sm" required>
						</div>
						al n.
						<div class="form-group">
						<input name="numerofine" size="2" type="text" class="form-control input-sm" required>
						</div>
						 Anno protocollo:
						<SELECT class="form-control input-sm" name="annoprotocollo" >
						<?php
							$esistenzatabella1=mysql_query("show tables like 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
							$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
							$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
							while ($esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM))
							{
							if ('lettere'.$my_calendario->anno== $esistenzatabella11[0]) { $selected='selected'; }
							else { $selected ='';}
							$annoprotocollo= explode("lettere", $esistenzatabella11[0]);
							?><OPTION value="<?php echo $annoprotocollo[1] ;?>" <?php echo $selected ;?>> <?php echo $annoprotocollo[1].' ' ;?>
							<?php
							}
						?>
						</select>
						<br><br>
						<button class="btn btn-danger" type="submit"><i class="fa fa-file-pdf-o"></i> Genera PDF</button>
					
					</form>
				</div>
				
				<div class="col-sm-4">
					<i class="fa fa-calendar"></i> Stampa intervallo temporale:<br><br>
					<form class="form-inline" role="form" method="post" target="_BLANK" action="stampa-registro2-centro-include.php?search=date">
				
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