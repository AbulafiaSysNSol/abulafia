<?php

	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}

	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	$ordine=$_GET['ord'];
	$num=$_GET['num'];
	
	$p = new Prodotto();
	$a = new Anagrafica();
	$admin = $a->isAdmin($_SESSION['loginid']);
	
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	}
	else {
		$page = 0;
	}
	
	$res = $p->ricercaProdottoInizioFine($q, ($page * $num), $num, $ordine);
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
				<b><td style="vertical-align: middle">Codice</td> <td style="vertical-align: middle">Descrizione</td> <td style="vertical-align: middle">Prezzo</td> <td style="vertical-align: middle">U.M.</td> <td style="vertical-align: middle">Codice a Barre</td> <td style="vertical-align: middle">Azioni</td></b>
			</tr>
			<?php
			foreach($res as $val) {
				?>
				<tr>
					<td style="vertical-align: middle" align="center"><?php echo $val['codice']; ?></td>
					<td style="vertical-align: middle"><?php echo strtoupper($val['descrizione']); ?></td>
					<td style="vertical-align: middle" align="right"><?php echo number_format($val['prezzo'], 2, ',', '.') . ' &euro;'; ?></td>
					<td style="vertical-align: middle" align="center"><?php echo $val['unita_misura']; ?></td>
					<td style="vertical-align: middle" align="center"><?php echo $val['codicebarre']; ?></td> 
					<td style="vertical-align: middle" nowrap style="vertical-align: middle" align="center">
						<div class="btn-group btn-group-sm">
							<a class="btn btn-warning" href="?corpus=magazzino-modifica-prodotto&id=<?php echo $val['codice']; ?>">
								<i class="fa fa-pencil"></i> Modifica
							</a>
							<a class="btn btn-info" href="?corpus=magazzino-assegna-prodotto&id=<?php echo $val['codice']; ?>">
								<i class="fa fa-arrow-right"></i> Assegna
							</a>
							<?php if($admin) { ?>
								<a class="btn btn-danger" onClick="return confirm('Vuoi veramente cancellare questo prodotto?');" href="?corpus=magazzino-elimina-prodotto&id=<?php echo $val['codice']; ?>">
									<i class="fa fa-trash"></i> Elimina
								</a>
							<?php } ?>
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
