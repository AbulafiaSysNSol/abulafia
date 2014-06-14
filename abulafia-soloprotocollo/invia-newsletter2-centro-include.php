<?php

	
	$my_lettera = new Lettera();
	$my_file = new File();
	
	require('lib/phpmailer/PHPMailerAutoload.php');
	$mail = new PHPMailer();
	
	$idlettera= $_GET['id'];
	$annoricercaprotocollo=$_SESSION['annoricercaprotocollo'];
	$tabella= 'lettere'.$annoricercaprotocollo;
	$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");
	$setting=mysql_query("select * from mailsettings");
	$setting2=mysql_fetch_array($setting);
	$intestazione = $_POST['intestazione'];
	$firma = $_POST['firma'];
	if ($intestazione != 'intestazione') {
		$headermail = '';
	}
	else {
		$headermail = $setting2['headermail'].'<br><br>';	
	}

	if ($firma != 'firma') {
		$footermail = '';
	}
	else {
		$footermail = '<br><br>'.$setting2['footermail'];	
	}

	$mittente = $_SESSION['mittente'];
	$destinatario = $_POST['destinatario'];
	$destinatari = explode( ',' , $destinatario);
	$oggetto = stripslashes($_POST['oggetto']);
	$messaggio = stripslashes($_POST['messaggio']);
	
	/*
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'mail.cricatania.it';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = '';                 // SMTP username
	$mail->Password = '';      
	*/
	
	$mail->From = $mittente;
	$mail->FromName = 'Comitato Provinciale CRI Catania';
	
	foreach ($destinatari as $valore) {
		$mail->addAddress($valore);     // Add a recipient
	}
	
	$mail->addReplyTo($mittente);
	
	$urlfile = $my_lettera->cercaAllegati($idlettera, $annoricercaprotocollo);
	if ($urlfile) {
		$i = 1;
		foreach ($urlfile as $valore) {
				$f = 'lettere' . $annoricercaprotocollo . '/' . $idlettera . '/'. $valore[2];
				$estensione = $my_file->estensioneFile($valore[2]);
				echo $estensione;exit();
				$mail->addAttachment($f, 'AllegatoProt'.$idlettera.'-'.$i.$estensione);
				$i++;
		}
	}
	$mail->isHTML(true);   
	$mail->Subject = $oggetto;
	$mail->Body    = $headermail.$messaggio.$footermail;

	if(!$mail->send()) {
		echo '<div class="alert alert-danger"><b><i class="fa fa-times"></i> Errore:</b> si è verificato un errore nell\'invio dell\'email.<br>'.$mail->ErrorInfo.'</div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'FAILED';
	} else {
		echo '<div class="alert alert-success"><i class="fa fa-check"></i> Email inviata con successo!</div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'SUCCESSFUL';
	}
	
	$my_log -> publscrivilog($_SESSION['loginname'],'mail' , $esito , 'oggetto '.$oggetto.' - prot '.$idlettera.' - destinatari:'.$destinatario, $_SESSION['maillog']);
?>