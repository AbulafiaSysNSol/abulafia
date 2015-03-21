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
	
	if ( isset($_GET['anno'])) {
		$anno=$_GET['anno'];
	}
	else {
		$anno = $_SESSION['annoricercaprotocollo'];
	}
	
	$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
	$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
	
	//controllo se l'anno del protocollo da modificare è uguale a quello in corso
	if ($anno != $annoprotocollo) { 
		?>
		<h4><div align="center" class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <b>Attenzione:</b> non puoi modificare una registrazione di un protocollo in archivio.</div></h4>
		<?php
		include 'sotto-include.php'; //carica il file con il footer.
		exit();
	}

	//controllo dell'autorizazione necessaria alla modifica del protocollo
	$risultati3=mysql_query("select * from joinlettereinserimento$annoprotocollo, users where joinlettereinserimento$annoprotocollo.idlettera='$idlettera' and joinlettereinserimento$annoprotocollo.idinser=users.idanagrafica ");
	$row3 = mysql_fetch_array($risultati3);
	if (($_SESSION['auth'] <= $row3['auth']) and ($row3['idinser'] !=  $_SESSION['loginid'])) {
		echo 'Non hai un livello di autorizzazione sufficiente a modificare questo protocollo.';?> 
		<a href="login0.php?corpus=dettagli-protocollo&from=risultati&id=<?php echo $idlettera;?>"><br><br>Vai alla pagina dei Dettagli del Protocollo N.<?php echo $idlettera;?><br><br></a><?php
		include 'sotto-include.php'; //carica il file con il footer.
		exit();
	}
	//fine controllo dell'autorizazione necessaria alla modifica del protocollo

	$row = mysql_fetch_array($risultati);
	$row = array_map('stripslashes', $row);
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
	
	if($from == "correggi") {
		$_SESSION['block'] = false;
	}

	if ($from =='aggiungi') {
		$idanagrafica=$_GET['idanagrafica'];
		$aggiungi=mysql_query("insert into joinletteremittenti$annoprotocollo values('$idlettera', '$idanagrafica')");
		$user = $_SESSION['loginid'];
		$time = time();
		$anagrafica = new Anagrafica();
		$name = $anagrafica->getName($idanagrafica);
		if(!$_SESSION['block']) {
			$regmodifica = mysql_query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$anno', 'Aggiunto mittente/destinatario', '$user', '$time', '#DEFEB4', ' ', '$name')");
		}
		$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'AGGIUNTO MITTENTE/DESTINATARIO '. $idanagrafica , $_SESSION['historylog']);
	}
	
	if ($from == 'elimina-mittente') {  
		$idanagrafica=$_GET['idanagrafica'];
		$idlettera=$_GET['id'];
		
		//controllo almeno un mittente/destinatario
		$count=mysql_query("select count(*) from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$count = mysql_fetch_row($count);
		if($count[0] == 1) {
			echo '<div class="alert alert-danger"><b><i class="fa fa-warning"></i> Errore:</b> impossibile eliminare l\'unico mittente o destinario delle lettera. Aggiungerne prima un altro.</div>';
			$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'FAILED' , 'TENTATIVO DI ELIMINARE MITTENTE/DESTINATARIO '. $idanagrafica , $_SESSION['historylog']);
		}
		else {
			$elimina=mysql_query("delete from joinletteremittenti$annoprotocollo where idanagrafica='$idanagrafica' and idlettera='$idlettera'");
			$user = $_SESSION['loginid'];
			$time = time();
			$anagrafica = new Anagrafica();
			$name = $anagrafica->getName($idanagrafica);
			if(!$_SESSION['block']) {
				$regmodifica = mysql_query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$anno', 'Rimosso mittente/destinatario', '$user', '$time', '#FC9E9E', '$name', ' ')");
			}
			$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'ELIMINATO MITTENTE/DESTINATARIO '. $idanagrafica , $_SESSION['historylog']);
		}
		$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
	}
	
	if ($from == 'eliminaallegato') {  
		$idlettera=$_GET['idlettera'];
		$anno = $_GET['anno'];
		$nome = $_GET['nome'];
		$deletequery=mysql_query("DELETE FROM joinlettereallegati WHERE idlettera=idlettera AND annoprotocollo=$annoprotocollo AND pathfile='$nome'");
		$user = $_SESSION['loginid'];
		$time = time();
		if(!$_SESSION['block']) {
			$regmodifica = mysql_query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$anno', 'Rimosso allegato', '$user', '$time', '#FC9E9E', '$nome', ' ')");
		}
		$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'ELIMINATO ALLEGATO '. $nome , $_SESSION['historylog']);
	}
	
	if ($from == 'urlpdf') {  
		$idlettera=$_GET['idlettera'];
		$risultati=mysql_query("SELECT * from lettere$annoprotocollo where idlettera='$idlettera'");
		$risultati2=mysql_query("select * from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$row = mysql_fetch_array($risultati);
		$row = array_map('stripslashes', $row);
		$datalettera = $row['datalettera'] ;
		list($anno, $mese, $giorno) = explode("-", $datalettera);
		$dataregistrazione = $row['dataregistrazione'] ;
		list($annor, $meser, $giornor) = explode("-", $dataregistrazione);
	}
	
	if($_SESSION['block']) {
		?>
		<h3>
		<center>
		<div class="row">
			<div class="col-xs-12">
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
				<div class="col-xs-12">
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
			<div class="col-xs-12">
				<div class="alert alert-success"><i class="fa fa-check"></i> File allegato <b>correttamente!</b></div>
			</div>
		</div>
		<?php
		}
		?>
		
		<div class="row">
			<div class="col-xs-6">
				<h3><b><small><i class="fa fa-square-o"></i></small> Primo Step: <small><b>modifica</b> allegati <i class="fa fa-folder-open-o"></i> e mittenti/destinatari <i class="fa fa-group"></i> </b></small></h3>
			</div>
			<div class="col-xs-6">
				<h3><b><small><i class="fa fa-square-o"></i></small> Secondo Step: <small><b>modifica</b> dettagli della lettera <i class="fa fa-file-text-o"></i></b></small></h3>
			</div>
		</div>
		
		<div class="row">
		<div class="col-xs-6">
		<hr>
		
		<form enctype="multipart/form-data" action="login0.php?from=modifica-protocollo&corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
		<label for="exampleInputFile"><span class="glyphicon glyphicon-upload"></span> Carica allegato</label> 
		<input required name="uploadedfile" type="file" id="exampleInputFile" />
		<br>
		<button id="buttonload" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Caricamento in corso..." type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span> Allega File</button>
		</form>
		
		<?php
			$urlfile= $my_lettera->cercaAllegati($idlettera, $annoprotocollo);
			if ($urlfile) {
				foreach ($urlfile as $valore) {
					$download = $my_file->downloadlink($valore[2], $idlettera, $annoprotocollo, '30'); //richiamo del metodo "downloadlink" dell'oggetto file
					echo "<br><i class=\"fa fa-file-o\"></i> <b>File associato: </b>" . $download;?> - <a href="login0.php?corpus=modifica-protocollo
																			&from=eliminaallegato
																			&idlettera=<?php echo $idlettera;?>
																			&anno=<?php echo $annoprotocollo;?>
																			&nome=<?php echo $valore[2];?>"></span> 
																			Elimina <span class="glyphicon glyphicon-trash"></a>
				<?php
				}
			}
			else {
				echo "<br>Nessun file associato.";
			}
		?>
		
		<div class="row">
		<div class ="col-xs-12" id="content" style="display: none;">
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
		$count=mysql_query("select count(*) from joinletteremittenti$annoprotocollo, anagrafica where joinletteremittenti$annoprotocollo.idlettera='$idlettera' and joinletteremittenti$annoprotocollo.idanagrafica=anagrafica.idanagrafica ");
		$count = mysql_fetch_row($count);
		if($count[0] > 0) {
			echo '<b><i class="fa fa-users"></i> Mittenti/Destinatari attuali:</b><br><br>';
			while ($row2 = mysql_fetch_array($risultati2)) {
				$row2 = array_map('stripslashes', $row2);
				echo '<a href="anagrafica-mini.php?id=' . $row2['idanagrafica'].'" class="fancybox" data-fancybox-type="iframe">' . $row2['cognome'] . ' ' . $row2['nome'] ;?></a> - <a href="login0.php?corpus=modifica-protocollo&from=elimina-mittente&id=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $row['urlpdf'];?>">Elimina <span class="glyphicon glyphicon-trash"></span></a><br><?php
			}
		}
		else {
			echo 'Nessun mittente/destinatario associato.<br>';
		}
		$urlpdf=$row['urlpdf'];
		?>
		
		</div>
		<div class="col-xs-6">
		<hr>
		
		<form class="form-group" action="login0.php?corpus=protocollo3&from=modifica&idlettera=<?php echo $idlettera;?>" method="post" >
			<label><span class="glyphicon glyphicon-sort"></span> Spedita/Ricevuta:</label>
			<div class="row">
			<div class="col-xs-11">
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
			<div class="col-xs-11">
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
				<div class="col-xs-11">
					<input type="text" class="form-control datepickerProt" name="data" value="<?php echo $data; ?>">
				</div>
			</div>
				
			<br>
			<label><span class="glyphicon glyphicon-briefcase"></span> Mezzo di trasmissione:</label>
			<div class="row">
			<div class="col-xs-11">
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
			<div class="col-xs-11">
			<?php
			$risultati=mysql_query("select distinct * from titolario");
			?>
			<select class="form-control" name="riferimento">
			<option value="">nessuna titolazione
			<?php
			while ($risultati2=mysql_fetch_array($risultati)) {
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
			<div class="col-xs-11">
			<?php
			$risultati=mysql_query("select distinct * from pratiche");
			?>
			<select class="form-control" name="pratica">
			<option value="">nessuna pratica
			<?php
			while ($risultati2=mysql_fetch_array($risultati)) {
				$risultati2 = array_map ("stripslashes",$risultati2);
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
			<div class="col-xs-11">
			<input class="form-control" size="40" type="text" name="note" value="<?php echo $row['note']; ?>"/></label>
			</div>
			</div>
			
			<br>
			<?php
			if(!$_SESSION['block']) {
				?>
				<button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Modifica in corso..." type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Modifica Protocollo</button>
				<?php
			}
			else {
				?>
				<button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Registrazione in corso..." type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Registra Lettera</button>
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
		
	$("#buttonload").click(function() {
		var $btn = $(this);
		 if(document.getElementById("exampleInputFile").value != '') {
			$btn.button('loading');
		}
	});
</script>

<script language="javascript">
 <!--
function loading() {
	if(document.getElementById("exampleInputFile").value != '') {
		document.getElementById("content").style.display="table";
	}	
}
 //-->
</script> 
