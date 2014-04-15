<?php

	session_start();
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	$tipologia=$_GET['tipologia'];
	$idlettera=$_GET['idlettera'];
	
	if ($tipologia =='') {
		$filtro = '';
	}
	else { 
		$filtro = "and tipologia='".$tipologia."'";
	}
	
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'cognome');
	$where= $my_ricerca->where;
	
	echo '<br>' . $q . ' non presente nell\'anagrafica. <a href="#" data-toggle="modal" data-target="#myModal">Aggiungi al database</a><br>';
	
	$sql=mysql_query("SELECT * FROM anagrafica $where $filtro limit 5");
	while($row = mysql_fetch_array($sql)) {
		?>
		<br>
		<a href="login0.php?corpus=protocollo2&idanagrafica=<?php echo $row['idanagrafica'];?>&idlettera=<?php echo $idlettera;?>&from=aggiungi">
			<?php echo $row['cognome'].' '.$row['nome'];?>
		</a>
		<br>
		<?php
	}
	
	
	?>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	    	<form method="POST" action="cazzo.php">
	      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Inserimento rapido in anagrafica</h4>
	      </div>
	      
			<div class="modal-body">
			
					<div class="form-group">
						<label>Tipologia:</label>
						<div class="row">
							<div class="col-xs-4">
								<select class="form-control input-sm" name="anagraficatipologia">
								<OPTION value="persona"> Persona Fisica</OPTION>
								<OPTION value="carica"> Carica Elettiva o Incarico</OPTION>
								<OPTION Value="ente"> Ente</OPTION>
								</select>
							</div>
						</div>
						<br><label>Cognome o Denominazione:</label>
						<div class="row">
							<div class="col-xs-8">
								<input type="text" class="form-control input-sm" name="cognome" value="<?php echo $q; ?>">
							</div>
						</div>
						<br><br>
						<div align="right">
							<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
							<button type="submit" class="btn btn-primary">Salva ed associa al protocollo</button>
						</div>
					</div>
				
			</div>
		</form>
	    </div>
	  </div>
	</div>

	<?php

	mysql_close ($verificaconnessione);

?>