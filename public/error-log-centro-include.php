<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-warning"></i> Log degli ultimi 50 errori</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			<?php 
				$my_log->publleggilog('0', '50', 'error', $_SESSION['logfile']); //legge dal log degli accessi
			?>
			</p>
			<br><b><a href="download.php?lud=access.log&est=log"><i class="fa fa-download"></i> Scarica il log degli errori</a></b>

		</div>
				
</div>