<?php

$l = new Lettera();
$user = $_SESSION['loginid'];
if($my_anagrafica->isAdmin($_SESSION['loginid'])) {
	$count = $connessione->query("SELECT COUNT(*) FROM comp_lettera WHERE (vista = 1 OR vista = 2) AND firmata = 0");
}
else {
	$count = $connessione->query("SELECT COUNT(*) FROM comp_lettera, joinpersoneuffici WHERE (vista = 1 OR vista = 2) AND firmata = 0 AND joinpersoneuffici.ufficio = comp_lettera.ufficio AND joinpersoneuffici.utente = $user");
}
$num = $count->fetch();

if($num[0] == 0) {
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=elenco-lettere&from=nessuna-lettera"; 
	else 
		window.location="login0.php?corpus=elenco-lettere&from=nessuna-lettera"; 
	</SCRIPT>
	<?php
	exit();
}

if($my_anagrafica->isAdmin($_SESSION['loginid'])) {
	$query = $connessione->query("SELECT *, comp_lettera.id AS idlettera FROM comp_lettera WHERE (vista = 1 OR vista = 2) AND firmata = 0");
}
else {
	$query = $connessione->query("SELECT *, comp_lettera.id AS idlettera FROM comp_lettera, joinpersoneuffici WHERE (vista = 1 OR vista = 2) AND firmata = 0 AND joinpersoneuffici.ufficio = comp_lettera.ufficio AND joinpersoneuffici.utente = $user");
}
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-file-text-o"></i> Elenco Lettere da Firmare</strong></h3>
	</div>

	<div class="panel-body">
		
		<?php
			if (isset($_GET['delete']) &&($_GET['delete'] == 'ok')) {
			?>
				<center><div class="alert alert-danger"><i class="fa fa-check"></i> Lettera cancellata <b>correttamente!</b></div></center>
			<?php
			}
		?>
		
		<table class="table table-bordered">
			<tr style="vertical-align: middle" align="center">
				<td><b>ID</b></td>
				<td><b>Oggetto</b></td>
				<td><b>Vista</b></td>
				<td><b>Firmata</b></td>
				<td width="240"><b>Opzioni</b></td>
			</tr>
			
			<?php
			$contatorelinee = 0;
			while ($risultati2 = $query->fetch()) {
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
					<td style="vertical-align: middle" align="center">
						<div class="btn-group btn-group-sm">
							<a class="btn btn-info" data-fancybox data-type="iframe" data-preload="false" data-toggle="tooltip" data-placement="left" title="Anteprima lettera" href="componilettera.php?id=<?php echo $risultati2['idlettera'] ?>">
									<span class="glyphicon glyphicon-info-sign"></span>
							</a>
							<?php if($risultati2['firmata'] == 0) { ?>
							<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica lettera" href="login0.php?corpus=modifica-lettera&idlettera=<?php echo $risultati2['idlettera'] ?>&from=elenco-lettere-firma">
									<i class="fa fa-edit"></i>
							</a>
							<?php }
							if($risultati2['firmata'] == 0) { ?>
							<a class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Modifica destinatari" href="login0.php?corpus=lettera2&id=<?php echo $risultati2['idlettera'] ?>">
									<i class="fa fa-users"></i>
							</a>
							<?php }
							if($risultati2['vista'] != 2) { ?>
							<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Segna come vista" href="vista-lettera.php?id=<?php echo $risultati2['idlettera'] ?>&from=elenco-lettere-firma">
									<i class="fa fa-eye"></i>
							</a>
							<?php }
							if($l->destinatariOk($risultati2['idlettera'])) {
							 ?>
							<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Firma" href="firma-lettera.php?id=<?php echo $risultati2['idlettera'] ?>&from=elenco-lettere-firma">
									<i class="fa fa-pencil"></i>
							</a>
							<?php } ?>
							<a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Elimina" onclick="return confirm('Sicuro di voler cancellare la lettera?')" href="elimina-lettera.php?id=<?php echo $risultati2['idlettera'] ?>&from=elenco-lettere-firma">
									<i class="fa fa-trash-o"></i>
							</a>
						</div>
					</td>
				</tr>
				<?php 
			} 
			?>
		</table>
		
	</div>
</div>
	