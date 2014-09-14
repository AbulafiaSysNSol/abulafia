<?php
	session_start();
	include '../db-connessione-include.php'; //connessione al db-server
	include 'class/Calendario.obj.inc';
	$id = $_GET['idlettera'];
	$from = $_GET['from'];
	
	$calendario = new Calendario();
	
	$data = $calendario->dataDB($_POST['data']);
	$allegati = $_POST['allegati'];
	$oggetto = addslashes($_POST['oggetto']);
	$testo = addslashes($_POST['message']);
	$vista = 0;
	$firmata = 0;
	$insert = $_SESSION['loginid'];
	
	$update = mysql_query(" UPDATE comp_lettera SET data = '$data', oggetto = '$oggetto', testo = '$testo', allegati = '$allegati' WHERE id = $id ");
	echo mysql_error();
	
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
					Messaggio automatico inviato da ' . $_SESSION['nomeapplicativo'] 
					.'.<br>Non rispondere a questa email.';
		$esito = $mail->send();
		header("Location: login0.php?corpus=".$from."&id=" . $id);
	}
	else {
		echo 'Errore nella registrazione dei dati';
	}
?>