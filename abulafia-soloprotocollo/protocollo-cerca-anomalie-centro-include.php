<?php
	$filtro=$_GET['filtro'];
	$lettera = new Lettera();
	$calendario = new Calendario;
	$anno = $_SESSION['annoprotocollo'];
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-bug"></i> Elenco delle presunte anomalie: <?php echo '('.$filtro.')';?></b></h3>
	</div>
  
	<div class="panel-body">
     
		<?php
		if ($filtro == 'doppiomittente') { 
		
			?> <!--inizio scelta filtro ='cognomenome'-->

			<table class="table table-bordered">
				<tr>
					<td align="center"><b>Prot. N.</td>
					<td align="center"><b>Data</td>
					<td align="center"><b>N. Mittenti</td>
					<td><b>Mittenti</td>
				</tr>

			<?php
				$risultati= mysql_query("select * from lettere$anno WHERE lettere$anno.speditaricevuta='ricevuta'");

				if (!$risultati) {
					echo 'Nessun risultato dalla query';
				}

				while ($row = mysql_fetch_array($risultati)) {
					$nummitt = $lettera->contaMittenti($row['idlettera'], $anno);
					if($nummitt > 1) {
						?>
						<tr>
							<td align="center"><a href="login0.php?corpus=dettagli-protocollo&id=<?php echo $row['idlettera'];?>"><?php echo $row['idlettera']; ?></td>
							<td align="center" valign="middle"><?php echo $calendario->dataSlash($row['datalettera']); ?></td>
							<td align="center" valign="middle"><?php echo $nummitt; ?></td>
							<td valign="middle">
								<?php
								$mittenti = $lettera->getMittenti($row['idlettera'],$anno);
								foreach($mittenti as $valore) {
									?>
									<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $valore['idanagrafica'];?>"> 
										<?php echo ucwords(stripslashes($valore['nome']) . '  ' . stripslashes($valore['cognome']) . ';');?>
									</a>
									<?php
								}
								?>
							</td>
						</tr>
						<?php
					}
				}
			?>
			</table>
			<?php 
		} //fine scelta filtro ='cognomenome'-->
		?>
		<a href="login0.php?corpus=diagnostica"><b><i class="fa fa-arrow-left"></i> Indietro</b></a>
	</div>
</div>