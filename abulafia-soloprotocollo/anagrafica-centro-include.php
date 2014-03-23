<?php
$urlfoto= $_GET['urlfoto'];
if (!$urlfoto) { $urlfoto = 'sagoma.jpg'; }
$my_anagrafica= new Anagrafica(); //crea un nuovo oggetto Anagrafica
?>

<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Inserimento di un nuovo soggetto in anagrafica</strong></h3>
		</div>
		<div class="panel-body">
		
			<?php
			 if($_GET['upfoto'] == "error") {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-danger">C'e' stato un errore nel caricamento della foto, controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.</div>
				</div>
			</div>
			<?php
			}
			?>
			
			<?php
			 if($_GET['upfoto'] == "success") {
			?>
			<div class="row">
				<div class="col-xs-5">
					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Foto inserita correttamente</div>
				</div>
			</div>
			<?php
			}
			?>
			
			<div class="form-group">
			<label>Associa una foto:</label>
			<form role="form" enctype="multipart/form-data" action="login0.php?corpus=upload-foto" method="POST">
			<table>
			<tr>

			<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['fotomaxfilesize'];?>" />			
			<input name="uploadedfile" type="file" id="exampleInputFile">
			<br>
			<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Salva</button>
			</td>

			<td><img src="foto/<?php echo $urlfoto ;?>" height="100"></td>

			</tr>
			</table>
			</form>

			<form name="modulo" method="post" >

			<div class="form-group">
				<label>Tipologia:</label>
				<div class="row">
					<div class="col-xs-2">
						<select class="form-control input-sm"  size=1 cols=4 NAME="anagraficatipologia" onChange="Change()">
						<OPTION selected value="">Scegli...
						<OPTION value="persona"> Persona Fisica
						<OPTION value="carica"> Carica Elettiva o Incarico
						<OPTION Value="ente"> Ente
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Cognome o Denominazione:</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control input-sm" size="40" name="cognome" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Nome:</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control input-sm" size="40" name="nome" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Nato il (gg-mm-aaaa)</label>
				<div class="row">
					<div class="col-xs-4">
						<table><tr>
						
						<td>
						<select class="form-control input-sm" size="1" cols=4 type="text" name="nascitadatagiorno" disabled />
						<OPTION selected value="01">
						<?php
						$iterazionemese = 0;
						while ($iterazionemese < 31) { $iterazionemese = $iterazionemese +1;?>
						<OPTION value="<?php echo $iterazionemese ;?>"> <?php echo $iterazionemese?>
						<?php } ?>
						</select>
						</select>
						</td>
						
						<td>
						<select class="form-control input-sm" size="1" cols=4 type="text" name="nascitadatamese" disabled />
						<OPTION selected value="01"> &nbsp;&nbsp;
						<?php
						$iterazionemese = 0;
						while ($iterazionemese < 12) { $iterazionemese = $iterazionemese +1;?>
						<OPTION value="<?php echo $iterazionemese ;?>"> <?php echo $iterazionemese?>
						<?php } ?>
						</select>
						</td>
						
						<td>
						<select class="form-control input-sm" size="1" cols=4 type="text" name="nascitadataanno" disabled />
						<OPTION selected value="1901"> &nbsp;&nbsp;
						<?php 
						$iterazioneannonascita = 1920;
						while ($iterazioneannonascita < strftime("%Y") ) { $iterazioneannonascita = $iterazioneannonascita +1;?> 
						<OPTION value="<?php echo $iterazioneannonascita;?>"> <?php echo $iterazioneannonascita;}?>
						</select>
						</td>
						
						</tr></table>
						
					</div>						
				</div>
			</div>
			
			<div class="form-group">
				<label>Comune di nascita:</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control input-sm" size="30" name="nascitacomune" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Provincia di nascita:</label>
				<div class="row">
					<div class="col-xs-1">
						<input type="text" class="form-control input-sm" size="40" name="nascitaprovincia" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Stato:</label>
				<div class="row">
					<div class="col-xs-3">
						<input type="text" class="form-control input-sm" size="40" name="nascitastato" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Residente in via:</label>
				<div class="row">
					<div class="col-xs-5">
						<input type="text" class="form-control input-sm" size="40" name="residenzavia" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>N:</label>
				<div class="row">
					<div class="col-xs-1">
						<input type="text" class="form-control input-sm" size="40" name="residenzacivico" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Comune di:</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control input-sm" size="40" name="residenzacomune" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Provincia:</label>
				<div class="row">
					<div class="col-xs-1">
						<input type="text" class="form-control input-sm" size="40" name="residenzaprovincia" disabled>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>CAP:</label>
				<div class="row">
					<div class="col-xs-2">
						<input type="text" class="form-control input-sm" size="40" name="residenzacap" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Stato di residenza:</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control input-sm" size="40" name="residenzastato" disabled>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Gruppo sanguigno:</label>
				<div class="row">
					<div class="col-xs-2">
						<select class="form-control input-sm"  size=1 cols=4 NAME="grupposanguigno" onChange="Change()" disabled>
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
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Codice Fiscale:</label>
				<div class="row">
					<div class="col-xs-4">
						<input type="text" class="form-control input-sm" size="40" name="codicefiscale" disabled>
					</div>
				</div>
			</div>
			
			<label>Recapito:</label>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-2">
						<SELECT class="form-control input-sm" size=1 cols=4 NAME="tipo"  disabled><br>
						<OPTION Value=""> seleziona tipo
						<OPTION Value="email"> E-Mail
						<OPTION value="fisso"> Fisso
						<OPTION value="cell"> Cell.
						<OPTION Value="fax"> Fax
						<OPTION Value="msn"> MSN
						<OPTION Value="facebook">Facebook
						<OPTION Value="twitter"> Twitter
						</select>
					</div>

					<div class="col-xs-3">
						<input type="text" class="form-control input-sm" size="40" name="numero" disabled>
					</div>
				</div>
			</div>

			
			<label>Altro recapito:</label>
			<div class="form-group">
				<div class="row">
					<div class="col-xs-2">
						<SELECT class="form-control input-sm" size=1 cols=4 NAME="tipo2"  disabled><br>
						<OPTION Value=""> seleziona tipo
						<OPTION Value="email"> E-Mail
						<OPTION value="fisso"> Fisso
						<OPTION value="cell"> Cell.
						<OPTION Value="fax"> Fax
						<OPTION Value="msn"> MSN
						<OPTION Value="facebook">Facebook
						<OPTION Value="twitter"> Twitter
						</select>
					</div>

					<div class="col-xs-3">
						<input type="text" class="form-control input-sm" size="40" name="numero2" disabled>
					</div>
				</div>
			</div>
			
			
			<button type="button" class="btn btn-default" onClick="Controllo()">Inserisci</button>

			</form>

		</div>
	</div>	
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
