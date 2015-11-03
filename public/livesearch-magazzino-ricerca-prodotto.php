<?php

	session_start();
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	
	$p = new Prodotto();
	
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	else {
		$page = 0;
	}
	
	if(isset($_GET['num'])) {
		$num = $_GET['num'];
	}
	else {
		$num = 25;
	}
	
	$res = $p->ricercaProdottoInizioFine($q, ($page * $num), $num);
	$count = $p->contaProdotto($q);
	$totpages = ceil($count / $num);
	
?>

<?php
	if($count > 0) {
		?>
		<table class="table table-bordered" width="100%">
			<tr>
				<td colspan="6" style="vertical-align: middle">
					Risultati: <b><?php echo $count; ?></b>
				</td>
			</tr>
			<tr align="center">
				<b><td>Codice</td> <td>Descrizione</td> <td>Prezzo</td> <td>U.M.</td> <td>Codice a Barre</td> <td>Azioni</td></b>
			</tr>
			<?php
			foreach($res as $val) {
				?>
				<tr>
					<td align="center"><?php echo $val['codice']; ?></td>
					<td><?php echo strtoupper($val['descrizione']); ?></td>
					<td align="right"><?php echo number_format($val['prezzo'], 2, ',', '.') . ' &euro;'; ?></td>
					<td><?php echo $val['unita_misura']; ?></td>
					<td align="center"><?php echo $val['codicebarre']; ?></td> 
					<td nowrap style="vertical-align: middle" align="center">
						<div class="btn-group btn-group-sm">
							<a class="btn btn-warning" href="?corpus=magazzino-modifica-prodotto&id=<?php echo $val['codice']; ?>">
								<i class="fa fa-pencil"></i> Modifica
							</a>
							<a class="btn btn-info" href="">
								<i class="fa fa-arrow-right"></i> Assegna
							</a>
							<a class="btn btn-danger" href="">
								<i class="fa fa-trash"></i> Elimina
							</a>
						</div>
					</td>
				</tr>
				<?php
			}
			?>
			
		</table>
		<?php
	}
	else {
		?>
		<center><div class="alert alert-danger"><b><i class="fa fa-warning"></i> Nessun</b> risultato trovato con i criteri di ricerca applicati.</div></center>
		<?php
	}
	
	mysql_close ($verificaconnessione);
?>
