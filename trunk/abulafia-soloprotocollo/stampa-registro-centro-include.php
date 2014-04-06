<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Stampa registro di protocollo</strong></h3>
		</div>
		
		<div class="panel-body">
		
		<?php
		 if( isset($_GET['noresult']) && $_GET['noresult'] == 1) {
		?>
		<div class="row">
		<div class="col-xs-12">
		<div class="alert alert-danger">Nessun risultato trovato. Provare a variare i parametri di ricerca.</div></div></div>
		<?php
		}
		?>	
		
		<?php
		 if( isset($_GET['noresult']) && $_GET['noresult'] == 2) {
		?>
		<div class="row">
		<div class="col-xs-12">
		<div class="alert alert-danger">Indicare date di ricerca appartenenti allo stesso anno.</div></div></div>
		<?php
		}
		?>
			<div class="row">
			
				<div class="col-xs-4">
					Stampa intervallo numerico:<br><br>
					<form class="form-inline" role="form" method="post" target="_BLANK" action="login0.php?corpus=stampa-registro2&search=num">
				
						Dal n. 
						<div class="form-group">
						<input name="numeroinizio" size="2" type="text" class="form-control">
						</div>
						al n.
						<div class="form-group">
						<input name="numerofine" size="2" type="text" class="form-control">
						</div>
						<br><br>Anno protocollo:
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
							<?
							}
						?>
						</select>
						<br><br>
						<button class="btn btn-primary" type="submit">Stampa</button>
					
					</form>
				</div>
				
				<div class="col-xs-4">
					Stampa intervallo temporale:<br><br>
					<form class="form-inline" role="form" method="post" target="_BLANK" action="login0.php?corpus=stampa-registro2&search=date">
				
						Dal 
						<div class="form-group">
						<input name="datainizio" size="10" type="text" class="form-control datepicker">
						</div>
						al
						<div class="form-group">
						<input name="datafine" size="10" type="text" class="form-control datepicker">
						</div>
						<br><br>
						<button class="btn btn-primary" type="submit">Stampa</button>
					
					</form>
				</div>
			
			</div>
			
		</div>
		
</div>