<style>
#progress-bar {background-color: #c0c0c0;height:30px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
#progress-div {border:#808080 1px solid;padding: 0px 0px;margin:30px 0px;border-radius:4px;text-align:center;display:none;}
#targetLayer{width:100%;text-align:center;display:none;}
</style>

<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$my_file = new File(); //crea un nuovo oggetto 'file'
	$my_lettera = new Lettera();
	$loginid=$_SESSION['loginid'];
	$date=strftime("%Y-%m-%d");
	$from= $_GET['from'];
	
	if ( isset($_GET['id'])) {
		$idlettera=$_GET['id'];
	}
	else {
		$idlettera = $_GET['idlettera'];
	}
	
	if ( isset($_GET['anno'])) {
		$anno=$_GET['anno'];
	}
	else {
		$anno = $_SESSION['annoricercaprotocollo'];
	}
	
	$risultati = $connessione->query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
	$risultati2 = $connessione->query("SELECT * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
	
	//controllo se l'anno del protocollo da modificare è uguale a quello in corso
	if ($anno != $annoprotocollo) 
	{ 
		?>
		<h4><div align="center" class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <b>Attenzione:</b> non puoi modificare una registrazione di un protocollo in archivio.</div></h4>
		<?php
		include 'sotto-include.php'; //carica il file con il footer.
		exit();
	}

	//controllo dell'autorizazione necessaria alla modifica del protocollo
	$risultati3 = $connessione->query("SELECT * from joinlettereinserimento$annoprotocollo, users where joinlettereinserimento$annoprotocollo.idlettera='$idlettera' and joinlettereinserimento$annoprotocollo.idinser = users.idanagrafica ");
	$row3 = $risultati3->fetch();
	if (($_SESSION['auth'] <= $row3['auth']) and ($row3['idinser'] !=  $_SESSION['loginid'])) 
	{
		echo 'Non hai un livello di autorizzazione sufficiente a modificare questo protocollo.';?> 
		<a href="login0.php?corpus=dettagli-protocollo&from=risultati&id=<?php echo $idlettera;?>"><br><br>Vai alla pagina dei Dettagli del Protocollo N.<?php echo $idlettera;?><br><br></a><?php
		include 'sotto-include.php'; //carica il file con il footer.
		exit();
	}
	//fine controllo dell'autorizazione necessaria alla modifica del protocollo

	$row = $risultati->fetch();
	$row = array_map('stripslashes', $row);
	$datalettera = $row['datalettera'] ;
	list($anno, $mese, $giorno) = explode("-", $datalettera);
	$dataregistrazione = $row['dataregistrazione'] ;
	list($annor, $meser, $giornor) = explode("-", $dataregistrazione);

	if($from == "errore") 
	{
		$errore = true;
	}
	else 
	{
		$errore = false;
	}
	
	if($from == "correggi") 
	{
		$_SESSION['block'] = false;
	}

	if ($from =='aggiungi') 
	{
		$idanagrafica=$_GET['idanagrafica'];
		$aggiungi = $connessione->query("INSERT INTO joinletteremittenti$annoprotocollo values('$idlettera', '$idanagrafica')");
		$user = $_SESSION['loginid'];
		$time = time();
		$anagrafica = new Anagrafica();
		$name = $anagrafica->getName($idanagrafica);
		if(!$_SESSION['block']) 
		{
			$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$anno', 'Aggiunto mittente/destinatario', '$user', '$time', '#DEFEB4', ' ', '$name')");
		}
		$risultati = $connessione->query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2 = $connessione->query("SELECT * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$my_log->publscrivilog( $_SESSION['loginname'], 'GO TO MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'AGGIUNTO MITTENTE/DESTINATARIO '. $idanagrafica , $_SESSION['logfile'], 'protocollo');
	}
	
	if ($from == 'elimina-mittente') 
	{  
		$idanagrafica=$_GET['idanagrafica'];
		$idlettera=$_GET['id'];
		
		//controllo almeno un mittente/destinatario
		$count = $connessione->query("SELECT count(*) from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$count = $count->fetch();
		if($count[0] == 1) 
		{
			echo '<div class="alert alert-danger"><b><i class="fa fa-warning"></i> Errore:</b> impossibile eliminare l\'unico mittente o destinario delle lettera. Aggiungerne prima un altro.</div>';
			$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'FAILED' , 'TENTATIVO DI ELIMINARE MITTENTE/DESTINATARIO '. $idanagrafica , $_SESSION['logfile'], 'protocollo');
		}
		else 
		{
			$elimina = $connessione->query("DELETE from joinletteremittenti$annoprotocollo where idanagrafica='$idanagrafica' and idlettera='$idlettera'");
			$user = $_SESSION['loginid'];
			$time = time();
			$anagrafica = new Anagrafica();
			$name = $anagrafica->getName($idanagrafica);
			if(!$_SESSION['block']) 
			{
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$anno', 'Rimosso mittente/destinatario', '$user', '$time', '#FC9E9E', '$name', ' ')");
			}
			$my_log->publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'ELIMINATO MITTENTE/DESTINATARIO '. $idanagrafica , $_SESSION['logfile'], 'protocollo');
		}
		$risultati = $connessione->query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2 = $connessione->query("SELECT * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
	}
	
	if ($from == 'eliminaallegato') 
	{  
		$idlettera=$_GET['idlettera'];
		$anno = $_GET['anno'];
		$nome = $_GET['nome'];
		$deletequery=$connessione->query("DELETE FROM joinlettereallegati WHERE idlettera=idlettera AND annoprotocollo=$annoprotocollo AND pathfile='$nome'");
		$user = $_SESSION['loginid'];
		$time = time();
		if(!$_SESSION['block']) 
		{
			$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$anno', 'Rimosso allegato', '$user', '$time', '#FC9E9E', '$nome', ' ')");
		}
		$risultati = $connessione->query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2 = $connessione->query("SELECT * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'ELIMINATO ALLEGATO '. $nome , $_SESSION['logfile'], 'protocollo');
		$utentemod = $connessione->query("UPDATE joinlettereinserimento$anno SET joinlettereinserimento$anno.idmod='$loginid', joinlettereinserimento$anno.datamod='$date' WHERE joinlettereinserimento$anno.idlettera='$idlettera' LIMIT 1");
	}
	
	if ($from == 'urlpdf') 
	{  
		$idlettera=$_GET['idlettera'];
		$risultati = $connessione->query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2 = $connessione->query("SELECT * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$row = $risultati->fetch();
		$row = array_map('stripslashes', $row);
		$datalettera = $row['datalettera'] ;
		list($anno, $mese, $giorno) = explode("-", $datalettera);
		$dataregistrazione = $row['dataregistrazione'] ;
		list($annor, $meser, $giornor) = explode("-", $dataregistrazione);
		$utentemod = $connessione->query("UPDATE joinlettereinserimento$anno SET joinlettereinserimento$anno.idmod='$loginid', joinlettereinserimento$anno.datamod='$date' WHERE joinlettereinserimento$anno.idlettera='$idlettera' LIMIT 1");
	}
	
	if($_SESSION['block']) {
		?>
		<h3>
		<center>
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-info"><b><i class="fa fa-lock"></i> Numero di Protocollo: <?php echo $row['idlettera'];?>
				<h5>Non</b> lasciare questa pagina prima di aver inserito i dettagli mancanti.</h5></div>
			</div>
		</div>
		</center>
		</h3>
		<?php
	}
?>

<div class="<?php if($errore) { echo "panel panel-danger";} else { echo "panel panel-default";} ?>">
	<div class="panel-heading">
		<h3 class="panel-title"><strong><?php if($_SESSION['block']) echo 'Completa'; else echo 'Modifica'; ?> protocollo numero: <?php echo $row['idlettera'];?></strong><?php if($errore) { echo " - <b>ERRORE:</b> Bisogna inserire almeno un mittente o un destinatario.";} ?></h3>
	</div>
	
	<div class="panel-body">
	
		<?php
		if( isset($_GET['upfile']) && $_GET['upfile'] == "error") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger"><b><i class="fa fa-warning"></i> Attenzione:</b> c'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.</div>
				</div>
			</div>
			<?php
		}
		?>
		
		<?php
		 if( isset($_GET['upfile']) && $_GET['upfile'] == "success") {
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-success"><i class="fa fa-check"></i> File allegato <b>correttamente!</b></div>
			</div>
		</div>
		<?php
		}
		?>
		
		<div class="row">
		<div class="col-sm-6">

		<h3><b><small><i class="fa fa-square-o"></i></small> Primo Step: <small><b>modifica</b> allegati <i class="fa fa-folder-open-o"></i> e mittenti/destinatari <i class="fa fa-group"></i> </b></small></h3>

		<hr>
		
		<form id="uploadForm" enctype="multipart/form-data" action="login0.php?from=modifica-protocollo&corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
			<div class="row">
				<div class="col-sm-11">
					<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
					<label for="exampleInputFile"><span class="glyphicon glyphicon-upload"></span> Carica allegato</label> 
					<input required id="uploadedfile" name="uploadedfile[]" type="file" multiple="multiple" class="filestyle" data-buttonBefore="true" />
					<br>
					<button id="buttonload" onclick="showbar();" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Caricamento in corso...attendere!" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span> Allega File</button>
					<br><br>
					<div class="progress" id="progress" style="display: none;">
					  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
					</div>
				</div>
			</div>
		</form>
		
		<?php
			$urlfile = $my_lettera->cercaAllegati($idlettera, $annoprotocollo);
			if ($urlfile) {
				?>
				<br><i class="fa fa-fw fa-paperclip"></i> <b>File associati:</b><br><br>
				<table class="table table-hover">
					<?php
					foreach ($urlfile as $valore) {
						$download = $my_file->downloadlink($valore[2], $idlettera, $annoprotocollo, '30'); //richiamo del metodo "downloadlink" dell'oggetto file
						echo "<tr><td>" . $download; ?></td>
						<td><a class="btn btn-xs btn-danger" href="login0.php?corpus=modifica-protocollo
							&from=eliminaallegato
							&idlettera=<?php echo $idlettera;?>
							&anno=<?php echo $annoprotocollo;?>
							&nome=<?php echo $valore[2];?>"> 
							<i class="fa fa-trash fa-fw"></i>
						</a></td></tr>
					<?php
					}
					?>
				</table>
				<?php
			}
			else {
				echo "<br>Nessun file associato.";
			}
		?>
		
		<div class="row">
		<div class ="col-sm-12" id="content" style="display: none;">
		<br>
		<i class="fa fa-spinner fa-spin"></i><b> Caricamento File in corso...</b>
		<img src="images/progress.gif">
		</div>
		</div>

		<hr>
		<?php
			if($errore) { echo "<div class=\"alert alert-danger\">"; }
			$my_lettera -> modificaMittente ($idlettera,''); //richiamo del metodo
			if($errore) { echo "</div>"; }
		?>
		
		<?php
		$count = $connessione->query("SELECT count(*) from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$count = $count->fetch();
		if($count[0] > 0) {
			echo '<br><b><i class="fa fa-users"></i> Mittenti/Destinatari attuali:</b><br><br>';
			while ($row2 = $risultati2->fetch()) {
				$row2 = array_map('stripslashes', $row2);
				echo '<a href="anagrafica-mini.php?id=' . $row2['idanagrafica'].'" class="fancybox" data-fancybox-type="iframe">' . $row2['cognome'] . ' ' . $row2['nome'] ;?></a> - <a href="login0.php?corpus=modifica-protocollo&from=elimina-mittente&id=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $row['urlpdf'];?>">Elimina <span class="glyphicon glyphicon-trash"></span></a><br><?php
			}
		}
		else {
			echo 'Nessun mittente/destinatario associato.<br>';
		}
		echo '<br>';
		$urlpdf=$row['urlpdf'];
		?>
		
		</div>
		<div class="col-sm-6">

		<h3><b><small><i class="fa fa-square-o"></i></small> Secondo Step: <small><b>modifica</b> dettagli della lettera <i class="fa fa-file-text-o"></i></b></small></h3>

		<hr>
		
		<form class="form-group" action="login0.php?corpus=protocollo3&from=modifica&idlettera=<?php echo $idlettera;?>" method="post" >
			<label><span class="glyphicon glyphicon-sort"></span> Spedita/Ricevuta:</label>
			<div class="row">
			<div class="col-sm-11">
			<select required class="form-control" type="text" name="spedita-ricevuta" id="sped" />
				<OPTION selected value="<?php echo $row['speditaricevuta'];?>"> <?php echo $row['speditaricevuta'];?>
				<OPTION value="ricevuta"> Ricevuta
				<OPTION value="spedita"> Spedita
			</select>
			</div>
			</div>
				
			<br>
			<label><span class="glyphicon glyphicon-asterisk"></span> Oggetto della lettera:</label>
			<div class="row">
			<div class="col-sm-11">
			<input required id="ogg" class="form-control" size="40" type="text" name="oggetto" value="<?php echo str_replace('"',"''",$row['oggetto']); ?>" />
			</div>
			</div>
			
			<br>
			<?php
				if($giorno == 0)
					$giorno = strftime("%d");
				if($mese == 0)
					$mese = strftime("%m");
				if($anno == 0)
					$anno = strftime("%Y");
				$data = $giorno.'/'.$mese.'/'.$anno;
			?>
			<label><span class="glyphicon glyphicon-calendar"></span> Data della lettera</label>
			<div class="row">
				<div class="col-sm-11">
					<input type="text" class="form-control datepickerProt" name="data" value="<?php echo $data; ?>">
				</div>
			</div>
				
			<br>
			<label><span class="glyphicon glyphicon-briefcase"></span> Mezzo di trasmissione:</label>
			<div class="row">
			<div class="col-sm-11">
			<SELECT class="form-control" size=1 cols=4 NAME="posizione">
				<OPTION selected value="<?php echo $row['posizione']; ?>"> <?php echo $row['posizione']; ?>
				<OPTION value="posta ordinaria"> posta ordinaria
				<OPTION value="raccomandata"> raccomandata
				<OPTION Value="telegramma"> telegramma
				<OPTION value="fax"> fax
				<OPTION value="email"> email
				<OPTION value="consegna a mano"> consegna a mano
				<OPTION value="PEC"> PEC
			</select>
			</div>
			</div>
			
			<br>
			<label><i class="fa fa-archive"></i> Titolazione:</label>
			<div class="row">
			<div class="col-sm-11">
			<?php
			$risultati = $connessione->query("SELECT distinct * from titolario");
			?>
			<select class="form-control" name="riferimento">
			<option value="">nessuna titolazione
			<?php
			while ($risultati2 = $risultati->fetch()) {
				$risultati2 = array_map ("stripslashes",$risultati2);
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
			<label><i class="fa fa-tag"></i> Pratica:</label>
			<div class="row">
			<div class="col-sm-11">
			<?php
			$risultati = $connessione->query("SELECT distinct * from pratiche");
			?>
			<select class="form-control" name="pratica">
			<option value="">nessuna pratica
			<?php
			while ($risultati2 = $risultati->fetch()) {
				$risultati2 = array_map("stripslashes",$risultati2);
				 if( $row['pratica'] == $risultati2['id'] ) {
					echo '<option selected value="' . $risultati2['id'] . '">' . $risultati2['descrizione'];
				}
				else {
					echo '<option value="' . $risultati2['id'] . '">' . $risultati2['descrizione'];
				}
			}
			echo '</select>';
			?>
			</div>
			</div>
			
			<br>
			<label><span class="glyphicon glyphicon-comment"></span> Note:</label>
			<div class="row">
			<div class="col-sm-11">
			<input class="form-control" size="40" type="text" name="note" value="<?php echo stripslashes($row['note']); ?>"/></label>
			</div>
			</div>
			
			<br>
			<?php
			if(!$_SESSION['block']) {
				?>
				<button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Modifica in corso..." type="submit" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-edit"></span> Modifica Protocollo</button>
				<?php
			}
			else {
				?>
				<button id="button2" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Registrazione in corso..." type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus-sign"></span> Registra Lettera</button>
				<?php
			}
			?>
			
		</div>
		</div>
		
		</form>
	</div>
</div>

<script>
	$("#buttonl").click(function() {
		var $btn = $(this);
		var oggetto = document.getElementById("ogg").value;
		var spedita = document.getElementById("sped").value;
		if ((oggetto == "") || (oggetto == "undefined") || (spedita == "") || (spedita == "undefined")) {
			return;
		}
		else {
			$btn.button('loading');
		}
	});

	$("#button2").click(function() {
		var $btn = $(this);
		var oggetto = document.getElementById("ogg").value;
		var spedita = document.getElementById("sped").value;
		if ((oggetto == "") || (oggetto == "undefined") || (spedita == "") || (spedita == "undefined")) {
			return;
		}
		else {
			$btn.button('loading');
		}
	});
		
	$("#buttonload").click(function() {
		var $btn = $(this);
		 if(document.getElementById("uploadedfile").value != '') {
			$btn.button('loading');
		}
	});
</script>

<script language="javascript">
 <!--

 function showbar() {
	document.getElementById("progress").style.display="block";	
}

function loading() {
	if(document.getElementById("exampleInputFile").value != '') {
		document.getElementById("content").style.display="table";
	}	
}
 //-->
</script> 
