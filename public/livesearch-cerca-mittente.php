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

	$a = new Anagrafica();
	
	if ($tipologia =='') {
		$filtro = '';
	}
	else { 
		$filtro = "and tipologia='".$tipologia."'";
	}
	
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'cognome');
	$where= $my_ricerca->where;
	
	?>
	<div class="row">
		<div class="col-sm-9">
			<?php

			echo '<br>Se <b><i>"' . $q . '"</i></b> non è presente nell\'elenco sottostante <a href="#" data-toggle="modal" data-target="#myModal">vai all\'inserimento rapido <span class="glyphicon glyphicon-share-alt"></span></a><br>';
			
			$sql=mysql_query("SELECT * FROM anagrafica $where $filtro limit 10");
			?>
			<table class="table table-condensed">
			<?php
			while($row = mysql_fetch_array($sql)) {
				$row = array_map('stripslashes', $row);
				?>
					<tr>
						<td style="vertical-align: middle" width="11%">
							<img src="<?php echo $a->getFoto($row['idanagrafica']); ?>" class="img-circle img-responsive">
						</td>
						<td style="vertical-align: middle">
							<?php echo $row['cognome'].' '.$row['nome'];?>
							</a>
						</td>
						<td style="vertical-align: middle">
							<a href="anagrafica-mini.php?id=<?php echo $row['idanagrafica']; ?>" class="fancybox btn btn-default" data-fancybox-type="iframe">
								<i class="fa fa-info fa-fw"></i>
							</a>
							<a class="btn btn-primary" href="login0.php?corpus=protocollo2&idanagrafica=<?php echo $row['idanagrafica'];?>&idlettera=<?php echo $idlettera;?>&from=aggiungi">
								<i class="fa fa-user-plus fa-fw"></i>
							</a>
						</td>
					</tr>
				<?php
			}
			?>
			</table>
		</div>
	</div>
	<?php
	mysql_close ($verificaconnessione);

?>
