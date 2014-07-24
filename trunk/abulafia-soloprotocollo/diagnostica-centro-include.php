<?php
	if ($_SESSION['auth'] < 90) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b><span class="glyphicon glyphicon-wrench"></span> Diagnostica</b></h3>
	</div>
  
	<div class="panel-body">
		<h4><i class="fa fa-users"></i> Ricerca anomalie in Anagrafica:</h4>
		<ul>
			<div class="row">
				<div class="cols-md-11 col-md-offset-1">
					<li><a href="login0.php?corpus=anagrafica-cerca-anomalie&filtro=cognomenome">"Cognome + Nome" duplicato;</a></li>
				</div>
			</div>
		</ul>
	</div>
</div>