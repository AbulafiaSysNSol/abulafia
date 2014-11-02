<?php
	if ($_SESSION['auth'] < 90) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b><span class="glyphicon glyphicon-wrench"></span> Diagnostica</b></h3>
	</div>
  
	<div class="panel-body">
	<div class="row">
	<div class="col-md-4">
		<h4><i class="fa fa-book"></i> Ricerca anomalie in Protocollo:</h4>
		<ul>
			<div class="row">
				<div class="cols-md-11 col-md-offset-1">
					<li><a href="login0.php?corpus=protocollo-cerca-anomalie&filtro=doppiomittente">Mittente non univoco;</a></li>
				</div>
			</div>
		</ul>
	</div>
		
	<div class="col-md-4">	
		<h4><i class="fa fa-users"></i> Ricerca anomalie in Anagrafica:</h4>
		<ul>
			<div class="row">
				<div class="cols-md-11 col-md-offset-1">
					<li><a href="login0.php?corpus=anagrafica-cerca-anomalie&filtro=cognomenome">"Cognome + Nome" duplicato;</a></li>
				</div>
			</div>
		</ul>
	</div>
	
	<div class="col-md-4">
		<h4><i class="fa fa-envelope-o"></i> Test Email:</h4>
		<ul>
			<div class="row">
				<div class="cols-md-11 col-md-offset-1">
					<li><a href="login0.php?corpus=test-mailserver" onclick="loading();">Test server mail;</a></li>
				</div>
			</div>
		</ul>
		<div id="connect" style="display: none;"><i class="fa fa-circle-o-notch fa-spin"></i> Connessione al server mail in corso...</div>
	</div>
	</div>
		
	</div>
</div>

<script language="javascript">
  function loading() {
	document.getElementById("connect").style.display="table";
  }
</script> 
