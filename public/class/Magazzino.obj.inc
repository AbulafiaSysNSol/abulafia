<?php 
	class Magazzino{
	
		public function insertSettore($descrizione, $owner) { //<man>Inserisce un nuovo settore nel DB passando la descrizione e l'id di chi lo inserisce</man>
			$query = mysql_query("INSERT INTO settori (id, descrizione, owner) VALUES ('', '$descrizione', '$owner')");
			return $query;
		}
		
		public function getSettoreById($id) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			$query = mysql_query("SELECT * FROM settori WHERE id = '$id'");
			$res = mysql_fetch_row($query);
			return $res[1];
		}
		
		public function getSettori() { //<man>Restituisce un array contente tutti i settori registrati nel DB</man>
			$query = mysql_query("SELECT * FROM settori");
			$settori = array();
			while ($res = mysql_fetch_array($query)) {
				array_push($settori,$res);
			}
			return $settori;
		}
		
		public function delSettore($id) { //<man>Elimina un settore passando l'id</man>
			$query = mysql_query("DELETE FROM settori WHERE id = '$id'");
			return $query;
		}
		
		public function updateSettore($id, $descrizione) { //<man>Aggiorna la descrizione di un settore passando l'id</man>
			$query = mysql_query("UPDATE settori SET descrizione = '$descrizione' WHERE id = '$id'");
			return $query;
		}
	}
?>