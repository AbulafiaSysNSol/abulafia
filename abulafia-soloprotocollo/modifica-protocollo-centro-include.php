<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$my_file = new File(); //crea un nuovo oggetto 'file'
	$my_lettera = new Lettera();
	$from= $_GET['from'];
	if ( isset($_GET['id'])) {
		$idlettera=$_GET['id'];
	}
	else {
		$idlettera = $_GET['idlettera'];
	}
	
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
		exit();
	}
	//fine controllo dell'autorizazione necessaria alla modifica del protocollo

	$row = mysql_fetch_array($risultati);
	$datalettera = $row['datalettera'] ;
	list($anno, $mese, $giorno) = explode("-", $datalettera);
	$dataregistrazione = $row['dataregistrazione'] ;
	list($annor, $meser, $giornor) = explode("-", $dataregistrazione);

	if($from == "errore") {
		$errore = true;
	}
	else {
		$errore = false;
	}

	if ($from =='aggiungi') {
		$idanagrafica=$_GET['idanagrafica'];
		$aggiungi=mysql_query("insert into joinletteremittenti$annoprotocollo values('$idlettera', '$idanagrafica')");
		$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
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

<div class="<?php if($errore) { echo "panel panel-danger";} else { echo "panel panel-default";} ?>">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Modifica protocollo numero: <?php echo $row['idlettera'];?></strong><?php if($errore) { echo " - <b>ERRORE:</b> Bisogna inserire almeno un mittente o un destinatario.";} ?></h3>
	</div>
	
	<div class="panel-body">
	
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
		
		<form enctype="multipart/form-data" action="login0.php?from=modifica-protocollo&corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
		<table>
		<tr>
		<td>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
		<label for="exampleInputFile">Carica allegato</label> 
		<input name="uploadedfile" type="file" id="exampleInputFile" />
		</td>
		<td valign="bottom">
		<button type="submit" class="btn btn-default" onClick="loading()"><span class="glyphicon glyphicon-paperclip"></span> Allega File</button>
		</td>
		</tr>
		</table>
		</form>
		
		<br>
		<?php
			$download = $my_file -> downloadlink($row['urlpdf'], $row['idlettera'], $annoprotocollo, '6');
			if ($download != "Nessun file associato") {
				echo "<span class=\"glyphicon glyphicon-file\"></span> <b>File associato: </b>" . $download;
			}
			else {
				echo "Nessun file associato.";
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
			$my_lettera -> modificaMittente ($idlettera,''); //richiamo del metodo
			if($errore) { echo "</div>"; }
		?>
		
		<?php
		$count=mysql_query("select count(*) from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$count = mysql_fetch_row($count);
		if($count[0] > 0) {
			echo '<b>Mittenti/Destinatari attuali:</b><br><br>';
			while ($row2 = mysql_fetch_array($risultati2)) {
				echo $row2['cognome'] . '  -  ' . $row2['nome'] ;?> <a href="login0.php?corpus=modifica-protocollo&from=elimina-mittente&id=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $row['urlpdf'];?>">elimina</a><br><?php
			}
		}
		else {
			echo 'Nessun mittente/destinatario associato.<br>';
		}
		$urlpdf=$row['urlpdf'];
		?>
		
		<form class="form-group" action="login0.php?corpus=protocollo3&from=modifica&dataoriginalegiorno=<?php echo $giornor; ?>&dataoriginalemese=<?php echo $meser; ?>&dataoriginaleanno=<?php echo $annor; ?>&urlpdf=<?php echo $urlpdf;?>&idlettera=<?php echo $idlettera;?>" method="post" >
			<br>
			<label>Spedita/Ricevuta:</label>
			<div class="row">
			<div class="col-xs-2">
			<select class="form-control" size="1" cols=4 type="text" name="spedita-ricevuta" />
				<OPTION selected value="<?php echo $row['speditaricevuta'];?>"> <?php echo $row['speditaricevuta'];?>
				<OPTION value="ricevuta"> Ricevuta
				<OPTION value="spedita"> Spedita
			</select>
			</div>
			</div>
				
			<br>
			<label>Oggetto della lettera:</label>
			<div class="row">
			<div class="col-xs-5">
			<input class="form-control" size="40" type="text" name="oggetto" value="<?php echo $row['oggetto'];?>"/>
			</div>
			</div>
			
			<br>
			<?php
				$data = $giorno.'/'.$mese.'/'.$anno;
			?>
			<label>Data della lettera</label>
			<div class="row">
				<div class="col-xs-2">
					<input type="text" class="form-control datepicker" name="data" value="<?php echo $data; ?>">
				</div>
			</div>
				
			<br>
			<label>Mezzo di trasmissione:</label>
			<div class="row">
			<div class="col-xs-2">
			<SELECT class="form-control" size=1 cols=4 NAME="posizione">
				<OPTION selected value="<?php echo $row['posizione']; ?>"> <?php echo $row['posizione']; ?>
				<OPTION value="posta ordinaria"> posta ordinaria
				<OPTION value="raccomandata"> raccomandata
				<OPTION Value="telegramma"> telegramma
				<OPTION value="fax"> fax
				<OPTION value="email"> email
				<OPTION value="consegna a mano"> consegna a mano
			</select>
			</div>
			</div>
			
			<br>
			<label>Titolazione:</label>
			<div class="row">
			<div class="col-xs-3">
			<?php
			$risultati=mysql_query("select distinct * from titolario");
			?>
			<select class="form-control" name="riferimento">
			<option value="">nessuna titolazione
			<?php
			while ($risultati2=mysql_fetch_array($risultati))
			{
				 if( $row['riferimento'] == $risultati2['codice'] ) {
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
			
			<br>
			<label>Note:</label>
			<div class="row">
			<div class="col-xs-5">
			<input class="form-control" size="40" type="text" name="note" value="<?php echo $row['note']; ?>"/></label>
			</div>
			</div>
			
			<br>
			<button type="submit" class="btn btn-primary">MODIFICA</button>
		</form>
	</div>
</div>

<script language="javascript">
 <!--
function loading() {
	document.getElementById("content").style.display="table";	
}
 //-->
</script> 
