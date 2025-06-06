<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'lib/phpmailer/src/Exception.php';
	require 'lib/phpmailer/src/PHPMailer.php';
	require 'lib/phpmailer/src/SMTP.php';
	$mail = new PHPMailer();
	
	include "../mail-conf-include.php";	
	$res = $mail->smtpConnect();
	if($res) {
		?>
		<div class="alert alert-success"><b><i class="fa fa-check"></i> SUCCESSO:</b> collegamento al server mail riuscito correttamente. </div>
		<?php
	}
	else {
		?>
		<div class="alert alert-danger"><b><i class="fa fa-warning"></i> ERRORE:</b> Impossibile collegarsi al server mail. <?php echo 'Error: ' . $mail->ErrorInfo; ?> <br><br>Controllare i parametri nelle <a href="?corpus=server-mail">impostazioni email</a>. </div>
		<?php
	}
?>

<a href="login0.php?corpus=diagnostica"><b><i class="fa fa-arrow-left"></i> Indietro</b></a>