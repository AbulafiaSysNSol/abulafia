<?php

	//inizio passaggio dati da pagina inserimento
	if(isset($_POST['cognome'])) {
		$cognome = $_POST['cognome'];
	}
	if(isset($_POST['nome'])) {
		$nome = $_POST['nome'];
	}
	if(isset($_POST['datanascita'])) {
		$datanascita = $_POST['datanascita'];
	}
	else {
		$datanascita = "00/00/0000";
	}
	if(isset($_POST['nascitacomune'])) {
		$nascita_comune = $_POST['nascitacomune'];
	}
	if(isset($_POST['nascitaprovincia'])) {
		$nascita_provincia  = $_POST['nascitaprovincia'];
	}
	if(isset($_POST['nascitastato'])) {
		$nascita_stato = $_POST['nascitastato'];
	}
	if(isset($_POST['residenzavia'])) {
		$residenza_via = $_POST['residenzavia'];
	}
	if(isset($_POST['residenzacivico'])) {
		$residenza_civico = $_POST['residenzacivico'];
	}
	if(isset($_POST['residenzacomune'])) {
		$residenza_comune = $_POST['residenzacomune'];
	}
	if(isset($_POST['residenzacap'])) {
		$residenza_cap = $_POST['residenzacap'];
	}
	if(isset($_POST['residenzaprovincia'])) {
		$residenza_provincia = $_POST['residenzaprovincia'];
	}
	if(isset($_POST['residenzastato'])) {
		$residenza_stato = $_POST['residenzastato'];
	}
	if(isset($_POST['url-foto'])) {
		$url_foto = $_POST['url-foto'];
	}
	if(isset($_POST['grupposanguigno'])) {
		$gruppo_sanguigno = $_POST['grupposanguigno'];
	}
	if(isset($_POST['codicefiscale'])) {
		$codice_fiscale = $_POST['codicefiscale'];
	}
	if($datanascita != '') {
		$nascitadata = explode('/',$datanascita);
		$nascita_data = $nascitadata[2].'-'.$nascitadata[1].'-'.$nascitadata[0];
	}
	else {
		$nascita_data='0000-00-00';
	}
	$id =$_GET['id'];
	$anagraficatipologia= $_POST['anagraficatipologia'];
	//fine passaggio dati

	//controllo esistenza

	$query = mysql_query("
		UPDATE anagrafica 
		set anagrafica.cognome ='$cognome', 
		anagrafica.nome ='$nome', 
		anagrafica.nascitadata='$nascita_data', 
		anagrafica.nascitacomune='$nascita_comune', 
		anagrafica.nascitaprovincia='$nascita_provincia', 
		anagrafica.nascitastato='$nascita_stato', 
		anagrafica.residenzavia='$residenza_via', 
		anagrafica.residenzacivico='$residenza_civico', 
		anagrafica.residenzacitta='$residenza_comune', 
		anagrafica.residenzaprovincia='$residenza_provincia', 
		anagrafica.residenzastato='$residenza_stato', 
		anagrafica.grupposanguigno='$gruppo_sanguigno', 
		anagrafica.codicefiscale='$codice_fiscale', 
		anagrafica.residenzacap='$residenza_cap', 
		anagrafica.tipologia='$anagraficatipologia' 
		WHERE anagrafica.idanagrafica='$id' 
		" );
		
	echo  mysql_error();
	
	if (!$query) { 
		$inserimento='false'; 
	}
	else { 
		$inserimento='true';
	}
?>

<!--reindirizzamento alla pagina dove vengono mostrati i dati-->

<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=dettagli-anagrafica&inserimento=<?php echo $inserimento;?>&id=<?php echo $id;?>"; 
	else window.location="login0.php?corpus=dettagli-anagrafica&inserimento=<?php echo $inserimento;?>&id=<?php echo $id;?>"
</SCRIPT>



