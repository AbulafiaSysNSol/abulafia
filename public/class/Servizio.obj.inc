<?php 

	class Servizio{
	
		public function inserisciServizio($codice, $descrizione, $indirizzo, $citta, $cap, $telefono, $email, $magazzino) {
			$query = mysql_query("INSERT INTO servizi VALUES ('$codice', '$descrizione', '$indirizzo', '$citta', '$cap', '$telefono', '$email', '$magazzino')");
			return $query;
		}

		public function modificaServizio($id, $codice, $descrizione, $indirizzo, $citta, $cap, $telefono, $email, $magazzino) {
			$query = mysql_query("UPDATE servizi SET codice='$codice', descrizione='$descrizione', indirizzo='$indirizzo', citta='$citta', cap='$cap', telefono='$telefono', email='$email', magazzino='$magazzino' WHERE codice = '$id'");
			return $query;
		}

		public function getServizioById($id) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			$query = mysql_query("SELECT * FROM servizi WHERE codice = '$id'");
			$res = mysql_fetch_row($query);
			return $res[1];
		}

		public function getInfo($id) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			$query = mysql_query("SELECT * FROM servizi WHERE codice = '$id'");
			$result = array();
			while ($query2 = mysql_fetch_array($query)) {
				array_push($result, $query2);
			}
			return $result;
		}
		
		public function ricercaServizio($descrizione) {
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = mysql_query("SELECT * FROM servizi ORDER BY magazzino DESC, descrizione ASC");
			}
			else {
				$query = mysql_query("SELECT * FROM servizi WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') ORDER BY magazzino DESC, descrizione ASC");
			}
			
			$result = array();
			while ($query2 = mysql_fetch_array($query)) {
				array_push($result, $query2);
			}
			return $result;		
		}
		
		public function contaServizi($descrizione) {
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = mysql_query("SELECT COUNT(*) FROM servizi");
			}
			else {
				$query = mysql_query("SELECT COUNT(*) FROM servizi WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$count = mysql_fetch_row($query);
			return $count[0];
		}

	}

?>