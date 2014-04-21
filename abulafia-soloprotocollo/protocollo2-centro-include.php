<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$from= $_GET['from'];
	$my_file = new File(); //crea un nuovo oggetto 'file'
	$my_lettera = new Lettera(); //crea un nuovo oggetto
	$add = false;
	
	if (isset($_session['dbname'])) { 
		$dbname=$_session['dbname']; 
	}
	
	if (isset($_GET['idanagrafica'])) { 
		$idanagrafica=$_GET['idanagrafica']; 
	}
	
	if($from == "errore") {
		$errore = true;
		$idlettera = $_GET['idlettera'];
	}
	else {
		$errore = false;
	}
	
	//se la pagina da cui si proviene è crea nuovo protocollo
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
		$loginid=$_SESSION['loginid'];
		$tracciautenteinserimento=mysql_query("insert into joinlettereinserimento$annoprotocollo values('$ultimoid', '$loginid','','')");
		
		if ($insertid > 0) { 
			$idlettera = $insertid;
		}
	}

	if ($from == 'aggiungi') {
			$idlettera=$_GET['idlettera'];
			$my_lettera -> publinseriscimittente ($idlettera, $idanagrafica, $annoprotocollo); //richiamo del metodo
			$add = true;
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

<!-- Modal -->
	<form action="?corpus=inserimento.rapido.anagrafica&idlettera=<?php echo $idlettera; ?>" method="POST" name="modale">
		<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Inserimento rapido in anagrafica</h4>
					</div>
	      
					<div class="modal-body">
						<div class="form-group">
							<label>Tipologia:</label>
							<div class="row">
								<div class="col-xs-5">
									<select class="form-control input-sm" name="anagraficatipologia" onChange="changeSelect()">
									<OPTION value="persona"> Persona Fisica</OPTION>
									<OPTION value="carica"> Carica Elettiva o Incarico</OPTION>
									<OPTION Value="ente"> Ente</OPTION>
									</select>
								</div>
							</div>
							<br>
							<label id="lblcognome">Cognome:</label>
							<label id="lblden" style="display: none;">Denominazione:</label>
							<div class="row">
								<div class="col-xs-8">
									<input type="text" class="form-control input-sm" name="cognome" required>
								</div>
							</div>
							<br>
							<label id="lblnome">Nome:</label>
							<div class="row">
								<div class="col-xs-8">
									<input id="txtnome" type="text" class="form-control input-sm" name="nome" required>
								</div>
							</div>
						</div>
					</div>
			
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
						<button type="submit" class="btn btn-primary">Salva ed associa al protocollo</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->

<div class="<?php if($errore) { echo "panel panel-danger";} else { echo "panel panel-default";} ?>">
	
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Protocollo numero: <?php echo $idlettera;?></strong><?php if($errore) { echo " - <b>ERRORE:</b> Bisogna inserire almeno un mittente o un destinatario.";} ?></h3>
		</div>
		
		<div class="panel-body">
			
			<?php
			if( isset($_GET['insert']) && $_GET['insert'] == "error") {
				?>
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-danger">C'è stato un errore nell'associare la nuova anagrafica.</div>
					</div>
				</div>
				<?php
			}
			?>
		
			<?php
			if( isset($_GET['upfile']) && $_GET['upfile'] == "error") {
				?>
				<div class="row">
					<div class="col-xs-12">
						<div class="alert alert-danger">C'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.</div>
					</div>
				</div>
				<?php
			}
			?>
			
			<?php
			 if( isset($_GET['upfile']) && $_GET['upfile'] == "success") {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-success">File allegato correttamente!</div>
				</div>
			</div>
			<?php
			}
			?>
			
			<div class="form-group">
			<form role="form" enctype="multipart/form-data" action="login0.php?corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
			<table>
			<tr>
			<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />			
			<label for="exampleInputFile">Carica allegato</label>
			<input name="uploadedfile" type="file" id="exampleInputFile">
			</td>
			<td valign="bottom">
			<button type="submit" class="btn btn-default" onClick="loading()"><span class="glyphicon glyphicon-paperclip"></span> Allega File</button>
			</td>
			</tr>
			</table>
			</form>
			
			<?php
			$cercadocumento= mysql_query("select distinct * from lettere$annoprotocollo where idlettera='$idlettera'");
			$urlpdf1= mysql_fetch_array($cercadocumento);
			$urlpdf=$urlpdf1['urlpdf'];
			$download = $my_file->downloadlink ($urlpdf, $idlettera, $annoprotocollo, '30'); //richiamo del metodo "downloadlink" dell'oggetto file
			if ($download != "Nessun file associato") {
				echo "<br><span class=\"glyphicon glyphicon-file\"></span> <b>File associato: </b>" . $download;
			}
			else {
				echo "<br>Nessun file associato.";
			}
				
			?>

			<div class="row">
			<div class ="col-xs-5" id="content" style="display: none;">
			<br>
			<b>Caricamento in corso...</b>
			<img src="images/progress.gif">
			</div>
			</div>
			
			<br>
			
			<?php
				if($errore) { echo "<div class=\"alert alert-danger\">"; }
				$my_lettera -> publcercamittente ($idlettera,''); //richiamo del metodo
				if($errore) { echo "</div>"; }
			?>
			
			<?php
			$risultati=mysql_query("select anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, joinletteremittenti$annoprotocollo.idlettera, joinletteremittenti$annoprotocollo.idanagrafica from anagrafica, joinletteremittenti$annoprotocollo where anagrafica.idanagrafica = joinletteremittenti$annoprotocollo.idanagrafica and joinletteremittenti$annoprotocollo.idlettera='$idlettera'");
			if ($row = mysql_fetch_array($risultati)) {
				echo '<b>Mittenti/Destinatari:<br><br></b>';
				$risultati2=mysql_query("select anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, joinletteremittenti$annoprotocollo.idlettera, joinletteremittenti$annoprotocollo.idanagrafica from anagrafica, joinletteremittenti$annoprotocollo where anagrafica.idanagrafica = joinletteremittenti$annoprotocollo.idanagrafica and joinletteremittenti$annoprotocollo.idlettera='$idlettera'");
				while ($row2 = mysql_fetch_array($risultati2)) {
					echo ucwords($row2['cognome'] . ' ' . $row2['nome']) ;?> - <a href="login0.php?corpus=protocollo2&from=elimina-mittente&idlettera=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $urlpdf;?>">Elimina</a><br>
					<?php
				}
			}
			else {
				echo 'Nessun mittente/destinatario associato.<br>';
			}
			echo '<br>';
			?>

			<form name="modulo" method="post" >
			
			<div class="form-group">
				<label>Spedita/Ricevuta</label>
				<div class="row">
					<div class="col-xs-2">
						<select class="form-control" size="1" cols=4 type="text" name="spedita-ricevuta" />
						<OPTION value="ricevuta" <?php if( ($errore || $add) && isset($_SESSION['spedita-ricevuta']) && $_SESSION['spedita-ricevuta'] == "ricevuta") {echo "selected";} ?>> Ricevuta
						<OPTION value="spedita" <?php if( ($errore || $add) && isset($_SESSION['spedita-ricevuta']) && $_SESSION['spedita-ricevuta'] == "spedita") {echo "selected";} ?>> Spedita
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Oggetto della lettera:</label>
				<div class="row">
					<div class="col-xs-5">
						<input type="text" class="form-control" name="oggetto" <?php if( ($errore || $add) && isset($_SESSION['oggetto']) ) { echo "value=\"".$_SESSION['oggetto']."\"";} ?> >
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Data della lettera:</label>
				<div class="row">
					<div class="col-xs-2">
						<input type="text" class="form-control datepicker" name="data" <?php if( ($errore || $add) && isset($_SESSION['data']) ) { echo "value=\"".$_SESSION['data']."\"";} ?> >
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Mezzo di trasmissione:</label>
				<div class="row">
					<div class="col-xs-2">
						<select class="form-control" size=1 cols=4 NAME="posizione">
						<OPTION selected value="">
						<OPTION value="posta ordinaria" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "posta ordinaria") {echo "selected";} ?>> posta ordinaria
						<OPTION value="raccomandata"<?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "raccomandata") {echo "selected";} ?>> raccomandata
						<OPTION Value="telegramma" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "telegramma") {echo "selected";} ?>> telegramma
						<OPTION value="fax" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "fax") {echo "selected";} ?>> fax
						<OPTION value="email" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "email") {echo "selected";} ?>> email
						<OPTION value="consegna a mano" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "consegna a mano") {echo "selected";} ?>> consegna a mano
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
				<div class="col-xs-3">
				<label>Titolazione:</label>
				<?php
				$risultati=mysql_query("select distinct * from titolario");
				?>
				<select class="form-control" size=1 cols=4 NAME="riferimento">
				<option value="">nessuna titolazione
				<?php
				while ($risultati2=mysql_fetch_array($risultati))
				{
					 if( ($errore || $add) && isset($_SESSION['riferimento']) && $_SESSION['riferimento'] == $risultati2['codice'] ) {
						echo '<option selected value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
					}
					else {
						echo '<option value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
					}
				}
				echo '</select>';
				?>
				</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Note:</label>
				<div class="row">
					<div class="col-xs-5">
						<input type="text" class="form-control" name="note" <?php if( ($errore || $add) && isset($_SESSION['note'])) { echo "value=\"".$_SESSION['note']."\"";} ?>>
					</div>
				</div>
			</div>
			
			<button type="button" class="btn btn-default" onClick="Controllo()">Registra</button>

			</form>

		</div>
	</div>	
</div>

<script language="javascript">

 <!--
 function changeSelect() {
	var type = document.modale.anagraficatipologia.options[document.modale.anagraficatipologia.selectedIndex].value;
	if (type == "persona") {
		document.getElementById("lblcognome").style.display="table";
		document.getElementById("lblden").style.display="none";
		document.getElementById("txtnome").style.display="table";
		document.getElementById("txtnome").required = true;
		document.getElementById("lblnome").style.display="table";
	}
	if (type == "carica") {
		document.getElementById("lblcognome").style.display="none";
		document.getElementById("lblnome").style.display="none";
		document.getElementById("lblden").style.display="table";	
		document.getElementById("txtnome").style.display="none";
		document.getElementById("txtnome").required = false;
	}
	if (type == "ente") {
		document.getElementById("lblcognome").style.display="none";
		document.getElementById("lblnome").style.display="none";
		document.getElementById("lblden").style.display="table";
		document.getElementById("txtnome").style.display="none";
		document.getElementById("txtnome").required = false;
	}
 }
  function loading() 

  {
	  document.getElementById("content").style.display="table";	
  }

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
