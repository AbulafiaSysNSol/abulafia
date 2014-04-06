<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
$my_file = new File(); //crea un nuovo oggetto 'file'
$from= $_GET['from'];
$idlettera=$_GET['id'];
$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
if ($_SESSION['annoricercaprotocollo'] != $annoprotocollo) { echo 'Non puoi modificare una registrazione di un protocollo in archivio'; exit();}

//controllo dell'autorizazione necessaria alla modifica del protocollo
$risultati3=mysql_query("select * from joinlettereinserimento$annoprotocollo, users where joinlettereinserimento$annoprotocollo.idlettera='$idlettera' and joinlettereinserimento$annoprotocollo.idinser=users.idanagrafica ");
$row3 = mysql_fetch_array($risultati3);
if (($_SESSION['auth'] <= $row3['auth']) and ($row3['idinser'] !=  $_SESSION['loginid'])) {
echo 'Non hai un livello di autorizzazione sufficiente a modificare questo protocollo.';?> 
<a href="login0.php?corpus=dettagli-protocollo&from=risultati&id=<?php echo $idlettera;?>"><br><br>Vai alla pagina dei Dettagli del Protocollo n°<?php echo $idlettera;?></a><?php
include 'sotto-include.php'; //carica il file con il footer.
exit;
}
//fine controllo dell'autorizazione necessaria alla modifica del protocollo

$row = mysql_fetch_array($risultati);
$datalettera = $row['datalettera'] ;
list($anno, $mese, $giorno) = explode("-", $datalettera);
$dataregistrazione = $row['dataregistrazione'] ;
list($annor, $meser, $giornor) = explode("-", $dataregistrazione);


if ($from =='aggiungi') {
$idanagrafica=$_GET['idanagrafica'];
$aggiungi=mysql_query("insert into joinletteremittenti$annoprotocollo values('$idlettera', '$idanagrafica')");
$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
//$urlpdf = $_GET['urlpdf'];

}
if ($from == 'elimina-mittente') {  
$idanagrafica=$_GET['idanagrafica'];
$idlettera=$_GET['id'];
$elimina=mysql_query("delete from joinletteremittenti$annoprotocollo where idanagrafica='$idanagrafica' and idlettera='$idlettera'");
$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
$urlpdf = $_GET['urlpdf'];
}
if ($from == 'urlpdf') {  
$urlpdf = $_GET['urlpdf'];
$idlettera=$_GET['idlettera'];
$inserisci= mysql_query("UPDATE lettere$annoprotocollo SET urlpdf = '$urlpdf' where idlettera = '$idlettera' " );
$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
$row = mysql_fetch_array($risultati);
$datalettera = $row['datalettera'] ;
list($anno, $mese, $giorno) = explode("-", $datalettera);
$dataregistrazione = $row['dataregistrazione'] ;
list($annor, $meser, $giornor) = explode("-", $dataregistrazione);
}


?>

	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Modifica protocollo numero: <?php echo $row['idlettera'];?> </u></h3>
				
				</div>
				<div class="content">
					<p>
<?php
//$insertid = mysql_insert_id();

//if ($insertid > 0) { $idlettera = $insertid;}
?>
<form enctype="multipart/form-data" action="login0.php?from=modifica-protocollo&corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
Carica il file contenente il documento da registrare:<br> <input size="22" name="uploadedfile" type="file" />
<input type="submit" value="Upload" />
</form>

<p>
<?php
	$download = $my_file -> downloadlink($value[4], $value[0], $annoricercaprotocollo, '30');
	if ($download != "Nessun file associato") 
		{
		echo $download;
		}
					
	else 
		{
		echo "Nessun file associato";
		}
?>
</p>

<form action="login0.php?corpus=prot2-aggiungi-mittente&idlettera=<?php echo $row['idlettera'];?>&urlpdf=<?php echo $row['urlpdf'];?>" method="post" >
<label> <b>Aggiungi mittente/destinatario</b><br> <input type="text" name="cercato"/>
</label>
<input type="submit" value="CERCA" />
</form>
<b>Mittenti/destinatari:<br></b>
<?php

while ($row2 = mysql_fetch_array($risultati2)) {
echo $row2['cognome'] . '  -  ' . $row2['nome'] ;?> <a href="login0.php?corpus=modifica-protocollo&from=elimina-mittente&id=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $row['urlpdf'];?>">elimina</a><br><?php
}
?>
<?php $urlpdf=$row['urlpdf'];?>
<form action="login0.php?from=modifica&dataoriginalegiorno=<?php echo $giornor; ?>&dataoriginalemese=<?php echo $meser; ?>&dataoriginaleanno=<?php echo $annor; ?>&corpus=protocollo3&urlpdf=<?php echo $urlpdf;?>&idlettera=<?php echo $idlettera;?>" method="post" >
<br>
<label><b> Spedita/Ricevuta</b><br>
<select size="1" cols=4 type="text" name="spedita-ricevuta" />
<OPTION selected value="<?php echo $row['speditaricevuta'];?>"> <?php echo $row['speditaricevuta'];?>&nbsp;&nbsp;
<OPTION value="ricevuta"> Ricevuta&nbsp;&nbsp;
<OPTION value="spedita"> Spedita&nbsp;&nbsp;
</select>
</label>

<label> <br>Oggetto della lettera:<br><input size="40" type="text" name="oggetto"value="<?php echo $row['oggetto'];?>"/>

</label>

<label> <br>Data della lettera<br>
<select size="1" cols=4 type="text" name="lettera-data-giorno" />
<OPTION selected value="<?php echo $giorno; ?>"> <?php echo $giorno; ?>
<?php
$iterazionegiornodelmese = 0;
while ($iterazionegiornodelmese < 31) { $iterazionegiornodelmese = $iterazionegiornodelmese +1;?>
<OPTION value="<?php echo $iterazionegiornodelmese;?>"> <?php echo $iterazionegiornodelmese;?>&nbsp;&nbsp; 
<?php } ?>
</select>
</label>
<label>
<select size="1" cols=4 type="text" name="lettera-data-mese" />
<OPTION selected value="<?php echo $mese; ?>"> <?php echo $mese; ?>
<?php
$iterazionemese = 0;
while ($iterazionemese < 12) { $iterazionemese = $iterazionemese +1;?>
<OPTION value="<?php echo $iterazionemese;?>"> <?php echo $iterazionemese;?>&nbsp;&nbsp; 
<?php } ?>
</select>
</label>
<label>
<select size="1" cols=4 type="text" name="lettera-data-anno" />
<OPTION selected value="<?php echo $anno; ?>"> <?php echo $anno; ?>
<?php 
$iterazioneannonascita = 1920;
while ($iterazioneannonascita < strftime("%Y") ) { $iterazioneannonascita = $iterazioneannonascita +1;?> 
<OPTION value="<?php echo $iterazioneannonascita;?>"> <?php echo $iterazioneannonascita;}?>&nbsp;&nbsp;
</select>

</label>



<label> <br>Mezzo di trasmissione<br>

<SELECT size=1 cols=4 NAME="posizione">
<OPTION selected value="<?php echo $row['posizione']; ?>"> <?php echo $row['posizione']; ?>
<OPTION value="posta ordinaria"> posta ordinaria&nbsp;&nbsp;
<OPTION value="raccomandata"> raccomandata
<OPTION Value="telegramma"> telegramma
<OPTION value="fax"> fax
<OPTION value="email"> email
<OPTION value="consegna a mano"> consegna a mano
</select>
</label>


<label> <br>Note:<br><input size="40" type="text" name="note" value="<?php echo $row['note']; ?>"/>

</label>


<br>
<br>
<input type="submit" value="MODIFICA" /><br><br>
</form>




</p></div>
					
			
<div class="footer">

					
				</div>
		</div>
			
			<!-- post end -->

		</div>
		
