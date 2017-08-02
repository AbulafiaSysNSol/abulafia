<?php
	$id= $_GET['id'];
	$risultati=$verificaconnessione->query("select * from anagrafica 
						where idanagrafica='$id'");

	$risultati3=$verificaconnessione->query("select * from users 
						where idanagrafica='$id'");

	$row = $risultati->fetch_array();
	$row3 = $risultati->fetch_array();
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-user"></i> Gestione Utente: <?php echo ucwords(stripslashes($row['cognome'].' '.$row['nome']));?></strong></h3>
	</div>
  
	<div class="panel-body">
		<form name="modifica" method="post" >
			<div class="form-group">
				<div class="row">
					<div class="col-sm-3">
						<label>Username:</label>
						<input class="form-control input-sm" type="text" name="nomeutente"  value="<?php echo $row3['loginname'];?>"/>
					</div>
				
					<div class="col-sm-1">
						<label>Auth:</label>
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
					
					<?php
					$anag = new Anagrafica($verificaconnessione);
					if ($anag->isAdmin($_SESSION['loginid'])) {
					?>
					<div class="col-sm-1">
						<label>Admin:</label><br>
						<center><input type="checkbox" name="admin" value="1" <?php if($row3['admin'] == 1) echo 'checked'; ?>/></center>
					</div>
					<?php
					}
					?>

					<div class="col-sm-1">
						<label>Anagrafica:</label><br>
						<center><input type="checkbox" name="anagrafica" value="1" <?php if($row3['anagrafica'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<label>Protocollo:</label><br>
						<center><input type="checkbox" name="protocollo" value="1" <?php if($row3['protocollo'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<label>Lettere:</label><br>
						<center><input type="checkbox" name="lettere" value="1" <?php if($row3['lettere'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<label>Magazzino:</label><br>
						<center><input type="checkbox" name="magazzino" value="1" <?php if($row3['magazzino'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<label>Contabilit&agrave:</label><br>
						<center><input type="checkbox" name="contabilita" value="1" <?php if($row3['contabilita'] == 1) echo 'checked'; ?>/></center>
					</div>

				</div>

				<br>

				<div class="row">
					<div class="col-sm-3">
						<label>Password:</label>
						<input class="form-control input-sm" type="password" name="nuovapassword1" />
					</div>

					<div class="col-sm-3">
						<label>Ripeti password:</label>
						<input class="form-control input-sm" type="password" name="nuovapassword2" />
					</div>
				</div>

				<br>
				<button class="btn btn-success" onClick="Controllo()"><i class="fa fa-edit"></i> Modifica</button>
			
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
