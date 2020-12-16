<?php 

require_once('../db-connessione-include.php');

class Anagrafica {

	var $contacomponenti;

	function publcontaanagrafica ($tipologia) { 
		global $connessione;
		$contacomponenti2 = $connessione->query("SELECT COUNT(*) FROM anagrafica WHERE tipologia='$tipologia'");
		$contacomponenti1 = $contacomponenti2->fetch();
		$this->contacomponenti = $contacomponenti1[0];
	}

	function publcognomidiffusi () {
		global $connessione;
		$this->contacognomi2 = $connessione->query("
								SELECT cognome,
								COUNT(*) AS conteggio
								FROM anagrafica 
								WHERE tipologia='persona' 
								GROUP BY cognome
								ORDER BY conteggio DESC"); //query per contare i cognomi per diffusione
	}

	function publnomidiffusi () { //<man> Restituisce un array di nomi in ordine di diffusione</man>
		global $connessione;
		$this->contanomi2 = $connessione->query("
								SELECT nome,
								count(*) as conteggio
								from anagrafica 
								where tipologia='persona' 
								group by nome
								order by conteggio desc"); //query per contare i cognomi per diffusione
	}
	
	public function getNotificationsIns() {
		global $connessione;
		$mailaddress = array();
		$query = $connessione->query("SELECT jointelefonipersone.numero 
							FROM jointelefonipersone, usersettings, users 
							WHERE jointelefonipersone.idanagrafica = usersettings.idanagrafica 
							AND usersettings.idanagrafica = users.idanagrafica 
							AND users.auth > 98 
							AND usersettings.notificains = 1
							AND jointelefonipersone.tipo = 'envelope-o'
						");
		while ($mail = $query->fetch()) {
			array_push($mailaddress, $mail);
		}
		return $mailaddress;	
	}
	
	public function getNotificationsMod() {
		global $connessione;
		$mailaddress = array();
		$query = $connessione->query(" 	SELECT jointelefonipersone.numero 
							FROM jointelefonipersone, usersettings, users 
							WHERE jointelefonipersone.idanagrafica = usersettings.idanagrafica 
							AND usersettings.idanagrafica = users.idanagrafica 
							AND users.auth > 98 
							AND usersettings.notificamod = 1
							AND jointelefonipersone.tipo = 'envelope-o'
						");
		while ($mail = $query->fetch()) {
			array_push($mailaddress, $mail);
		}
		return $mailaddress;	
	}
	
	public function getName($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.cognome, anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch();
		if($nome[1]) 
			return $nome[0] . ' ' . $nome[1];
		else 
			return $nome[0];
	}

	public function getNome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getCognome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.cognome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getData($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.nascitadata FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch();
		return $nome[0];
	}

	public function getLuogoNascita($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.nascitacomune FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getCodiceFiscale($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.codicefiscale FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getEmail($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT users.mainemail FROM users WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getFoto($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		global $connessione;
		$query = $connessione->query("SELECT anagrafica.urlfoto FROM anagrafica WHERE idanagrafica = $id");
		$foto = $query->fetch();
		if($foto[0]) 
			return 'foto/' . $foto[0];
		else 
			return 'foto/sagoma.png';
	}
	
	public function isAdmin($id) {
		global $connessione;
		$query = $connessione->query("SELECT admin FROM users WHERE idanagrafica = $id");
		$admin = $query->fetch();
		if ($admin[0] == 1)
			return true;
		else
			return false;
	}

	public function isAnagrafica($id) {
		global $connessione;
		$query = $connessione->query("SELECT anagrafica FROM users WHERE idanagrafica = $id");
		$anagrafica = $query->fetch();
		if ($anagrafica[0] == 1) 
			return true;
		else
			return false;
	}

	public function isProtocollo($id) {
		global $connessione;
		$query = $connessione->query("SELECT protocollo FROM users WHERE idanagrafica = $id");
		$protocollo = $query->fetch();
		if ($protocollo[0] == 1) 
			return true;
		else
			return false;
	}

	public function isDocumenti($id) {
		global $connessione;
		$query = $connessione->query("SELECT documenti FROM users WHERE idanagrafica = $id");
		$documenti = $query->fetch();
		if ($documenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function isLettere($id) {
		global $connessione;
		$query = $connessione->query("SELECT lettere FROM users WHERE idanagrafica = $id");
		$lettere = $query->fetch();
		if ($lettere[0] == 1) 
			return true;
		else
			return false;
	}

	public function isMagazzino($id) {
		global $connessione;
		$query = $connessione->query("SELECT magazzino FROM users WHERE idanagrafica = $id");
		$magazzino = $query->fetch();
		if ($magazzino[0] == 1) 
			return true;
		else
			return false;
	}

	public function isAmbulatorio($id) {
		global $connessione;
		$query = $connessione->query("SELECT ambulatorio FROM users WHERE idanagrafica = $id");
		$ambulatorio = $query->fetch();
		if ($ambulatorio[0] == 1) 
			return true;
		else
			return false;
	}

	public function isAutoparco($id) {
		global $connessione;
		$query = $connessione->query("SELECT autoparco FROM users WHERE idanagrafica = $id");
		$autoparco = $query->fetch();
		if ($autoparco[0] == 1)
			return true;
		else
			return false;
	}

	public function isOpco($id) { //operatore di centrale
		global $connessione;
		$query = $connessione->query("SELECT opco FROM users WHERE idanagrafica = $id");
		$autoparco = $query->fetch();
		if ($autoparco[0] == 1)
			return true;
		else
			return false;
	}

	public function isRespco($id) { //responsabile di centrale
		global $connessione;
		$query = $connessione->query("SELECT respco FROM users WHERE idanagrafica = $id");
		$autoparco = $query->fetch();
		if ($autoparco[0] == 1)
			return true;
		else
			return false;
	}

	public function isContabilita($id) {
		global $connessione;
		$query = $connessione->query("SELECT contabilita FROM users WHERE idanagrafica = $id");
		$contabilita = $query->fetch();
		if ($contabilita[0] == 1) 
			return true;
		else
			return false;
	}

	public function isUser($id) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM users WHERE idanagrafica = $id");
		$utenti = $query->fetch();
		if ($utenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function canSign($idutente, $idufficio) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM joinpersoneuffici WHERE utente = $idutente AND ufficio = $idufficio");
		$abilitazione = $query->fetch();
		if ($abilitazione[0] > 0) 
			return true;
		else
			return false;
	}

	public function profileIsUpdate($id) {
		global $connessione;
		$query = $connessione->query("SELECT updateprofile FROM users WHERE idanagrafica = $id");
		$profile = $query->fetch();
		if ($profile[0] == 1) 
			return true;
		else
			return false;
	}

	public function updateprofile($id, $nome, $cognome, $data, $luogonascita, $codicefiscale, $email, $terminiecondizioni) {
		global $connessione;
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE anagrafica SET nome = :nome, cognome = :cognome, nascitadata = :data, nascitacomune = :luogonascita, codicefiscale = :codicefiscale WHERE anagrafica.idanagrafica = :id"); 
			$query->bindParam(':nome', $nome);
			$query->bindParam(':cognome', $cognome);
			$query->bindParam(':data', $data);
			$query->bindParam(':luogonascita', $luogonascita);
			$query->bindParam(':codicefiscale', $codicefiscale);
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$q1 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
			$q1 = false;
		}

		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE users SET mainemail = :email, terminiecondizioni = :terminiecondizioni WHERE users.idanagrafica = :id"); 
			$query->bindParam(':email', $email);
			$query->bindParam(':terminiecondizioni', $terminiecondizioni);
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$q2 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q2 = false;
		}

		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE users SET updateprofile = '1' WHERE idanagrafica = :id"); 
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$q3 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q3 = false;
		}

		if ($q1 && $q2 && $q3) {
			return true;
		}
		else {
			return false;
		}
	}

	public function insertAssistito($nome, $cognome, $codicefiscale, $cittanascita, $datanascita, $cittadinanza, $residenzacitta, $residenzavia, $residentenumero, $documento, $documentonumero) { 
		
		global $connessione;
		
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO cert_assistito VALUES ('', :nome, :cognome, :codicefiscale, :cittanascita, :datanascita, :cittadinanza, :residenzacitta, :residenzavia, :residentenumero, :documento, :documentonumero)"); 
			$query->bindParam(':nome', $nome);
			$query->bindParam(':cognome', $cognome);
			$query->bindParam(':codicefiscale', $codicefiscale);
			$query->bindParam(':cittanascita', $cittanascita);
			$query->bindParam(':datanascita', $datanascita);
			$query->bindParam(':cittadinanza', $cittadinanza);
			$query->bindParam(':residenzacitta', $residenzacitta);
			$query->bindParam(':residenzavia', $residenzavia);
			$query->bindParam(':residentenumero', $residentenumero);
			$query->bindParam(':documento', $documento);
			$query->bindParam(':documentonumero', $documentonumero);
			$query->execute();
			$connessione->commit();
			$q3 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q3 = false;
		}		
		return $q3;
	}

	public function editAssistito($id, $nome, $cognome, $codicefiscale, $cittanascita, $datanascita, $cittadinanza, $residenzacitta, $residenzavia, $residentenumero, $documento, $documentonumero) { 
		
		global $connessione;
		
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE cert_assistito SET nome = :nome, cognome = :cognome, codicefiscale = :codicefiscale, luogonascita = :cittanascita, datanascita = :datanascita, cittadinanza = :cittadinanza, residenzacitta = :residenzacitta, residenzavia = :residenzavia, residenzanumero = :residentenumero, documento = :documento, documentonumero = :documentonumero WHERE id = :id"); 
			$query->bindParam(':nome', $nome);
			$query->bindParam(':cognome', $cognome);
			$query->bindParam(':codicefiscale', $codicefiscale);
			$query->bindParam(':cittanascita', $cittanascita);
			$query->bindParam(':datanascita', $datanascita);
			$query->bindParam(':cittadinanza', $cittadinanza);
			$query->bindParam(':residenzacitta', $residenzacitta);
			$query->bindParam(':residenzavia', $residenzavia);
			$query->bindParam(':residentenumero', $residentenumero);
			$query->bindParam(':documento', $documento);
			$query->bindParam(':documentonumero', $documentonumero);
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$q3 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q3 = false;
		}		

		return $q3;
	}

	public function deleteAssistito($id) { 
		global $connessione;
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("DELETE FROM cert_assistito WHERE id = :id"); 
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$q = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q = false;
		}
		return $q;
	}

	public function infoAssistito($id) {
		global $connessione;
		$query = $connessione->query("SELECT * FROM cert_assistito WHERE id = $id");
		$res = $query->fetch();;
		return $res;
	}

	public function getNomeAssistito($id) {
		global $connessione;
		$query = $connessione->query("SELECT nome, cognome FROM cert_assistito WHERE id = $id");
		$res = $query->fetch();
		$nome = $res[0] . ' ' . $res[1];
		return $nome;
	}

	public function Autorizza($id) {

		global $connessione;
		$autorizzato = 1;

		try {
			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE anagrafica SET autorizzato = :autorizzato WHERE idanagrafica = :idanagrafica");
			$query->bindParam(':autorizzato', $autorizzato);
			$query->bindParam(':idanagrafica', $id);
			$query->execute();
			$connessione->commit();
			$q3 = true;
		}
		catch (PDOException $errorePDO) {
			echo "Errore: " . $errorePDO->getMessage();
			$connessione->rollBack();
			$q3 = false;
		}

		return $q3;
	}

	public function revocaAutorizzazione($id) {
		global $connessione;
		$autorizzato = 0;

		try {
			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE anagrafica SET autorizzato = :autorizzato WHERE idanagrafica = :idanagrafica");
			$query->bindParam(':autorizzato', $autorizzato);
			$query->bindParam(':idanagrafica', $id);
			$query->execute();
			$connessione->commit();
			$q3 = true;
		}
		catch (PDOException $errorePDO) {
			echo "Errore: " . $errorePDO->getMessage();
			$connessione->rollBack();
			$q3 = false;
		}

		return $q3;
	}

	function random_string($length) {
   		$string = "";
 		for ($i = 0; $i <= ($length/32); $i++)
        $string .= md5(time()+rand(0,99));
 		$max_start_index = (32*$i)-$length;
   		$random_string = substr($string, rand(0, $max_start_index), $length);
	    return $random_string;
	}

	public function nuovoVolontario($nome, $cognome, $codicefiscale, $email) {
		global $connessione;

		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO anagrafica VALUES (null, :nome, :cognome, '', '', '', '', '', '', '0000-00-00', '', '', '', '', '', :codicefiscale, 'persona', '0', '1', '0')"); 
			$query->bindParam(':nome', $nome);
			$query->bindParam(':cognome', $cognome);
			$query->bindParam(':codicefiscale', $codicefiscale);
			$query->execute();
			$lastid = $connessione->lastInsertId();
			$connessione->commit();
			$inserimento = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore1: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$inserimento = false;
		 	exit();
		}	
		
		$id = $lastid;
		$nome = str_replace("'","",$nome);
		$cognome = str_replace("'","",$cognome);	
		$nomenuovoutente = strtolower($nome.'.'.$cognome);
		$password = $this->random_string(8);
		$passwordDB = md5($password);

		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO users VALUES(:id, 0, :nomenuovoutente, :passwordDB, :email, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)"); 
			$query->bindParam(':id', $id);
			$query->bindParam(':nomenuovoutente', $nomenuovoutente);
			$query->bindParam(':passwordDB', $passwordDB);
			$query->bindParam(':email', $email);
			$query->execute();
			$connessione->commit();
			$nuovoutente = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore2: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$nuovoutente = false;
		 	exit();
		}	

		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO usersettings VALUES(:id, 30, '', '#DEFEB4', '#FFFFCC', '100%', '0', '0')"); 
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$setting = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore3: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$setting = false;
		 	exit();
		}

		//use PHPMailer\PHPMailer\PHPMailer;
		//use PHPMailer\PHPMailer\Exception;
		require 'lib/phpmailer/src/Exception.php';
		require 'lib/phpmailer/src/PHPMailer.php';
		require 'lib/phpmailer/src/SMTP.php';
		$mail = new PHPMailer();
		$oggetto = "Creazione Nuovo Utente AbulafiaWeb";
		$messaggio = 	'Buongiorno '. $nome . ' ' . $cognome . ',<br><br>&egrave; ti confermiamo la 					creazione del tuo account sulla piattaforma Abulafia Web.<br><br>
						Di seguito i dati per accedere:<br><br>
						link: ' . $_SESSION['paginaprincipale'] . '<br>
						username: ' . $nomenuovoutente . '<br>
						password: ' . $password . '<br><br>
						Per eventuali chiarimenti puoi rispondere a questa email.
						<br><br>Il Team di Abulafia';

		$mail->setFrom ("supporto@abulafiaweb.it", "Abulafia Web");
		$mail->addReplyTo ("supporto@abulafiaweb.it");
		$mail->addAddress($email);
		$mail->isHTML(true);   
		$mail->Subject = $oggetto;
		$mail->Body = $messaggio;
		$result = $mail->send();

		if($inserimento && $nuovoutente && $setting && $result) {
			return true;
		}
		else {
			return false;
		}
	}

	public function getCellulare($id) {
		global $connessione;
		$risultati2 = $connessione->query("SELECT * FROM jointelefonipersone WHERE idanagrafica = '$id'");
		$countrecapiti = $connessione->query("SELECT COUNT(*) FROM jointelefonipersone WHERE idanagrafica = '$id'");
		$cr = $countrecapiti->fetch();

		if ($cr[0] > 0) {
			$row2 = $risultati2->fetch();
			while ($cell = $row2)
			{
				if ($cell['tipo'] = 'mobile')
				{
					return $cell['numero'];
				}
			}

		}
		else
		{
			return null;
		}

	}

}

?>
