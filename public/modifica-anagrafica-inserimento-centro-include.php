<?php

	//inizio passaggio dati da pagina inserimento
	if(isset($_POST['cognome'])) {
		$cognome = $_POST['cognome'];
	}
	else {
		$cognome = '';
	}
	if(isset($_POST['nome'])) {
		$nome = $_POST['nome'];
	}
	else {
		$nome = '';
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
	else {
		$nascita_comune = '';
	}
	if(isset($_POST['nascitaprovincia'])) {
		$nascita_provincia  = $_POST['nascitaprovincia'];
	}
	else {
		$nascita_provincia = '';
	}
	if(isset($_POST['nascitastato'])) {
		$nascita_stato = $_POST['nascitastato'];
	}
	else {
		$nascita_stato = '';
	}
	if(isset($_POST['residenzavia'])) {
		$residenza_via = $_POST['residenzavia'];
	}
	else {
		$residenza_via = '';
	}
	if(isset($_POST['residenzacivico'])) {
		$residenza_civico = $_POST['residenzacivico'];
	}
	else {
		$residenza_civico = '';
	}
	if(isset($_POST['residenzacomune'])) {
		$residenza_comune = $_POST['residenzacomune'];
	}
	else {
		$residenza_comune = '';
	}
	if(isset($_POST['residenzacap'])) {
		$residenza_cap = $_POST['residenzacap'];
	}
	else {
		$residenza_cap = '';
	}
	if(isset($_POST['residenzaprovincia'])) {
		$residenza_provincia = $_POST['residenzaprovincia'];
	}
	else {
		$residenza_provincia = '';
	}
	if(isset($_POST['residenzastato'])) {
		$residenza_stato = $_POST['residenzastato'];
	}
	else {
		$residenza_stato = '';
	}
	if(isset($_POST['url-foto'])) {
		$url_foto = $_POST['url-foto'];
	}
	else {
		$url_foto = '';
	}
	if(isset($_POST['grupposanguigno'])) {
		$gruppo_sanguigno = $_POST['grupposanguigno'];
	}
	else {
		$gruppo_sanguigno = '';
	}
	if(isset($_POST['codicefiscale'])) {
		$codice_fiscale = $_POST['codicefiscale'];
	}
	else {
		$codice_fiscale = '';
	}

	if(isset($_POST['fuoriuso'])) {
		$fuoriuso = 1;
	}
	else {
		$fuoriuso = 0;
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
		anagrafica.tipologia='$anagraficatipologia',
		anagrafica.fuoriuso='$fuoriuso' 
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

<script LANGUAGE="Javascript">
	window.location="login0.php?corpus=dettagli-anagrafica&inserimento=<?php echo $inserimento;?>&id=<?php echo $id;?>&from=modifica"; 
</script>