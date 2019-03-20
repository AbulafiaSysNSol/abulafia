<?php
	
	$_SESSION['block'] = false;
	$data = new Calendario();
	$lettera = new Lettera();
	$amb = new Ambulatorio();
	$e = new Mail();
	$a = new Anagrafica();
	$anno = $_SESSION['annoprotocollo'];
	$annoprotocollo = $_SESSION['annoprotocollo'];
/*deprecato	$lettereinlavorazione = mysql_query("SELECT COUNT(*) FROM comp_lettera WHERE protocollo = 0");
	$numerolettere=mysql_fetch_row($lettereinlavorazione); */
	try 
		{
   		$connessione->beginTransaction();
		$query = $connessione->prepare('SELECT count(*) 
						from comp_lettere 
						where protocollo=0
						'); 
		$query->execute();
		$connessione->commit();
		} 
		
		//gestione dell'eventuale errore della connessione
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
		}

	$risultati = $query->fetchAll();
	$numerolettere=$risultati[0];


		
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
		<center><h4><div class="alert alert-info"><i class="fa fa-check"></i> Impostazioni email salvate <b>correttamente!</b></div></h4></center>
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

				if(($a->isLettere($_SESSION['loginid'])) && ($numerolettere[0] > 0)) {
					echo '<center><div class="alert alert-info"><b><h4><i class="fa fa-wrench"></i> In Lavorazione:</b></h4>';
					if($numerolettere[0] == 1) {echo 'C\'&egrave; ';} else {echo 'Ci sono ';} 
					echo '<h2><b>' . $numerolettere[0] . '</b></h2>';
					if($numerolettere[0] == 1) {echo 'lettera ';} else {echo 'lettere ';}
					echo '<a href="?corpus=elenco-lettere">in lavorazione</a>.</div></center>';
					$todo = 1;
				}

				if(($a->isLettere($_SESSION['loginid'])) && ($_SESSION['dafirmare'] > 0)) {
					echo '<center><div class="alert alert-info"><b><h4><i class="fa fa-pencil"></i> Da Firmare:</b></h4>';
					if($_SESSION['dafirmare'] == 1) {echo 'C\'&egrave; ';} else {echo 'Ci sono ';} 
					echo '<h2><b>' . $_SESSION['dafirmare'] . '</b></h2>';
					if($_SESSION['dafirmare'] == 1) {echo 'lettera ';} else {echo 'lettere ';}
					echo '<a href="?corpus=elenco-lettere-firma">da firmare</a>.</div></center>';
					$todo = 1;
				}

				if(($a->isLettere($_SESSION['loginid'])) && ($_SESSION['daprotocollare'] > 0)) {
					echo '<center><div class="alert alert-warning"><b><h4><i class="fa fa-book"></i> Da Protocollare:</b></h4>';
					if($_SESSION['daprotocollare'] == 1) {echo 'C\'&egrave; ';} else {echo 'Ci sono ';} 
					echo '<h2><b>' . $_SESSION['daprotocollare'] . '</b></h2>';
					if($_SESSION['daprotocollare'] == 1) {echo 'lettera ';} else {echo 'lettere ';}
					echo '<a href="?corpus=elenco-lettere">da protocollare</a>.</div></center>';
					$todo = 1;
				}

				if(($a->isAmbulatorio($_SESSION['loginid'])) && ($amb->countRichieste() > 0)) {
					$certificati = $amb->countRichieste();
					echo '<center><div class="alert alert-warning"><b><h4><i class="fa fa-medkit"></i> Certificati Medici:</b></h4>';
					if($certificati == 1) {echo 'C\'&egrave; ';} else {echo 'Ci sono ';} 
					echo '<h2><b>' . $certificati . '</b></h2>';
					if($certificati == 1) {echo 'certificato ';} else {echo 'certificati ';}
					echo '<a href="?corpus=cert-list-richieste">da emettere</a>.</div></center>';
					$todo = 1;
				}

				if($todo == 0) {
					echo '<center><div class="alert alert-success"><b><h4><i class="fa fa-check"></i> Ben Fatto!</b></h4>Nessuna azione richiede la tua attenzione.</center>';
				}

				if (!$e->isSetMail()) {
					echo '<center><div class="alert alert-info"><b><h4><i class="fa fa-envelope"></i> Invio Email</b></h4>per poter inviare email bisogna configurare le impostazioni in <a href="?corpus=server-mail">questa pagina</a>.</div></center>';
				}

				?>
			</div>
		</div>

		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-hdd-o"></i> Spazio Archiviazione:</strong></h3>
			</div>
			
			<div class="panel-body">
				<?php
				$file = new File();
				$dim =  round($file->sizeDirectory("../public/") / (1024*1024), 2) ;
				$max = $_SESSION['quota'];
				$percentuale = ( $dim / $max ) * 100;
				if($percentuale <=50)
					$class = "progress-bar-success";
				else if($percentuale <=80)
					$class = "progress-bar-warning";
				else
					$class = "progress-bar-danger";
				?>
				<div class="progress">
					<div class="progress-bar <?php echo $class; ?>" role="progressbar" aria-valuenow="<?php echo $dim; ?>" aria-valuemin="0" aria-valuemax="<?php echo $max; ?>" style="width: <?php echo $percentuale; ?>%;">
					</div>
				</div>
				<center><?php echo $file->unitaMisura($dim).' su ' . $file->unitaMisura($max) . ' (' . round($percentuale,2).'%)'; ?></center>
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
					echo "<tr><td><b>N.</b></td><td><b>DATA</b></td><td><b>OGGETTO</b></td></tr>";
					foreach ($risultati as $val) {
						if($val[3]=='spedita') {
							$icon = '<i class="fa fa-arrow-up fa-fw"></i> ';
						}
						else {
							$icon = '<i class="fa fa-arrow-down fa-fw"></i> ';
						}
						echo "	<tr>
								<td><a href=\"?corpus=dettagli-protocollo&id=".$val[0]."&anno=".$anno."\">".$icon.$val[0]."</a></td>
								<td><a href=\"?corpus=dettagli-protocollo&id=".$val[0]."&anno=".$anno."\">".$data->dataSlash($val[1])."</a></td>
								<td><a href=\"?corpus=dettagli-protocollo&id=".$val[0]."&anno=".$anno."\">".$val[2]."</a></td>
								</tr>";
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
