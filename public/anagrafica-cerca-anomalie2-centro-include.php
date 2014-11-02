<?php

	$controlloget='ok';
	
	//RECUPERO VARIABILE FROM DAL GET
	
	if(isset($_GET['filtro'])) //controlla che sia passata la variabile
		{ 
		$filtro= $_GET['filtro'];
		}
	
	else { $controlloget='no'; }
	
	
	if(isset($_GET['id1'])) //controlla che sia passata la variabile
		{ 
		$id1= $_GET['id1']; 
		}
	else { $controlloget='no'; }
		
	if(isset($_GET['id2'])) //controlla che sia passata la variabile
		{ 
		$id2= $_GET['id2'];
	
		}
	else { $controlloget='no'; }
		
	//controlli logici
	
	if (($id1==$id2) or ($controlloget=='no')) //se una delle variabili manca, non prosegue
		{
		$_SESSION['message']= 'Errore nell\'url, ricontrollare i parametri della pagina';
		?>
		<script language="javascript">
 			<!--
 			document.modulo.action = 'login0.php?corpus=anagrafica-cerca-anomalie';
 			-->
 		</script>
 		<?php
		exit();
		}


	
	//INSERISCO I DATI NEL DATABASE SE IL FROM E' DIVERSO DA MODIFICA
	if($from != 'modifica') {
	
		//SCRIVO I DETTAGLI DELLA LETTERA NEL DB
		$inserimento = mysql_query("insert 
					into lettere$annoprotocollo
					values
					('', 
					'$oggetto',
					'$datalettera',
					'$dataregistrazione',
					'',
					'$speditaricevuta', 
					'$posizione', 
					'$riferimento', 
					'$pratica', 
					'$note')
					");
		
		$ultimoid = mysql_insert_id();
		
		//SCRIVO L'UTENTE CHE HA FATTO L'INSERIMENTO
		$utentemod =mysql_query("	INSERT INTO 
								joinlettereinserimento$annoprotocollo 
							VALUES ( 
								'$ultimoid',
								'$loginid',
								'',
								'$dataregistrazione'
							)
						");
		
		//SCRIVO I MITTENTI/DESTINATARI NEL DB
		foreach ($my_lettera->arraymittenti as $key => $value) { //inserisce i dati dei mittenti nel db
			$inserimento1= mysql_query("insert
						into joinletteremittenti$annoprotocollo
						values
						('$ultimoid',
						'$key'
						)");
			echo  mysql_error();
		}
		
		//SCRIVO GLI ALLEGATI NEL DB
		foreach ($my_lettera->arrayallegati as $key => $value) { //inserisce i dati degli allegati nel db e provvede a spostare i file dalla dir temp
			$inserimento2= mysql_query("insert
						into joinlettereallegati
						values
						(
						'$ultimoid',
						'$annoprotocollo',
						'$key')
						");
			echo  mysql_error();
			if (!is_dir("lettere$annoprotocollo/".$ultimoid)) { //se non esiste una directory con il l'id della lettera, 
									//la crea per ospitare gli allegati
									mkdir("lettere$annoprotocollo/".$ultimoid, 0777, true);
									}
			rename($value, "lettere$annoprotocollo".'/'.$ultimoid.'/'.$key);
		}
		
		//CREO IL QRCODE NELLA DIRECTORY LETTEREANNO/QRCODE
		include('lib/qrcode/qrlib.php');
		$id = $ultimoid;
		$anno = $annoprotocollo;
		
		if (!is_dir('lettere'.$anno.'/qrcode/')) {
			$creadir=mkdir('lettere'.$anno.'/qrcode/', 0777, true);
			if (!$creadir) die ("Impossibile creare la directory: qrcode/");
		}
		
		$pathqrcode = 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
		$param = 'Protocollo n° '.$id.' del '.$dataregistrazione;
		$codeText = $param; 
		$debugLog = ob_get_contents(); 
		QRcode::png($codeText, $pathqrcode);
		
		//SE L'INSERIMENTO NON VA A BUON FINE SCRIVO NEL LOG L'ERRORE
		if ( (!$inserimento || !$inserimento1) ) { 
			echo "Inserimento non riuscito" ; 
			$my_log -> publscrivilog( 	$_SESSION['loginname'], 
								'TENTATA REGISTRAZIONE LETTERA '. $ultimoid, 
								'FAILED' , 
								'' , 
								$_SESSION['historylog']
							);
		}
		
		//SE L'INSERIMENTO VA A BUON FINE SCRIVO NEL LOG E SE SONO ATTIVE LE NOTIFICHE MANDO EMAIL
		else { 
			$indirizzi = $anagrafica->getNotificationsIns();
			if ($indirizzi) {
				//invio notifica
				$mail = new PHPMailer();
				$mail->From = 'no-reply@cricatania.it';
				$mail->FromName = 'Abulafia';
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
				$my_log -> publscrivilog($_SESSION['loginname'],
							'send notifications' , 
							$esito ,
							'notifica automatica - inserisci lettera', 
							$_SESSION['maillog']);
			}
			//scrittura history log		
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'REGISTRATA LETTERA '. $ultimoid , 
						'OK' , 
						'' , 
						$_SESSION['historylog']);
		}
	}
	
	if($from == 'modifica') {
	
		$idlettera = $_GET['idlettera'];
		$modifica = mysql_query("	UPDATE 
								lettere$annoprotocollo 
							SET 
								speditaricevuta = '$speditaricevuta', 
								oggetto = '$oggetto',
								datalettera = '$datalettera',
								posizione = '$posizione',
								riferimento = '$riferimento',
								pratica = '$pratica',
								note = '$note'
							WHERE 
								lettere$annoprotocollo.idlettera='$idlettera' 
							LIMIT 1
						");
		echo mysql_error();
		
		$date=strftime("%Y-%m-%d");
		//AGGIORNO L'UTENTE CHE HA FATTO LA MODIFICA
		$utentemod =mysql_query("	UPDATE 
								joinlettereinserimento$annoprotocollo 
							SET 
								joinlettereinserimento$annoprotocollo.idmod='$loginid', 
								joinlettereinserimento$annoprotocollo.datamod='$date' 
							WHERE 
								joinlettereinserimento$annoprotocollo.idlettera='$idlettera' 
							LIMIT 1
						");
	
		//SE LA MODIFICA NON E' ANDATA A BUON FINE SCRIVO L'ERRORE NEL LOG
		if (!$modifica) { 
			echo "Modifica non riuscita" ; 
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'TENTATA MODIFICA LETTERA '. $idlettera , 
						'FAILED' , 
						'' , 
						$_SESSION['historylog']);
		}
		
		//SE LA MODIFICA E' ANDATA A BUON FINE SCRIVO NEL LOG E SE LE NOTIFICHE SONO ATTIVE MANDO L'EMAIL
		else {
			$indirizzi = $anagrafica->getNotificationsMod();
			if ($indirizzi) {
				//invio notifica
				$mail = new PHPMailer();
				$mail->From = 'no-reply@cricatania.it';
				$mail->FromName = 'Abulafia';
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
							$_SESSION['maillog']);
			}
			
			//scrittura history log
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'MODIFICATA LETTERA '. 
						$idlettera , 
						'OK' , 
						'' , 
						$_SESSION['historylog']);
			
			$ultimoid= $idlettera;
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

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=protocollo4&from=<?php echo $from ?>&id=<?php echo $ultimoid ?>&anno=<?php echo $annoprotocollo ?>"; 
	else 
		window.location="login0.php?corpus=protocollo4&from=<?php echo $from ?>&id=<?php echo $ultimoid ?>&anno=<?php echo $annoprotocollo ?>"; 
</SCRIPT>
