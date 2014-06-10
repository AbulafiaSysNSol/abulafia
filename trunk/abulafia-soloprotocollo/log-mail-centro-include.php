<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-envelope"></span> Log delle ultime 15 email</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '15', ' ', $_SESSION['maillog']);//legge dal log delle email inviate
			?>
			</p>
			<br><a href="download.php?lud=log/mail.log&est=log">Scarica il log delle mail</a>

		</div>
				
</div>