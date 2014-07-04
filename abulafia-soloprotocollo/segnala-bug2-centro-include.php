<?php

require('lib/phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer();

$annoprotocollo = $_SESSION['annoprotocollo'];
$loginid= $_SESSION['loginid'];
$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");

//passaggio delle variabili dalla pagina del form
$destinatario = $_SESSION['email'];
$mittente = $_SESSION['loginname'];
$oggetto = 'Segnalazione bug in '.$_SESSION['nomeapplicativo'];
$messaggio = 'Pagina: '.$_POST['pagina-errore'].' -- Errore: '.$_POST['messaggio'];

	include "../mail-conf-include.php";
	$mail->From = $mittente;
	$mail->FromName = 'Segnalazione Bug Abulafia';
	$mail->addAddress($destinatario);     // Add a recipient
	$mail->addReplyTo($mittente);
	$mail->isHTML(true);   
	$mail->Subject = $oggetto;
	$mail->Body    = $messaggio;
	if(!$mail->send()) {
		echo '<div class="alert alert-danger"><b><i class="fa fa-times"></i> Errore:</b> si è verificato un errore nell\'invio dell\'email.<br>'.$mail->ErrorInfo.'</div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'FAILED';
	} else {
		echo '<div class="alert alert-success"><i class="fa fa-check"></i> Segnalazione inviata con successo!</div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'SUCCESSFUL';
	}


$my_log -> publscrivilog($_SESSION['loginname'],'bug report' , $esito ,'Pagina: '.$_POST['pagina-errore'], $_SESSION['maillog']);

?>