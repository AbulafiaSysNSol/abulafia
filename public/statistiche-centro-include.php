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
		<h3 class="panel-title"><strong><i class="fa fa-bar-chart"></i> Un po' di numeri di <?php echo $_SESSION['nomeapplicativo'];?></strong></h3>
	</div>
			
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-5">
				<i class="fa fa-calendar"></i>
				<?php 
					echo $_SESSION['nomeapplicativo'] . ' e\' in uso da <b>'; 
					if( (int)$anniusoapplicazione > 0) { 
						echo (int)$anniusoapplicazione . ' anni e ' .(int)$giorniusoapplicazione.' giorni</b>;'; 
					} 
					else { 
						echo (int)$giorniusoapplicazione.' giorni</b>;'; 
					} 
				?>
				<br><br>
				<i class="fa fa-book"></i> Sono state registrate <b><?php echo $numprot; ?></b> lettere, di cui:
				<div class="row">
					<div class="col-md-6 col-md-offset-1">
						<ul>
						<?php
						foreach($numanni as $anno => $numerolettere ) {
							echo '<li><b>' . $numerolettere . '</b> nel ' . $anno . ';</li>';
						}
						?>
						</ul>
					</div>
				</div>
				<i class="fa fa-file-text-o"></i> Sono state scritte <b><?php echo $numlettere[0]; ?></b> lettere;
				<br><br>
				<i class="fa fa-paperclip"></i> Sono stati caricati <b><?php echo $numallegati[0]; ?></b> allegati;
				<br><br>
				<i class="fa fa-group"></i> Sono presenti <b><?php echo $numanagrafiche[0]; ?></b> anagrafiche;
				<br><br>
				<i class="fa fa-male"></i> Sono presenti <b><?php echo $numutenti[0]; ?></b> utenti;
				<br><br>
				<i class="fa fa-sign-in"></i> Sono stati eseguiti <b><?php echo $numaccessi; ?></b> accessi;
				<br><br>
				<i class="fa fa-envelope-o"></i> Sono state inviate <b><?php echo $numemail[0]; ?></b> email;
			</div>
			
			<div class="col-xs-7">
				<img src="images/stats.jpg">
			</div>
		</div>
	</div>
</div>