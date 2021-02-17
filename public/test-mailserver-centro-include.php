<?php

	require_once 'lib/phpmailer/src/Exception.php';
	require_once 'lib/phpmailer/src/PHPMailer.php';
	require_once 'lib/phpmailer/src/SMTP.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer;
	
	include "../mail-conf-include.php";	
	$res = $mail->smtpConnect();
	if($res) {
		?>
		<div class="alert alert-success"><b><i class="fa fa-check"></i> SUCCESSO:</b> collegamento al server mail riuscito correttamente. </div>
		<?php
	}
	else {
		?>
		<div class="alert alert-danger"><b><i class="fa fa-warning"></i> ERRORE:</b> Impossibile collegarsi al server mail.<br><br>Controllare i parametri nelle <a href="?corpus=server-mail">impostazioni email</a>. </div>
		<?php
	}
?>

<a href="login0.php?corpus=diagnostica"><b><i class="fa fa-arrow-left"></i> Indietro</b></a>
