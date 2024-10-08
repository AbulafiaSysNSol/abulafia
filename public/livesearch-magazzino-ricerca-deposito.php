<?php
	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q = $_GET['q'];
	$z = $_GET['z'];

	if (($q == '') && ($z == '')) {
		?>
		<center><div class="alert alert-warning"><b><i class="fa fa-warning"></i></b> Seleziona <b>almeno</b> un magazzino o un prodotto.</div></center>
		<?php
		$connessione = null;
		exit();
	}
	$p = new Prodotto();
	$m = new Magazzino();
	$s = new Servizio();
	$c = new Calendario();
	
	$res = $p->ricercaDeposito($q, $z);
	$count = $p->contaDeposito($q, $z);
?>

<?php
	if($count > 0) {
		
		//tabella per i documenti di carico scarico
		if ( (isset($_GET['doc'])) && ($_GET['doc']) ) {
			?>
			<table class="table table-stripe" width="100%">
				<?php
				foreach($res as $val) {
					?>
						<tr>
							<td style="vertical-align: middle" align="center"><a href="javascript:selectProdotto('<?php echo $val['codice'];?>','<?php echo strtoupper($val['descrizione']);?>');"><?php echo $val['codice']; ?></a></td>
							<td style="vertical-align: middle"><a href="javascript:selectProdotto('<?php echo $val['codice'];?>','<?php echo strtoupper($val['descrizione']);?>');"><i class="fa fa-plus-circle"></i> <?php echo strtoupper($val['descrizione']); ?></a></td>
							<td style="vertical-align: middle" align="center"><?php echo $val['giacenza']; ?></td>
						</tr>
					<?php
				}
				?>
			</table>
			<?php
		}

		//tabella per la ricerca dei depositi
		else {
			?>
			<table class="table table-bordered" width="100%">
				<tr>
					<td colspan="10" style="vertical-align: middle">
						Risultati: <b><?php echo $count; ?></b>
					</td>
				</tr>
				<tr align="center">
					<td style="vertical-align: middle"><b>Magazzino</b></td>
					<td style="vertical-align: middle"><b>Prodotto</b></td>
					<td style="vertical-align: middle"><b>Descrizione</b></td>
					<td style="vertical-align: middle"><b>U.M.</b></td>
					<td style="vertical-align: middle"><b>Scorta Min.</b></td>
					<td style="vertical-align: middle"><b>Giacenza</b></td>
					<td style="vertical-align: middle"><b>Lotto</b></td>
					<td style="vertical-align: middle"><b>Scadenza</b></td>
					
					<td></td>
				</tr>
				<?php
				foreach($res as $val) {
					?>
					<tr>
						<td style="vertical-align: middle" align="left"><?php echo $s->getServizioById($val[0]); ?></td>
						<td style="vertical-align: middle" align="center"><?php echo $val['codice']; ?></td>
						<td style="vertical-align: middle"><?php echo strtoupper($val['descrizione']); ?></td>
						<td style="vertical-align: middle" align="center"><?php echo $val['unita_misura']; ?></td>
						<td style="vertical-align: middle" align="center"><?php echo $val['scortaminima']; ?></td>
						<td style="vertical-align: middle" align="center"><b><?php echo $val['giacenza']; ?></b></td>
						<td style="vertical-align: middle" align="center"><b><?php if( (isset($val['lotto'])) && ($val['lotto'] != "") ) { echo $val['lotto']; } else { echo "-"; } ?></b></td>
						<td style="vertical-align: middle" align="center"><b><?php if( (isset($val['scadenza'])) && ($val['scadenza'] != "0000-00-00") ) { echo $c->dataSlash($val['scadenza']); } else { echo "-"; } ?></b></td>
						
						<td align="center"><a class="btn btn-warning btn-sm" href="?corpus=magazzino-modifica-deposito&id=<?php echo $val[14] ?>"><i class="fa fa-edit fa-fw"></i></a></td>
					</tr>
				<?php
				}
				?>
				
			</table>
			<?php
		}
	}
	else {
		?>
		<center><div class="alert alert-danger"><b><i class="fa fa-warning"></i> Nessun</b> risultato trovato con i criteri di ricerca applicati.</div></center>
		<?php
	}
	
	$connessione = null;
?>

<script type="text/javascript">
 
  function selectProdotto(codice,descrizione) { 
	
  	document.getElementById("prodotto1").value = codice;
  	document.getElementById("descrizione1").value = descrizione;
  	document.getElementById("prodotto1").disabled = true;
  	document.getElementById("quantita1").disabled = false;
  	document.getElementById("nota1").disabled = false;
  
  }

</script>