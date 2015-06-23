<?php

	session_start();
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	
	$p = new Prodotto();
	
	$res = $p->ricercaProdotto($q);
	
?>
	<table class="table table-bordered" width="100%">
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

	mysql_close ($verificaconnessione);

?>
