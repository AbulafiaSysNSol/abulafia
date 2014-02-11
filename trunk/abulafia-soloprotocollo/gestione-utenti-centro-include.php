<?php
//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
if ($_SESSION['auth'] < 99) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>
<script type="text/javascript" src="livesearch-aggiungi-utente.js">

</script>
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
	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3>Gestione Utenti di <?php echo $_SESSION['nomeapplicativo'];?>:</h3>
				
				</div>
				<div class="content">
					<p><b>Elenco utenti attuali:<br></b>
<table border="1" cellpadding="3" cellspacing="3" width="490">

<?php
$risultati=mysql_query("select distinct * from users, anagrafica where users.idanagrafica=anagrafica.idanagrafica order by users.auth desc, anagrafica.cognome, anagrafica.nome ");
while ($risultati2=mysql_fetch_array($risultati))
{?>
<tr><td><a href="login0.php?corpus=dettagli-anagrafica&id=<?php echo $risultati2['idanagrafica'];?>"><?php echo $risultati2['cognome'].', '.$risultati2['nome'];?></a></td><td> Auth=<?php echo $risultati2['auth'];?></td><td><a href="login0.php?corpus=gestione-utenti-modifica-utente&id=<?php echo $risultati2['idanagrafica'];?>"> Modifica dati Login</a></td><td> <a href="login0.php?corpus=gestione-utenti-elimina-utente&id=<?php echo $risultati2['idanagrafica'];?>"> Elimina questo Utente</a><?php echo'<br>'; } ?> </td></tr>
</table>
<p><h2>Aggiungi Utente:<br><br></h2></p>

						<form>
						<input type="text" id="txt1" size="30" onkeyup="showResult(this.value)" />
						<div id="livesearch"></div>
						</form>

</p>

			</div>	

		</div>
			
			<!-- primary content end -->
	
		</div>

