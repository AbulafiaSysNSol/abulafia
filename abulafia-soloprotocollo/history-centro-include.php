<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-time"></span> Log delle ultime 40 azioni</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '40', ' ', $_SESSION['historylog']);//legge dal log delle email inviate
			?>
			</p>
			<br><a href="download.php?lud=log/history.log&est=log">Scarica il log di tutte le azioni</a>

		</div>
				
</div>