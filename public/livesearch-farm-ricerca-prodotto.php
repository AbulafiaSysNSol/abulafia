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
				<td colspan="5" style="vertical-align: middle">
					Risultati: <b><?php echo $count; ?></b> --- 
					Pagina <b><?php echo $page+1 . ' </b>di<b> ' . $totpages; ?></b> ---  
					Risultati per pagina: <select class="form-inline input-sm" NAME="numerorisultati">
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="75">75</option>
									<option value="100">100</option>
								</select>
				</td>
			</tr>
			<tr align="center">
				<b><td>Codice</td> <td>Descrizione</td> <td>Prezzo</td> <td>Note</td> <td>U.M.</td></b>
			</tr>
			<?php
			foreach($res as $val) {
				?>
				<tr>
					<td align="center"><?php echo $val['codice']; ?></td> <td><?php echo $val['descrizione']; ?></td> <td align="right"><?php echo $val['prezzo'] . ' &euro;'; ?></td> <td><?php echo $val['note']; ?></td> <td align="center"><?php echo $val['unita_misura']; ?></td>
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
