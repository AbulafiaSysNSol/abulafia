<?php
	//inizio passaggio dati da pagina inserimento
	if( isset($_POST['insertok']) ) {
		$insertok = $_POST['insertok'];
	}
	else {
		$insertok = '';
	}
	if( isset($_POST['cognome']) ) {
		$cognome = stripslashes($_POST['cognome']);
	}
	else {
		$cognome = '';
	}
	if( isset($_POST['nome']) ) {
		$nome = stripslashes($_POST['nome']);
	}
	else {
		$nome = '';
	}
	if(  isset($_POST['datanascita']) && $_POST['datanascita'] != '' ) {
		$datanascita = $_POST['datanascita'];
		$nascitadata = explode('/',$datanascita);
		$nascita_data = $nascitadata[2].'-'.$nascitadata[1].'-'.$nascitadata[0];
	}
	else {
		$nascita_data = '';
	}
	if( isset($_POST['nascitacomune']) ) {
		$nascita_comune = stripslashes($_POST['nascitacomune']);
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
		$residenza_via = stripslashes($_POST['residenzavia']);
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
		$residenza_comune = stripslashes($_POST['residenzacomune']);
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
	$controlloesistenza = $connessione->query("SELECT COUNT(*) from anagrafica where cognome='$cognome' and nome ='$nome' and nascitadata='$nascita_data' ");
	$res_count = $controlloesistenza->fetch();

	if($res_count[0] < 1) {

		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO anagrafica VALUES (null, :nome, :cognome, :residenza_stato, :residenza_provincia, :residenza_comune, :residenza_via, :residenza_civico, :residenza_cap, :nascita_data, :nascita_stato, :nascita_provincia, :nascita_comune, :url_foto, :gruppo_sanguigno, :codice_fiscale, :anagraficatipologia, '0')"); 
			$query->bindParam(':nome', $nome);
			$query->bindParam(':cognome', $cognome);
			$query->bindParam(':residenza_stato', $residenza_stato);
			$query->bindParam(':residenza_provincia', $residenza_provincia);
			$query->bindParam(':residenza_comune', $residenza_comune);
			$query->bindParam(':residenza_via', $residenza_via);
			$query->bindParam(':residenza_civico', $residenza_civico);
			$query->bindParam(':residenza_cap', $residenza_cap);
			$query->bindParam(':nascita_data', $nascita_data);
			$query->bindParam(':nascita_stato', $nascita_stato);
			$query->bindParam(':nascita_provincia', $nascita_provincia);
			$query->bindParam(':nascita_comune', $nascita_comune);
			$query->bindParam(':url_foto', $url_foto);
			$query->bindParam(':gruppo_sanguigno', $gruppo_sanguigno);
			$query->bindParam(':codice_fiscale', $codice_fiscale);
			$query->bindParam(':anagraficatipologia', $anagraficatipologia);
			$query->execute();
			$lastid = $connessione->lastInsertId();
			$connessione->commit();
			$inserimento = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$inserimento = false;
		 	exit();
		}		
		$old_compl_url = 'foto/'.$url_foto;
		$new_compl_url = 'foto/'.$lastid.$url_foto;
		@rename ("$old_compl_url", "$new_compl_url");
		if($url_foto != '') {
			$newname = $lastid.$url_foto;
		}
		else {
			$newname = '';
		}
		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE anagrafica SET anagrafica.urlfoto = :newname where anagrafica.idanagrafica = :lastid"); 
			$query->bindParam(':newname', $newname);
			$query->bindParam(':lastid', $lastid);
			$query->execute();
			$ultimoid = $connessione->lastInsertId();
			$connessione->commit();
			$inserimento3 = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$inserimento3 = false;
		 	exit();
		}	
		if (!$inserimento3) { 
			echo "<br>Inserimento foto non riuscito"; 
		}
		if (!$inserimento) { 
			echo "<br>Inserimento non riuscito" ; 
		}
		
		//inserimento di un recapito associato all'anagrafica solo se il recapito non è vuoto
		if (($telefono != '' ) and ($lastid != '' )) {
			try {
			   	$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO jointelefonipersone VALUES (:lastid, :telefono, :tipo)"); 
				$query->bindParam(':lastid', $lastid);
				$query->bindParam(':telefono', $telefono);
				$query->bindParam(':tipo', $tipo);
				$query->execute();
				$connessione->commit();
				$inserimento2 = true;
			}	 
			catch (PDOException $errorePDO) { 
			   	echo "Errore: " . $errorePDO->getMessage();
			   	$connessione->rollBack();
			 	$inserimento2 = false;
			 	exit();
			}	
			if (!$inserimento2) { 
				echo "<br>Inserimento recapito non riuscito" ; 
			}
		}
		if (($telefono2 != '' ) and ($lastid != '' )) {
			try {
			   	$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO jointelefonipersone VALUES (:lastid, :telefono, :tipo2)"); 
				$query->bindParam(':lastid', $lastid);
				$query->bindParam(':telefono', $telefono);
				$query->bindParam(':tipo2', $tipo2);
				$query->execute();
				$connessione->commit();
				$inserimento2 = true;
			}	 
			catch (PDOException $errorePDO) { 
			   	echo "Errore: " . $errorePDO->getMessage();
			   	$connessione->rollBack();
			 	$inserimento2 = false;
			 	exit();
			}	
			if (!$inserimento2) { 
				echo "<br>Inserimento secondo recapito non riuscito"; 
			}
		}
		?>
		<script language = "javascript">
			window.location = "login0.php?corpus=dettagli-anagrafica&from=insert&exist=false&id=<?php echo $lastid;?>";
		</script>
		<?php
	}
	else {
		?>
		<script language = "javascript">
			window.location = "login0.php?corpus=dettagli-anagrafica&from=insert&exist=true";
		</script>
		<?php
	}
?>