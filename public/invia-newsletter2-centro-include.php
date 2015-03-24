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
		$footermail = '<br><br>'.$setting2['footermail'];	
	}

	$mittente = $_SESSION['mittente'];
	$destinatario = str_replace(' ', '', $_POST['destinatario']);
	$destinatari = explode(',' , $destinatario);
	$oggetto = $_POST['oggetto'];
	$messaggio = $_POST['messaggio'];
	
	include "../mail-conf-include.php";
	
	$mail->From = $mittente;
	$mail->FromName = $_SESSION['denominazione'];
	
	//inserisco gli allegati
	$all = 0;
	$urlfile = $my_lettera->cercaAllegati($idlettera, $annoricercaprotocollo);
	if ($urlfile) {
		$i = 1;
		foreach ($urlfile as $valore) {
				$f = 'lettere' . $annoricercaprotocollo . '/' . $idlettera . '/'. $valore[2];
				$estensione = $my_file->estensioneFile($valore[2]);
				$nameall = 'AllegatoProt'.$idlettera.'-'.$i.'.'.$estensione;
				if(!$mail->addAttachment($f, $nameall)) {
					$all = 1;
				}
				$i++;
		}
	}
	
	//aggiungo i destinatari
	foreach ($destinatari as $valore) {
		$mail->addAddress($valore);     // Add a recipient
	}
	
	//setto l'indirizzo di risposta
	$mail->addReplyTo($_SESSION['mittente']);
	
	$mail->isHTML(true);   
	$mail->Subject = $oggetto;
	$mail->Body = $headermail.$messaggio.$footermail;
	
	$result = $mail->send();

	if(!$result) {
		echo '<div class="alert alert-danger"><b><i class="fa fa-times"></i> Errore:</b> si è verificato un errore nell\'invio dell\'email.<br>'.$mail->ErrorInfo.'</div>';
		echo '<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>';
		$esito= 'FAILED';
	} 
	else {
		?>
		<div class="row">
			<div class="col-xs-6">
				<div class="alert alert-success"><i class="fa fa-check"></i> Email inviata con <b>successo!</b></div>
			</div>
			<div class="col-xs-6">
				<?php
				if($all) {
					$class="alert alert-danger";
					$message = '<b><i class="fa fa-times"></i> Attenzione:</b> si è verificato un problema di invio con l\'allegato!';
				}
				else {
					$class="alert alert-success";
					$message = '<i class="fa fa-check"></i> Allegato inviato <b>correttamente!</b>';
				}
				?>
				<div class="<?php echo $class; ?>"><?php echo $message; ?></div>
			</div>
		</div>
		<a href="?corpus=home"><i class="fa fa-reply"></i> Torna alla home</a>
		<?php
		$esito= 'SUCCESSFUL';
		$userid = $_SESSION['loginid'];
		$data = date("Y-m-d");
		foreach ($destinatari as $valore) {
			$insert = mysql_query("INSERT INTO mailsend VALUES ( '', '$userid', '$valore', '$data', '$idlettera', '$annoricercaprotocollo')");
			echo mysql_error();
		}
	}
	
	$my_log -> publscrivilog($_SESSION['loginname'],'mail' , $esito , 'oggetto '.$oggetto.' - prot '.$idlettera.' - destinatari:'.str_replace(',',', ',$destinatario), $_SESSION['maillog']);
?>