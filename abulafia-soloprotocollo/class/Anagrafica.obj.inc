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
							FROM jointelefonipersone, defaultsettings, users 
							WHERE jointelefonipersone.idanagrafica = defaultsettings.idanagrafica 
							AND defaultsettings.idanagrafica = users.idanagrafica 
							AND users.auth > 98 
							AND defaultsettings.notificains = 1
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
							FROM jointelefonipersone, defaultsettings, users 
							WHERE jointelefonipersone.idanagrafica = defaultsettings.idanagrafica 
							AND defaultsettings.idanagrafica = users.idanagrafica 
							AND users.auth > 98 
							AND defaultsettings.notificamod = 1
							AND jointelefonipersone.tipo = 'envelope-o'
						");
		while ($mail = mysql_fetch_array($query)) {
			array_push($mailaddress, $mail);
		}
		return $mailaddress;	
	}

}

?>