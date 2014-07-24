<?php
	$filtro=$_GET['filtro'];
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-bug"></i> Elenco delle presunte anomalie: <?php echo '('.$filtro.')';?></b></h3>
	</div>
  
	<div class="panel-body">
     
		<?php
		if ($filtro == 'cognomenome') { 
		
			?> <!--inizio scelta filtro ='cognomenome'-->

			<table class="table table-bordered">
				<tr>
					<td><b>ID</td>
					<td><b>Cognome</td>
					<td><b>Nome</td>
					<td><b>Data di Nascita</td>
				</tr>

			<?php
				$risultati= mysql_query("select * from anagrafica order by anagrafica.cognome, anagrafica.nome");

				if (!$risultati) {
					echo 'Nessun risultato dalla query';
				}

				while ($row = mysql_fetch_array($risultati)) { //inizio ciclo while1
					$cognome= $row['cognome'];
					$nome= $row['nome'];
					$id= $row['idanagrafica'];
					$datagrezza=$row['nascitadata'];
					$datadinascita= list($anno, $mese, $giorno) = explode("-", $datagrezza);
					$datadinascita2 = "$giorno-$mese-$anno";
					$verificaduplicati= mysql_query("select COUNT(*) from anagrafica where anagrafica.cognome='$cognome' and anagrafica.nome='$nome'");
					$res_count=mysql_fetch_row($verificaduplicati);
					
					if ($res_count[0] > 1) { //caso in cui il gruppo cognome+nome risulti duplicato - primo if
						?>
						<tr>
							<td><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $id ;?>"><?php echo $id; ?></td>
							<td valign="middle"><?php echo $cognome; ?></td>
							<td valign="middle"><?php echo $nome; ?></td>
							<td  valign="middle"><?php echo $datadinascita2; ?></td>
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