<?php 

	require_once('../db-connessione-include.php');

	class Servizio{
	
		public function inserisciServizio($codice, $descrizione, $indirizzo, $citta, $cap, $telefono, $email, $magazzino) {
			global $connessione;
			try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO servizi VALUES (:codice, :descrizione, :indirizzo, :citta, :cap, :telefono, :email, :magazzino)"); 
			$query->bindParam(':codice', $codice);
			$query->bindParam(':descrizione', $descrizione);
			$query->bindParam(':indirizzo', $indirizzo);
			$query->bindParam(':citta', $citta);
			$query->bindParam(':cap', $cap);
			$query->bindParam(':telefono', $telefono);
			$query->bindParam(':email', $email);
			$query->bindParam(':magazzino', $magazzino);
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

		public function modificaServizio($id, $codice, $descrizione, $indirizzo, $citta, $cap, $telefono, $email, $magazzino) {
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("UPDATE servizi SET codice = :codice, descrizione = :descrizione, indirizzo = :indirizzo, citta = :citta, cap = :cap, telefono = :telefono, email = :email, magazzino = :magazzino WHERE codice = :id"); 
				$query->bindParam(':codice', $codice);
				$query->bindParam(':descrizione', $descrizione);
				$query->bindParam(':indirizzo', $indirizzo);
				$query->bindParam(':citta', $citta);
				$query->bindParam(':cap', $cap);
				$query->bindParam(':telefono', $telefono);
				$query->bindParam(':email', $email);
				$query->bindParam(':magazzino', $magazzino);
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

		public function eliminaServizio($id) {
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("DELETE FROM servizi WHERE codice = :id"); 
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

		public function getServizioById($id) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			global $connessione;
			$query = $connessione->query("SELECT * FROM servizi WHERE codice = '$id'");
			$res = $query->fetch();
			return $res[1];
		}

		public function getInfo($id) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			global $connessione;
			$query = $connessione->query("SELECT * FROM servizi WHERE codice = '$id'");
			$result = array();
			while ($query2 = $query->fetch()) {
				array_push($result, $query2);
			}
			return $result;
		}
		
		public function ricercaServizio($descrizione) {
			global $connessione;
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = $connessione->query("SELECT * FROM servizi ORDER BY codice ASC, descrizione ASC");
			}
			else {
				$query = $connessione->query("SELECT * FROM servizi WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') ORDER BY codice ASC, descrizione ASC");
			}
			
			$result = array();
			while ($query2 = $query->fetch()) {
				array_push($result, $query2);
			}
			return $result;		
		}
		
		public function contaServizi($descrizione) {
			global $connessione;
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = $connessione->query("SELECT COUNT(*) FROM servizi");
			}
			else {
				$query = $connessione->query("SELECT COUNT(*) FROM servizi WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$count = $query->fetch();
			return $count[0];
		}

	}

?>