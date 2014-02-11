<?php
$urlfoto= $_GET['urlfoto'];
$my_anagrafica= new Anagrafica(); //crea un nuovo oggetto Anagrafica
?>


<div id="primarycontent">
		




		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Inserimento di un nuovo soggetto:</u></h3>
				
				</div>
				<div class="content">
					<p><b> 

<img src="foto/<?php echo $urlfoto ;?>" height="100">
<form enctype="multipart/form-data" action="login0.php?corpus=upload-foto" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['fotomaxfilesize'];?>" />
Carica una foto:<br> <input size="22" name="uploadedfile" type="file" />
<input type="submit" value="Upload" />
</form>
<form name="modulo" method="post" >
<label> <br>Tipologia:<br>
<?php if ($_SESSION['auth'] > 10) {?>
<SELECT size=1 cols=4 NAME="anagraficatipologia" onChange="Change()">
<OPTION selected value="">Scegli...
<OPTION value="persona"> Persona Fisica
<OPTION value="carica"> Carica Elettiva o Incarico&nbsp;
<OPTION value="gruppo"> Gruppo Pionieri
<OPTION Value="ente"> Ente
</select>
<?php } else { ?>	
<SELECT size=1 cols=4 NAME="anagraficatipologia" onChange="Change()">
<OPTION selected value="">Scegli...
<OPTION value="persona"> Persona Fisica &nbsp 
</select>
<?php } ?>	
</label>
<br>
<label>Cognome o Denominazione <br><input size="40" type="text" name="cognome" disabled />
</label>

<label> <br>Nome<br><input size="40" type="text" name="nome" disabled />

</label>

<label> <br>Nato il (gg-mm-aaaa)<br>
<select size="1" cols=4 type="text" name="nascitadatagiorno" disabled />
<OPTION selected value="01"> &nbsp;&nbsp;
<?php
$iterazionemese = 0;
while ($iterazionemese < 31) { $iterazionemese = $iterazionemese +1;?>
<OPTION value="<?php echo $iterazionemese ;?>"> <?php echo $iterazionemese?>&nbsp;&nbsp; 
<?php } ?>
</select>
</select>
</label>
<label>
<select size="1" cols=4 type="text" name="nascitadatamese" disabled />
<OPTION selected value="01"> &nbsp;&nbsp;
<?php
$iterazionemese = 0;
while ($iterazionemese < 12) { $iterazionemese = $iterazionemese +1;?>
<OPTION value="<?php echo $iterazionemese ;?>"> <?php echo $iterazionemese?>&nbsp;&nbsp; 
<?php } ?>
</select>
</label>

<label>
<select size="1" cols=4 type="text" name="nascitadataanno" disabled />
<OPTION selected value="1901"> &nbsp;&nbsp;
<?php 
$iterazioneannonascita = 1920;
while ($iterazioneannonascita < strftime("%Y") ) { $iterazioneannonascita = $iterazioneannonascita +1;?> 
<OPTION value="<?php echo $iterazioneannonascita;?>"> <?php echo $iterazioneannonascita;}?>
</select>
</label>
<br>
<?php
$my_anagrafica -> publscegliregione ('nascita'); //richiamo del metodo "scegli regione" dell'oggetto Anagrafica
?>

<label> <br>Comune <br><input size="30" type="text" name="nascitacomune" disabled />
</label>

<label>  Prov.  <input size="3" type="text" name="nascitaprovincia" disabled />
</label>

<label> <br>Stato<br><input size="40" type="text" name="nascitastato"  value="italia" disabled />
</label>

<label> <br>Residente in (via)<br><input size="30" type="text" name="residenzavia" disabled />
</label>

<label> Num. <input size="3" type="text" name="residenzacivico" disabled />
</label>

<label> <br>Residente in (comune)<br><input size="30" type="text" name="residenzacomune" disabled />
</label>

<label> Prov. <input size="3" type="text" name="residenzaprovincia" disabled />
</label>

<label> <br>Codice di avviamento postale<br><input size="40" type="text" name="residenzacap" disabled />
</label>

<label> <br>Residente in (stato)<br><input size="40" type="text" name="residenzastato" value="italia"  disabled />
</label>







<label> <br>Gruppo Sanguigno<br>

<SELECT size=1 cols=4 NAME="grupposanguigno"  disabled>
<OPTION selected value="">
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

<label> <br>Codice Fiscale<br><input size="40" type="text" name="codicefiscale"  disabled />
</label>

<label> <br>Telefono/Fax/E-Mail/Contatto MSN<br><input size="27" type="text" name="numero"  disabled />
</label>

<label>  Tipo  <SELECT size=1 cols=4 NAME="tipo"  disabled><br>
<OPTION Value="email"> E-Mail
<OPTION value="fisso"> Fisso
<OPTION value="cell"> Cell.
<OPTION Value="fax"> Fax
<OPTION Value="msn"> MSN
<OPTION Value="facebook"> Url Profilo Facebook&nbsp;
<OPTION Value="twitter"> Twitter&nbsp;
</label>
</select>
<label> <br>Altro Telefono/Fax/E-Mail/Contatto MSN<br><input size="27" type="text" name="numero2"  disabled />
</label>

<label>  Tipo  <SELECT size=1 cols=4 NAME="tipo2" disabled><br>
<OPTION value="cell"> Cell.
<OPTION Value="email"> E-Mail
<OPTION value="fisso"> Fisso
<OPTION Value="fax"> Fax
<OPTION Value="msn"> MSN
<OPTION Value="facebook"> Url Profilo Facebook&nbsp;
<OPTION Value="twitter"> Twitter&nbsp;
</label>

</select>

<br>
(Ulteriori recapiti telefonici o informatici potranno essere aggiunti<br> dopo aver creato l'anagrafica, cliccando su "<i>modifica questa anagrafica</i>")

<br><br>

<input type="button" value="INSERISCI" onClick="Controllo()" /><br><br></b>
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
      var tipo = document.modulo.anagraficatipologia.options[document.modulo.anagraficatipologia.selectedIndex].value;
    
	//controllo coerenza dati
	if ((tipo == "") || (tipo == "undefined")) 
	{
           alert("Il campo Tipologia è obbligatorio");
           document.modulo.anagraficatipologia.focus();
           return false;
      }
	else if ((cognome == "") || (cognome == "undefined")) 
	{
           alert("Il campo Cognome è obbligatorio");
           document.modulo.cognome.focus();
           return false;
      }
	
	//mando i dati alla pagina
	else 
	{
           document.modulo.action = "login0.php?corpus=inserisci2&url-foto=<?php echo $urlfoto;?>";
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
	  document.modulo.numero2.disabled = false;
	  document.modulo.tipo2.disabled = false;
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
	  document.modulo.numero2.disabled = false;
	  document.modulo.tipo2.disabled = false;

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
	  document.modulo.numero2.disabled = false;
	  document.modulo.tipo2.disabled = false;
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
	  document.modulo.numero2.disabled = false;
	  document.modulo.tipo2.disabled = false;
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
	  document.modulo.numero2.disabled = false;
	  document.modulo.tipo2.disabled = false;
	}
  }
 //-->
</script> 
