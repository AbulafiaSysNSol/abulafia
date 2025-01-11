<?php
	$calendario = new Calendario();
	$lett = new Lettera();
	$id = $_GET['id'];
	$lettera = $connessione->query(" SELECT * FROM comp_lettera WHERE id = $id ");
	$datilettera = $lettera->fetch();
	$data = $datilettera[3];
	$allegati = $datilettera[6];
	$testo = $datilettera[5];
	$oggetto = $datilettera[4];
	$ufficio = $datilettera[10];
	$verificaDest = false;
	$verificaDestCon = false;

?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><span class="glyphicon glyphicon-pencil"></span> Componi Lettera - STEP 2: Aggiungi destinatari</b></h3>
	</div>
	
	<div class="panel-body">
	
		<div class="row">		
			<script type="text/javascript" src="livesearch-cerca-destinatario.js"></script>
			<div class="col-sm-6">
				<h5><i class="fa fa-search"></i> Cerca destinatari:</h5>
				<input class="form-control input-sm" type="text" name="valore" placeholder="ricerca destinatario per cognome o ragione sociale..." onkeyup="showResult(this.value,<?php echo $id;?>,0)">
				<div id="livesearch"></div>
				<br><h5><i class="fa fa-users"></i> Destinatari attuali:</h5>
				
				<?php
					$query = $connessione->query("SELECT anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, comp_destinatari.conoscenza, comp_destinatari.attributo, comp_destinatari.id, comp_destinatari.riga1, comp_destinatari.riga2
									FROM anagrafica, comp_destinatari
									WHERE anagrafica.idanagrafica = comp_destinatari.idanagrafica
									AND comp_destinatari.idlettera = '$id'
									AND comp_destinatari.conoscenza = 0");
					echo '<table class="table table-bordered">';
					$contatorelinee=0;
					$i=0;
					while ($dest = $query->fetch()) {
						$riga = 'riga'.$i;
						if ( $contatorelinee % 2 == 1 ) { 
							$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
						} //primo colore
						else { 
							$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
						} //secondo colore
						$contatorelinee = $contatorelinee + 1 ;
						?>
						<script type="text/javascript" src="livesearch-cambia-attributo.js"></script>
						<tr bgcolor=<?php echo $colorelinee; ?>>
							<td style="vertical-align: middle" align="center">
								<select class="form-control input-sm" onChange="changeAttr(<?php echo $dest['idanagrafica']; ?>,<?php echo $id;?>,this.value)">
									<option value="<?php echo $dest['attributo']; ?>"><?php echo $dest['attributo']; ?></option>
									<?php
									$attributi = $lett->getAttributi();
									foreach($attributi as $value) {
										echo '<option value="' . $value[0] . '">' . stripslashes($value[0]) . '</option>';
									}
									?>
									<option value=""></option>
								</select>
							</td>
							
							<td style="vertical-align: middle">
								<?php
								echo '<b>' . stripslashes($dest['cognome'] . ' ' . $dest['nome']) . '</b>';
								$verificaDest = true;
								?>
							</td>
							<td style="vertical-align: middle">
								<center>
									<a href="comp-lettera-elimina-destinatario.php?idanagrafica=<?php echo $dest['idanagrafica']; ?>&idlettera=<?php echo $id; ?>&conoscenza=<?php echo $dest['conoscenza']; ?>"><i class="fa fa-trash-o"></i></a>
								</center>
							</td>
						</tr>
						<script type="text/javascript" src="livesearch-riga-aggiuntiva.js"></script>
						<tr bgcolor=<?php echo $colorelinee; ?>>
							<td rowspan="2"></td>
							<td>
								<input class="form-control input-sm" type="text" id="<?php echo $riga; ?>" value="<?php echo $dest['riga1']; ?>">
							</td>
							<td style="vertical-align: middle">
								<center>
									<a href="javascript:inserisciRiga('1', '<?php echo $dest['id']; ?>', document.getElementById('<?php echo $riga; ?>').value)"><i class="fa fa-save"></i></a>
								</center>
							</td>
						</tr>
						<tr bgcolor=<?php echo $colorelinee; ?>>
							<?php $riga++; ?>
							<td>
								<input class="form-control input-sm" type="text" id="<?php echo $riga; ?>" value="<?php echo $dest['riga2']; ?>">
							</td>
							<td style="vertical-align: middle">
								<center>
									<a href="javascript:inserisciRiga('2', '<?php echo $dest['id']; ?>', document.getElementById('<?php echo $riga; ?>').value)"><i class="fa fa-save"></i></a>
								</center>
							</td>
						</tr>
					<?php
					$i=$i+2;
					}
					if(!$verificaDest) {
						echo "<br>Nessun destinatario inserito.";
					}
					echo '</table>';
				?>
				
			</div>
			
			<div class="col-sm-6">
				<h5><i class="fa fa-search"></i> Cerca destinatari per conoscenza:</h5>
				<input class="form-control input-sm" type="text" name="valore" placeholder="ricerca destinatario per cognome o ragione sociale..." onkeyup="showResult(this.value,<?php echo $id;?>,1)">
				<div id="livesearch2"></div>
				<br><h5><i class="fa fa-users"></i> Destinatari per conoscenza attuali:</h5>
				
				<?php
					$query = $connessione->query(	"SELECT anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, comp_destinatari.conoscenza, comp_destinatari.attributo, comp_destinatari.id, comp_destinatari.riga1, comp_destinatari.riga2
									FROM anagrafica, comp_destinatari
									WHERE anagrafica.idanagrafica = comp_destinatari.idanagrafica
									AND comp_destinatari.idlettera = '$id'
									AND comp_destinatari.conoscenza = 1");
					echo '<table class="table table-bordered">';
					$contatorelinee=1;
					while ($dest = $query->fetch()) {
						$riga = 'riga'.$i;
						if ( $contatorelinee % 2 == 1 ) { 
							$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
						} //primo colore
						else { 
							$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
						} //secondo colore
						$contatorelinee = $contatorelinee + 1 ;
						?>
						<script type="text/javascript" src="livesearch-cambia-attributo.js"></script>
						<tr bgcolor=<?php echo $colorelinee; ?>>
							<td style="vertical-align: middle" align="center">
								<select class="form-control input-sm" onChange="changeAttr(<?php echo $dest['idanagrafica']; ?>,<?php echo $id;?>,this.value)">
									<option value="<?php echo $dest['attributo']; ?>"><?php echo $dest['attributo']; ?></option>
									<?php
										$attributi = $lett->getAttributi();
										foreach($attributi as $value) {
											echo '<option value="' . $value[0] . '">' . stripslashes($value[0]) . '</option>';
										}
									?>
									<option value=""></option>
								</select>
							</td>
							<td style="vertical-align: middle">
								<?php
								echo '<b>'.stripslashes($dest['cognome'] . ' ' . $dest['nome']) . '</b></td>
								<td style="vertical-align: middle" align="center"><a href="comp-lettera-elimina-destinatario.php?idanagrafica=' . $dest['idanagrafica'] . '&idlettera=' . $id . '&conoscenza=' . $dest['conoscenza'] . '"><i class="fa fa-trash-o"></i></a>';
								$verificaDestCon = true; ?>
							</td>
						</tr>
						<script type="text/javascript" src="livesearch-riga-aggiuntiva.js"></script>
						<tr bgcolor=<?php echo $colorelinee; ?>>
							<td rowspan="2"></td>
							<td>
								<input class="form-control input-sm" type="text" id="<?php echo $riga; ?>" value="<?php echo $dest['riga1']; ?>">
							</td>
							<td style="vertical-align: middle">
								<center>
									<a href="javascript:inserisciRiga('1', '<?php echo $dest['id']; ?>', document.getElementById('<?php echo $riga; ?>').value)"><i class="fa fa-save"></i></a>
								</center>
							</td>
						</tr>
						<tr bgcolor=<?php echo $colorelinee; ?>>
							<?php $riga++; ?>
							<td>
								<input class="form-control input-sm" type="text" id="<?php echo $riga; ?>" value="<?php echo $dest['riga2']; ?>">
							</td>
							<td style="vertical-align: middle">
								<center>
									<a href="javascript:inserisciRiga('2', '<?php echo $dest['id']; ?>', document.getElementById('<?php echo $riga; ?>').value)"><i class="fa fa-save"></i></a>
								</center>
							</td>
						</tr>
					<?php
					$i=$i+2;
					}
					if(!$verificaDestCon) {
						echo "<br>Nessun destinatario per conoscenza inserito.";
					}
					echo '</table>';
				?>
			</div>
		</div>
		<hr>
		<center>
		<a href="?corpus=modifica-lettera&idlettera=<?php echo $id; ?>&from=lettera2"><button class="btn btn-warning btn-lg" type="button"><i class="fa fa-arrow-left"></i> Torna ai dettagli</button></a>
		<a data-fancybox data-type="iframe" data-preload="false" href="componilettera.php?id=<?php echo $id; ?>"><button class="btn btn-info btn-lg" type="button"><i class="fa fa-file-o"></i> Anteprima Lettera</button></a>
		<a href="sottoponi-lettera-firma.php?idlettera=<?php echo $id; ?>"><button class="btn btn-success btn-lg" type="button"><i class="fa fa-arrow-right"></i> Manda alla firma</button></a>
		<?php if(($my_anagrafica->isAdmin($_SESSION['loginid']) || $my_anagrafica->canSign($_SESSION['loginid'], $ufficio)) && ($verificaDest)) { ?>
			<a href="firma-lettera.php?id=<?php echo $id; ?>&from=elenco-lettere"><button class="btn btn-danger btn-lg" type="button"><i class="fa fa-pencil"></i> Firma</button></a>
		<?php } ?>
		</center>
	</div>
</div>