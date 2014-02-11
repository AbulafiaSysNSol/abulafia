<?php
$level = $_SESSION['auth'];
$id = $_GET['id'];

//filtro per consentire agli ispettori (che hanno un livello auth basso) di lmodificare l'anagrafica dei soli componenti del proprio gruppo
$gruppo=mysql_query("select distinct * from joinanagraficagruppo where idanagrafica='$id'");
$gruppo2= mysql_fetch_array($gruppo); //definizione del gruppo di cui mostrare i componenti

$gruppoutente=$_SESSION['gruppo']; //definizione del gruppo cui appartiene l'utente di abulafia loggato al momento

//limitazione per gli utenti di basso livello che possono vedere solo gli appartenenti al proprio gruppo
if (($level < 11) and ($gruppoutente != $gruppo2['idgruppo'])) { 
echo "Non hai l'autorizzazione necessaria per accedere a questa pagina. Se ritieni di averne diritto, contatta l'amministratore.";
exit();
}


//inizio del passaggio dei dati dalla pagina precedente
$from = $_GET['from'];
$tabella = $_GET['tabella'];
$urlfoto =$_GET['url-foto'];
$urlfoto2 =$_POST['url-foto2'];
$numero = $_POST['numero'];
$tipo = $_POST['tipo'];
$numero2 = $_GET['numero'];
$tipo2 = $_GET['tipo'];
//fine del passaggio dei dati dalla pagina precedente

if ($from == 'foto-modifica') {$inserisci= mysql_query("UPDATE anagrafica SET urlfoto = '$urlfoto' where idanagrafica = '$id' " );
}
if ($from == 'numero-modifica') {$inserisci= mysql_query("insert into jointelefonipersone values('$id', '$numero', '$tipo' )");
}
if ($from == 'elimina-numero-modifica') {$elimina= mysql_query("DELETE FROM jointelefonipersone WHERE numero = '$numero2' and tipo = '$tipo2' and idanagrafica='$id'");
}
$risultati= mysql_query ("select distinct * from anagrafica where anagrafica.idanagrafica ='$id'");
$risultati2= mysql_query ("select * from jointelefonipersone where jointelefonipersone.idanagrafica='$id' ");
$row = mysql_fetch_array($risultati);
$data = $row['nascitadata'] ;
list($anno, $mese, $giorno) = explode("-", $data);
$data2 = "$giorno-$mese-$anno";

?>
	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Modifica soggetto:</u></h3>
				
				</div>
				<div class="content">
					<p>

<img src="foto/<?php echo $row['urlfoto'] ;?>" height="100">

<form enctype="multipart/form-data" action="login0.php?corpus=modifica-foto&id=<?php echo $id;?>" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['fotomaxfilesize'];?>" />
Carica una foto:<br> <input size="22" name="uploadedfile" type="file" />
<input type="submit" value="Upload" />
</form>

<body onLoad="Change()">

<br><b>Recapiti:</b><br><?php
while ($row2 = mysql_fetch_array($risultati2)) {
echo $row2['numero'] . '  -  ' . $row2['tipo'] ;?> <a href="login0.php?corpus=modifica-anagrafica&from=elimina-numero-modifica&id=<?php echo $id;?>&numero=<?php echo $row2['numero'];?>&tipo=<?php echo $row2['tipo'];?>">elimina</a><br><?php
}
?>
<form action="login0.php?corpus=modifica-anagrafica&from=numero-modifica&id=<?php echo $id;?>" method="post" >
<label>Numero/Descrizione<br><input size="18" type="text" name="numero" />
</label>

<label>  Tipo  <SELECT size=1 cols=4 NAME="tipo"><br>
<OPTION value="fisso"> Fisso
<OPTION value="cell"> Cell.
<OPTION Value="fax"> Fax
<OPTION Value="email"> E-Mail
<OPTION Value="msn"> MSN
<OPTION Value="facebook"> Url Facebook
</label>
</select>
<input type="submit" value="AGGIUNGI" /><br>
</form>

<form name="modulo" method="post">

<label> <br>Tipologia:<br>

<?php if ($_SESSION['auth'] > 10) {?>

<SELECT size=1 cols=4 NAME="anagraficatipologia" onChange="Change()">

<?php if( $row['tipologia'] == 'persona') { ?>
<OPTION value="persona" selected >Persona Fisica </OPTION>
<?php } else { ?>
<OPTION value="persona">Persona Fisica</OPTION>
<?php } ?>

<?php if( $row['tipologia'] == 'carica') { ?>
<OPTION value="carica" selected >Carica Elettiva o Incarico&nbsp;</OPTION>
<?php } else { ?>
<OPTION value="carica">Carica Elettiva o Incarico&nbsp;</OPTION>
<?php } ?>

<?php if( $row['tipologia'] == 'gruppo') { ?>
<OPTION value="gruppo" selected >Gruppo Pionieri</OPTION>
<?php } else { ?>
<OPTION value="gruppo">Gruppo Pionieri</OPTION>
<?php } ?>

<?php if( $row['tipologia'] == 'ente') { ?>
<OPTION Value="ente" selected >Ente</OPTION>
<?php } else { ?>
<OPTION value="ente">Ente</OPTION>
<?php } ?>

</select>
<?php } else { ?>

<SELECT size=1 cols=4 NAME="anagraficatipologia" onChange="Change()">
<OPTION value="persona" selected >Persona Fisica </OPTION>
<?php } ?>

</label>
<br>

<label><b> Cognome o denominazione <br><input size="40" type="text" name="cognome" value="<?php echo $row['cognome'];?>" />
</label>

<label> <br>Nome (lasciare vuoto in caso di ente o carica)<br><input size="40" type="text" name="nome" value="<?php echo $row['nome'];?>"/>

</label>

<label> <br>Nato il (gg-mm-aaaa)<br>
<select size="1" cols=4 type="text" name="nascitadatagiorno" />
<OPTION selected value="<?php echo $giorno;?>"> <?php echo $giorno;?>
<?php
$iterazionegiornodelmese = 0;
while ($iterazionegiornodelmese < 31) { $iterazionegiornodelmese = $iterazionegiornodelmese +1;?>
<OPTION value="<?php echo $iterazionegiornodelmese;?>"> <?php echo $iterazionegiornodelmese;?>&nbsp;&nbsp; 
<?php } ?>
</select>
</label>

<label>
<select size="1" cols=4 type="text" name="nascitadatamese" />
<OPTION selected value="<?php echo $mese;?>"> <?php echo $mese;?>
<?php
$iterazionemese = 0;
while ($iterazionemese < 12) { $iterazionemese = $iterazionemese +1;?>
<OPTION value="<?php echo $iterazionemese;?>"> <?php echo $iterazionemese;?>&nbsp;&nbsp; 
<?php } ?>
</select>
</label>

<label>
<select size="1" cols=4 type="text" name="nascitadataanno" />
<OPTION selected value="<?php echo $anno;?>"> <?php echo $anno;?>&nbsp;&nbsp; 
<?php 
$iterazioneannonascita =1920;
while ($iterazioneannonascita < strftime("%Y") ) { $iterazioneannonascita = $iterazioneannonascita +1;?> 
<OPTION value="<?php echo $iterazioneannonascita;?>"> <?php echo $iterazioneannonascita;}?>
</select>

</label>

<label> <br>Comune <br><input size="30" type="text" name="nascitacomune"  value="<?php echo $row['nascitacomune'];?>"/>
</label>

<label>  Prov.  <input size="3" type="text" name="nascitaprovincia"  value="<?php echo $row['nascitaprovincia'];?>"/>
</label>

<label> <br>Stato<br><input size="40" type="text" name="nascitastato"  value="<?php echo $row['nascitastato'];?>"/>
</label>

<label> <br>Residente in (via)<br><input size="30" type="text" name="residenzavia"  value="<?php echo $row['residenzavia'];?>"/>
</label>

<label> Num. <input size="3" type="text" name="residenzacivico"  value="<?php echo $row['residenzacivico'];?>"/>
</label>

<label> <br>Residente in (comune)<br><input size="30" type="text" name="residenzacomune"  value="<?php echo $row['residenzacitta'];?>"/>
</label>

<label> Prov. <input size="3" type="text" name="residenzaprovincia"  value="<?php echo $row['residenzaprovincia'];?>"/>
</label>

<label><br>Codice di avviamento postale<br> <input size="30" type="text" name="residenzacap"  value="<?php echo $row['residenzacap'];?>"/>
</label>

<label> <br>Residente in (stato)<br><input size="40" type="text" name="residenzastato"  value="<?php echo $row['residenzastato'];?>"/>
</label>


<label> <br>Gruppo Sanguigno<br>

<SELECT size=1 cols=4 NAME="grupposanguigno" >
<OPTION selected="value="<?php echo $row['grupposanguigno'];?>""> <?php echo $row['grupposanguigno'];?>
<OPTION value="0rh+"> 0rh+
<OPTION value="0rh-"> 0rh-
<OPTION Value="Arh+"> Arh+
<OPTION value="Arh-"> Arh-
<OPTION value="Brh+"> Brh+
<OPTION value="Brh-"> Brh-
<OPTION Value="ABrh+"> ABrh+&nbsp;
<OPTION value="ABrh-"> ABrh-
</select>
</label>

<label> <br>Codice Fiscale<br><input size="40" type="text" name="codicefiscale" value="<?php echo $row['codicefiscale'];?>" />
</label>
</b>

</body>

<br>


<br>

<input type="button" value="MODIFICA" onClick="Controllo()" /><br><br>
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
	var cognome = document.modulo.cognome.value;
      
	if ((cognome == "") || (cognome == "undefined")) 
	{
           alert("Il campo Cognome è obbligatorio");
           document.modulo.cognome.focus();
           return false;
      }
	
	//mando i dati alla pagina
	else 
	{
           document.modulo.action = "login0.php?corpus=modifica-anagrafica-inserimento&id=<?php echo $id;?>";
           document.modulo.submit();
      }
  }
  
  function Change() 
  {
	//acquisisco il valore delle variabili
	var type = document.modulo.anagraficatipologia.options[document.modulo.anagraficatipologia.selectedIndex].value;
	
	if (type == "persona") 
	{
	  document.modulo.cognome.disabled = false;
          document.modulo.nome.disabled = false;
	  document.modulo.nascitadatagiorno.disabled = false;
	  document.modulo.nascitadatamese.disabled = false;
	  document.modulo.nascitadataanno.disabled = false;
	  document.modulo.nascitacomune.disabled = false;
	  document.modulo.nascitaprovincia.disabled = false;
	  document.modulo.nascitastato.disabled = false;
	  document.modulo.residenzavia.disabled = false;
	  document.modulo.residenzacivico.disabled = false;
	  document.modulo.residenzacomune.disabled = false;
	  document.modulo.residenzaprovincia.disabled = false;
	  document.modulo.residenzacap.disabled = false;
	  document.modulo.residenzastato.disabled = false;
	  document.modulo.grupposanguigno.disabled = false;
	  document.modulo.codicefiscale.disabled = false;
	  document.modulo.numero.disabled = false;
	  document.modulo.tipo.disabled = false;
	}
	  	  
	if (type == "gruppo") 
	{
  	  document.modulo.cognome.disabled = false;
          document.modulo.nome.disabled = true;
	  document.modulo.nascitadatagiorno.disabled = false;
	  document.modulo.nascitadatamese.disabled = false;
	  document.modulo.nascitadataanno.disabled = false;
	  document.modulo.nascitacomune.disabled = true;
	  document.modulo.nascitaprovincia.disabled = true;
	  document.modulo.nascitastato.disabled = true;
	  document.modulo.residenzavia.disabled = false;
	  document.modulo.residenzacivico.disabled = false;
	  document.modulo.residenzacomune.disabled = false;
	  document.modulo.residenzaprovincia.disabled = false;
	  document.modulo.residenzacap.disabled = false;
	  document.modulo.residenzastato.disabled = false;
	  document.modulo.grupposanguigno.disabled = true;
	  document.modulo.codicefiscale.disabled = true;
	  document.modulo.numero.disabled = false;
	  document.modulo.tipo.disabled = false;


	}
	
	if (type == "carica") 
	{
	  document.modulo.cognome.disabled = false;
	  document.modulo.nome.disabled = true;
	  document.modulo.nascitadatagiorno.disabled = true;
	  document.modulo.nascitadatamese.disabled = true;
	  document.modulo.nascitadataanno.disabled = true;
	  document.modulo.nascitacomune.disabled = true;
	  document.modulo.nascitaprovincia.disabled = true;
	  document.modulo.nascitastato.disabled = true;
	  document.modulo.residenzavia.disabled = true;
	  document.modulo.residenzacivico.disabled = true;
	  document.modulo.residenzacomune.disabled = true;
	  document.modulo.residenzaprovincia.disabled = true;
	  document.modulo.residenzacap.disabled = true;
	  document.modulo.residenzastato.disabled = true;
	  document.modulo.grupposanguigno.disabled = true;
	  document.modulo.codicefiscale.disabled = true;
	  document.modulo.numero.disabled = false;
	  document.modulo.tipo.disabled = false;
	}
	
	if (type == "ente") 
	{
	  document.modulo.cognome.disabled = false;	
	  document.modulo.nome.disabled = true;
	  document.modulo.nascitadatagiorno.disabled = true;
	  document.modulo.nascitadatamese.disabled = true;
	  document.modulo.nascitadataanno.disabled = true;
	  document.modulo.nascitacomune.disabled = true;
	  document.modulo.nascitaprovincia.disabled = true;
	  document.modulo.nascitastato.disabled = true;
	  document.modulo.residenzavia.disabled = false;
	  document.modulo.residenzacivico.disabled = false;
	  document.modulo.residenzacomune.disabled = false;
	  document.modulo.residenzaprovincia.disabled = false;
	  document.modulo.residenzacap.disabled = false;
	  document.modulo.residenzastato.disabled = false;
	  document.modulo.grupposanguigno.disabled = true;
	  document.modulo.codicefiscale.disabled = false;
	  document.modulo.numero.disabled = false;
	  document.modulo.tipo.disabled = false;
	}
	
	if (type == "") 
	{
	  document.modulo.cognome.disabled = true;	
	  document.modulo.nome.disabled = true;
	  document.modulo.nascitadatagiorno.disabled = true;
	  document.modulo.nascitadatamese.disabled = true;
	  document.modulo.nascitadataanno.disabled = true;
	  document.modulo.nascitacomune.disabled = true;
	  document.modulo.nascitaprovincia.disabled = true;
	  document.modulo.nascitastato.disabled = true;
	  document.modulo.residenzavia.disabled = true;
	  document.modulo.residenzacivico.disabled = true;
	  document.modulo.residenzacomune.disabled = true;
	  document.modulo.residenzaprovincia.disabled = true;
	  document.modulo.residenzacap.disabled = true;
	  document.modulo.residenzastato.disabled = true;
	  document.modulo.grupposanguigno.disabled = true;
	  document.modulo.codicefiscale.disabled = true;
	  document.modulo.numero.disabled = true;
	  document.modulo.tipo.disabled = true;
	}
}
 //-->
</script> 


