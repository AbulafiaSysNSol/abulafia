<?php
$id= $_GET['id'];
$risultati=mysql_query("select * from anagrafica where idanagrafica='$id'");
$risultati2=mysql_query("select * from jointelefonipersone where idanagrafica='$id'");
$risultati3=mysql_query("select * from users where idanagrafica='$id'");
$row = mysql_fetch_array($risultati);
$row3 = mysql_fetch_array($risultati3);
$data = $row['nascitadata'] ;
list($anno, $mese, $giorno) = explode("-", $data);
$idcarica = $_GET['idcarica'];
$datainizio = $_GET['datainizio'];
$datafine = $_GET['datafine'];
$annonow = date("Y");
?>

<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Gestione Utente:<br><?php echo $row['cognome'].', '.$row['nome'];?></u></h3>
				</div>
			</div>

	<div class="content">
	
	
<img src="foto/<?php echo $row['urlfoto'] ;?>" height="100">	
<form name="modifica" method="post" >

<label><p><h4>Nome Utente per il Login:<br></h4><br>
<input size="20" type="text" name="nomeutente"  value="<?php echo $row3['loginname'];?>"/>
</label><label><p><h4>Livello di Autorizzazione:<br></h4><br>
<select size="1" cols=4 type="text" name="authlevel1" />
<OPTION selected value="<?php echo $row3['auth'];?>"> <?php echo $row3['auth'];?>
<?php
$iterazioneauth = 0;
while ($iterazioneauth < 100) { $iterazioneauth = $iterazioneauth +1;?>
<OPTION value="<?php echo $iterazioneauth;?>"> <?php echo $iterazioneauth;?>&nbsp;&nbsp; 
<?php } ?>
</select>
<br>
</label>
<label> <br><h4>Nuova password</h4><br><input size="40" type="password" name="nuovapassword1" />

</label>

<label> <br><br><h4>Ripeti password</h4><br><input size="40" type="password" name="nuovapassword2" />

</label>

</p>
<br><br><input type="button" value="MODIFICA" onClick="Controllo()" /><br><br>
	</form>


	</div>
	
</div>

<script language="javascript">
 <!--
  function Controllo() 
  {
	//acquisisco il valore delle variabili
	var nomeutente = document.modifica.nomeutente.value;
	var nuovapassword1 = document.modifica.nuovapassword1.value;
	var nuovapassword2 = document.modifica.nuovapassword2.value;
      
	if ((nomeutente == "") || (nomeutente == "undefined")) 
	{
           alert("Il campo 'Nome Utente' e' obbligatorio");
           document.modifica.nomeutente.focus();
           return false;
      }

	else if (nuovapassword1 != nuovapassword2) 
	{
           alert("Le due password non coincidono");
           document.modulo.nuovapassword1.focus();
           return false;
      }
	
	//mando i dati alla pagina
	else 
	{
           document.modifica.action = "login0.php?corpus=gestione-utenti-modifica-utente2&id=<?php echo $id;?>";
           document.modifica.submit();
      }
  }
 //-->
</script> 




