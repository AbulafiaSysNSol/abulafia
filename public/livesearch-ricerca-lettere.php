<?php
	session_start();
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$ogg = $_GET['q'];
	$num = $_GET['num'];

	$query = mysql_query("SELECT * FROM comp_lettera WHERE protocollo != 0 AND oggetto LIKE '%$ogg%' ORDER BY id DESC LIMIT $num");
?>
	<table class="table table-bordered">
		<tr style="vertical-align: middle" align="center">
			<td><b>ID</b></td>
			<td><b>Oggetto</b></td>
			<td><b>Vista</b></td>
			<td><b>Firmata</b></td>
			<td><b>Protocollata</b></td>
			<td width="240"><b>Opzioni</b></td>
		</tr>
		
		<?php
		$contatorelinee = 0;
		while ($risultati2=mysql_fetch_array($query))	{
			$risultati2 = array_map('stripslashes', $risultati2);
			if ( $contatorelinee % 2 == 1 ) { 
					$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
				} //primo colore
				else { 
					$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
				} //secondo colore
				$contatorelinee = $contatorelinee + 1 ;
			?>
			<tr bgcolor=<?php echo $colorelinee; ?>>
				<td style="vertical-align: middle" align="center"><?php echo $risultati2['id'];?></td>
				<td style="vertical-align: middle"><?php echo strip_tags($risultati2['oggetto']);?></td>
				<td style="vertical-align: middle" align="center"><?php if($risultati2['vista'] == 2) { echo '<i class="fa fa-check"></i>'; } else { echo '<i class="fa fa-times"></i>'; }?></td>
				<td style="vertical-align: middle" align="center"><?php if($risultati2['firmata'] == 1) { echo '<i class="fa fa-check"></i>'; } else { echo '<i class="fa fa-times"></i>'; }?></td>
				<td style="vertical-align: middle" align="center"><?php if($risultati2['protocollo'] != 0) { echo '<i class="fa fa-check"></i>'; } else { echo '<i class="fa fa-times"></i>'; }?></td>
				<td style="vertical-align: middle" align="center">
					<div class="btn-group btn-group-sm">
						<?php if($risultati2['protocollo'] == 0) { ?>
						<a class="btn btn-info fancybox" data-fancybox-type="iframe" data-toggle="tooltip" data-placement="left" title="Anteprima lettera" href="componilettera.php?id=<?php echo $risultati2['id'] ?>">
								<span class="glyphicon glyphicon-info-sign"></span>
						</a>
						<?php }
						if($risultati2['protocollo'] != 0) { ?>
						<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Dettagli protocollo" href="login0.php?corpus=dettagli-protocollo&id=<?php echo $risultati2['protocollo'] ?>&anno=<?php echo $risultati2['anno'] ?>">
								Vedi Dettagli <i class="fa fa-arrow-right"></i>
						</a>
						<?php }
						if($risultati2['firmata'] == 0) { ?>
						<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica lettera" href="login0.php?corpus=modifica-lettera&idlettera=<?php echo $risultati2['id'] ?>&from=elenco-lettere">
								<i class="fa fa-edit"></i>
						</a>
						<?php }
						if($risultati2['firmata'] == 0) { ?>
						<a class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Modifica destinatari" href="login0.php?corpus=lettera2&id=<?php echo $risultati2['id'] ?>">
								<i class="fa fa-users"></i>
						</a>
						<?php }
						if($risultati2['vista'] != 2 && $_SESSION['auth'] >= 90) { ?>
						<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Segna come vista" href="vista-lettera.php?id=<?php echo $risultati2['id'] ?>&from=elenco-lettere">
								<i class="fa fa-eye"></i>
						</a>
						<?php }
						if($risultati2['firmata'] != 1 && $_SESSION['auth'] >= 90) { ?>
						<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Firma" href="firma-lettera.php?id=<?php echo $risultati2['id'] ?>&from=elenco-lettere">
								<i class="fa fa-pencil"></i>
						</a>
						<?php }
						if($risultati2['firmata'] == 1 && $risultati2['protocollo'] == 0) { ?>
						<a class="btn btn-success" data-placement="left" title="Protocolla" href="?corpus=modale-protocollo&id=<?php echo $risultati2['id'] ?>">
								<i class="fa fa-book"></i>
						</a>
						<?php }
						if($risultati2['protocollo'] == 0 && $_SESSION['auth'] >= 99) { ?>
						<a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Elimina" onclick="return confirm('Sicuro di voler cancellare la lettera?')" href="elimina-lettera.php?id=<?php echo $risultati2['id'] ?>&from=elenco-lettere">
								<i class="fa fa-trash-o"></i>
						</a>
						<?php } ?>
					</div>
				</td>
			</tr>
			<?php 
		} 
		?>
	</table>