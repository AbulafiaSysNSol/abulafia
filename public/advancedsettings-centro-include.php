<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	if (!is_numeric($annoprotocollo))
	{
		echo "Errore nella definizione dell'anno"; 
		exit; 
	}

	//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
	if ($_SESSION['auth'] < 99) 
	{ 
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
				if( isset($_GET['update']) && $_GET['update'] == "error") 
				{
				?>
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-danger center">
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						<b> Attenzione:</b> c'e' stato un errore nella modifica delle impostazioni, 
						riprova in seguito o contatta l'amministratore del server.
						</div>
					</div>
				</div>
				<?php
				}

				if( isset($_GET['update']) && $_GET['update'] == "success") 
				{
				?>
				<div class="row">
					<div class="col-sm-12">
						<center>
						<div class="alert alert-success">
						<span class="glyphicon glyphicon-ok"></span> 
						<b>Impostazioni Salvate!</b>
						</div>
						</center>
					</div>
				</div>
				<?php
				}
							
			try 
				{
   				$connessione->beginTransaction();
				$lettereannoprotocollo="lettere".$annoprotocollo;
				$query = $connessione->prepare("SELECT count(*) 
								from $lettereannoprotocollo
								where datalettera !='0000-00-00'
								"); 
				$query->execute();
				$connessione->commit();
				} 
		
				//gestione dell'eventuale errore della connessione
				catch (PDOException $errorePDO) { 
    				echo "Errore: " . $errorePDO->getMessage();
				$connessione->rollBack();
				}

			$risultati = $query->fetchAll();
			$res_count=$risultati[0];
			
			$contalettere= $res_count[0] +1 ;
			//fine funzione per determinare se la tabella "lettere" è vuota. 
			?>
			
			<form name="modifica" method="post" class="form-group">
			<div class="row">
				<div class="col-sm-4">
					<center>
					<h3><i class="fa fa-cog"></i> Generali:</h3><br>
					</center>
					<label>Nome dell'applicativo:</label>
					<input class="form-control" 
						type="text" 
						name="nomeapplicativo"  
						value="<?php echo $_SESSION['nomeapplicativo'];?>" 
						<?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>
					<label>Descrizione breve:</label>
					<input class="form-control" 
							type="text" 
							name="headerdescription"  
							value="<?php echo $_SESSION['headerdescription'];?>" 
							<?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>
					<label>Numero Versione</label>
					<input class="form-control" 
							type="text" 
							name="version"  
							value="<?php echo $_SESSION['version'];?>" 
							<?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>
					<label>Denominazione</label>
					<input class="form-control" 
							type="text" 
							name="denominazione"  
							value="<?php echo stripslashes($_SESSION['denominazione']);?>"/>
					<br>
					<label>Sede (Citt&agrave;)</label>
					<input class="form-control" 
							type="text" 
							name="sede"  
							value="<?php echo stripslashes($_SESSION['sede']);?>"/>
					<br>
					<label>Vertice (presidente/commissario)</label>
					<input class="form-control" 
							type="text" 
							name="vertice"  
							value="<?php echo $_SESSION['vertice'];?>"/>
				</div>
				
				<div class="col-sm-4">
					<center>
					<h3><i class="fa fa-book"></i> Protocollo:</h3><br>
					</center>
					<label>Inizio utilizzo Abulafia (aaaa/mm/gg)</label>
					<input class="form-control" 
							type="text" 
							name="inizio"  
							value="<?php echo $_SESSION['inizio'];?>" <?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>	
					<label>Anno Corrente per il Protocollo</label>
					<input class="form-control" type="text" name="annoprotocollo"  value="<?php echo $_SESSION['annoprotocollo'];?>" disabled />
					<br>
					<label>Numero iniziale per il Protocollo:</label>
					<input class="form-control" size="50" type="text" name="primoprotocollo"  value="<?php echo $contalettere;?>"/>
						<script language="javascript">
							var primoprotocollo = document.modifica.primoprotocollo.value;
							if (primoprotocollo > 1) {
								 document.modifica.primoprotocollo.disabled = true;
							}
						</script>
					<br>
					<label>Max File Size Anagrafica (<b>espresse in byte</b>):</label>
					<input class="form-control" size="50" type="text" name="fotomaxfilesize"  value="<?php echo $_SESSION['fotomaxfilesize'];?>" <?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>
					<label>Max File Size Protocollo (<b>espressi in byte</b>):</label>
					<input class="form-control" type="text" name="protocollomaxfilesize"  value="<?php echo $_SESSION['protocollomaxfilesize'];?>" <?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>
					<label>Pagina principale</label>
					<input class="form-control" size="50" type="text" name="paginaprincipale"  value="<?php echo $_SESSION['paginaprincipale'];?>" <?php if(!$admin) { echo 'readonly'; } ?>/>
				</div>

				<div class="col-sm-4">

					<center><h3><i class="fa fa-envelope-o"></i> Email:</h3><br></center>
					<label>Email:</label>
					<input class="form-control" type="text" name="email"  value="<?php echo $_SESSION['email'];?>" <?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>

					<center><h3><i class="fa fa-hdd-o"></i> Spazio Archiviazione:</h3><br></center>
					<label>Quota su Disco Disponibile (MB):</label>
					<input class="form-control" type="text" name="quota"  value="<?php echo $_SESSION['quota'];?>" <?php if(!$admin) { echo 'readonly'; } ?>/>
					<br>

					<center><h3><i class="fa fa-server"></i> Moduli:</h3><br></center>
					<table class="table table-hover">
						<tr>
							<td><label>Anagrafica </label></td><td><input type="checkbox" name="anagrafica" <?php if($_SESSION['mod_anagrafica']) echo 'checked'; ?>
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
						<tr>
							<td><label>Protocollo </label></td><td><input type="checkbox" name="protocollo" <?php if($_SESSION['mod_protocollo']) echo 'checked'; ?> 
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
						<tr>
							<td><label>Documenti </label></td><td><input type="checkbox" name="documenti" <?php if($_SESSION['mod_documenti']) echo 'checked'; ?> 
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
						<tr>
							<td><label>Lettere </label></td><td><input type="checkbox" name="lettere" <?php if($_SESSION['mod_lettere']) echo 'checked'; ?>
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
						<tr>
							<td><label>Magazzino </label></td><td><input type="checkbox" name="magazzino" <?php if($_SESSION['mod_magazzino']) echo 'checked'; ?>
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
						<tr>
							<td><label>Ambulatorio </label></td><td><input type="checkbox" name="ambulatorio" <?php if($_SESSION['mod_ambulatorio']) echo 'checked'; ?>
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
						<tr>
							<td><label>Contabilità </label></td><td><input type="checkbox" name="contabilita" <?php if($_SESSION['mod_contabilita']) echo 'checked'; ?>
							<?php if(!$admin) { echo 'disabled'; } ?> > </td>
						</tr>
					</table>				
				</div>

			</div>

			<br>
			<center><button class="btn btn-info btn-lg" onClick="Controllo()" /><i class="fa fa-floppy-o"></i> Salva Impostazioni</button></center>
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
	
	if ((version == "") || (version == "undefined")) 
	{
           alert("Il campo Versione è obbligatorio");
           document.modifica.versione.focus();
           return false;
      }
	if ((nomeapplicativo == "") || (nomeapplicativo == "undefined")) 
	{
           alert("Il campo Nome dell'Applicativo è obbligatorio");
           document.modifica.nomeapplicativo.focus();
           return false;
      }
	if ((email == "") || (email == "undefined")) 
	{
           alert("Il campo EMAIL è obbligatorio");
           document.modifica.email.focus();
           return false;
      }
	if ((paginaprincipale == "") || (paginaprincipale == "undefined")) 
	{
           alert("Il campo Pagina Principale è obbligatorio");
           document.modifica.paginaprincipale.focus();
           return false;
      }
	if ((protocollomaxfilesize == "") || (protocollomaxfilesize == "undefined")) 
	{
           alert("Il campo Max File Size (protocollo) è obbligatorio");
           document.modifica.protocollomaxfilesize.focus();
           return false;
      }
	if ((fotomaxfilesize == "") || (fotomaxfilesize == "undefined")) 
	{
           alert("Il campo Max File Size (foto) è obbligatorio");
           document.modifica.fotomaxfilesize.focus();
           return false;
      }
	if ((annoprotocollo == "") || (annoprotocollo == "undefined")) 
	{
           alert("Il campo Anno Corrente per il Protocollo è obbligatorio");
           document.modifica.annoprotocollo.focus();
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
