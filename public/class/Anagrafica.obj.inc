<?php 

class Anagrafica {

	private function connessione() {
		include '../db-connessione-include.php';
		$this->conn = $connessione;
	}

	var $contacomponenti;

	function publcontaanagrafica ($tipologia) { 
		$this->connessione();
		$contacomponenti2= $this->conn->query("SELECT COUNT(*) FROM anagrafica WHERE tipologia='$tipologia'");
		$contacomponenti1= $contacomponenti2->fetch();
		$this->contacomponenti= $contacomponenti1[0];
	}

	function publcognomidiffusi () {
		$this->connessione();
		$this->contacognomi2= $this->conn->query("
								SELECT cognome,
								COUNT(*) AS conteggio
								FROM anagrafica 
								WHERE tipologia='persona' 
								GROUP BY cognome
								ORDER BY conteggio DESC"); //query per contare i cognomi per diffusione
	}

	function publnomidiffusi () { //<man> Restituisce un array di nomi in ordine di diffusione</man>
		$this->connessione();
		$this->contanomi2= $this->conn->query("
								SELECT nome,
								count(*) as conteggio
								from anagrafica 
								where tipologia='persona' 
								group by nome
								order by conteggio desc"); //query per contare i cognomi per diffusione
	}
	
	public function getNotificationsIns() {
		$this->connessione();
		$mailaddress = array();
		$query = $this->conn->query("SELECT jointelefonipersone.numero 
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
		$this->connessione();
		$mailaddress = array();
		$query = $this->conn->query(" 	SELECT jointelefonipersone.numero 
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
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica.cognome, anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch();
		if($nome[1]) 
			return $nome[0] . ' ' . $nome[1];
		else 
			return $nome[0];
	}

	public function getNome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getCognome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica.cognome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getData($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica.nascitadata FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch();
		return $nome[0];
	}

	public function getLuogoNascita($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->conn->query("SELECT anagrafica.nascitacomune FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getCodiceFiscale($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica.codicefiscale FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getEmail($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$this->connessione();
		$query = $this->conn->query("SELECT users.mainemail FROM users WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getFoto($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica.urlfoto FROM anagrafica WHERE idanagrafica = $id");
		$foto = $query->fetch();
		if($foto[0]) 
			return 'foto/' . $foto[0];
		else 
			return 'foto/sagoma.png';
	}
	
	public function isAdmin($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT admin FROM users WHERE idanagrafica = $id");
		$admin = $query->fetch();
		if ($admin[0] == 1)
			return true;
		else
			return false;
	}

	public function isAnagrafica($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT anagrafica FROM users WHERE idanagrafica = $id");
		$anagrafica = $query->fetch();
		if ($anagrafica[0] == 1) 
			return true;
		else
			return false;
	}

	public function isProtocollo($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT protocollo FROM users WHERE idanagrafica = $id");
		$protocollo = $query->fetch();
		if ($protocollo[0] == 1) 
			return true;
		else
			return false;
	}

	public function isDocumenti($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT documenti FROM users WHERE idanagrafica = $id");
		$documenti = $query->fetch();
		if ($documenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function isLettere($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT lettere FROM users WHERE idanagrafica = $id");
		$lettere = $query->fetch();
		if ($lettere[0] == 1) 
			return true;
		else
			return false;
	}

	public function isMagazzino($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT magazzino FROM users WHERE idanagrafica = $id");
		$magazzino = $query->fetch();
		if ($magazzino[0] == 1) 
			return true;
		else
			return false;
	}

	public function isAmbulatorio($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT ambulatorio FROM users WHERE idanagrafica = $id");
		$ambulatorio = $query->fetch();
		if ($ambulatorio[0] == 1) 
			return true;
		else
			return false;
	}

	public function isContabilita($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT contabilita FROM users WHERE idanagrafica = $id");
		$contabilita = $query->fetch();
		if ($contabilita[0] == 1) 
			return true;
		else
			return false;
	}

	public function isUser($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT COUNT(*) FROM users WHERE idanagrafica = $id");
		$utenti = $query->fetch();
		if ($utenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function canSign($idutente, $idufficio) {
		$this->connessione();
		$query = $this->conn->query("SELECT COUNT(*) FROM joinpersoneuffici WHERE utente = $idutente AND ufficio = $idufficio");
		$abilitazione = $query->fetch();
		if ($abilitazione[0] > 0) 
			return true;
		else
			return false;
	}

	public function profileIsUpdate($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT updateprofile FROM users WHERE idanagrafica = $id");
		$profile = $query->fetch();
		if ($profile[0] == 1) 
			return true;
		else
			return false;
	}

	public function updateProfile($id, $nome, $cognome, $data, $luogonascita, $codicefiscale, $email, $terminiecondizioni) {
		$this->connessione();
		try {
   			$conn->beginTransaction();
			$query = $conn->prepare("UPDATE anagrafica SET nome = :nome, cognome = :cognome, nascitadata = :data, nascitacomune = :luogonascita, codicefiscale = :codicefiscale WHERE anagrafica.idanagrafica = :id"); 
			$query->bindParam(':nome', $nome);
			$query->bindParam(':cognome', $cognome);
			$query->bindParam(':data', $data);
			$query->bindParam(':luogonascita', $luogonascita);
			$query->bindParam(':codicefiscale', $codicefiscale);
			$query->bindParam(':id', $id);
			$query->execute();
			$conn->commit();
			$q1 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
			$q1 = false;
		}

		try {
   			$conn->beginTransaction();
			$query = $conn->prepare("UPDATE users SET mainemail = :email, terminiecondizioni = :terminiecondizioni WHERE users.idanagrafica = :id"); 
			$query->bindParam(':email', $email);
			$query->bindParam(':terminiecondizioni', $terminiecondizioni);
			$query->bindParam(':id', $id);
			$query->execute();
			$conn->commit();
			$q2 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$q2 = false;
		}

		try {
   			$conn->beginTransaction();
			$query = $conn->prepare("UPDATE users SET updateprofile = '1' WHERE idanagrafica = :id"); 
			$query->bindParam(':id', $id);
			$query->execute();
			$conn->commit();
			$q3 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
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
		$this->connessione();
		
		try {
   			$conn->beginTransaction();
			$query = $conn->prepare("INSERT INTO cert_assistito VALUES ('', :nome, :cognome, :codicefiscale, :cittanascita, :datanascita, :cittadinanza, :residenzacitta, :residenzavia, :residentenumero, :documento, :documentonumero)"); 
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
			$conn->commit();
			$q3 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$q3 = false;
		}		
		return $q3;
	}

	public function editAssistito($id, $nome, $cognome, $codicefiscale, $cittanascita, $datanascita, $cittadinanza, $residenzacitta, $residenzavia, $residentenumero, $documento, $documentonumero) { 
		$this->connessione();
		
		try {
   			$conn->beginTransaction();
			$query = $conn->prepare("UPDATE cert_assistito SET nome = :nome, cognome = :cognome, codicefiscale = :codicefiscale, luogonascita = :cittanascita, datanascita = :datanascita, cittadinanza = :cittadinanza, residenzacitta = :residenzacitta, residenzavia = :residenzavia, residenzanumero = :residentenumero, documento = :documento, documentonumero = :documentonumero WHERE id = :id"); 
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
			$conn->commit();
			$q3 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$q3 = false;
		}		

		return $q3;
	}

	public function deleteAssistito($id) { 
		$this->connessione();
		
		try {
   			$conn->beginTransaction();
			$query = $conn->prepare("DELETE FROM cert_assistito WHERE id = :id"); 
			$query->bindParam(':id', $id);
			$query->execute();
			$conn->commit();
			$q = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$q = false;
		}
		return $q;
	}

	public function infoAssistito($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT * FROM cert_assistito WHERE id = $id");
		$res = $query->fetch();;
		return $res;
	}

	public function getNomeAssistito($id) {
		$this->connessione();
		$query = $this->conn->query("SELECT nome, cognome FROM cert_assistito WHERE id = $id");
		$res = $query->fetch();
		$nome = $res[0] . ' ' . $res[1];
		return $nome;
	}

}

?>