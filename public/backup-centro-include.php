<?php
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO BACKUP' , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
?>

<div class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><strong><i class="fa fa-cloud-download"></i> Backup Manuale Allegati Protocollo</strong></h3>
		</div>
		
		<div class="panel-body">
		
			<div class="row">
				<center>
				
				<div class="col-sm-12">
					<h4>Seleziona Anno per il Download degli Allegati:</h4><br>
					<form class="form-inline" role="form" method="post" name="download">
				
						<i class="fa fa-fw fa-calendar"></i> Anno Protocollo:
						<SELECT class="form-control input-sm" name="anno" >
						<?php
							$esistenzatabella1=mysql_query("show tables like 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
							$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
							$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
							while ($esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM))
							{
							if ('lettere'.$my_calendario->anno== $esistenzatabella11[0]) { $selected='selected'; }
							else { $selected ='';}
							$annoprotocollo= explode("lettere", $esistenzatabella11[0]);
							?><OPTION value="<?php echo $annoprotocollo[1] ;?>" <?php echo $selected ;?>> <?php echo $annoprotocollo[1];?>
							<?php
							}
						?>
						</select>
						<br><br>
						<small>Selezionare l'intervallo di protocolli per il download degli allegati (max 200)</small>
						<br><br>
						<label>Dal</label> <input class="form-control input-sm" name="inizio" type="text" required>
						<label>al</label> <input class="form-control input-sm" name="fine" type="text" required>
						<br><br>
						<button id="buttondownload" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Preparazione al download in corso<br>non chiudere questa finestra" class="btn btn-success" type="button" onClick="validate();"><i class="fa fa-fw fa-download"></i> Download</button>
					
					</form>
				</div>
				
				</center>
			</div>
			
		</div>
</div>

<script>
	$("#buttondownload").click(function() {
		var $btn = $(this);
		var inizio = document.download.inizio.value;
		var fine = document.download.fine.value;
		if (inizio == '' || fine == '' || (fine - inizio) > 200) {
	        return false;
		}
		else {
			$btn.button('loading');
			setTimeout(function() {
       			$btn.button('reset');
   			}, 15000);
   		}
	});
</script>

<script language="javascript">

	function validate() {
		var inizio = document.download.inizio.value;
		var fine = document.download.fine.value;
		if (inizio == '' || fine == '') {
			alert("I campi inizio e fine sono obbligatori");
	        document.download.inizio.focus();
	        return false;
		}
		if ((fine - inizio) > 200) {
	           alert("Seleziona un'intervallo di max 200 allegati");
	           document.download.inizio.focus();
	           return false;
	    }
		else {
	    	document.download.action = "backup2.php";
	        document.download.submit();
	    }
  	}

</script>