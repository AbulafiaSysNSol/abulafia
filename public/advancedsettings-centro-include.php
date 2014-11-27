<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
	if ($_SESSION['auth'] < 99) { 
		echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; 
		exit ();
	}
	$anag = new Anagrafica();
	$admin = $anag->isAdmin($_SESSION['loginid']);
?>
<div class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><strong><i class="fa fa-cogs"></i> Advanced Settings</strong></h3>
		</div>
		<div class="panel-body">
			<?php
				 if( isset($_GET['update']) && $_GET['update'] == "error") {
				?>
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span><b> Attenzione:</b> c'e' stato un errore nella modifica delle impostazioni, riprova in seguito o contatta l'amministratore del server.</div>
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
						<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Impostazioni modificate con <b>successo!</b></div>
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
			
			<form name="modifica" method="post" class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label>Nome dell'applicativo:</label>
					<input class="form-control" type="text" name="nomeapplicativo"  value="<?php echo $_SESSION['nomeapplicativo'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Descrizione breve:</label>
					<input class="form-control" type="text" name="headerdescription"  value="<?php echo $_SESSION['headerdescription'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Numero Versione</label>
					<input class="form-control" type="text" name="version"  value="<?php echo $_SESSION['version'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Email</label>
					<input class="form-control" type="text" name="email"  value="<?php echo $_SESSION['email'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Max File Size (allegati del Protocollo, <b>espressi in byte</b>)</label>
					<input class="form-control" type="text" name="protocollomaxfilesize"  value="<?php echo $_SESSION['protocollomaxfilesize'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Anno Corrente per il Protocollo</label>
					<input class="form-control" type="text" name="annoprotocollo"  value="<?php echo $_SESSION['annoprotocollo'];?>" disabled />
					<br>
					<label>Sede (città)</label>
					<input class="form-control" type="text" name="sede"  value="<?php echo $_SESSION['sede'];?>"/>
					<br>
					<label>Denominazione Comitato</label>
					<input class="form-control" type="text" name="denominazione"  value="<?php echo $_SESSION['denominazione'];?>"/>
				</div>
				
				<div class="col-xs-6">
					<label>Numero iniziale per il Protocollo (settabile solo nella prima installazione)</label>
					<input class="form-control" size="50" type="text" name="primoprotocollo"  value="<?php echo $contalettere;?>"/>
						<script language="javascript">
						var primoprotocollo = document.modifica.primoprotocollo.value;
							if (primoprotocollo > 1) 
							{
								 document.modifica.primoprotocollo.disabled = true;
							}
						</script>
					<br>
					<label>Max File Size (foto dell'anagrafica, <b>espresse in byte</b>)</label>
					<input class="form-control" size="50" type="text" name="fotomaxfilesize"  value="<?php echo $_SESSION['fotomaxfilesize'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Pagina principale</label>
					<input class="form-control" size="50" type="text" name="paginaprincipale"  value="<?php echo $_SESSION['paginaprincipale'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
					<br>
					<label>Mittente Mail-Protocollo</label>
					<input class="form-control" size="50" type="text" name="mittente"  value="<?php echo $_SESSION['mittente'];?>"/>
					<br>
					<label>Header Mail-Protocollo</label>
					<input class="form-control" size="50" type="text" name="headermail"  value="<?php echo $_SESSION['headermail'];?>"/>
					<br>
					<label>Footer Mail-Protocollo</label>
					<input class="form-control" size="50" type="text" name="footermail"  value="<?php echo $_SESSION['footermail'];?>"/>
					<br>
					<label>Vertice (presidente/commissario)</label>
					<input class="form-control" type="text" name="vertice"  value="<?php echo $_SESSION['vertice'];?>"/>
					<br>
					<label>Inizio utilizzo Abulafia (aaaa/mm/gg)</label>
					<input class="form-control" type="text" name="inizio"  value="<?php echo $_SESSION['inizio'];?>" <?php if(!$admin) echo 'disabled'; ?>/>
				</div>
			</div>
			<br>
			<center>
			<button class="btn btn-info btn-lg" onClick="Controllo()" /><span class="glyphicon glyphicon-edit"></span> Modifica</button>
			</center>
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
