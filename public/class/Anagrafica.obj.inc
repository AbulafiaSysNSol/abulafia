<?php 

class Anagrafica {

	public function __construct($connessione) {
    	$this->connessione = $connessione;
    }

	var $contacomponenti;

	function publcontaanagrafica ($tipologia) { 
		$contacomponenti2= $this->connessione->query("SELECT COUNT(*) FROM anagrafica WHERE tipologia='$tipologia'");
		$contacomponenti1= $contacomponenti2->fetch();
		$this->contacomponenti= $contacomponenti1[0];
	}

	function publcognomidiffusi () {
		$this->contacognomi2= $this->connessione->query("
								SELECT cognome,
								COUNT(*) AS conteggio
								FROM anagrafica 
								WHERE tipologia='persona' 
								GROUP BY cognome
								ORDER BY conteggio DESC"); //query per contare i cognomi per diffusione
	}

	function publnomidiffusi () { //<man> Restituisce un array di nomi in ordine di diffusione</man>
		$this->contanomi2= $this->connessione->query("
								SELECT nome,
								count(*) as conteggio
								from anagrafica 
								where tipologia='persona' 
								group by nome
								order by conteggio desc"); //query per contare i cognomi per diffusione
	}
	
	public function getNotificationsIns() {
		$mailaddress = array();
		$query = $this->connessione->query("SELECT jointelefonipersone.numero 
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
		$mailaddress = array();
		$query = $this->connessione->query(" 	SELECT jointelefonipersone.numero 
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
		$query = $this->connessione->query("SELECT anagrafica.cognome, anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch();
		if($nome[1]) 
			return $nome[0] . ' ' . $nome[1];
		else 
			return $nome[0];
	}

	public function getNome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getCognome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT anagrafica.cognome FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getData($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT anagrafica.nascitadata FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch();
		return $nome[0];
	}

	public function getLuogoNascita($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT anagrafica.nascitacomune FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getCodiceFiscale($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT anagrafica.codicefiscale FROM anagrafica WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getEmail($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT users.mainemail FROM users WHERE idanagrafica = $id");
		$nome = $query->fetch(); 
		return $nome[0];
	}

	public function getFoto($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = $this->connessione->query("SELECT anagrafica.urlfoto FROM anagrafica WHERE idanagrafica = $id");
		$foto = $query->fetch();
		if($foto[0]) 
			return 'foto/' . $foto[0];
		else 
			return 'foto/sagoma.png';
	}
	
	public function isAdmin($id) {
		$query = $this->connessione->query("SELECT admin FROM users WHERE idanagrafica = $id");
		$admin = $query->fetch();
		if ($admin[0] == 1)
			return true;
		else
			return false;
	}

	public function isAnagrafica($id) {
		$query = $this->connessione->query("SELECT anagrafica FROM users WHERE idanagrafica = $id");
		$anagrafica = $query->fetch();
		if ($anagrafica[0] == 1) 
			return true;
		else
			return false;
	}

	public function isProtocollo($id) {
		$query = $this->connessione->query("SELECT protocollo FROM users WHERE idanagrafica = $id");
		$protocollo = $query->fetch();
		if ($protocollo[0] == 1) 
			return true;
		else
			return false;
	}

	public function isDocumenti($id) {
		$query = $this->connessione->query("SELECT documenti FROM users WHERE idanagrafica = $id");
		$documenti = $query->fetch();
		if ($documenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function isLettere($id) {
		$query = $this->connessione->query("SELECT lettere FROM users WHERE idanagrafica = $id");
		$lettere = $query->fetch();
		if ($lettere[0] == 1) 
			return true;
		else
			return false;
	}

	public function isMagazzino($id) {
		$query = $this->connessione->query("SELECT magazzino FROM users WHERE idanagrafica = $id");
		$magazzino = $query->fetch();
		if ($magazzino[0] == 1) 
			return true;
		else
			return false;
	}

	public function isAmbulatorio($id) {
		$query = $this->connessione->query("SELECT ambulatorio FROM users WHERE idanagrafica = $id");
		$ambulatorio = $query->fetch();
		if ($ambulatorio[0] == 1) 
			return true;
		else
			return false;
	}

	public function isContabilita($id) {
		$query = $this->connessione->query("SELECT contabilita FROM users WHERE idanagrafica = $id");
		$contabilita = $query->fetch();
		if ($contabilita[0] == 1) 
			return true;
		else
			return false;
	}

	public function isUser($id) {
		$query = $this->connessione->query("SELECT COUNT(*) FROM users WHERE idanagrafica = $id");
		$utenti = $query->fetch();
		if ($utenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function canSign($idutente, $idufficio) {
		$query = $this->connessione->query("SELECT COUNT(*) FROM joinpersoneuffici WHERE utente = $idutente AND ufficio = $idufficio");
		$abilitazione = $query->fetch();
		if ($abilitazione[0] > 0) 
			return true;
		else
			return false;
	}

	public function profileIsUpdate($id) {
		$query = $this->connessione->query("SELECT updateprofile FROM users WHERE idanagrafica = $id");
		$profile = $query->fetch();
		if ($profile[0] == 1) 
			return true;
		else
			return false;
	}

	public function updateProfile($id, $nome, $cognome, $data, $luogonascita, $codicefiscale, $email, $terminiecondizioni) {
		$query = mysql_query("UPDATE anagrafica SET nome = '$nome', cognome = '$cognome', nascitadata = '$data', nascitacomune = '$luogonascita', codicefiscale = '$codicefiscale' WHERE anagrafica.idanagrafica = $id");
		$query2 = mysql_query("UPDATE users SET mainemail = '$email', terminiecondizioni = '$terminiecondizioni' WHERE users.idanagrafica = $id");
		$query3 = mysql_query("UPDATE users SET updateprofile = '1' WHERE idanagrafica = $id");
		if ($query && $query2 && $query3) {
			return true;
		}
		else {
			return false;
		}
	}

	public function insertAssistito($nome, $cognome, $codicefiscale, $cittanascita, $datanascita, $cittadinanza, $residenzacitta, $residenzavia, $residentenumero, $documento, $documentonumero) { 
			$query = mysql_query("INSERT INTO cert_assistito VALUES ('', '$nome', '$cognome', '$codicefiscale', '$cittanascita', '$datanascita', '$cittadinanza', '$residenzacitta', '$residenzavia', '$residentenumero', '$documento', '$documentonumero')");
			return $query;
	}

	public function editAssistito($id, $nome, $cognome, $codicefiscale, $cittanascita, $datanascita, $cittadinanza, $residenzacitta, $residenzavia, $residentenumero, $documento, $documentonumero) { 
			$query = mysql_query("UPDATE cert_assistito SET nome = '$nome', cognome = '$cognome', codicefiscale = '$codicefiscale', luogonascita = '$cittanascita', datanascita = '$datanascita', cittadinanza = '$cittadinanza', residenzacitta = '$residenzacitta', residenzavia = '$residenzavia', residenzanumero = '$residentenumero', documento = '$documento', documentonumero = '$documentonumero' WHERE id = '$id'");
			return $query;
	}

	public function deleteAssistito($id) { 
			$query = mysql_query("DELETE FROM cert_assistito WHERE id = '$id'");
			return $query;
	}

	public function infoAssistito($id) {
		$query = mysql_query("SELECT * FROM cert_assistito WHERE id = $id");
		$res = mysql_fetch_array($query);
		return $res;
	}

	public function getNomeAssistito($id) {
		$query = mysql_query("SELECT nome, cognome FROM cert_assistito WHERE id = $id");
		$res = mysql_fetch_row($query);
		$nome = $res[0] . ' ' . $res[1];
		return $nome;
	}

}

?>