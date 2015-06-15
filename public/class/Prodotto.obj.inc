<?php 

	class Prodotto {
	
		public function inserisciProdotto($descrizione, $prezzo, $note, $unita) {
			$query = mysql_query("INSERT INTO anagrafica_prodotto VALUES ('', '$descrizione', '$prezzo', '$note', '$unita')");
			return $query;
		}

	}

?>