<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-envelope"></span> Log delle ultime 20 email</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '20', ' ', $_SESSION['maillog']);//legge dal log delle email inviate
			?>
			</p>
			<br><b><a href="download.php?lud=mail.log&est=log"><i class="fa fa-download"></i> Scarica il log delle mail</a></b>

		</div>
				
</div>