<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
$my_file = new File(); //crea un nuovo oggetto 'file'
$my_lettera = new Lettera(); //crea un nuovo oggetto
$from= $_GET['from'];
$dbname=$_session['dbname'];
$idanagrafica=$_GET['idanagrafica'];
//se la pagina da cui si proviene è "crea nuovo protocollo" 
if ($from == 'crea') {  
$lastrec= mysql_query("SELECT * FROM lettere$annoprotocollo ORDER BY idlettera desc LIMIT 1");
while ($lastrec2 = mysql_fetch_array($lastrec)) {
$lastrec3=$lastrec2['idlettera'];
$lasttopic=$lastrec2['oggetto'];
}
$lastjoinletteremittenti=mysql_query("SELECT count(*) FROM joinletteremittenti$annoprotocollo where idlettera='$lastrec3'");
$lastjoinletteremittenti = mysql_fetch_array($lastjoinletteremittenti);

        
if (($lastjoinletteremittenti[0] < 1) or (!$lasttopic)) { //controlla che sia stato attribuito un oggetto e un mittente all'ultimo protocollo. In caso non sia stato fatto, lo cancella e lo riutilizza, in quanto ritenuto un protocollo non correttamente registrato e probabile frutto di errore.
$cancella=mysql_query("DELETE FROM lettere$annoprotocollo WHERE idlettera='$lastrec3' limit 1 ");
$resetta=mysql_query("ALTER TABLE lettere$annoprotocollo AUTO_INCREMENT = $lastrec3 ");
$cancella2=mysql_query("DELETE from joinletteremittenti$annoprotocollo where idlettera='$lastrec3' limit 1");
$cancella3=mysql_query("DELETE from joinlettereinserimento$annoprotocollo where idlettera='$lastrec3' limit 1");
}
$dataregistrazione = strftime("%Y-%m-%d");
$crea=mysql_query("insert into lettere$annoprotocollo values('','','','$dataregistrazione','','','','','')");
$ultimoid=mysql_insert_id();
$insertid=$ultimoid;
//$inseriscimittentestandard=mysql_query("insert into joinletteremittenti values('$ultimoid',1)"); eliminata perché inutile dopo modifica del 22-10-2009: l'inserimento del mittente anonimo avviene di default in pagina protocollo3- se non è stato selezionato nessun mittente
$loginid=$_SESSION['loginid'];
$tracciautenteinserimento=mysql_query("insert into joinlettereinserimento$annoprotocollo values('$ultimoid', '$loginid','','')");
}



if ($from =='aggiungi') 
	{
	$idlettera=$_GET['idlettera'];
	$my_lettera -> publinseriscimittente ($idlettera, $idanagrafica, $annoprotocollo); //richiamo del metodo
	}


if ($from == 'elimina-mittente') { 
$idlettera=$_GET['idlettera'];
$elimina=mysql_query("delete from joinletteremittenti$annoprotocollo where idanagrafica='$idanagrafica' and idlettera='$idlettera'");

$urlpdf = $_GET['urlpdf'];
}
if ($from == 'urlpdf') {  
$urlpdf = $_GET['urlpdf'];
$idlettera=$_GET['idlettera'];
}


?>

	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Protocollo numero: <?php echo $insertid; echo $idlettera;?> </u></h3>
				
				</div>
				<div class="content">
					<p>
<?php


if ($insertid > 0) { $idlettera = $insertid;}?>
<form enctype="multipart/form-data" action="login0.php?corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
Carica il file contenente il documento da registrare:<br> <input size="22" name="uploadedfile" type="file" />
<input type="submit" value="Upload" />
</form>

<?php
$cercadocumento= mysql_query("select distinct * from lettere$annoprotocollo where idlettera='$idlettera'");
$urlpdf1= mysql_fetch_array($cercadocumento);
$urlpdf=$urlpdf1['urlpdf'];
$my_file -> publdownloadlink ($urlpdf, $idlettera, $annoprotocollo); //richiamo del metodo "downloadlink" dell'oggetto file
?><br><br><?php
echo "Ricerca mittente o destinatario:\n";
$my_lettera -> publcercamittente ($idlettera,''); //richiamo del metodo
?>

<b>Mittenti/destinatari:<br></b>
<?php
$risultati=mysql_query("select anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, joinletteremittenti$annoprotocollo.idlettera, joinletteremittenti$annoprotocollo.idanagrafica from anagrafica, joinletteremittenti$annoprotocollo where anagrafica.idanagrafica = joinletteremittenti$annoprotocollo.idanagrafica and joinletteremittenti$annoprotocollo.idlettera='$idlettera'");
while ($row2 = mysql_fetch_array($risultati)) {
echo $row2['cognome'] . '  -  ' . $row2['nome'] ;?> <a href="login0.php?corpus=protocollo2&from=elimina-mittente&idlettera=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $urlpdf;?>">elimina</a><br><?php
}
?>

<form name="modulo" method="post" >
<br>
<label><b> Spedita/Ricevuta</b><br>
<select size="1" cols=4 type="text" name="spedita-ricevuta" />
<OPTION value="ricevuta"> Ricevuta&nbsp;&nbsp;
<OPTION value="spedita"> Spedita&nbsp;&nbsp;
</select>
</label>

<label> <br>Oggetto della lettera:<br><input size="40" type="text" name="oggetto" />

</label>

<label> <br>Data della lettera<br>
<select size="1" cols=4 type="text" name="lettera-data-giorno" />
<?php
$iterazionegiornodelmese = 0;
while ($iterazionegiornodelmese < 31) { $iterazionegiornodelmese = $iterazionegiornodelmese +1;
if ($iterazionegiornodelmese != strftime("%d")) { ?>
<OPTION value="<?php echo $iterazionegiornodelmese;?>"> <?php echo $iterazionegiornodelmese;?>&nbsp;&nbsp; 
<?php } 
else { ?><OPTION selected value="<?php echo $iterazionegiornodelmese;?>"> <?php echo $iterazionegiornodelmese;?>&nbsp;&nbsp; 
<?php }
}?>
</select>
</label>

<label>
<select size="1" cols=4 type="text" name="lettera-data-mese" />
<?php
$iterazionemese = 0;
$iterazionemese2= '';
$meseattuale = strftime("%m");
while ($iterazionemese < 12) { $iterazionemese = $iterazionemese +1;
if ($iterazionemese<10) {$iterazionemese2= '0'.$iterazionemese;} 
else {$iterazionemese2= $iterazionemese;}
if (strcmp($iterazionemese2,$meseattuale) != 0) { ?>
<OPTION value="<?php echo $iterazionemese2 ;?>"> <?php echo $iterazionemese2?>&nbsp;&nbsp; 
<?php } 
else { ?><OPTION selected value="<?php echo $iterazionemese2 ;?>"> <?php echo $iterazionemese2 ;?>&nbsp;&nbsp; 
<?php }
}?>
</select>
</label>

<label>
<select size="1" cols=4 type="text" name="lettera-data-anno" />

<?php
$iterazioneanno = strftime("%Y") - 3 ;
while ($iterazioneanno < (strftime("%Y")-1) ) { $iterazioneanno = $iterazioneanno +1;?>
<OPTION value="<?php echo $iterazioneanno;?>"> <?php echo $iterazioneanno;?>&nbsp;&nbsp; 
<?php }?> 
<OPTION selected value="<?php echo strftime("%Y");?>"> <?php echo strftime("%Y");?>&nbsp;&nbsp; 
</select>

</label>



<label> <br>Mezzo di trasmissione<br>

<SELECT size=1 cols=4 NAME="posizione">
<OPTION selected value="">
<OPTION value="posta ordinaria"> posta ordinaria&nbsp;&nbsp;
<OPTION value="raccomandata"> raccomandata
<OPTION Value="telegramma"> telegramma
<OPTION value="fax"> fax
<OPTION value="email"> email
<OPTION value="consegna a mano"> consegna a mano
</select>
</label>


<label> <br>Note:<br><input size="40" type="text" name="note" />

</label>


<br>
<br>
<input type="button" value="REGISTRA" onClick="Controllo()" /><br><br>
</form>




</p></div>
					
			
<div class="footer">

					
				</div>
		</div>
			
			<!-- post end -->

		</div>

<script language="javascript">
 <!--
  function Controllo() 
  {
	//acquisisco il valore delle variabili
	var oggetto = document.modulo.oggetto.value;

    
	//controllo coerenza dati
	
	if ((oggetto == "") || (oggetto == "undefined")) 
	{
           alert("Il campo OGGETTO e' obbligatorio");
           document.modulo.oggetto.focus();
           return false;
      }
	
	//mando i dati alla pagina
	else 
	{
           document.modulo.action = "login0.php?corpus=protocollo3&urlpdf=<?php echo $urlpdf;?>&idlettera=<?php echo $idlettera;?>";
           document.modulo.submit();
      }
  }
 //-->
</script> 
