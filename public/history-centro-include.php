<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-time"></span> Log delle ultime 50 azioni</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '50', ' ', $_SESSION['page request']);//legge dal log
			?>
			</p>
			<br><b><a href="download.php?lud=history.log&est=log"><i class="fa fa-download"></i> Scarica il log di tutte le azioni</a></b>

		</div>
				
</div>
