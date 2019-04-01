<?php 

	require_once('../db-connessione-include.php');

	class Prodotto {
	
		public function inserisciProdotto($descrizione, $prezzo, $note, $unita, $barcode) {
			global $connessione;
			try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO anagrafica_prodotto VALUES (null, :descrizione, :prezzo, :note, :unita, :barcode)"); 
			$query->bindParam(':descrizione', $descrizione);
			$query->bindParam(':prezzo', $prezzo);
			$query->bindParam(':note', $note);
			$query->bindParam(':unita', $unita);
			$query->bindParam(':barcode', $barcode);
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
		
		public function modificaProdotto($codice, $descrizione, $prezzo, $note, $unita, $barcode) {
			global $connessione;
			try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE anagrafica_prodotto SET descrizione=:descrizione, prezzo=:prezzo, note=:note, unita_misura=:unita, codicebarre=:barcode WHERE codice=:codice"); 
			$query->bindParam(':descrizione', $descrizione);
			$query->bindParam(':prezzo', $prezzo);
			$query->bindParam(':note', $note);
			$query->bindParam(':unita', $unita);
			$query->bindParam(':barcode', $barcode);
			$query->bindParam(':codice', $codice);
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
		
		public function eliminaProdotto($codice) {
			global $connessione;
			try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("DELETE FROM anagrafica_prodotto WHERE codice=:codice"); 
			$query->bindParam(':codice', $codice);
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
		
		public function assegnaProdotto($codiceprodotto, $magazzino, $settore, $scortaminima, $riordino, $giacenzainiziale, $confezionamento) {
			global $connessione;
			try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO joinprodottimagazzini VALUES (null, :codiceprodotto, :magazzino, :settore, :scortaminima, :riordino, :giacenzainiziale, :giacenzainiziale, :confezionamento )"); 
			$query->bindParam(':codiceprodotto', $codiceprodotto);
			$query->bindParam(':magazzino', $magazzino);
			$query->bindParam(':settore', $settore);
			$query->bindParam(':scortaminima', $scortaminima);
			$query->bindParam(':riordino', $riordino);
			$query->bindParam(':giacenzainiziale', $giacenzainiziale);
			$query->bindParam(':confezionamento', $confezionamento);
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
		
		public function contaProdotto($descrizione) {
			global $connessione;
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = $connessione->query("SELECT COUNT(*) FROM anagrafica_prodotto");
			}
			else {
				$query = $connessione->query("SELECT COUNT(*) FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') OR (codicebarre LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$count = $query->fetch();
			return $count[0];
		}
		
		public function getInfo($id) {
			global $connessione;
			$query = $connessione->query("SELECT * FROM anagrafica_prodotto WHERE codice = '$id'");
			$result = $query->fetch();
			return $result;
		}

		public function getProdottoById($id) { //<man>Restituisce la descrizione del prodottoe pasando l'id</man>
			global $connessione;
			$query = $connessione->query("SELECT * FROM anagrafica_prodotto WHERE codice = '$id'");
			$res = $query->fetch();
			return $res[1];
		}
		
		public function ricercaProdotto($descrizione) {
			global $connessione;
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = $connessione->query("SELECT * FROM anagrafica_prodotto ORDER BY descrizione ASC");
			}
			else {
				$query = $connessione->query("SELECT * FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') OR (codicebarre LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$result = array();
			while ($query2 = $query->fetch()) {
				array_push($result, $query2);
			}
			return $result;		
		}
		
		public function ricercaDeposito($prodotto, $magazzino) {
			global $connessione;
			if ($magazzino == "") {
				$query = $connessione->query("SELECT * FROM servizi, anagrafica_prodotto, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			else {
				$query = $connessione->query("SELECT * FROM servizi, anagrafica_prodotto, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND joinprodottimagazzini.codicemagazzino = '$magazzino' AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			$result = array();
			while ($query2 = $query->fetch()) {
				array_push($result, $query2);
			}
			return $result;		
		}
		
		public function contaDeposito($prodotto, $magazzino) {
			global $connessione;
			if ($magazzino == "") {
				$query = $connessione->query("SELECT COUNT(*) FROM anagrafica_prodotto, servizi, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			else {
				$query = $connessione->query("SELECT COUNT(*) FROM anagrafica_prodotto, servizi, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND joinprodottimagazzini.codicemagazzino = '$magazzino' AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			$count = $query->fetch();
			return $count[0];
		}
		
		public function ricercaProdottoInizioFine($descrizione, $inizio, $max, $ordine) {
			global $connessione;
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = $connessione->query("SELECT * FROM anagrafica_prodotto $ordine LIMIT $inizio, $max");
			}
			else {
				$query = $connessione->query("SELECT * FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') OR (codicebarre LIKE '%$descrizione%') $ordine LIMIT $inizio, $max");
			}
			
			$result = array();
			while ($query2 = $query->fetch()) {
				array_push($result, $query2);
			}
			return $result;		
		}

	}

?>