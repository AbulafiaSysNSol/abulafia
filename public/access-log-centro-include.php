<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-key"></i> Log degli ultimi 50 accessi</strong></h3>
	</div>
	
	<div class="panel-body">
		<p>
			<?php 
				$my_log->publleggilog('0', '50', 'access', $_SESSION['logfile']); //legge dal log degli accessi
			?>
		</p>

		<form action="download-on-the-fly.php" method="post">
   			<input type="hidden" name="textonthefly" value="<?php print(base64_encode(serialize($my_log->righefiltrate))); ?>">
			<input type="hidden" name="logname" value="Access LOG">
			<input type="hidden" name="filename" value="access-log.txt">
			<br>
   			<center><button class="btn btn-success btn-sm" type="submit" name="submit_parse"><i class="fa fa-download fa-fw"></i> Scarica questo LOG completo</button></center>
		</form>
	</div>
				
</div>


