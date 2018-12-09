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

	$a = new Anagrafica();
	$c = new Calendario();
	
	$ogg = $_GET['q'];
	$num = $_GET['num'];

	$query = mysql_query("SELECT * FROM cert_accesso WHERE diagnosi LIKE '%$ogg%' ORDER BY data DESC LIMIT $num");
?>
	
<table class="table table-bordered">
	<tr style="vertical-align: middle">
		<td><b>Data</b></td>
		<td><b>Ora</b></td>
		<td><b>Medico</b></td>
		<td><b>Assistito</b></td>
		<td><b>Diagnosi</b></td>
		<td align="center"><b>Opzioni</b></td>
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
			<td style="vertical-align: middle"><?php echo $c->dataSlash($risultati2['data']);?></td>
			<td style="vertical-align: middle"><?php echo $c->oraOM($risultati2['ora']);?></td>
			<td style="vertical-align: middle"><?php echo ucwords($a->getName($risultati2['medico']));?></td>
			<td style="vertical-align: middle"><?php echo ucwords($a->getNomeAssistito($risultati2['anagrafica']));?></td>
			<td style="vertical-align: middle"><?php echo $risultati2['diagnosi'];?></td>
			<td style="vertical-align: middle" align="center">
				<div class="btn-group btn-group-xs">
					
					<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Info Prestazione" href="?corpus=cert-genera-richiesta&idanagrafica=<?php echo $risultati2['anagrafica']; ?>&idvisita=<?php echo $risultati2['id']; ?>" data-toggle="modal" data-target="#myModal">
							Richiedi Certificato <i class="fa fa-arrow-right fa-fw"></i>
					</a>
					<!--
					<a class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Info Prestazione" href="#" data-toggle="modal" data-target="#myModal">
							<i class="fa fa-info-circle fa-fw"></i>
					</a>

					<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica Prestazione" href="#">
							<i class="fa fa-edit fa-fw"></i>
					</a>
					-->
					<?php //if($a->isAdmin($_SESSION['loginid'])) {
						?>
					<!--	<a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Elimina Prestazione" onclick="return confirm('Sicuro di voler cancellare la prestazione?')" href="#">
							<i class="fa fa-trash-o fa-fw"></i>
						</a>
					-->
						<?php
					//}
					?>
				</div>
			</td>
		</tr>
		<?php 
	} 
	?>
</table>