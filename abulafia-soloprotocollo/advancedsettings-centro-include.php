<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
if ($_SESSION['auth'] < 99) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>
<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Advanced Settings</strong></h3>
		</div>
		<div class="panel-body">
		
		<?php
			 if( isset($_GET['update']) && $_GET['update'] == "error") {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-danger">C'e' stato un errore nella modifica delle impostazioni, riprova in seguito o contatta l'amministratore del server.</div>
				</div>
			</div>
			<?php
			}
			?>
			
			<?php
			 if( isset($_GET['update']) && $_GET['update'] == "success") {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Impostazioni modificate con successo!</div>
				</div>
			</div>
			<?php
			}
		?>

<?php //funzione per determinare se la tabella "lettere" è vuota. In caso positivo è possibile settare il campo "primo numero per il protocollo"
$contalettere=mysql_query("select count(*) from lettere$annoprotocollo where lettere$annoprotocollo.datalettera!='0000-00-00'");
$res_count=mysql_fetch_row($contalettere);
$contalettere= $res_count[0] +1 ;
//fine funzione per determinare se la tabella "lettere" è vuota. 
?>
Per rendere effettive le modifiche e' consigliato effettuare il logout.
<br>
<form name="modifica" method="post" class="form-group">
<label> <br>Nome dell'applicativo:<br><input class="form-control" size="50" type="text" name="nomeapplicativo"  value="<?php echo $_SESSION['nomeapplicativo'];?>"/>
</label><br>
<label> <br>Descrizione breve (in alto a destra)<br><input class="form-control" size="50" type="text" name="headerdescription"  value="<?php echo $_SESSION['headerdescription'];?>"/>
</label><br>
<label> <br>Numero Versione <br><input class="form-control" size="50" type="text" name="version"  value="<?php echo $_SESSION['version'];?>"/>
</label><br>
<label> <br>Email <br><input class="form-control" size="50" type="text" name="email"  value="<?php echo $_SESSION['email'];?>"/>
</label><br>
<label> <br>Max File Size (allegati del Protocollo, <b>espressi in byte</B>) <br><input class="form-control" size="50" type="text" name="protocollomaxfilesize"  value="<?php echo $_SESSION['protocollomaxfilesize'];?>"/>
</label><br>
<label> <br>Anno Corrente per il Protocollo <br><input class="form-control" size="50" type="text" name="annoprotocollo"  value="<?php echo $_SESSION['annoprotocollo'];?>" disabled/>
</label><br>
<label> <br>Numero iniziale per il Protocollo (settabile solo nella prima installazione) <br><input class="form-control" size="50" type="text" name="primoprotocollo"  value="<?php echo $contalettere;?>"/>
	<script language="javascript">
	var primoprotocollo = document.modifica.primoprotocollo.value;
		if (primoprotocollo > 1) 
		{
	 		 document.modifica.primoprotocollo.disabled = true;
		}
	</script>
</label><br>
<label> <br>Max File Size (foto dell'anagrafica, <b>espresse in byte</B>) <br><input class="form-control" size="50" type="text" name="fotomaxfilesize"  value="<?php echo $_SESSION['fotomaxfilesize'];?>"/>
</label><br>
<label> <br>Pagina principale<br><input class="form-control" size="50" type="text" name="paginaprincipale"  value="<?php echo $_SESSION['paginaprincipale'];?>"/>
</label><br>
<label> <br>Mittente Mail-Protocollo <br><input class="form-control" size="50" type="text" name="mittente"  value="<?php echo $_SESSION['mittente'];?>"/>
</label><br>
<label> <br>Header Mail-Protocollo <br><input class="form-control" size="50" type="text" name="headermail"  value="<?php echo $_SESSION['headermail'];?>"/>
</label><br>
<label> <br>Footer Mail-Protocollo <br><input class="form-control" size="50" type="text" name="footermail"  value="<?php echo $_SESSION['footermail'];?>"/>
</label><br><br>
<button class="btn btn-primary" onClick="Controllo()" />Modifica</button>
</form>

</div>
</div>


<script language="javascript">
 <!--
  function Controllo() 
  {
	//acquisisco il valore delle variabili
	var nomeapplicativo = document.modifica.nomeapplicativo.value;
	var headerdescription = document.modifica.headerdescription.value;   
	var version = document.modifica.version.value;
	var email = document.modifica.email.value;
	var paginaprincipale = document.modifica.paginaprincipale.value;
	var protocollomaxfilesize = document.modifica.protocollomaxfilesize.value;
	var annoprotocollo = document.modifica.annoprotocollo.value;
	var fotomaxfilesize = document.modifica.fotomaxfilesize.value;
	var mittente = document.modifica.mittente.value;
	var headermail = document.modifica.headermail.value;
	var footermail = document.modifica.footermail.value;
	
	if ((footermail == "") || (footermail == "undefined")) 
	{
           alert("Il campo Footer Mail-Protocollo è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((headermail == "") || (headermail == "undefined")) 
	{
           alert("Il campo Header Mail-Protocollo è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }	
	if ((mittente == "") || (mittente == "undefined")) 
	{
           alert("Il campo Mittente Mail-Protocollo è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((version == "") || (version == "undefined")) 
	{
           alert("Il campo Versione è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((nomeapplicativo == "") || (nomeapplicativo == "undefined")) 
	{
           alert("Il campo Nome dell'Applicativo è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((email == "") || (email == "undefined")) 
	{
           alert("Il campo EMAIL è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((paginaprincipale == "") || (paginaprincipale == "undefined")) 
	{
           alert("Il campo Pagina Principale è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((protocollomaxfilesize == "") || (protocollomaxfilesize == "undefined")) 
	{
           alert("Il campo Max File Size (protocollo) è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((fotomaxfilesize == "") || (fotomaxfilesize == "undefined")) 
	{
           alert("Il campo Max File Size (foto) è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((annoprotocollo == "") || (annoprotocollo == "undefined")) 
	{
           alert("Il campo Anno Corrente per il Protocollo è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((headerdescription == "") || (headerdescription == "undefined")) 
	{
           alert("Il campo Descrizione Breve è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	
	
	//mando i dati alla pagina
	else 
	{
           document.modifica.action = "advancedsettings-inserisci.php";
           document.modifica.submit();
      }
  }
 //-->
</script> 
