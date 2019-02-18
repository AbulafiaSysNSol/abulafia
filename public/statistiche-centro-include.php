<?php
	$reg = new Registroprotocollo();
	$log = new Log();
	$anni = $reg->getAnni();
	$anniusoapplicazione = (strtotime("now") - strtotime($_SESSION['inizio']))/60/60/24/365;
	$giorniusoapplicazione = ((strtotime("now") - strtotime($_SESSION['inizio']))/60/60/24)-(int)$anniusoapplicazione*365;
	$lettere = mysql_query("SELECT COUNT(*) FROM comp_lettera");
	$numlettere = mysql_fetch_row($lettere);
	$allegati = mysql_query("SELECT COUNT(*) FROM joinlettereallegati");
	$numallegati = mysql_fetch_row($allegati);
	$utenti = mysql_query("SELECT COUNT(*) FROM users");
	$numutenti = mysql_fetch_row($utenti);
	$anagrafiche = mysql_query("SELECT COUNT(*) FROM anagrafica");
	$numanagrafiche = mysql_fetch_row($anagrafiche);
	$email = mysql_query("SELECT COUNT(*) FROM mailsend");
	$numemail = mysql_fetch_row($email);
	$numaccessi = $log->contaLog("access.log");
	$numprot = 0;
	$numanni = array();
	foreach($anni as $annoprot) {
		$lettere = mysql_query("SELECT COUNT(*) FROM lettere$annoprot");
		$numlett = mysql_fetch_row($lettere);
		$numprot = $numprot + $numlett[0];
		$numanni[$annoprot] = $numlett[0];
	}
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-bar-chart"></i> Un po' di numeri di <?php echo $_SESSION['nomeapplicativo'] . ' - ' . $_SESSION['headerdescription'];?></strong></h3>
	</div>
			
	<div class="panel-body">
		<div class="row">
			<center>
			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-hourglass-half fa-2x"></i></h2>
					<?php 
						echo '<br>Abulafia Web<br>e\' in uso da:<h3><b>'; 
						if( (int)$anniusoapplicazione > 0) { 
							echo (int)$anniusoapplicazione . ' anni e ' .(int)$giorniusoapplicazione.' giorni</b></h3>'; 
						} 
						else { 
							echo (int)$giorniusoapplicazione.' giorni</b></h3>;'; 
						} 
					?>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-book fa-2x"></i></h2>
					<br>Numero di protocolli registrati nel sistema: 
					<h3><b><?php echo $numprot; ?></b></h3>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-file-text-o fa-2x"></i></h2>
					<br>Numero di lettere scritte dal sistema: 
					<h3><b><?php echo $numlettere[0]; ?></b></h3>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-paperclip fa-2x"></i></h2>
					<br>File allegati ai protocolli caricati nel sistema: 
					<h3><b><?php echo $numallegati[0]; ?></b></h3>
				</div>
			</div>
			</center>
		</div>

		<div class="row">
			<center>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-id-card fa-2x"></i></h2>
					<br>Anagrafiche registrate nel sistema: 
					<h3><b><?php echo $numanagrafiche[0]; ?></b></h3>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-users fa-2x"></i></h2>
					<br>Utenti abilitati all'utilizzo del software: 
					<h3><b><?php echo $numutenti[0] - 1; ?></b></h3>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-sign-in fa-2x"></i></h2>
					<br>Numero di accessi eseguiti nel sistema: 
					<h3><b><?php echo $numaccessi; ?></b></h3>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-envelope fa-2x"></i></h2>
					<br>Numero di email inviate dal sistema: 
					<h3><b><?php echo $numemail[0]; ?></b></h3>
				</div>
			</div>

		</div>
	</div>
</div>