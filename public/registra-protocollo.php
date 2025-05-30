<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php'; //connessione al db-server
	
	$id = $_GET['id'];
	$idnext = $id;

	//CREAZIONE NUOVI OGGETTI
	include('class/Anagrafica.obj.inc');
	include('class/Calendario.obj.inc');
	$anagrafica = new Anagrafica();
	$calendario = new Calendario();
	$my_log = new Log();
	
	//LIBRERIA PER L'INVIO DI EMAIL
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'lib/phpmailer/src/Exception.php';
	require 'lib/phpmailer/src/PHPMailer.php';
	require 'lib/phpmailer/src/SMTP.php';

	$date=strftime("%d/%m/%Y");
	$ora = date("g:i a");
	$datamail = $date . ' alle ' . $ora;
	
	//VARIABILI DI SESSIONI
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$loginid=$_SESSION['loginid'];
	
	//ACQUISISCO I DATI GIA' REGISTRATI DELLA LETTERA
	$query = $connessione->query("SELECT * FROM comp_lettera WHERE id = $id");
	$dati = $query->fetch();
	$oggetto = strip_tags(addslashes($dati['oggetto']));
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
	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO lettere$annoprotocollo VALUES (null, :oggetto, :datalettera, :dataregistrazione, '', :speditaricevuta, :posizione, :riferimento, :pratica, :note) "); 
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
		$inserimento = true;
	}	 
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
    	$connessione->rollBack();
    	$inserimento = false;
    	exit();
	}
	
	//AGGIORNO LA LETTERA
	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE comp_lettera SET protocollo = :ultimoid, anno = :annoprotocollo WHERE id = :id"); 
		$query->bindParam(':ultimoid', $ultimoid);
		$query->bindParam(':annoprotocollo', $annoprotocollo);
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
	}	 
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
    	$connessione->rollBack();
    	exit();
	}
		
	//SCRIVO L'UTENTE CHE HA FATTO L'INSERIMENTO
	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO joinlettereinserimento$annoprotocollo VALUES(:ultimoid, :loginid, '0', :dataregistrazione)"); 
		$query->bindParam(':ultimoid', $ultimoid);
		$query->bindParam(':loginid', $loginid);
		$query->bindParam(':dataregistrazione', $dataregistrazione);
		$query->execute();
		$connessione->commit();
	}	 
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
    	$connessione->rollBack();
    	exit();
	}
		
	//SCRIVO I MITTENTI/DESTINATARI NEL DB
	$destinatari = $connessione->query("SELECT * FROM comp_destinatari WHERE idlettera = $id");
	while($dest = $destinatari->fetch()) {
		$idanagrafica = $dest['idanagrafica']; 
		$inserimento1= $connessione->query("INSERT INTO joinletteremittenti$annoprotocollo VALUES ('$ultimoid', '$idanagrafica')");
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
	$param = 'Protocollo n� '.$id.' del '.$dataregistrazione;
	$codeText = $param; 
	$debugLog = ob_get_contents(); 
	QRcode::png($codeText, $pathqrcode);
		
	//SE L'INSERIMENTO NON VA A BUON FINE SCRIVO NEL LOG L'ERRORE
	if ( (!$inserimento || !$inserimento1) ) { 
		echo "Inserimento non riuscito" ; 
		$my_log -> publscrivilog($_SESSION['loginname'], 'TENTATA REGISTRAZIONE LETTERA '. $ultimoid, 'FAILED' , '' , $_SESSION['logfile'], 'protocollo');
	}
		
	//SE L'INSERIMENTO VA A BUON FINE SCRIVO NEL LOG E SE SONO ATTIVE LE NOTIFICHE MANDO EMAIL
	else { 
		$indirizzi = $anagrafica->getNotificationsIns();
		if ($indirizzi) {
			//invio notifica
			$mail = new PHPMailer\PHPMailer\PHPMailer;
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
			$my_log -> publscrivilog($_SESSION['loginname'],
						'send notifications' , 
						$esito ,
						'notifica automatica - inserisci lettera', 
						$_SESSION['logfile'], 'mail');
		}
		//scrittura history log		
		$my_log -> publscrivilog( $_SESSION['loginname'], 
					'REGISTRATA LETTERA '. $ultimoid , 
					'OK' , 
					'' , 
					$_SESSION['logfile'], 
					'protocollo');
	}
	
?>

<script language = "javascript">
	window.location="componilettera.php?id=<?php echo $idnext ?>&from=protocolla-lettera"; 
</script>