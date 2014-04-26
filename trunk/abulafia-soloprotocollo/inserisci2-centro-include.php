<?php

	//inizio passaggio dati da pagina inserimento
	if( isset($_POST['insertok']) ) {
		$insertok = $_POST['insertok'];
	}
	$cognome = $_POST['cognome'];
	$nome = $_POST['nome'];
	$datanascita = $_POST['datanascita'];
	$nascita_comune = $_POST['nascitacomune'];
	$nascita_provincia  = $_POST['nascitaprovincia'];
	$nascita_stato = $_POST['nascitastato'];
	$residenza_via = $_POST['residenzavia'];
	$residenza_civico = $_POST['residenzacivico'];
	$residenza_comune = $_POST['residenzacomune'];
	$residenza_cap = $_POST['residenzacap'];
	$residenza_provincia = $_POST['residenzaprovincia'];
	$residenza_stato = $_POST['residenzastato'];
	if( isset($_GET['url-foto']) ) {
		$url_foto = $_GET['url-foto'];
	}
	else {
		$url_foto = '';
	}
	$gruppo_sanguigno = $_POST['grupposanguigno'];
	$codice_fiscale = $_POST['codicefiscale'];
	$telefono = $_POST['numero'];
	$tipo = $_POST['tipo'];
	$telefono2 = $_POST['numero2'];
	$tipo2 = $_POST['tipo2'];
	$nascitadata = explode('/',$datanascita);
	$nascita_data = $nascitadata[2].'-'.$nascitadata[1].'-'.$nascitadata[0];
	$anagraficatipologia= $_POST['anagraficatipologia'];

	//fine passaggio dati

	//controllo esistenza
	$controlloesistenza = mysql_query("SELECT COUNT(*) from anagrafica where cognome='$cognome' and nome ='$nome' and nascitadata='$nascita_data' ");
	$res_count = mysql_fetch_row($controlloesistenza);

	if($res_count[0] < 1) {
		$inserimento = mysql_query("INSERT INTO anagrafica VALUES ('','$nome','$cognome','$residenza_stato','$residenza_provincia','$residenza_comune','$residenza_via','$residenza_civico','$residenza_cap',
		'$nascita_data','$nascita_stato','$nascita_provincia','$nascita_comune','$url_foto','$gruppo_sanguigno','$codice_fiscale','$anagraficatipologia') " );
		echo  mysql_error();
		$lastid=mysql_insert_id();
		$old_compl_url='foto/'.$url_foto;
		$new_compl_url='foto/'.$lastid.$url_foto;
		@rename ("$old_compl_url", "$new_compl_url");
		if($url_foto != '') {
			$newname=$lastid.$url_foto;
		}
		else {
			$newname = '';
		}
		$inserimento3=mysql_query("update anagrafica set anagrafica.urlfoto='$newname' where anagrafica.idanagrafica='$lastid'");
		if (!$inserimento3) { 
			echo "<br>Inserimento foto non riuscito"; 
		}
		if (!$inserimento) { 
			echo "<br>Inserimento non riuscito" ; 
		}
		$ultimoid = mysql_insert_id();
		
		//inserimento di un recapito associato all'anagrafica solo se il recapito non è vuoto
		if (($telefono != '' ) and ($lastid != '' )) {
			$inserimento2 = mysql_query("INSERT INTO jointelefonipersone VALUES ('$lastid','$telefono','$tipo') " );
			if (!$inserimento2) { 
				echo "<br>Inserimento recapito non riuscito" ; 
			}
		}
		if (($telefono2 != '' ) and ($lastid != '' )) {
			$inserimento2 = mysql_query("INSERT INTO jointelefonipersone VALUES ('$lastid','$telefono2','$tipo2') " );
			if (!$inserimento2) { 
				echo "<br>Inserimento secondo recapito non riuscito"; 
			}
		}
		$exist = false;
	}
	else {
		$exist = true;
	}
?>

<div class="panel panel-default">
	<?php if(!$exist) { ?>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Anagrafica registrata correttamente!</div>
				</div>
			</div>
			<p><img width="130" src="foto/<?php echo $lastid.$url_foto; ?>"><br><br>Cognome: <strong><?php echo $cognome ; ?></strong> <br>Nome: <strong><?php echo $nome ; ?></strong><br>Data di Nascita: <strong><?php echo $datanascita; ?></strong></p>
		</div>
		  
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Opzioni:</strong></h3>
		</div>
		<div class="panel-body">
			<p><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&id=<?php echo $lastid;?>">Visualizza Dettagli di questa anagrafica</a></p>
			<p><a href="login0.php?corpus=anagrafica">Inserisci nuova anagrafica</a></p>
		</div>
	<?php }
	else {
		?>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> <b>Errore:</b> il soggetto è già presente in anagrafica, controlla.</div>
				</div>
			</div>
		</div>
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Opzioni:</strong></h3>
		</div>
		<div class="panel-body">
			<p><a href="login0.php?corpus=anagrafica">Inserisci nuova anagrafica</a></p>
		</div>
	<?php } ?>
</div>