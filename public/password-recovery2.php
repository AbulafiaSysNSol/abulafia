<?php

	session_start(); //avvio della sessione per caricare le variabili

	require('lib/phpmailer/PHPMailerAutoload.php');
	$mail = new PHPMailer();

	function random_string($length) {
   		$string = "";
 		for ($i = 0; $i <= ($length/32); $i++)
        $string .= md5(time()+rand(0,99));
 		$max_start_index = (32*$i)-$length;
   		$random_string = substr($string, rand(0, $max_start_index), $length);
	    return $random_string;
	}

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$cf = $_POST['codicefiscale']; // nome utente inserito nella form della pagina iniziale
	$email = $_POST['email']; // password inserita nella form della pagina iniziale
	
	include '../db-connessione-include.php'; //connessione al db-server
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI

	$settings3=mysql_query("select distinct * from defaultsettings");
	$settings4=mysql_fetch_array($settings3);
	$url = $settings4['paginaprincipale'];

	$utente = mysql_query("SELECT COUNT(*) FROM users, anagrafica WHERE users.mainemail='$email' and anagrafica.codicefiscale='$cf'"); //controllo della correttezza di email e codicefiscale
	$utente2 = mysql_fetch_array($utente);

	if ($utente2[0] < 1 ) {
		?>
		<script>
			window.location="password-recovery.php?err=1";
		</script>
		<?php 
	}
	else {
		$data = time();
		$idutente = mysql_query("SELECT users.idanagrafica FROM users WHERE users.mainemail='$email'");
		$idutente2 = mysql_fetch_row($idutente);
		$id = $idutente2[0];
		$token = random_string(30);
		$linkreset = $url . "/password-recovery3?token=" . $token;
		$insert = mysql_query("INSERT INTO passwordrecovery VALUES ( '', '$id', '$token', '$data')");

		$oggetto = "Link Reimposta Password";
		$messaggio = 	'Buongiorno,<br><br>di seguito il link per resettare la tua password di accesso ad Abulafia Web.<br><br>
						Se non sei stato tu a fare questa richiesta di reset, ti preghiamo di ignorare questo messaggio
						e contattare gli amministratori del sistema.<br><br>
						Per resettare la tua password <a href="' . $linkreset .'" target="_blank">clicca qui</a>.
						<br><br>Il link sar&agrave; attivo per 24 ore.
						<br><br>Il Team di Abulafia';

		$mail->setFrom ("info@abulafiaweb.it", "Abulafia Web");
		$mail->addReplyTo ("info@abulafiaweb.it");
		$mail->addAddress($email);
		
		$mail->isHTML(true);   
		$mail->Subject = $oggetto;
		$mail->Body = $messaggio;
		
		$result = $mail->send();

		if($result) {
			?>
			<script>
				window.location="index.php?recovery=1";
			</script>
			<?php
		}
	}

?>

