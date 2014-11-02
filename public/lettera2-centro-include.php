<?php
	$calendario = new Calendario();
	
	$id = $_GET['id'];
	$lettera = mysql_query(" SELECT * FROM comp_lettera WHERE id = $id ");
	$datilettera = mysql_fetch_row($lettera);
	$data = $datilettera[3];
	$allegati = $datilettera[6];
	$testo = $datilettera[5];
	$oggetto = $datilettera[4];

?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><span class="glyphicon glyphicon-pencil"></span> Componi Lettera - STEP 2: Aggiungi destinatari</b></h3>
	</div>
	
	<div class="panel-body">
	
		<div class="row">		
			<script type="text/javascript" src="livesearch-cerca-destinatario.js"></script>
			<div class="col-xs-6">
				<h5><i class="fa fa-search"></i> Cerca destinatari:</h5>
				<input class="form-control input-sm" type="text" name="valore" placeholder="ricerca destinatario per cognome o ragione sociale..." onkeyup="showResult(this.value,<?php echo $id;?>,0)">
				<div id="livesearch"></div>
				<br><h5><i class="fa fa-users"></i> Destinatari attuali:</h5>
				
				<?php
					$query = mysql_query(	"SELECT anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, comp_destinatari.conoscenza, comp_destinatari.attributo
									FROM anagrafica, comp_destinatari
									WHERE anagrafica.idanagrafica = comp_destinatari.idanagrafica
									AND comp_destinatari.idlettera = '$id'
									AND comp_destinatari.conoscenza = 0");
					echo '<table class="table table-bordered">';
					while ($dest = mysql_fetch_array($query)) {
						?>
						<script type="text/javascript" src="livesearch-cambia-attributo.js"></script>
						<tr><td style="vertical-align: middle" align="center">
						<select class="form-control input-sm" onChange="changeAttr(<?php echo $dest['idanagrafica']; ?>,<?php echo $id;?>,this.value)">
							<option value="<?php echo $dest['attributo']; ?>"><?php echo $dest['attributo']; ?></option>
							<option value="Al ">Al:</option>
							<option value="Alla ">Alla:</option>
							<option value="Agli ">Agli:</option>
							<option value="Ai ">Ai:</option>
							<option value="A ">A:</option>
							<option value="Al Volontario ">Al Volontario:</option>
							<option value="Alla Volontaria ">Alla Volontaria:</option>
							<option value="Ai Volontari ">Ai Volontari:</option>
							<option value="A Tutti i ">A Tutti i:</option>
							<option value="Spett.">Spett.:</option>
							<option value=""></option>
						</select>
						</td>
						<td style="vertical-align: middle">
						<?php
						echo stripslashes($dest['cognome'] . ' ' . $dest['nome']) . '</td><td style="vertical-align: middle"><a href="comp-lettera-elimina-destinatario.php?idanagrafica=' . $dest['idanagrafica'] . '&idlettera=' . $id . '&conoscenza=' . $dest['conoscenza'] . '"><i class="fa fa-trash-o"></i> elimina</a>';
						echo '</td></tr>';
					}
					echo '</table>';
				?>
				
			</div>
			
			<div class="col-xs-6">
				<h5><i class="fa fa-search"></i> Cerca destinatari per conoscenza:</h5>
				<input class="form-control input-sm" type="text" name="valore" placeholder="ricerca destinatario per cognome o ragione sociale..." onkeyup="showResult(this.value,<?php echo $id;?>,1)">
				<div id="livesearch2"></div>
				<br><h5><i class="fa fa-users"></i> Destinatari per conoscenza attuali:</h5>
				
				<?php
					$query = mysql_query(	"SELECT anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, comp_destinatari.conoscenza, comp_destinatari.attributo
									FROM anagrafica, comp_destinatari
									WHERE anagrafica.idanagrafica = comp_destinatari.idanagrafica
									AND comp_destinatari.idlettera = '$id'
									AND comp_destinatari.conoscenza = 1");
					echo '<table class="table table-bordered">';
					while ($dest = mysql_fetch_array($query)) {
						?>
						<script type="text/javascript" src="livesearch-cambia-attributo.js"></script>
						<tr><td style="vertical-align: middle" align="center">
						<select class="form-control input-sm" onChange="changeAttr(<?php echo $dest['idanagrafica']; ?>,<?php echo $id;?>,this.value)">
							<option value="<?php echo $dest['attributo']; ?>"><?php echo $dest['attributo']; ?></option>
							<option value="Al ">Al:</option>
							<option value="Alla ">Alla:</option>
							<option value="Agli ">Agli:</option>
							<option value="Ai ">Ai:</option>
							<option value="A ">A:</option>
							<option value="Al Volontario ">Al Volontario:</option>
							<option value="Alla Volontaria ">Alla Volontaria:</option>
							<option value="Ai Volontari ">Ai Volontari:</option>
							<option value="A Tutti i ">A Tutti i:</option>
							<option value="Spett. ">Spett.:</option>
							<option value=""></option>
						</select>
						</td>
						<td style="vertical-align: middle">
						<?php
						echo stripslashes($dest['cognome'] . ' ' . $dest['nome']) . '</td><td style="vertical-align: middle"><a href="comp-lettera-elimina-destinatario.php?idanagrafica=' . $dest['idanagrafica'] . '&idlettera=' . $id . '&conoscenza=' . $dest['conoscenza'] . '"><i class="fa fa-trash-o"></i> elimina</a>';
						echo '</td></tr>';
					}
					echo '</table>';
				?>
			</div>
		</div>
		
		<a href="?corpus=modifica-lettera&idlettera=<?php echo $id; ?>&from=lettera2"><button class="btn btn-warning btn-lg" type="button"><i class="fa fa-arrow-left"></i> Torna ai dettagli</button></a>
		<a class="fancybox" data-fancybox-type="iframe" href="componilettera.php?id=<?php echo $id; ?>"><button class="btn btn-info btn-lg" type="button"><i class="fa fa-file-o"></i> Anteprima Lettera</button></a>
		<?php if($_SESSION['auth'] < 100) { ?>
			<a href="sottoponi-lettera-firma.php?idlettera=<?php echo $id; ?>"><button class="btn btn-success btn-lg" type="button"><i class="fa fa-check"></i> Manda alla firma</button></a>
		<?php } else { ?>
			<a href="firma-lettera.php?id=<?php echo $id; ?>&from=elenco-lettere"><button class="btn btn-success btn-lg" type="button"><i class="fa fa-pencil"></i> Firma</button></a>
		<?php } ?>
	</div>
</div>

