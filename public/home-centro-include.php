<?php
	
	$_SESSION['block'] = false;
	$data = new Calendario();
	$lettera = new Lettera();
	$e = new Mail();
	$a = new Anagrafica();
	$anno = $_SESSION['annoprotocollo'];
	$annoprotocollo = $_SESSION['annoprotocollo'];
		
	if (isset($_GET['firma']) &&($_GET['firma'] == 'ok')) {
		?>
		<center><h4><div class="alert alert-success"><i class="fa fa-check"></i> Lettera sottoposta alla firma <b>correttamente!</b></div></h4></center>
		<?php
	}

	if (isset($_GET['profile']) &&($_GET['profile'] == 'ok')) {
		?>
		<center><h4><div class="alert alert-success"><i class="fa fa-check"></i> Profilo aggiornato <b>correttamente!</b> E adesso possibile riprendere l'uso del software.</div></h4></center>
		<?php
	}
	
	if (isset($_GET['email']) &&($_GET['email'] == 'ok')) {
		?>
		<center><h4><div class="alert alert-info"><i class="fa fa-check"></i> Impostazioni server mail salvate <b>correttamente!</b></div></h4></center>
		<?php
	}

	if (!$a->profileIsUpdate($_SESSION['loginid'])) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=modale-profilo&id=<?php echo $_SESSION['loginid'];?>";
		</script>
		<?php
	}
	
	if (isset($_GET['aggiornamento']) && ($_GET['aggiornamento'] == 'ok')) {
		?>
		<div class="row">
			
			<div class="col-sm-3">
				<div class="alert alert-info">
				<center><h3><b><i class="fa fa-refresh"></i> Aggiornamento di Sistema Versione 11.8</b></h3>
				<br><h4><b>Modifiche introdotte con l'aggiornamento:</b></h4>
				- Modificata la grafica dell'home page;<br>
				- Migliorata la visualizzazione in versione mobile;<br>
				<br>
				<small>Se notate anomalie o malfunzionamenti comunicateceli mediante la <a href="login0.php?corpus=segnala-bug">pagina di segnalazione errori.</a></small>
				</center></div>
			</div>

			<div class="col-sm-9">
				<div class="alert alert-warning">
				<center><h3><b><i class="fa fa-exclamation-triangle"></i> Comunicazione Importante</b></h3>
				<br><h4><b>Abulafia diventa Abulafia Web!</b></h4></center>
				<div style="text-align: justify;">Gentile Utente,<br>
				come avrai notato il progetto Abulafia sta subendo alcuni cambiamenti;
				stiamo apportando modifiche alla struttura per renderla pi&ugrave; performante ed efficiente, rimanendo al passo
				con i tempi e con le nuove tecnologie.
				Al momento per te cambia solo il link d'accesso al software.<br>
				Per maggiori informazioni puoi contattarci all'indirizzo email <b>info@abulafiaweb.it</b> o visitare
				il nostro <b><a href="http://abulafiaweb.it" target="_blank">sito web</a></b>.
				<br>
				Verrai informato di futuri cambiamenti che necessiteranno di una tua azione.<br><br>
				Il nuovo link per accedere al software per la tua associazione &egrave;<br><br>
				<center><h4><b><?php echo $_SESSION['paginaprincipale']; ?></h4></b></center>
				<small>*Tutti gli altri indirizzi verranno a breve dismessi, quindi ti preghiamo di aggiornare i tuoi
					segnalibri/preferiti usando il nuovo link.</small>
				</div>
				</div>
			</div>

		</div>
		<?php
	}
	?>
	
<div class="row">
	
	<div class="col-sm-3">		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-user-circle"></i> Profilo Utente:</strong></h3>
			</div>

			<div class="panel-body">
				<?php
				echo '<br><a href="?corpus=modifica-anagrafica&from=home&id=' . $_SESSION['loginid'] . '"><center><img class="img-circle" width="65%" src="' . $a->getFoto($_SESSION['loginid']) .'"></center></a>';
				echo '<br><br><div style="line-height: 2;">Nome: <b>' . $a->getNome($_SESSION['loginid']) . '</b></div>';
				echo '<div style="line-height: 2;">Cognome: <b>' . $a->getCognome($_SESSION['loginid']) . '</b></div>';
				echo '<div style="line-height: 2;">C.F.: <b>' . $a->getCodiceFiscale($_SESSION['loginid']) . '</b></div>';
				?>
				<hr>
				<div style="line-height: 1.8;"><a href="?corpus=modifica-anagrafica&from=home&id=<?php echo $_SESSION['loginid']?>"><i class="fa fa-edit fa-fw"></i> Modifica Profilo</a></div>
				<div style="line-height: 1.8;"><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>"><i class="fa fa-key fa-fw"></i> Gestione Credenziali</a></div>
				<div style="line-height: 1.8;"><a href="login0.php?corpus=settings"><i class="fa fa-cog fa-fw"></i> Impostazioni Utente</a></div>
			</div>
		</div>
	</div>
	

	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-calendar"></i> Calendario:</strong></h3>
			</div>
			
			<div class="panel-body">
				<div id='calendar'></div>
			</div>
		</div>
	</div>

	<div class="col-sm-3">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-calendar-check-o"></i> Avvisi/Reminder:</strong></h3>
			</div>
					
			<div class="panel-body">		
				<?php

				$todo = 0;

				if(isset($_GET['pass']) && ($_GET['pass'] == 1)) {
					echo '<center><div class="alert alert-warning"><b><h4><i class="fa fa-exclamation-triangle"></i> Attenzione</b></h4>Necessario modificare la password di default.<br><a href="?corpus=cambio-password&loginid='. $_SESSION['loginid'] . '">Clicca per modificare</a></div></center>';
					$todo = 1;
				}

				if($todo == 0) {
					echo '<center><div class="alert alert-success"><b><h4><i class="fa fa-check"></i> Ben Fatto!</b></h4>Nessuna azione richiede la tua attenzione.</center>';
				}

				if (!$e->isSetMail()) {
					echo '<center><div class="alert alert-info"><b><h4><i class="fa fa-exclamation-triangle"></i> Invio Email</b></h4>per poter inviare email bisogna configurare il server mail in <a href="?corpus=server-mail">questa pagina</a>.</div></center>';
				}

				?>
			</div>
		</div>

		<!-- blocco destro -->

	</div>
</div>

<!-- blocco ultimi protocolli registrati -->
<?php 
if($a->isProtocollo($_SESSION['loginid'])) { ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><strong><i class="fa fa-list-ul"></i> Ultimi protocolli registrati:</strong></h3>
		</div>
				
		<div class="panel-body">
			<?php
				$risultati = $lettera->ultimeLettere(7, $anno);
			?>
			<table class="table table-striped">
				<?php
				if($risultati) {
					echo "<tr><td></td><td><b>NUM.</b></td><td><b>DATA</b></td><td><b>OGGETTO</b></td><td></td></tr>";
					foreach ($risultati as $val) {
						if($val[3]=='spedita') {
							$icon = '<i class="fa fa-arrow-up"></i>';
						}
						else {
							$icon = '<i class="fa fa-arrow-down"></i>';
						}
						echo "<tr><td>".$icon."</td><td>".$val[0]."</td><td>".$data->dataSlash($val[1])."</td><td>".$val[2]."</td>
							<td width='55'><a href=\"?corpus=dettagli-protocollo&id=".$val[0]."&anno=".$anno."\">Vai <i class=\"fa fa-share\"></i></td></tr>";
					}
				}
				?>
			</table>
		</div>
	</div>
	<?php
}

if($a->isAdmin($_SESSION['loginid'])) { ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong><span class="glyphicon glyphicon-calendar"></span> Log degli ultimi 5 accessi:</strong></h3>
				</div>
						
				<div class="panel-body">
					<p><?php $my_log -> publleggilog('1', '5', 'login', $_SESSION['logfile']); //legge dal log degli accessi ?></p>
				</div>
			</div>
		</div>
	</div>
	<?php
}	
$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO HOME' , 'OK' , $_SESSION['ip'], $_SESSION['historylog']);
?>