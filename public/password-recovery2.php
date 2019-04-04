<?php

	session_start(); //avvio della sessione per caricare le variabili

	if (isset($_SESSION['auth']) && $_SESSION['auth'] > 1 ) {
        header("Location: login0.php?corpus=home");
    }

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
	
	include 'class/Log.obj.inc';
	include '../db-connessione-include.php'; //connessione al db-server
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI

	$settings3 = $connessione->query("SELECT distinct * from defaultsettings");
	$settings4 = $settings3->fetch();
	$url = $settings4['paginaprincipale'];

	$utente = $connessione->query("SELECT COUNT(*) FROM users, anagrafica WHERE users.mainemail='$email' and anagrafica.codicefiscale='$cf'"); //controllo della correttezza di email e codicefiscale
	$utente2 = $utente->fetch();

	if ($utente2[0] < 1 ) {
		?>
		<script>
			window.location="password-recovery.php?err=1";
		</script>
		<?php 
	}
	else {
		$data = time();
		$idutente = $connessione->query("SELECT users.idanagrafica FROM users WHERE users.mainemail='$email'");
		$idutente2 = $idutente->fetch();
		$id = $idutente2[0];
		$token = random_string(30);
		$linkreset = $url . "/public/password-recovery3.php?token=" . $token;
		
		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO passwordrecovery VALUES ( null, :id, :token, :data)"); 
			$query->bindParam(':id', $id);
			$query->bindParam(':token', $token);
			$query->bindParam(':data', $data);
			$query->execute();
			$connessione->commit();
			$insert = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$insert = false;
		}	
		
		$oggetto = "Link Reimposta Password";
		$messaggio = 	'Buongiorno,<br><br>di seguito il link per resettare la tua password di accesso ad Abulafia Web.<br><br>
						Se non sei stato tu a fare questa richiesta di reset, ti preghiamo di ignorare questo messaggio
						e contattare gli amministratori del sistema.<br><br>
						Per resettare la tua password <a href="' . $linkreset .'" target="_blank">clicca qui</a>.
						<br><br>Il link sar&agrave; attivo per 24 ore.
						<br><br>Il Team di Abulafia';

		$mail->setFrom ("supporto@abulafiaweb.it", "Abulafia Web");
		$mail->addReplyTo ("supporto@abulafiaweb.it");
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