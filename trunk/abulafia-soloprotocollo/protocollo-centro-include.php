<?php
//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
if ($_SESSION['auth'] < 20) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>

<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Registrazione nuovo protocollo</strong></h3>
		</div>
		<div class="panel-body">
			<p><a href="login0.php?corpus=protocollo2&from=crea"><span class="glyphicon glyphicon-plus"></span> Crea nuovo numero progressivo</a></p>
		</div>
		
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Registro di protocollo</strong></h3>
		</div>
		<div class="panel-body">
			<p><a href="login0.php?corpus=stampa-registro"><span class="glyphicon glyphicon-print"></span> Stampa il registro</a></p>
		</div>
		
		<?php if ($_SESSION['auth'] > 98) {?>
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Titolario</strong></h3>
		</div>
		<div class="panel-body">
			<p><a href="login0.php?corpus=titolario"><span class="glyphicon glyphicon-list"></span> Gestione posizioni</a></p>
		</div>
		<?php } ?>
		
</div>