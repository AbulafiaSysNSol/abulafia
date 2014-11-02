<?php

	require('lib/phpmailer/PHPMailerAutoload.php');
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
		<div class="alert alert-danger"><b><i class="fa fa-warning"></i> ERRORE:</b> impossibile collegarsi al server mail. Controllare i parametri nel file mail-conf.php. </div>
		<?php
	}
?>

<a href="login0.php?corpus=diagnostica"><b><i class="fa fa-arrow-left"></i> Indietro</b></a>