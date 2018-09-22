<?php
	//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
	if ($_SESSION['auth'] < 99) { 
		echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; 
		exit ();
	}
	$anag = new Anagrafica();
?>

<script type="text/javascript" src="livesearch-aggiungi-utente.js"></script>
<script language="javascript">
	var id=0;
</script>

<style type="text/css">
#livesearch
  {
  margin:0px;
  width:194px;
  }
#txt1
  {
  margin:0px;
  }
</style>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-group"></i> Gestione Utenti di <?php echo $_SESSION['nomeapplicativo'];?></strong></h3>
	</div>
			
	<div class="panel-body">
	
		<?php
		if (isset($_GET['mod']) &&($_GET['mod'] == 'ok')) {
			?>
			<div class="alert alert-success"><i class="fa fa-check"></i> Dati utente modificati <b>correttamente!</b></div>
			<?php
		}
		?>
		
		<div class="row">
			<div class="col-sm-9">
				<p><b><i class="fa fa-reorder"></i> Elenco utenti attuali:</b>
				<div class="table-responsive">
					<table class="table">
						<?php
						$risultati=mysql_query("select distinct * from users, anagrafica where users.idanagrafica=anagrafica.idanagrafica order by users.auth desc, anagrafica.cognome, anagrafica.nome ");
						?>
						<tr>
							<td><b>Utente</b></td>
							<td align="center"><b>Auth</b></td>
							<td align="center"><b>Admin</b></td>
							<td align="center"><b>Angrafica</b></td>
							<td align="center"><b>Protocollo</b></td>
							<td align="center"><b>Documenti</b></td>
							<td align="center"><b>Lettere</b></td>
							<td align="center"><b>Magazzino</b></td>
							<td align="center"><b>Contabilit&agrave</b></td>
							<td align="center"><b>Profile</b></td>
							<td align="center"><b>Opzioni</b></td>
						</tr>
						<?php
						while ($risultati2=mysql_fetch_array($risultati))	{
							$risultati2 = array_map('stripslashes', $risultati2);
							?>
							<tr>
								<td><a href="login0.php?corpus=dettagli-anagrafica&id=<?php echo $risultati2['idanagrafica'];?>"><?php echo ucwords($risultati2['cognome'].' '.$risultati2['nome']);?></a></td>
								<td align="center"><?php echo $risultati2['auth'];?></td>
								<td align="center"><?php if($risultati2['admin'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['anagrafica'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['protocollo'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['documenti'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['lettere'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['magazzino'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['contabilita'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center"><?php if($risultati2['updateprofile'] == 1) { echo '<i class="fa fa-check text-success"></i>'; } else { echo '<i class="fa fa-close text-danger"></i>'; }?></td>
								<td align="center">
									<div class="btn-group btn-group-xs">
										<?php if($anag->isAdmin($_SESSION['loginid'])) { ?><a class="btn btn-warning" href="login0.php?corpus=gestione-utenti-modifica-utente&id=<?php echo $risultati2['idanagrafica'];?>"><span class="glyphicon glyphicon-pencil"></span></a>
										<a class="btn btn-danger" onclick="return confirm('Sicuro di voler cancellare l\'utente')" href="login0.php?corpus=gestione-utenti-elimina-utente&id=<?php echo $risultati2['idanagrafica'];?>"><i class="fa fa-user-times"></i></a><?php } ?>
									</div>
								</td>								
							</tr>
							<?php
						} 
						?>
					</table>
					</center>
				</div>
			</div>
		
			<div class="col-sm-3">
				<p><b><i class="fa fa-user-plus"></i> Aggiungi Utente:</b>
					<form>
						<input class="form-control" placeholder="digita il cognome o parte di esso..." type="text" id="txt1" onkeyup="showResult(this.value)" />
						<div id="livesearch"></div>
					</form>
			</div>
		</div>
	</div>
</div>