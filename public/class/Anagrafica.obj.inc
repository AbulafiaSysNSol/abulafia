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

	public function getUserId() {
		global $connessione;
		$query = $connessione->query("SELECT idanagrafica FROM users WHERE protocollo = 1 AND admin = 0");
		$utenti = array();
		while ($ut = $query->fetch()) {
			array_push($utenti, $ut);
		}
		return $utenti;
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

}

?>
