<?php
	include '../db-connessione-include.php'; //connessione al db-server
	$idlettera = $_GET['idlettera'];
	
	$update = mysql_query(" UPDATE comp_lettera SET vista = 1 WHERE id = $idlettera "); 
	
	if($update) {
		include('lib/phpmailer/PHPMailerAutoload.php');
		$mail = new PHPMailer();
		$mail->From = 'no-reply@cricatania.it';
		$mail->FromName = 'Abulafia';
		$mail->isHTML(true);
		include "../mail-conf-include.php";
		$mail->addAddress('biagiosaitta@hotmail.it');
		$mail->Subject = 'Nuova lettera da firmare!';
		$mail->Body    = 'Ciao Presidente,<br><br>
					è stata scritta una nuova che richiede la tua firma!!<br>
					Triverai la lettera sotto il menu "Lettere" alla voce "Lettere da firmare".
					<br><br>
					Messaggio automatico inviato da Abulafia. 
					<br>Non rispondere a questa email.';
		if(!$mail->send()) {
			echo $mail->ErrorInfo;
			exit();
		}
		header("Location: login0.php?corpus=home&firma=ok");
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>