<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-time"></span> Log integrale delle ultime 50 registrazioni</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '20', ' ', $_SESSION['logfile']);//legge dal log
			?>
			</p>
			<br><b><a href="download.php?lud=general.log&est=log"><i class="fa fa-download"></i> Scarica il log integrale di tutte le azioni</a></b>

		</div>
				
</div>
