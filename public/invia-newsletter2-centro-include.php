<?php
	
	set_time_limit(0);
	
	$my_lettera = new Lettera();
	$my_file = new File();
	
	require('lib/phpmailer/PHPMailerAutoload.php');
	$mail = new PHPMailer();

	$idlettera= $_GET['id'];
	$annoricercaprotocollo=$_GET['anno'];
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

	$destinatario = str_replace(' ', '', $_POST['destinatario']);
	$destinatari = explode(',' , $destinatario);
	$oggetto = stripslashes($_POST['oggetto']);
	$messaggio = stripslashes($_POST['messaggio']);
	
	include "../mail-conf-include.php";
	
	$mail->From = $_SESSION['usernamemail'];
	$mail->addReplyTo = $_SESSION['usernamemail'];
	$mail->FromName = $_SESSION['denominazione'];

	//inserisco gli allegati
	$urlfile = $my_lettera->cercaAllegati($idlettera, $annoricercaprotocollo);
	if ($urlfile) {
		$i = 1;
		foreach ($urlfile as $valore) {
				$f = 'lettere' . $annoricercaprotocollo . '/' . $idlettera . '/'. $valore[2];
				$estensione = $my_file->estensioneFile($valore[2]);
				$nameall = 'AllegatoProt'.$idlettera.'-'.$i.'.'.$estensione;
				$mail->addAttachment($f, $nameall);
				$i++;
		}
	}

	//aggiungo i destinatari
	foreach ($destinatari as $valore) {
		$mail->addAddress($valore);     // Add a recipient
	}
	
	$mail->isHTML(true);   
	$mail->Subject = stripslashes($oggetto);
	$mail->Body = $headermail.stripslashes($messaggio).$footermail;
	
	$result = $mail->send();
	
	if(!$result) {
		echo '<div class="alert alert-danger"><b><i class="fa fa-times"></i> Errore:</b> si è verificato un errore nell\'invio dell\'email.<br>'.$mail->ErrorInfo.'</div>';
		echo '<a href="?corpus=dettagli-protocollo&id=' . $idlettera . '&anno=' . $annoricercaprotocollo . '"><i class="fa fa-reply"></i> Torna ai dettagli del protocollo</a> - <a href="?corpus=home"><i class="fa fa-home"></i> Torna alla home</a>';
		$esito= 'FAILED';
	} 
	else {
		$esito= 'SUCCESSFUL';
		$userid = $_SESSION['loginid'];
		$data = date("Y-m-d");
		$erroreallegati = 0;
		foreach ($destinatari as $valore) {
			$insert = mysql_query("INSERT INTO mailsend VALUES ( '', '$userid', '$valore', '$data', '$idlettera', '$annoricercaprotocollo')");
			echo mysql_error();
			$erroreallegati = 1;
		}
		?>
		<div class="row">
			<div class="col-xs-6">
				<div class="alert alert-success"><i class="fa fa-check"></i> Email inviata con <b>successo!</b></div>
			</div>
			
			<?php
			if($erroreallegati == 0) {
				?>
				<div class="col-xs-6">
					<div class="alert alert-danger"><i class="fa fa-times"></i> <b>Attenzione:</b> si è verificato un problema con l'invio degli allegati. Riprovare.</div>
				</div>
				<?php
			}
			else {
				?>
				<div class="col-xs-6">
					<div class="alert alert-success"><i class="fa fa-check"></i> Allegati inviati con <b>successo!</b></div>
				</div>
				<?php
			}
			?>
		</div>
		<a href="?corpus=dettagli-protocollo&id=<?php echo $idlettera; ?>&anno=<?php echo $annoricercaprotocollo; ?>"><i class="fa fa-reply"></i> Torna ai dettagli del protocollo</a> - <a href="?corpus=home"><i class="fa fa-home"></i> Torna alla home</a>
		<?php
	}
	
	$my_log -> publscrivilog($_SESSION['loginname'],'mail' , $esito , 'oggetto '.$oggetto.' - prot '.$idlettera.' - destinatari:'.str_replace(',',', ',$destinatario), $_SESSION['maillog']);
?>