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

	public function isContabilita($id) {
		$query = mysql_query("SELECT contabilita FROM users WHERE idanagrafica = $id");
		$contabilita = mysql_fetch_row($query);
		if ($contabilita[0] == 1) 
			return true;
		else
			return false;
	}

}

?>