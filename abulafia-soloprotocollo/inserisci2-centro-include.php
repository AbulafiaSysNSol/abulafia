<?php

	//inizio passaggio dati da pagina inserimento
	if( isset($_POST['insertok']) ) {
		$insertok = $_POST['insertok'];
	}
	else {
		$insertok = '';
	}
	if( isset($_POST['cognome']) ) {
		$cognome = $_POST['cognome'];
	}
	else {
		$cognome = '';
	}
	if( isset($_POST['nome']) ) {
		$nome = $_POST['nome'];
	}
	else {
		$nome = '';
	}
	if( isset($_POST['datanascita']) ) {
		$datanascita = $_POST['datanascita'];
		$nascitadata = explode('/',$datanascita);
		$nascita_data = $nascitadata[2].'-'.$nascitadata[1].'-'.$nascitadata[0];
	}
	else {
		$datanascita = '';
		$nascitadata='';
		$nascita_data='';
	}
	if( isset($_POST['nascitacomune']) ) {
		$nascita_comune = $_POST['nascitacomune'];
	}
	else {
		$nascita_comune = '';
	}
	if( isset($_POST['nascitaprovincia']) ) {
		$nascita_provincia  = $_POST['nascitaprovincia'];
	}
	else {
		$nascita_provincia = '';
	}
	if( isset($_POST['nascitastato']) ) {
		$nascita_stato = $_POST['nascitastato'];
	}
	else {
		$nascita_stato = '';
	}
	if( isset($_POST['residenzavia']) ) {
		$residenza_via = $_POST['residenzavia'];
	}
	else {
		$residenza_via = '';
	}
	if( isset($_POST['residenzacivico']) ) {
		$residenza_civico = $_POST['residenzacivico'];
	}
	else {
		$residenza_civico = '';
	}
	if( isset($_POST['residenzacomune']) ) {
		$residenza_comune = $_POST['residenzacomune'];
	}
	else {
		$residenza_comune = '';
	}
	if( isset($_POST['residenzacap']) ) {
		$residenza_cap = $_POST['residenzacap'];
	}
	else {
		$residenza_cap = '';
	}
	if( isset($_POST['residenzaprovincia']) ) {
		$residenza_provincia = $_POST['residenzaprovincia'];
	}
	else {
		$residenza_provincia = '';
	}
	if( isset($_POST['residenzastato']) ) {
		$residenza_stato = $_POST['residenzastato'];
	}
	else {
		$residenza_stato = '';
	}
	if( isset($_GET['url-foto']) ) {
		$url_foto = $_GET['url-foto'];
	}
	else {
		$url_foto = '';
	}
	if( isset($_POST['grupposanguigno']) ) {
		$gruppo_sanguigno = $_POST['grupposanguigno'];
	}
	else {
		$gruppo_sanguigno = '';
	}
	if( isset($_POST['codicefiscale']) ) {
		$codice_fiscale = $_POST['codicefiscale'];
	}
	else {
		$codice_fiscale = '';
	}
	if( isset($_POST['numero']) ) {
		$telefono = $_POST['numero'];
	}
	else {
		$telefono = '';
	}
	if( isset($_POST['tipo']) ) {
		$tipo = $_POST['tipo'];
	}
	else {
		$tipo = '';
	}
	if( isset($_POST['numero2']) ) {
		$telefono2 = $_POST['numero2'];
	}
	else {
		$telefono2 = '';
	}
	if( isset($_POST['tipo2']) ) {
		$tipo2 = $_POST['tipo2'];
	}
	else {
		$tipo2 = '';
	}
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
			<p>
				<img width="130" src="<?php if($url_foto != '') { echo 'foto/'.$lastid.$url_foto; } else { echo 'images/nessuna.jpg'; } ?>">
				<br><br>
				Cognome: <strong><?php echo stripslashes($cognome) ; ?></strong> 
				<br>
				Nome: <strong><?php echo stripslashes($nome) ; ?></strong>
				<br>
				Data di Nascita: <strong><?php echo stripslashes($datanascita); ?></strong>
			</p>
		</div>
		  
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Opzioni:</strong></h3>
		</div>
		<div class="panel-body">
			<p><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&id=<?php echo $lastid;?>"><i class="fa fa-bars"></i> Visualizza Dettagli di questa anagrafica</a></p>
			<p><a href="login0.php?corpus=anagrafica"><span class="glyphicon glyphicon-plus-sign"></span> Inserisci nuova anagrafica</a></p>
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
			<p><a href="login0.php?corpus=anagrafica"><span class="glyphicon glyphicon-plus-sign"></span> Inserisci nuova anagrafica</a></p>
		</div>
	<?php } ?>
</div>