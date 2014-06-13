<?php
	if(isset($_GET['pass']) && ($_GET['pass'] == 1)) {
		echo '<center><div class="alert alert-warning"><b><i class="fa fa-exclamation-triangle"></i> Attenzione:</b> non hai ancora modificato la tua password di default!<br>
			Per questioni di sicurezza ti invitiamo a cambiarla al più presto. <a href="?corpus=cambio-password&loginid='. $_SESSION['loginid'] . '">Cambia la tua password ora</a></div></center>';
	}
	$data = new Calendario();
	$lettera = new Lettera();
	$anno = $_SESSION['annoprotocollo'];
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$statslettere=mysql_query("select count(*) from lettere$annoprotocollo where datalettera != '0000/00/00'");
	$res_lettere = mysql_fetch_row($statslettere);
	$ultimoprot = $lettera->ultimoId($anno);
?>
<hr>
	<center>
		<h2>
			<i class="fa fa-calendar"></i>  Anno:<b> <?php echo $anno; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-book"></i>  Numero di protocollo attuale:<b> <?php echo $ultimoprot; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-text-o"></i>  Lettere registrate:<b> <?php echo $res_lettere[0]; ?></b>
		</h2>
	</center>
<hr>
<div class="row">
	<div class="col-xs-6">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><span class="glyphicon glyphicon-stats"></span> Stats:</strong></h3>
			</div>
			
			<div class="panel-body">
				<p><?php 
				$anniusoapplicazione = (strtotime("now") - strtotime("apr 1 2008"))/60/60/24/365;
				$giorniusoapplicazione = ((strtotime("now") - strtotime("apr 1 2008"))/60/60/24)-(int)$anniusoapplicazione*365;
				echo 'Questa web-application e\' in uso da '.(int)$anniusoapplicazione.' anni e '.(int)$giorniusoapplicazione.' giorni.';?></p>

					<p><?php 
					if ($res_lettere[0] > 0) {
					$statsusers1=mysql_query("select distinct * from users");
					echo 'Dettaglio lettere registrate: <br>';
					while ($statsusers2= mysql_fetch_array($statsusers1)) {
					$statsusers2a=$statsusers2['idanagrafica'];
					$statsusers3 = mysql_query("select count(*) from joinlettereinserimento$annoprotocollo where joinlettereinserimento$annoprotocollo.idinser = '$statsusers2a' AND datamod != '0000/00/00' ");
					$res_statsusers3 = mysql_fetch_row($statsusers3);
					if ($res_statsusers3[0] > 0) {
					echo ($res_statsusers3[0]).' inserite da '.$statsusers2['loginname'].'<br>';
					}
					}
					}?></p>

					<?php $statsanagrafica=mysql_query("select count(*) from anagrafica");
					$res_anagrafica = mysql_fetch_row($statsanagrafica);
					echo 'Nella tabella ANAGRAFICA sono presenti '.($res_anagrafica[0] - 1) .' occorrenze, di cui<br>';
					$my_anagrafica->publcontaanagrafica('persona');
					echo $my_anagrafica->contacomponenti.' persone fisiche<br>';
					$my_anagrafica->publcontaanagrafica('carica');
					echo $my_anagrafica->contacomponenti.' cariche o incarichi<br>';
					$my_anagrafica->publcontaanagrafica('ente');
					echo $my_anagrafica->contacomponenti.' enti<br>';
					$my_anagrafica->publcontaanagrafica('fornitore');
					echo $my_anagrafica->contacomponenti.' fornitori';
				    ?>
					
			</div>
		</div>
		
	</div>

	<div class="col-xs-6">
		
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-list-ul"></i> Ultimi protocolli registrati:</strong></h3>
			</div>
			
			<div class="panel-body">
				<?php
					$risultati = $lettera->ultimeLettere(5, $anno);
				?>
				<table class="table table-striped">
				<?php
				if($risultati) {
					echo "<tr><td></td><td><b>NUM.</b></td><td><b>DATA</b></td><td><b>OGGETTO</b></td><td></td></tr>";
					foreach ($risultati as $val) {
						if($val[3]=='spedita') {
							$icon = '<i class="fa fa-arrow-up"></i>';
						}
						else {
							$icon = '<i class="fa fa-arrow-down"></i>';
						}
						echo "<tr><td>".$icon."</td><td>".$val[0]."</td><td>".$data->dataSlash($val[1])."</td><td>".$val[2]."</td>
							<td width='55'><a href=\"?corpus=dettagli-protocollo&id=".$val[0]."\">Vai <i class=\"fa fa-share\"></i></td></tr>";
					}
				}
				?>
				</table>
			</div>
		
		</div>
		
	</div>
</div>

<div class="panel panel-default">
		
	<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-calendar"></span> Log degli ultimi 5 accessi:</strong></h3>
	</div>
			
	<div class="panel-body">
		<p><?php $my_log -> publleggilog('1', '5', 'login', $_SESSION['logfile']); //legge dal log degli accessi ?></p>
	</div>
	
</div>

<?php
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO HOME' , 'OK' , $_SESSION['ip'], $_SESSION['historylog']);
?>