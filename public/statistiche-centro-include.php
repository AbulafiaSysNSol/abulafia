<?php
	$reg = new Registroprotocollo();
	$log = new Log();
	$anni = $reg->getAnni();
	$anniusoapplicazione = (strtotime("now") - strtotime($_SESSION['inizio']))/60/60/24/365;
	$giorniusoapplicazione = ((strtotime("now") - strtotime($_SESSION['inizio']))/60/60/24)-(int)$anniusoapplicazione*365;
	$lettere = $connessione->query("SELECT COUNT(*) FROM comp_lettera");
	$numlettere = $lettere->fetch();
	$allegati = $connessione->query("SELECT COUNT(*) FROM joinlettereallegati");
	$numallegati = $allegati->fetch();
	$utenti = $connessione->query("SELECT COUNT(*) FROM users");
	$numutenti = $utenti->fetch();
	$anagrafiche = $connessione->query("SELECT COUNT(*) FROM anagrafica");
	$numanagrafiche = $anagrafiche->fetch();
	$email = $connessione->query("SELECT COUNT(*) FROM mailsend");
	$numemail = $email->fetch();
	$numaccessi = $log->contaLog("access.log");
	$numprot = 0;
	$numanni = array();
	foreach($anni as $annoprot) {
		$lettere = $connessione->query("SELECT COUNT(*) FROM lettere$annoprot");
		$numlett = $lettere->fetch();
		$numprot = $numprot + $numlett[0];
		$numanni[$annoprot] = $numlett[0];
	}
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-bar-chart"></i> Un po' di numeri di <?php echo $_SESSION['nomeapplicativo'] . ' - ' . $_SESSION['headerdescription'];?></strong></h3>
	</div>
			
	<div class="panel-body">
		<label><i class="fa fa-line-chart fa-fw"></i> Statistiche sull'utilizzo del software:</label><br><br>
		<div class="row">
			<center>
			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-hourglass-half"></i></h2>
					<?php 
						echo 'Abulafia Web<br>e\' in uso da:<h4><b>'; 
						if( (int)$anniusoapplicazione > 0) { 
							echo (int)$anniusoapplicazione . ' anni e ' .(int)$giorniusoapplicazione.' giorni</b></h3>'; 
						} 
						else { 
							echo (int)$giorniusoapplicazione.' giorni</b></h4>;'; 
						} 
					?>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-book"></i></h2>
					Numero di protocolli registrati nel sistema: 
					<h4><b><?php echo $numprot; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-file-text-o"></i></h2>
					Numero di lettere scritte dal sistema: 
					<h4><b><?php echo $numlettere[0]; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-paperclip"></i></h2>
					File allegati ai protocolli caricati nel sistema: 
					<h4><b><?php echo $numallegati[0]; ?></b></h4>
				</div>
			</div>
			</center>
		</div>

		<div class="row">
			<center>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-id-card"></i></h2>
					Anagrafiche registrate nel sistema: 
					<h4><b><?php echo $numanagrafiche[0]; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-users"></i></h2>
					Utenti abilitati all'utilizzo del software: 
					<h4><b><?php echo $numutenti[0] - 1; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-sign-in"></i></h2>
					Numero di accessi eseguiti nel sistema: 
					<h4><b><?php echo $numaccessi; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-envelope"></i></h2>
					Numero di email inviate dal sistema: 
					<h4><b><?php echo $numemail[0]; ?></b></h4>
				</div>
			</div>
		</div>
	</div>
</div>