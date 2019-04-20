<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-time"></span> Log integrale delle ultime 100 interazioni</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '100', ' ', $_SESSION['logfile']);//legge dal log
			?>
			</p>
			<br>
			<center><a class="btn btn-success btn-sm" href="download.php?lud=general.log&est=log"><i class="fa fa-download"></i> Scarica questo LOG completo</a></b></center>

		</div>
				
</div>