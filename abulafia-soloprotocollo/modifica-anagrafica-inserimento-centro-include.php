
<?php

//inizio passaggio dati da pagina inserimento

$cognome = $_POST['cognome'];
$nome = $_POST['nome'];
$nascita_data_giorno = $_POST['nascitadatagiorno'];
$nascita_data_mese = $_POST['nascitadatamese'];
$nascita_data_anno = $_POST['nascitadataanno'];
$nascita_comune = $_POST['nascitacomune'];
$nascita_provincia  = $_POST['nascitaprovincia'];
$nascita_stato = $_POST['nascitastato'];
$residenza_via = $_POST['residenzavia'];
$residenza_civico = $_POST['residenzacivico'];
$residenza_comune = $_POST['residenzacomune'];
$residenza_cap = $_POST['residenzacap'];
$residenza_provincia = $_POST['residenzaprovincia'];
$residenza_stato = $_POST['residenzastato'];
$url_foto = $_POST['url-foto'];
$gruppo_sanguigno = $_POST['grupposanguigno'];
$codice_fiscale = $_POST['codicefiscale'];
$telefono = $_POST['numero'];
$tipo = $_POST['tipo'];
$nascita_data = $nascita_data_anno.'-'.$nascita_data_mese.'-'.$nascita_data_giorno   ;
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

	if (!$query) { $inserimento='false'; }
	else { $inserimento='true';}
?>

<!--reindirizzamento alla pagina dove vengono mostrati i dati-->

<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=modifica2-anagrafica&inserimento=<?php echo $inserimento;?>&id=<?php echo $id;?>"; 
	else window.location="login0.php?corpus=modifica2-anagrafica&inserimento=<?php echo $inserimento;?>&id=<?php echo $id;?>"
</SCRIPT>



