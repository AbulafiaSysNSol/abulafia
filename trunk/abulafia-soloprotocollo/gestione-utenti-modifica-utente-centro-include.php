<?php
	$id= $_GET['id'];
	$risultati=mysql_query("select * from anagrafica where idanagrafica='$id'");
	$risultati3=mysql_query("select * from users where idanagrafica='$id'");
	$row = mysql_fetch_array($risultati);
	$row3 = mysql_fetch_array($risultati3);
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Gestione Utente: <?php echo ucwords(stripslashes($row['cognome'].' '.$row['nome']));?></strong></h3>
	</div>
  
	<div class="panel-body">
		<form name="modifica" method="post" >
			<div class="form-group">
				<div class="row">
				<div class="col-xs-3">
				<label>Username:</label>
					<input class="form-control input-sm" type="text" name="nomeutente"  value="<?php echo $row3['loginname'];?>"/>
				</div>
				</div>
				
				<div class="row">
				<div class="col-xs-2">
				<br><label>Auth:</label>
					<select class="form-control input-sm" type="text" name="authlevel1" />
						<OPTION selected value="<?php echo $row3['auth'];?>"> <?php echo $row3['auth'];?>
						<?php
						$iterazioneauth = 0;
						while ($iterazioneauth < 100) { 
							$iterazioneauth = $iterazioneauth +1;
							?>
							<OPTION value="<?php echo $iterazioneauth;?>"> <?php echo $iterazioneauth;?> 
							<?php 
						} 
						?>
					</select>
				</div>
				</div>
				
				<div class="row">
				<div class="col-xs-3">
				<br><label>Password</label>
					<input class="form-control input-sm" type="password" name="nuovapassword1" />
				</div>
				</div>
				
				<div class="row">
				<div class="col-xs-3">
				<br><label>Ripeti password</label>
					<input class="form-control input-sm" type="password" name="nuovapassword2" />
				</div>
				</div>
				
				<br>
				<button class="btn btn-primary" onClick="Controllo()">MODIFICA</button>
			
			</div>
		</form>
	</div>
	
</div>

<script language="javascript">
 <!--
  function Controllo() {
	
	//acquisisco il valore delle variabili
	var nomeutente = document.modifica.nomeutente.value;
	var nuovapassword1 = document.modifica.nuovapassword1.value;
	var nuovapassword2 = document.modifica.nuovapassword2.value;
      
	if ((nomeutente == "") || (nomeutente == "undefined")) {
		alert("Il campo 'Username' è obbligatorio");
		document.modifica.nomeutente.focus();
		return false;
	}

	else if (nuovapassword1 != nuovapassword2) {
		alert("Le due password non coincidono");
		document.modulo.nuovapassword1.focus();
		return false;
	}
	
	//mando i dati alla pagina
	else {
		document.modifica.action = "login0.php?corpus=gestione-utenti-modifica-utente2&id=<?php echo $id;?>";
		document.modifica.submit();
	}
  }
 //-->
</script> 