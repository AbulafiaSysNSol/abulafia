<?php

require('lib/phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer();

$loginid= $_SESSION['loginid'];
$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");

//passaggio delle variabili dalla pagina del form
$mittente = $_SESSION['loginname'].'@abulafia.com';
$messaggio = $_POST['feedback'];

	include "../mail-conf-include.php";
	$mail->From = $mittente;
	$mail->FromName = $mittente;
	$mail->addAddress('informatica@cricatania.it');     // Add a recipient
	$mail->addAddress('biagiosaitta@hotmail.it');
	$mail->addAddress('alfiomusmarra@gmail.com');
	$mail->addReplyTo('no-reply@abulafia.com');
	$mail->isHTML(true);   
	$mail->Subject = 'Feedback Abulafia';
	$mail->Body    = $messaggio;
	if(!$mail->send()) {
		echo '<div class="alert alert-danger"><b><i class="fa fa-times"></i> Errore:</b> si è verificato un errore nell\'invio del feedback.<br>'.$mail->ErrorInfo.'</div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'FAILED';
	} else {
		echo '<div class="alert alert-success"><i class="fa fa-check"></i> Feedback inviato con <b>successo!</b></div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'SUCCESSFUL';
	}


$my_log -> publscrivilog($_SESSION['loginname'], 'send feedback' , $esito , $messaggio, $_SESSION['maillog']);

?>