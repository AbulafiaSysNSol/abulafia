<?php

	$a = new Anagrafica();
	$level = $_SESSION['auth'];

	if (!$a->isAnagrafica($_SESSION['loginid'])) {
		$id = $_SESSION['loginid'];
	}
	else {
		$id = $_GET['id'];
	}

	//inizio del passaggio dei dati dalla pagina precedente
	$from = $_GET['from'];
	if(isset($_GET['tabella'])) {
		$tabella = $_GET['tabella'];
	}
	if(isset($_GET['url-foto'])) {
		$urlfoto =$_GET['url-foto'];
	}
	if(isset($_GET['url-foto2'])) {
		$urlfoto2 =$_POST['url-foto2'];
	}
	if(isset($_POST['numero'])) {
		$numero = $_POST['numero'];
	}
	if(isset($_POST['tipo'])) {
		$tipo = $_POST['tipo'];
	}
	if(isset($_GET['numero'])) {
		$numero2 = $_GET['numero'];
	}
	if(isset($_GET['tipo'])) {
		$tipo2 = $_GET['tipo'];
	}
	//fine del passaggio dei dati dalla pagina precedente

	if (($from == 'foto-modifica') && (isset($urlfoto))) {
		$inserisci= $connessione->query("UPDATE anagrafica SET urlfoto = '$urlfoto' where idanagrafica = '$id' " );
	}
	if ($from == 'numero-modifica') {
		$inserisci= $connessione->query("INSERT INTO jointelefonipersone values('$id', '$numero', '$tipo' )");
	}
	if ($from == 'elimina-numero-modifica') {
		$elimina= $connessione->query("DELETE FROM jointelefonipersone WHERE numero = '$numero2' and tipo = '$tipo2' and idanagrafica='$id'");
	}
	
	$risultati= $connessione->query("SELECT DISTINCT * from anagrafica where anagrafica.idanagrafica ='$id'");
	$risultati2= $connessione->query("SELECT * from jointelefonipersone where jointelefonipersone.idanagrafica='$id' order by jointelefonipersone.tipo");
	$row = $risultati->fetch();
	$row = array_map ("stripslashes",$row);
	$data = $row['nascitadata'] ;
	list($anno, $mese, $giorno) = explode("-", $data);
	$data2 = "$giorno-$mese-$anno";
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-edit fa-fw"></i> Modifica Anagrafica:</strong></h3>
	</div>

	<div class="panel-body">
	
		<?php
			if( isset($_GET['upfoto']) && $_GET['upfoto'] == "error") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger"><b><i class="fa fa-warning fa-fw"></i> Errore:</b> si &egrave; verificato un problema nel caricamento della foto, controlla la dimensione massima, riprova o contatta il <a href="https://abulafiaweb.freshdesk.com" target="_blank">supporto</a>.</div>
				</div>
			</div>
			<?php
			}

			if( isset($_GET['upfoto']) && $_GET['upfoto'] == "errest") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger"><b><i class="fa fa-warning fa-fw"></i> Errore:</b> il formato della foto deve essere <b>JPG</b> o <b>PNG</b>.</div>
				</div>
			</div>
			<?php
			}
		?>
	
		<div class="row">
			<div class="col-sm-3">
				<div class="alert alert-info">
					<label><span class="glyphicon glyphicon-picture"></span> Foto attuale:</label><br><br>
					<center><img class="img-circle" width="70%" src="<?php if($row['urlfoto']) {echo 'foto/'.$row['urlfoto'];} else {echo 'foto/sagoma.png';}?>"></center>
					<br><br>
					<form enctype="multipart/form-data" action="login0.php?corpus=modifica-foto&id=<?php echo $id;?>" method="POST">
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['fotomaxfilesize'];?>" />
						<label><span class="glyphicon glyphicon-camera"></span> Modifica foto:</label>
						<input required name="uploadedfile" type="file" />
						<br><center><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-upload"></span> Upload</button></center>
					</form>
				</div>
			</div>
				
			<div class="col-sm-9">
				<div class="alert alert-warning">
					<form class="form-inline" role="form" action="login0.php?corpus=modifica-anagrafica&from=numero-modifica&id=<?php echo $id;?>" method="post" >
						<label><span class="glyphicon glyphicon-plus-sign"></span> Aggiungi Recapito:</label><br><br>	
						<label>Tipo:</label>
						<div class="form-group">
						<SELECT class="form-control" NAME="tipo">
							<OPTION value="phone">Telefono
							<OPTION value="mobile">Cellullare
							<OPTION Value="fax">Fax
							<OPTION Value="envelope-o">E-Mail
							<OPTION Value="facebook">Facebook
							<OPTION Value="twitter">Twitter
							<OPTION value="linkedin"> Linkedin
						</select>
						</div>
							
						<label>Numero/Descrizione:</label>
							<div class="form-group">
								<input required size="30" class="form-control" type="text" name="numero">
							</div>
							
						<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-plus"></span> Aggiungi</button>
					</form>
				</div>
			</div>

			<div class="col-sm-9">
				<div class="alert alert-success">
					<label><span class="glyphicon glyphicon-earphone"></span> Recapiti attuali:</label><br><br>
					<table class="table">
					<?php
						while ($row2 = $risultati2->fetch()) {
						echo '<tr>';
						echo '<td><i class="fa fa-'.$row2['tipo'].'"></i></td><td>'.$row2['numero'];?></td><td><a href="login0.php?corpus=modifica-anagrafica&from=elimina-numero-modifica&id=<?php echo $id;?>&numero=<?php echo $row2['numero'];?>&tipo=<?php echo $row2['tipo'];?>"><button class="btn btn-danger btn-xs" type="button"><span class="glyphicon glyphicon-trash"></span></button></a></td>
						<?php
						echo '</tr>';
						}
					?>
					</table>
				</div>
			</div>

		</div>

		<body onLoad="Change()">

		<form class="form-horizontal" role="form" name="modulo" method="post">
		
			<?php
			if ($a->isAnagrafica($_SESSION['loginid'])) {
				?>
				<label>Tipologia:</label>
				<div class="row">
					<div class="col-sm-3">
						<SELECT class="form-control input-sm" NAME="anagraficatipologia" onChange="Change()">
						<?php
						if( $row['tipologia'] == 'persona') { 
							?>
							<OPTION value="persona" selected >Persona Fisica </OPTION>
							<?php 
						} 
						else { 
							?>
							<OPTION value="persona">Persona Fisica</OPTION>
							<?php
						} 
						 
						if( $row['tipologia'] == 'carica') { 
							?>
							<OPTION value="carica" selected >Carica Elettiva o Incarico</OPTION>
							<?php
						} 
						else { 
							?>
							<OPTION value="carica">Carica Elettiva o Incarico</OPTION>
							<?php
						} 
						
						if( $row['tipologia'] == 'ente') { 
							?>
							<OPTION Value="ente" selected >Ente</OPTION>
							<?php
						} 
						else { 
							?>
							<OPTION value="ente">Ente</OPTION>
							<?php
						}

						if( $row['tipologia'] == 'fornitore') { 
							?>
							<OPTION Value="fornitore" selected >Fornitore</OPTION>
							<?php
						}
						else {
							?>
							<OPTION value="fornitore">Fornitore</OPTION>
							<?php
						}
						?>
						</select>
					</div>
				</div>

				<br>

				<?php
			}
			else {
				?>
				<input type="hidden" name="anagraficatipologia" value="persona">
				<?php
			}
			?>
			
			<div class="row" style="padding: 7px;">
				<label id="lblcog" class="col-sm-2 control-label">Cognome:</label> 
				<label id="lblden" style="display: none;" class="col-sm-2 control-label">Denominazione:</label>
				<div class="col-sm-4">
					<input class="form-control input-sm" type="text" name="cognome" value="<?php echo $row['cognome'];?>" />
				</div>
			</div>
			
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Nome:</label>
				<div class="col-sm-4">
					<input class="form-control input-sm" type="text" name="nome" value="<?php echo $row['nome'];?>"/>
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Nato il:</label>
				<div class="col-sm-2">
					<?php
						$nascita = explode('-',$row['nascitadata']);
						$data = $nascita[2]."/".$nascita[1]."/".$nascita[0];
						if($data == '00/00/0000') {
							$data = '';
						}
					?>
					<input type="text" class="form-control input-sm datepickerAnag" name="datanascita" value="<?php echo $data; ?>">
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Comune:</label>
				<div class="col-sm-4">
					<input class="form-control input-sm" type="text" name="nascitacomune"  value="<?php echo $row['nascitacomune'];?>"/>
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Provincia:</label>
				<div class="col-sm-1">
					<input class="form-control input-sm" type="text" name="nascitaprovincia"  value="<?php echo $row['nascitaprovincia'];?>"/>
				</div>
			</div>
				
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Stato:</label>
				<div class="col-sm-3">
					<input class="form-control input-sm" type="text" name="nascitastato"  value="<?php echo $row['nascitastato'];?>"/>
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Residente in via:</label>
				<div class="col-sm-5">
					<input class="form-control input-sm" type="text" name="residenzavia"  value="<?php echo $row['residenzavia'];?>"/>
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Numero:</label>
				<div class="col-sm-1">
					<input class="form-control input-sm" type="text" name="residenzacivico"  value="<?php echo $row['residenzacivico'];?>"/>
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Comune di:</label>
				<div class="col-sm-4">
					<input class="form-control input-sm" type="text" name="residenzacomune"  value="<?php echo $row['residenzacitta'];?>"/>
				</div>
			</div>

			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Provincia:</label>
				<div class="col-sm-1">
					<input class="form-control input-sm" type="text" name="residenzaprovincia"  value="<?php echo $row['residenzaprovincia'];?>"/>
				</div>
			</div>

			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">CAP:</label>
				<div class="col-sm-2">
					<input class="form-control input-sm" type="text" name="residenzacap"  value="<?php echo $row['residenzacap'];?>"/>
				</div>
			</div>
		
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Stato di residenza:</label>
				<div class="col-sm-4">
					<input class="form-control input-sm" type="text" name="residenzastato"  value="<?php echo $row['residenzastato'];?>"/>
				</div>
			</div>

			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Gruppo Sanguigno:</label>
				<div class="col-sm-2">
					<select class="form-control input-sm" NAME="grupposanguigno" >
						<option selected="value="<?php echo $row['grupposanguigno'];?>""> <?php echo $row['grupposanguigno'];?> </option>
						<option value="0rh+"> 0rh+ </option>
						<option value="0rh-"> 0rh- </option>
						<option Value="Arh+"> Arh+ </option>
						<option value="Arh-"> Arh- </option>
						<option value="Brh+"> Brh+ </option>
						<option value="Brh-"> Brh- </option>
						<option Value="ABrh+"> ABrh+ </option>
						<option value="ABrh-"> ABrh- </option>
					</select>
				</div>
			</div>
			
			<div class="row" style="padding: 7px;">
				<label class="col-sm-2 control-label">Codice Fiscale:</label>
				<div class="col-sm-4">
					<input class="form-control input-sm" type="text" name="codicefiscale" value="<?php echo strtoupper($row['codicefiscale']);?>" />
				</div>
			</div>

			<?php
			if ($a->isAnagrafica($_SESSION['loginid'])) {
				?>
				<div class="row" style="padding: 7px;">
					<label class="col-sm-2 control-label">Fuori Uso:</label>
					<div class="col-sm-2" style="padding-top: 7px;">
						<input type="checkbox" name="fuoriuso" <?php if($row['fuoriuso'] == 1) echo 'checked'; ?> />
					</div>
				</div>
				<?php
			}
			?>
			
			</body>

			<br>
			<div class="col-sm-offset-2">
				<button class="btn btn-warning btn-lg" onClick="Controllo()"><span class="glyphicon glyphicon-edit"></span> Modifica Anagrafica</button>
			</div>
		</form>
	</div>
</div>

<script language="javascript">
 <!--
  function Controllo() 
  {
	//acquisisco il valore delle variabili
	var cognome = document.modulo.cognome.value;
      
	if ((cognome == "") || (cognome == "undefined")) 
	{
           alert("Il campo Cognome � obbligatorio");
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
		document.getElementById("lblcog").style.display="table";
		document.getElementById("lblden").style.display="none";
	  document.modulo.cognome.disabled = false;
          document.modulo.nome.disabled = false;
	  document.modulo.datanascita.disabled = false;
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
	
	if (type == "carica") 
	{
		document.getElementById("lblcog").style.display="none";
		document.getElementById("lblden").style.display="table";
	  document.modulo.cognome.disabled = false;
	  document.modulo.nome.disabled = true;
	  document.modulo.datanascita.disabled = true;
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
		document.getElementById("lblcog").style.display="none";
		document.getElementById("lblden").style.display="table";
	  document.modulo.cognome.disabled = false;	
	  document.modulo.nome.disabled = true;
	  document.modulo.datanascita.disabled = true;
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
	
	if (type == "fornitore") 
	{
		document.getElementById("lblcog").style.display="none";
		document.getElementById("lblden").style.display="table";
	  document.modulo.cognome.disabled = false;	
	  document.modulo.nome.disabled = true;
	  document.modulo.datanascita.disabled = true;
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
}
 //-->
</script> 