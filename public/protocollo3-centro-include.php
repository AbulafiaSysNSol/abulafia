<?php

	//RECUPERO VARIABILE FROM DAL GET
	if(isset($_GET['from'])) { 
		$from = $_GET['from']; 
		$idlettera = $_GET['idlettera'];
	}
	else {
		$from = '';
	}

	if (isset($_SESSION['my_lettera']) && ($from != 'modifica')) {
		$my_lettera = unserialize($_SESSION['my_lettera']); //carica l'oggetto 'lettera'
		// CONTROLLO SE E' STATO INSERITO ALMENO UN MITTENTO O UN DESTINATARIO
		if (count($my_lettera->arraymittenti) < 1) { 
			$_SESSION['spedita-ricevuta'] = $_POST['spedita-ricevuta'];
			$_SESSION['oggetto'] = $_POST['oggetto'];
			$_SESSION['data'] = $_POST['data'];
			$_SESSION['posizione'] = $_POST['posizione'];
			$_SESSION['riferimento'] = $_POST['riferimento'];
			$_SESSION['pratica'] = $_POST['pratica'];
			$_SESSION['note'] = $_POST['note'];
			
			//RITORNO ALLA PAGINA DI REGISTRAZIONE SE NON E' STATO INSERITO NEMMENO UN MITTENT O UN DESTISTARIO
			$_SESSION['my_lettera'] = serialize ($my_lettera);
			?>
		
			<script language = "javascript">
				window.location = "login0.php?corpus=protocollo2&from=errore";
			</script>
			
			<?php
			exit();
		}
		// FINE CONTROLLO MITTENTI/DESTINATARI
	}
	
	if($from == "modifica") {
		$mitt = new Lettera();
		$mittenti = $mitt->getMittenti($idlettera, $_SESSION['annoprotocollo']);
		if(count($mittenti) < 1) { 
			/*
			$_SESSION['spedita-ricevuta'] = $_POST['spedita-ricevuta'];
			$_SESSION['oggetto'] = $_POST['oggetto'];
			$_SESSION['data'] = $_POST['data'];
			$_SESSION['posizione'] = $_POST['posizione'];
			$_SESSION['riferimento'] = $_POST['riferimento'];
			$_SESSION['pratica'] = $_POST['pratica'];
			$_SESSION['note'] = $_POST['note'];
			*/
			?>
			<script language = "javascript"> 
				window.location="login0.php?corpus=modifica-protocollo&from=errore&tabella=protocollo&id=<?php echo $idlettera;?>";
			</script>
			<?php
			exit();
		}
	}

	//CREAZIONE NUOVI OGGETTI
	$anagrafica = new Anagrafica();
	$calendario = new Calendario();
	
	//LIBRERIA PER L'INVIO DI EMAIL
	include('lib/phpmailer/PHPMailerAutoload.php');
	$date = strftime("%d/%m/%Y");
	$ora = date("g:i a");
	$datamail = $date . ' alle ' . $ora;
	
	//VARIABILI DI SESSIONI
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$loginid = $_SESSION['loginid'];
	
	//ACQUISISCO I DATI DAL FORM
	$speditaricevuta = $_POST['spedita-ricevuta'];
	$oggetto = $_POST['oggetto'];
	$datalettera = $calendario->dataDB($_POST['data']);
	$posizione = $_POST['posizione'];
	$riferimento = $_POST['riferimento'];
	if($_POST['pratica'] != '') {
		$pratica = $_POST['pratica'];
	}
	else {
		$pratica = 0;
	}
	$note  = $_POST['note'];
	$dataregistrazione = strftime("%Y-%m-%d");
	$loginid = $_SESSION['loginid'];
	$auth = $_SESSION['auth'] ;
	//FINE ACQUISIZIONE DATI

	
	//INSERISCO I DATI NEL DATABASE SE IL FROM E' DIVERSO DA MODIFICA
	if($from != 'modifica') {
	
		//SCRIVO I DETTAGLI DELLA LETTERA NEL DB
		try {
	   		$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO lettere$annoprotocollo VALUES (null, :oggetto, :datalettera, :dataregistrazione, '', :speditaricevuta, :posizione, :riferimento, :pratica, :note)"); 
			$query->bindParam(':oggetto', $oggetto);
			$query->bindParam(':datalettera', $datalettera);
			$query->bindParam(':dataregistrazione', $dataregistrazione);
			$query->bindParam(':speditaricevuta', $speditaricevuta);
			$query->bindParam(':posizione', $posizione);
			$query->bindParam(':riferimento', $riferimento);
			$query->bindParam(':pratica', $pratica);
			$query->bindParam(':note', $note);
			$query->execute();
			$ultimoid = $connessione->lastInsertId();
			$connessione->commit();
			$ins1 = true;
		}	 
		catch (PDOException $errorePDO) { 
	    	echo "Errore: " . $errorePDO->getMessage();
	    	$connessione->rollBack();
	    	$ins1 = false;
	    	exit();
		}
		
		//SCRIVO L'UTENTE CHE HA FATTO L'INSERIMENTO
		try {
	   		$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO joinlettereinserimento$annoprotocollo VALUES(:ultimoid, :loginid, '', :dataregistrazione)"); 
			$query->bindParam(':ultimoid', $ultimoid);
			$query->bindParam(':loginid', $loginid);
			$query->bindParam(':dataregistrazione', $dataregistrazione);
			$query->execute();
			$connessione->commit();
			$ins2 = true;
		}	 
		catch (PDOException $errorePDO) { 
	    	echo "Errore: " . $errorePDO->getMessage();
	    	$connessione->rollBack();
	    	$ins2 = false;
	    	exit();
		}
		
		//SCRIVO I MITTENTI/DESTINATARI NEL DB
		foreach ($my_lettera->arraymittenti as $key => $value) { //inserisce i dati dei mittenti nel db
			try {
		   		$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO joinletteremittenti$annoprotocollo VALUES (:ultimoid, :key)"); 
				$query->bindParam(':ultimoid', $ultimoid);
				$query->bindParam(':key', $key);
				$query->execute();
				$connessione->commit();
				$ins3 = true;
			}	 
			catch (PDOException $errorePDO) { 
		    	echo "Errore: " . $errorePDO->getMessage();
		    	$connessione->rollBack();
		    	$ins3 = false;
		    	exit();
			}
		}
		
		//SCRIVO GLI ALLEGATI NEL DB
		foreach ($my_lettera->arrayallegati as $key => $value) { //inserisce i dati degli allegati nel db e provvede a spostare i file dalla dir temp
			try {
		   		$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO joinlettereallegati VALUES (:ultimoid, :annoprotocollo, :key)"); 
				$query->bindParam(':ultimoid', $ultimoid);
				$query->bindParam(':annoprotocollo', $annoprotocollo);
				$query->bindParam(':key', $key);
				$query->execute();
				$connessione->commit();
				$ins4 = true;
			}	 
			catch (PDOException $errorePDO) { 
		    	echo "Errore: " . $errorePDO->getMessage();
		    	$connessione->rollBack();
		    	$ins4 = false;
		    	exit();
			}
			if (!is_dir("lettere$annoprotocollo/".$ultimoid)) { //se non esiste una directory con il l'id della lettera, la crea per ospitare gli allegati
				mkdir("lettere$annoprotocollo/".$ultimoid, 0777, true);
			}
			rename($value, "lettere$annoprotocollo".'/'.$ultimoid.'/'.$key);
		}
		
		//CREO IL QRCODE NELLA DIRECTORY LETTEREANNO/QRCODE
		include('lib/qrcode/qrlib.php');
		$id = $ultimoid;
		$anno = $annoprotocollo;
		
		if (!is_dir('lettere'.$anno.'/qrcode/')) {
			$creadir = mkdir('lettere'.$anno.'/qrcode/', 0777, true);
			if (!$creadir) die ("Impossibile creare la directory: qrcode/");
		}
		
		$pathqrcode = 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
		$param = 'Protocollo n° '.$id.' del '.$dataregistrazione;
		$codeText = $param; 
		$debugLog = ob_get_contents(); 
		QRcode::png($codeText, $pathqrcode);
		
		//SE L'INSERIMENTO NON VA A BUON FINE SCRIVO NEL LOG L'ERRORE
		if ( (!$ins1 || !$ins2 || !$ins3) ) { 
			echo "Inserimento non riuscito:<br><br>
					Dati lettera: ".$ins1."<br>
					Utente Ins: ".$ins2."<br>
					Mitt/Dest: ".$ins3."<br>"; 
			$my_log->publscrivilog($_SESSION['loginname'], 'TENTATA REGISTRAZIONE LETTERA '. $ultimoid, 'FAILED' , '' , $_SESSION['logname'], 'protocollo');
			exit();
		}
		//SE L'INSERIMENTO VA A BUON FINE SCRIVO NEL LOG E SE SONO ATTIVE LE NOTIFICHE MANDO EMAIL
		else { 
			$indirizzi = $anagrafica->getNotificationsIns();
			if ($indirizzi) {
				//invio notifica
				$mail = new PHPMailer();
				$mail->From = 'no-reply@abulafiaweb.it';
				$mail->FromName = 'Abulafia Web Notification';
				$mail->isHTML(true);
				include "../mail-conf-include.php";
				foreach ($indirizzi as $email) {
					$mail->addAddress($email[0]);
				}
				$mail->Subject = 'Notifica registrazione nuova lettera in ' . $_SESSION['nomeapplicativo'];
				$mail->Body    = 'Con la presente si notifica l\'avvenuta registrazione della lettera n. <b>' . $idlettera . 
							'</b> avente come oggetto: <b>"'. $oggetto . '"</b>.<br>
							Inserimento effettuato da <b>' . $_SESSION['loginname'] 
							. '</b> il giorno ' . $datamail . '.<br><br>
							Messaggio automatico inviato da ' . $_SESSION['nomeapplicativo'] 
							.'.<br>Non rispondere a questa email.';
				$esito = $mail->send();
				//scrittura log mail
				$my_log -> publscrivilog($_SESSION['loginname'],'send notifications', $esito, 'notifica automatica - inserisci lettera', $_SESSION['logname'], 'mail');
			}
			//scrittura history log		
			$my_log -> publscrivilog( $_SESSION['loginname'], 'REGISTRATA LETTERA '. $ultimoid, 'OK', '', $_SESSION['logname'], 'protocollo');
		}
	}
	
	if($from == 'modifica') {
	
		$idlettera = $_GET['idlettera'];
		$change = false;
		//salvo le modifiche nel DB
		$lettera = new Lettera();
		$dettagli = $lettera->getDettagli( $idlettera, $annoprotocollo);
		$user = $_SESSION['loginid'];
		$time = time();
		
		if(!$_SESSION['block']) {
			if($dettagli['speditaricevuta'] != $speditaricevuta) {
				$old = $dettagli['speditaricevuta'];
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificato spedita/ricevuta', '$user', '$time', '#FFFFCC', '$old', '$speditaricevuta')");
				$change = true;
			}
			if($dettagli['oggetto'] != $oggetto) {
				$old = $dettagli['oggetto'];
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificato oggetto', '$user', '$time', '#FFFFCC', '$old', '$oggetto')");
				$change = true;
			}
			if($dettagli['datalettera'] != $datalettera) {
				$old = $calendario->dataSlash($dettagli['datalettera']);
				$new = $calendario->dataSlash($datalettera);
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificata data', '$user', '$time', '#FFFFCC', '$old', '$new')");
				$change = true;
			}
			if($dettagli['posizione'] != $posizione) {
				$old = $dettagli['posizione'];
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificato mezzo di trasmissione', '$user', '$time', '#FFFFCC', '$old', '$posizione')");
				$change = true;
			}
			if($dettagli['riferimento'] != $riferimento) {
				$old = addslashes($dettagli['riferimento'] . ' - ' . $lettera->getDescPosizione($dettagli['riferimento']));
				$now = addslashes($riferimento . ' - ' . $lettera->getDescPosizione($riferimento));
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificata posizione', '$user', '$time', '#FFFFCC', '$old', '$now')");
				$change = true;
			}
			if($dettagli['pratica'] != $pratica) {
				$old = addslashes($lettera->getDescPratica($dettagli['pratica']));
				$now = addslashes($lettera->getDescPratica($pratica));
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificata pratica', '$user', '$time', '#FFFFCC', '$old', '$now')");
				$change = true;
			}
			if($dettagli['note'] != $note) {
				$old = $dettagli['note'];
				$regmodifica = $connessione->query("INSERT INTO storico_modifiche VALUES('', '$idlettera', '$annoprotocollo', 'Modificata nota', '$user', '$time', '#FFFFCC', '$old', '$note')");
				$change = true;
			}
		}
		
		try {
			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE 
												lettere$annoprotocollo 
											SET 
												speditaricevuta = :speditaricevuta, 
												oggetto = :oggetto,
												datalettera = :datalettera,
												posizione = :posizione,
												riferimento = :riferimento,
												pratica = :pratica,
												note = :note
											WHERE 
												lettere$annoprotocollo.idlettera=:idlettera 
											LIMIT 1
											"); 
			$query->bindParam(':speditaricevuta', $speditaricevuta);
			$query->bindParam(':oggetto', $oggetto);
			$query->bindParam(':datalettera', $datalettera);
			$query->bindParam(':posizione', $posizione);
			$query->bindParam(':riferimento', $riferimento);
			$query->bindParam(':pratica', $pratica);
			$query->bindParam(':note', $note);
			$query->bindParam(':idlettera', $idlettera);
			$query->execute();
			$connessione->commit();
			$modifica = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		   	$modifica = false;
		   	exit();
		}
		
		$date=strftime("%Y-%m-%d");

		//AGGIORNO L'UTENTE CHE HA FATTO LA MODIFICA
		if(!$_SESSION['block']) {
			try {
				$connessione->beginTransaction();
				$query = $connessione->prepare("UPDATE 
													joinlettereinserimento$annoprotocollo 
												SET 
													joinlettereinserimento$annoprotocollo.idmod = :loginid, 
													joinlettereinserimento$annoprotocollo.datamod = :date 
												WHERE 
													joinlettereinserimento$annoprotocollo.idlettera = :idlettera 
												LIMIT 1
												"); 
				$query->bindParam(':loginid', $loginid);
				$query->bindParam(':date', $date);
				$query->bindParam(':idlettera', $idlettera);
				$query->execute();
				$connessione->commit();
				$utentemod = true;
			}	 
			catch (PDOException $errorePDO) { 
			   	echo "Errore: " . $errorePDO->getMessage();
			   	$connessione->rollBack();
			   	$utentemod = false;
			   	exit();
			}
		}
		
		//SE LA MODIFICA NON E' ANDATA A BUON FINE SCRIVO L'ERRORE NEL LOG
		if (!$modifica) { 
			echo "Modifica non riuscita" ; 
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'TENTATA MODIFICA LETTERA '. $idlettera , 
						'FAILED' , 
						'' , 
						$_SESSION['logname'], 
						'protocollo');
		}
		
		//SE LA MODIFICA E' ANDATA A BUON FINE SCRIVO NEL LOG E SE LE NOTIFICHE SONO ATTIVE MANDO L'EMAIL
		else {
			$indirizzi = $anagrafica->getNotificationsMod();
			if ($indirizzi) {
				//invio notifica
				$mail = new PHPMailer();
				$mail->From = 'no-reply@abulafiaweb.it';
				$mail->FromName = 'Abulafia Web Notification';
				$mail->isHTML(true);
				include "../mail-conf-include.php";
				foreach ($indirizzi as $email) {
					$mail->addAddress($email[0]);
				}
				$mail->Subject = 'Notifica modifica lettera in ' . $_SESSION['nomeapplicativo'];
				$mail->Body    = 'Con la presente si notifica la modifica della lettera n. <b>' . $idlettera . 
							'</b> avente come oggetto: <b>"'. $oggetto . '"</b>.<br>
							Modifica effettuata da <b>' . $_SESSION['loginname'] 
							. '</b> il giorno ' . $datamail . '<br><br>
							Messaggio automatico inviato da ' . $_SESSION['nomeapplicativo'] 
							.'.<br>Non rispondere a questa email.';
				$esito = $mail->send();
				//scrittura log mail
				$my_log -> publscrivilog($_SESSION['loginname'],
							'send notifications' , 
							$esito ,'notifica automatica - modifica lettera', 
							$_SESSION['logname'], 
							'mail');
			}
			
			//scrittura history log
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'MODIFICATA LETTERA '. 
						$idlettera , 
						'OK' , 
						'' , 
						$_SESSION['logname'], 
						'protocollo');
			
			$ultimoid = $idlettera;
		}
	}
	
	//RESET VARIABILI DI SESSIONE 
	unset($_SESSION['spedita-ricevuta']);
	unset($_SESSION['oggetto']);
	unset($_SESSION['data']);
	unset($_SESSION['posizione']);
	unset($_SESSION['riferimento']);
	unset($_SESSION['pratica']);
	unset($_SESSION['note']);
?>

<script language="javascript">
	window.location="login0.php?corpus=protocollo4&from=<?php echo $from ?>&id=<?php echo $ultimoid ?>&anno=<?php echo $annoprotocollo ?>"; 
</script>
