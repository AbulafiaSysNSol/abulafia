<?php
	
	set_time_limit(0);
	
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
		$footermail = $setting2['footermail'];	
	}

	$mittente = $_SESSION['mittente'];
	$destinatario = str_replace(' ', '', $_POST['destinatario']);
	$destinatari = explode( ',' , $destinatario);
	$oggetto = stripslashes($_POST['oggetto']);
	$messaggio = stripslashes($_POST['messaggio']);
	
	include "../mail-conf-include.php";
	
	$mail->From = $mittente;
	$mail->FromName = $_SESSION['denominazione'];
	
	foreach ($destinatari as $valore) {
		$mail->addAddress($valore);     // Add a recipient
	}
	
	$mail->addReplyTo('cp.catania@cri.it');
	
	$urlfile = $my_lettera->cercaAllegati($idlettera, $annoricercaprotocollo);
	if ($urlfile) {
		$i = 1;
		foreach ($urlfile as $valore) {
				$f = 'lettere' . $annoricercaprotocollo . '/' . $idlettera . '/'. $valore[2];
				$estensione = $my_file->estensioneFile($valore[2]);
				$mail->addAttachment($f, 'AllegatoProt'.$idlettera.'-'.$i.'.'.$estensione);
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
		echo '<div class="alert alert-success"><i class="fa fa-check"></i> Email inviata con <b>successo!</b></div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'SUCCESSFUL';
		$userid = $_SESSION['loginid'];
		$data = date("Y-m-d");
		foreach ($destinatari as $valore) {
			$insert = mysql_query("INSERT INTO mailsend VALUES ( '', '$userid', '$valore', '$data', '$idlettera', '$annoricercaprotocollo')");
			echo mysql_error();
		}
	}
	
	$my_log -> publscrivilog($_SESSION['loginname'],'mail' , $esito , 'oggetto '.$oggetto.' - prot '.$idlettera.' - destinatari:'.$destinatario, $_SESSION['maillog']);
?>