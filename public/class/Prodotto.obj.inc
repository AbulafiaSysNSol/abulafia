<?php 

	class Prodotto {
	
		public function inserisciProdotto($descrizione, $prezzo, $note, $unita) {
			$query = mysql_query("INSERT INTO anagrafica_prodotto VALUES ('', '$descrizione', '$prezzo', '$note', '$unita')");
			return $query;
		}
		
		public function ricercaProdotto($descrizione) {
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = mysql_query("SELECT * FROM anagrafica_prodotto ORDER BY descrizione ASC");
			}
			else {
				$query = mysql_query("SELECT * FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$result = array();
			while ($query2 = mysql_fetch_array($query)) {
				array_push($result, $query2);
			}
			return $result;		
		}

	}

?>