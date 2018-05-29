<?php
	
	$_SESSION['block'] = false;
	$data = new Calendario();
	$lettera = new Lettera();
	$e = new Mail();
	$a = new Anagrafica();
		
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

	/*if (!$e->isSetMail()) {
		?>
		<center><h4><div class="alert alert-warning"><i class="fa fa-warning"></i> <b>Attenzione:</b> per poter inviare email bisogna configurare il server mail in <a href="?corpus=server-mail">questa pagina</a>.</div></h4></center>
		<?php
	}*/

	if (!$a->profileIsUpdate($_SESSION['loginid'])) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=modale-profilo&id=<?php echo $_SESSION['loginid'];?>";
		</script>
		<?php
	}
	
	if (isset($_GET['aggiornamento']) && ($_GET['aggiornamento'] == 'ok')) {
		?>
			<div class="alert alert-info">
			<center><h3><b><i class="fa fa-refresh"></i> Aggiornamento di Sistema - Ver. 11.5</b></h3></center>
			<br><h4><b>Modifiche introdotte con l'aggiornamento:</b></h4>
			Upload Multipli:  &egrave; adesso possibile caricare contemporaneamente pi&ugrave; file alla volta durante la registrazione di un protocollo, basta selezionarne pi&ugrave; di uno dopo aver cliccato sul pulsante "scegli file";
			<br><br>
			<small>Se notate anomalie o malfunzionamenti comunicateceli mediante la <a href="login0.php?corpus=segnala-bug">pagina di segnalazione errori.</a></small>
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
				echo '<a href="?corpus=modifica-anagrafica&from=home&id=' . $_SESSION['loginid'] . '"><center><img class="img-circle" width="90%" src="' . $a->getFoto($_SESSION['loginid']) .'"></center></a>';
				echo '<br>ID: <b>' . $_SESSION['loginid'] . '</b>';
				echo '<br><br>Nome: <b>' . $a->getNome($_SESSION['loginid']) . '</b>';
				echo '<br><br>Cognome: <b>' . $a->getCognome($_SESSION['loginid']) . '</b>';
				echo '<br><br>C.F.: <b>' . $a->getCodiceFiscale($_SESSION['loginid']) . '</b>';
				?>
				<hr>
				<a href="?corpus=modifica-anagrafica&from=home&id=<?php echo $_SESSION['loginid']?>"><i class="fa fa-edit fa-fw"></i> Modifica Profilo</a>
				<br><br><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>"><i class="fa fa-key fa-fw"></i> Gestione Credenziali</a>
				<br><br><a href="login0.php?corpus=settings"><i class="fa fa-cog fa-fw"></i> Impostazioni Utente</a>
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
				<h3 class="panel-title"><strong><i class="fa fa-calendar-check-o"></i> Azioni Richieste:</strong></h3>
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

				?>
			</div>
		</div>

		<!-- blocco destro -->

	</div>
</div>

<?php 
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