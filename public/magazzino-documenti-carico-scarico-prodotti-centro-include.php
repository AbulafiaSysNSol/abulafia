<?php
	$id = $_GET['id'];
	$tipologia = $_GET['tipologia'];
	$m = new Magazzino();
	$info = $m-> getDocumentById($id);
	$c = new Calendario();
	$s = new Servizio();
?>

<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-navicon"></i> Aggiungi Prodotti Documento n. <?php echo $id; ?></strong></h3>
			</div>
			
			<div class="panel-body">
				
				<h5>N. Documento: <b><?php echo $info[0];?></b> del <b><?php echo $c->dataSlash($info[1]);?></b> | Riferimento: <b><?php echo $info[3];?></b> del <b><?php echo $c->dataSlash($info[5]);?></b></h5>
				<h5>Magazzino: <b><?php echo $s->getServizioById($info[2]);?></b> | Causale: <b><?php echo strtoupper($info[4]);?></b> | Note: <b><?php echo strtoupper($info[6]);?></b></h5>
				<br>

				<h4><i class="fa fa-search fa-fw"></i> Ricerca Prodotti da inserire nel documento:</h4>
				<!--Inizio tabella con inserimento prodotti e quantità-->
				<table id="prodotti" class="table table-bordered">
					<tr style="vertical-align: middle">
						<td width=20%><b>Codice</b></td>
						<td width=40%><b>Descrizione</b></td>
						<td width=5%><b>Quantit&agrave;</b></td>
						<td width=30%><b>Nota</b></td>
						<td width=5%></td>
					</tr>

					<script type="text/javascript" src="livesearch-magazzino-documento-deposito.js"></script>
					<form class="form-horizontal" role="form" name="righedocumento" method="post" action="magazzino-documenti-carico-scarico-prodotti2.php?id=<?php echo $id; ?>&tipologia=<?php echo $tipologia; ?>&magazzino=<?php echo $info[2]; ?>">
						<tr>
							<td><input id="prodotto1" type="text" class="form-control input-sm" name="prodotto" readonly></td>
							<td><input id="descrizione1" type="text" placeholder="inserisce il codice o la descrizione del prodotto da aggiungere..." class="form-control input-sm" name="descrizione" onkeyup="showResult(this.value,'<?php echo $info[2];?>')" required></td>
							<td><input id="quantita1" type="text" class="form-control input-sm" name="quantita" disabled required></td>
							<td><input id="nota1" type="text" class="form-control input-sm" name="nota" disabled></td>
							<td align="center"><button class="btn btn-success" id="subbutton" disabled><i class="fa fa-plus fa-fw"></i></button></td>
						</tr>
							
					</form>
				</table>
				
				<div id="livesearch">
					<!-- spazio riservato ai risultati live della ricerca -->
				</div>
				
				<br>
				<table id="prodotti" class="table table-condensed">
					<tr>
						<td colspan="5"><h4><i class="fa fa-list-ul fa-fw"></i> Prodotti nel documento:</h4></td>
					</tr>
					<tr style="vertical-align: middle">
						<td width=20%><b>Codice</b></td>
						<td width=40%><b>Descrizione</b></td>
						<td width=5%><b>Quantit&agrave;</b></td>
						<td width=30%><b>Nota</b></td>
						<td width=5%></td>
					</tr>
					<?php
					$res = $m->righeDocumento($id);
						foreach($res as $val) {
							?>
							<tr>
								<td style="vertical-align: middle"><?php echo $val['codice']; ?></td>
								<td style="vertical-align: middle"><?php echo strtoupper($val['descrizione']); ?></td>
								<td style="vertical-align: middle" align="center"><?php echo $val['quantita'] ?></td>
								<td style="vertical-align: middle"><?php echo $val[4]; ?></td>
								<td style="vertical-align: middle" align="center"><a class="btn btn-danger" href="?corpus=magazzino-documenti-carico-scarico-elimina-riga-documento&id=<?php echo $val[0]; ?>&documento=<?php echo $id; ?>"><i class="fa fa-trash fa-fw"></i></a></td>		
							</tr>
						<?php
						}
						?>
				</table>

			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">
 
  function selectProdotto(codice,descrizione) { 
	
  	document.getElementById("prodotto1").value = codice;
  	document.getElementById("descrizione1").value = descrizione;
  	document.getElementById("quantita1").disabled = false;
  	document.getElementById("quantita1").focus();
  	document.getElementById("nota1").disabled = false;
  	document.getElementById("subbutton").disabled = false;
  
  }

</script>