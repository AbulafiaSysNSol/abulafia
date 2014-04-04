<?php
//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
if ($_SESSION['auth'] < 99) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>

<script type="text/javascript" src="livesearch-aggiungi-utente.js"></script>
<script language="javascript">
var id=0;

//id = <?php echo($id);?> ;

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
		<h3 class="panel-title"><strong>Gestione Utenti di <?php echo $_SESSION['nomeapplicativo'];?></strong></h3>
		</div>
		<div class="panel-body">

			<p><b>Elenco utenti attuali:<br></b>
			
			<div class="table-responsive">
			<table class="table">
				<?php
				$risultati=mysql_query("select distinct * from users, anagrafica where users.idanagrafica=anagrafica.idanagrafica order by users.auth desc, anagrafica.cognome, anagrafica.nome ");
				?>
				<tr align="center"><td><b>Utente</b></td><td><b>Livello Autorizzazione</b></td><td><b>Opzioni</b></td></tr>
				<?php
				while ($risultati2=mysql_fetch_array($risultati))
				{
				?>
				<tr align="center"><td><a href="login0.php?corpus=dettagli-anagrafica&id=<?php echo $risultati2['idanagrafica'];?>"><?php echo $risultati2['cognome'].' '.$risultati2['nome'];?></a></td><td> Auth = <?php echo $risultati2['auth'];?></td><td><a href="login0.php?corpus=gestione-utenti-modifica-utente&id=<?php echo $risultati2['idanagrafica'];?>"> Modifica</a> - <a href="login0.php?corpus=gestione-utenti-elimina-utente&id=<?php echo $risultati2['idanagrafica'];?>">Elimina</a></td></tr>
				<?php 
				} 
				?>
			</table>
			</center>
			</div>

		</div>
				
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Aggiungi Utente:</strong></h3>
		</div>
		<div class="panel-body">
			<form>
			<input class="form-control" placeholder="digita il cognome o parte di esso..." type="text" id="txt1" onkeyup="showResult(this.value)" />
			<div id="livesearch"></div>
			</form>
		</div>
		
	</div>
	