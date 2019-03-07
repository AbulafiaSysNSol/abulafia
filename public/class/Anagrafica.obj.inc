<?php 

class Anagrafica {

	var $contacomponenti;

	function publcontaanagrafica ($tipologia) { //<man> Restituisce il numero di anagrafiche presenti nel database, passando come argomento la tipologia (es. persona, carica etc...)</man>
		$contacomponenti2= mysql_query("select count(*) from anagrafica where tipologia='$tipologia'"); //query per contare le anagrafiche per tipologia
		$contacomponenti1= mysql_fetch_row($contacomponenti2);
		$this->contacomponenti= $contacomponenti1[0];
	}

	function publcognomidiffusi () { //<man> Restituisce un array di cognomi in ordine di diffusione</man>
		$this->contacognomi2= mysql_query("
								select cognome,
								count(*) as conteggio
								from anagrafica 
								where tipologia='persona' 
								group by cognome
								order by conteggio desc"); //query per contare i cognomi per diffusione
	}

	function publnomidiffusi () { //<man> Restituisce un array di nomi in ordine di diffusione</man>
		$this->contanomi2= mysql_query("
								select nome,
								count(*) as conteggio
								from anagrafica 
								where tipologia='persona' 
								group by nome
								order by conteggio desc"); //query per contare i cognomi per diffusione
	}
	
	public function getNotificationsIns() {
		$mailaddress = array();
		$query = mysql_query(" 	SELECT jointelefonipersone.numero 
							FROM jointelefonipersone, usersettings, users 
							WHERE jointelefonipersone.idanagrafica = usersettings.idanagrafica 
							AND usersettings.idanagrafica = users.idanagrafica 
							AND users.auth > 98 
							AND usersettings.notificains = 1
							AND jointelefonipersone.tipo = 'envelope-o'
						");
		while ($mail = mysql_fetch_array($query)) {
			array_push($mailaddress, $mail);
		}
		return $mailaddress;	
	}
	
	public function getNotificationsMod() {
		$mailaddress = array();
		$query = mysql_query(" 	SELECT jointelefonipersone.numero 
							FROM jointelefonipersone, usersettings, users 
							WHERE jointelefonipersone.idanagrafica = usersettings.idanagrafica 
							AND usersettings.idanagrafica = users.idanagrafica 
							AND users.auth > 98 
							AND usersettings.notificamod = 1
							AND jointelefonipersone.tipo = 'envelope-o'
						");
		while ($mail = mysql_fetch_array($query)) {
			array_push($mailaddress, $mail);
		}
		return $mailaddress;	
	}
	
	public function getName($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.cognome, anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query);
		if($nome[1]) 
			return $nome[0] . ' ' . $nome[1];
		else 
			return $nome[0];
	}

	public function getNome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.nome FROM anagrafica WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query); 
		return $nome[0];
	}

	public function getCognome($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.cognome FROM anagrafica WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query); 
		return $nome[0];
	}

	public function getData($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.nascitadata FROM anagrafica WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query); 
		return $nome[0];
	}

	public function getLuogoNascita($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.nascitacomune FROM anagrafica WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query); 
		return $nome[0];
	}

	public function getCodiceFiscale($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.codicefiscale FROM anagrafica WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query); 
		return $nome[0];
	}

	public function getEmail($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT users.mainemail FROM users WHERE idanagrafica = $id");
		$nome = mysql_fetch_row($query); 
		return $nome[0];
	}

	public function getFoto($id) { //<man> Restituisce il nome e cognome di un anagrafica </man>
		$query = mysql_query("SELECT anagrafica.urlfoto FROM anagrafica WHERE idanagrafica = $id");
		$foto = mysql_fetch_row($query);
		if($foto[0]) 
			return 'foto/' . $foto[0];
		else 
			return 'foto/sagoma.png';
	}
	
	public function isAdmin($id) {
		$query = mysql_query("SELECT admin FROM users WHERE idanagrafica = $id");
		$admin = mysql_fetch_row($query);
		if ($admin[0] == 1) 
			return true;
		else
			return false;
	}

	public function isAnagrafica($id) {
		$query = mysql_query("SELECT anagrafica FROM users WHERE idanagrafica = $id");
		$anagrafica = mysql_fetch_row($query);
		if ($anagrafica[0] == 1) 
			return true;
		else
			return false;
	}

	public function isProtocollo($id) {
		$query = mysql_query("SELECT protocollo FROM users WHERE idanagrafica = $id");
		$protocollo = mysql_fetch_row($query);
		if ($protocollo[0] == 1) 
			return true;
		else
			return false;
	}

	public function isDocumenti($id) {
		$query = mysql_query("SELECT documenti FROM users WHERE idanagrafica = $id");
		$documenti = mysql_fetch_row($query);
		if ($documenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function isLettere($id) {
		$query = mysql_query("SELECT lettere FROM users WHERE idanagrafica = $id");
		$lettere = mysql_fetch_row($query);
		if ($lettere[0] == 1) 
			return true;
		else
			return false;
	}

	public function isMagazzino($id) {
		$query = mysql_query("SELECT magazzino FROM users WHERE idanagrafica = $id");
		$magazzino = mysql_fetch_row($query);
		if ($magazzino[0] == 1) 
			return true;
		else
			return false;
	}

	public function isAmbulatorio($id) {
		$query = mysql_query("SELECT ambulatorio FROM users WHERE idanagrafica = $id");
		$ambulatorio = mysql_fetch_row($query);
		if ($ambulatorio[0] == 1) 
			return true;
		else
			return false;
	}

	public function isContabilita($id) {
		$query = mysql_query("SELECT contabilita FROM users WHERE idanagrafica = $id");
		$contabilita = mysql_fetch_row($query);
		if ($contabilita[0] == 1) 
			return true;
		else
			return false;
	}

	public function isUser($id) {
		$query = mysql_query("SELECT COUNT(*) FROM users WHERE idanagrafica = $id");
		$utenti = mysql_fetch_row($query);
		if ($utenti[0] == 1) 
			return true;
		else
			return false;
	}

	public function canSign($idutente, $idufficio) {
		$query = mysql_query("SELECT COUNT(*) FROM joinpersoneuffici WHERE utente = $idutente AND ufficio = $idufficio");
		$abilitazione = mysql_fetch_row($query);
		if ($abilitazione[0] > 0) 
			return true;
		else
			return false;
	}

	public function profileIsUpdate($id) {
		$query = mysql_query("SELECT updateprofile FROM users WHERE idanagrafica = $id");
		$profile = mysql_fetch_row($query);
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