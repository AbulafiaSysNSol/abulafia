<?php
	
	//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
	if ($_SESSION['auth'] < 99) { 
		echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; 
		exit ();
	}

	$id= $_GET['id'];
	$risultati=mysql_query("select * from anagrafica where idanagrafica='$id'");
	$risultati3=mysql_query("select * from users where idanagrafica='$id'");
	$row = mysql_fetch_array($risultati);
	$row3 = mysql_fetch_array($risultati3);
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

					<div class="col-sm-3">
						<label>Email:</label>
						<input class="form-control input-sm" type="email" name="email" value="<?php echo $row3['mainemail']; ?>"/>
					</div>

					<div class="col-sm-3">
						<label>Password:</label>
						<input class="form-control input-sm" type="password" name="nuovapassword1" />
					</div>

					<div class="col-sm-3">
						<label>Ripeti password:</label>
						<input class="form-control input-sm" type="password" name="nuovapassword2" />
					</div>					

				</div>

				<br><br>

				<div class="row">
					
					<div class="col-sm-1">
						<center><label>Auth:</label>
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
						</select></center>
					</div>
					
					<?php
					$anag = new Anagrafica();
					if ($anag->isAdmin($_SESSION['loginid'])) {
					?>
					<div class="col-sm-1">
						<center><label>Admin:</label><br>
						<input type="checkbox" name="admin" value="1" <?php if($row3['admin'] == 1) echo 'checked'; ?>/></center>
					</div>
					<?php
					}
					?>

					<div class="col-sm-1">
						<center><label>Anagrafica:</label><br>
						<input type="checkbox" name="anagrafica" value="1" <?php if($row3['anagrafica'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<center><label>Protocollo:</label><br>
						<input type="checkbox" name="protocollo" value="1" <?php if($row3['protocollo'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<center><label>Documenti:</label><br>
						<input type="checkbox" name="documenti" value="1" <?php if($row3['documenti'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<center><label>Lettere:</label><br>
						<input type="checkbox" name="lettere" value="1" <?php if($row3['lettere'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<center><label>Magazzino:</label><br>
						<input type="checkbox" name="magazzino" value="1" <?php if($row3['magazzino'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<center><label>Contabilit&agrave:</label><br>
						<input type="checkbox" name="contabilita" value="1" <?php if($row3['contabilita'] == 1) echo 'checked'; ?>/></center>
					</div>

					<div class="col-sm-1">
						<center><label>Check:</label><br>
						<input type="checkbox" name="checkprofile" value="1" <?php if($row3['updateprofile'] == 1) echo 'checked'; ?>/></center>
					</div>

				</div>

				<br><br>
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