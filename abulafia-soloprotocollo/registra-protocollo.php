<?php
	session_start();
	
	include '../db-connessione-include.php'; //connessione al db-server
	
	$id = $_GET['id'];
	$idnext = $id;

	//CREAZIONE NUOVI OGGETTI
	include('class/Anagrafica.obj.inc');
	include('class/Log.obj.inc');
	include('class/Calendario.obj.inc');
	$anagrafica = new Anagrafica();
	$calendario = new Calendario();
	$my_log = new Log();
	
	//LIBRERIA PER L'INVIO DI EMAIL
	include('lib/phpmailer/PHPMailerAutoload.php');
	$date=strftime("%d/%m/%Y");
	$ora = date("g:i a");
	$datamail = $date . ' alle ' . $ora;
	
	//VARIABILI DI SESSIONI
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$loginid=$_SESSION['loginid'];
	
	//ACQUISISCO I DATI GIA' REGISTRATI DELLA LETTERA
	$query = mysql_query("SELECT * FROM comp_lettera WHERE id = $id");
	$dati = mysql_fetch_array($query);
	$oggetto= $dati['oggetto'];
	$datalettera = $dati['data'];
	$speditaricevuta = 'spedita';
	
	//ACQUISISCO I DATI DAL FORM
	$posizione = $_POST['posizione'];
	$riferimento = $_POST['riferimento'];
	$pratica = $_POST['pratica'];
	$note  = $_POST['note'];
	
	$dataregistrazione = strftime("%Y-%m-%d");
	$loginid = $_SESSION['loginid'];
	$auth = $_SESSION['auth'] ;
	//FINE ACQUISIZIONE DATI
	
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
	
	//AGGIORNO LA LETTERA
	$update = mysql_query("UPDATE comp_lettera SET protocollo = $ultimoid, anno = $annoprotocollo WHERE id = $id");
		
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
	$destinatari = mysql_query("SELECT * FROM comp_destinatari WHERE idlettera = $id");
	while($dest = mysql_fetch_array($destinatari)) {
		$idanagrafica = $dest['idanagrafica']; 
		$inserimento1= mysql_query("INSERT INTO joinletteremittenti$annoprotocollo VALUES ('$ultimoid', '$idanagrafica')");
		echo  mysql_error();
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
	
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="componilettera.php?id=<?php echo $idnext ?>&from=protocolla-lettera"; 
	else 
		window.location="componilettera.php?id=<?php echo $idnext ?>&from=protocolla-lettera"; 
</SCRIPT>