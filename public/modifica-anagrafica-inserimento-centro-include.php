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

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("
										UPDATE anagrafica 
										set anagrafica.cognome =:cognome, 
										anagrafica.nome =:nome, 
										anagrafica.nascitadata=:nascita_data, 
										anagrafica.nascitacomune=:nascita_comune, 
										anagrafica.nascitaprovincia=:nascita_provincia, 
										anagrafica.nascitastato=:nascita_stato, 
										anagrafica.residenzavia=:residenza_via, 
										anagrafica.residenzacivico=:residenza_civico, 
										anagrafica.residenzacitta=:residenza_comune, 
										anagrafica.residenzaprovincia=:residenza_provincia, 
										anagrafica.residenzastato=:residenza_stato, 
										anagrafica.grupposanguigno=:gruppo_sanguigno, 
										anagrafica.codicefiscale=:codice_fiscale, 
										anagrafica.residenzacap=:residenza_cap, 
										anagrafica.tipologia=:anagraficatipologia,
										anagrafica.fuoriuso=:fuoriuso 
										WHERE anagrafica.idanagrafica=:id 
										"); 
		$query->bindParam(':cognome', $cognome);
		$query->bindParam(':nome', $nome);
		$query->bindParam(':nascita_data', $nascita_data);
		$query->bindParam(':nascita_comune', $nascita_comune);
		$query->bindParam(':nascita_provincia', $nascita_provincia);
		$query->bindParam(':nascita_stato', $nascita_stato);
		$query->bindParam(':residenza_via', $residenza_via);
		$query->bindParam(':residenza_civico', $residenza_civico);
		$query->bindParam(':residenza_comune', $residenza_comune);
		$query->bindParam(':residenza_provincia', $residenza_provincia);
		$query->bindParam(':residenza_stato', $residenza_stato);
		$query->bindParam(':gruppo_sanguigno', $gruppo_sanguigno);
		$query->bindParam(':codice_fiscale', $codice_fiscale);
		$query->bindParam(':residenza_cap', $residenza_cap);
		$query->bindParam(':anagraficatipologia', $anagraficatipologia);
		$query->bindParam(':fuoriuso', $fuoriuso);
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$q = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$q = false;
	}		
	
	if (!$q) { 
		$inserimento='false'; 
	}
	else { 
		$inserimento='true';
	}
?>

<script LANGUAGE="Javascript">
	window.location="login0.php?corpus=dettagli-anagrafica&inserimento=<?php echo $inserimento;?>&id=<?php echo $id;?>&from=modifica"; 
</script>