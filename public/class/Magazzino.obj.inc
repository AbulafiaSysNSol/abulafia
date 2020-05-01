<?php

require_once('../db-connessione-include.php');

	class Magazzino{
	
		public function insertSettore($descrizione, $owner) { //<man>Inserisce un nuovo settore nel DB passando la descrizione e l'id di chi lo inserisce</man>
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO settori (id, descrizione, owner) VALUES (null, :descrizione, :owner)"); 
				$query->bindParam(':descrizione', $descrizione);
				$query->bindParam(':owner', $owner);
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
		
		public function getSettoreById($id) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			global $connessione;
			$query = $connessione->query("SELECT * FROM settori WHERE id = '$id'");
			$res = $query->fetch();
			return $res[1];
		}

		public function getDepositoById($id) {
			global $connessione;
			$query = $connessione->query("SELECT * FROM joinprodottimagazzini WHERE id = '$id'");
			$res = $query->fetch();
			return $res;
		}

		public function modificaDeposito($id, $settore, $scortaminima, $riordino, $confezionamento) {
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("UPDATE joinprodottimagazzini SET settore = :settore, scortaminima = :scortaminima, puntoriordino = :riordino, confezionamento = :confezionamento WHERE id = :id"); 
				$query->bindParam(':settore', $settore);
				$query->bindParam(':scortaminima', $scortaminima);
				$query->bindParam(':riordino', $riordino);
				$query->bindParam(':confezionamento', $confezionamento);
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
		
		public function getSettori() { //<man>Restituisce un array contente tutti i settori registrati nel DB</man>
			global $connessione;
			$query = $connessione->query("SELECT * FROM settori");
			$settori = array();
			while ($res = $query->fetch()) {
				array_push($settori,$res);
			}
			return $settori;
		}
		
		public function delSettore($id) { //<man>Elimina un settore passando l'id</man>
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("DELETE FROM settori WHERE id = :id"); 
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
		
		public function updateSettore($id, $descrizione) { //<man>Aggiorna la descrizione di un settore passando l'id</man>
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("UPDATE settori SET descrizione = :descrizione WHERE id = :id"); 
				$query->bindParam(':descrizione', $descrizione);
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

		public function newDocument($datadocumento, $magazzino, $riferimento, $causale, $datariferimento, $note, $tipologia) { //<man>Inserisce un nuovo documento</man>
			global $connessione;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO documenti_magazzino VALUES (null, :datadocumento, :magazzino, :riferimento, :causale, :datariferimento, :note, :tipologia) "); 
				$query->bindParam(':datadocumento', $datadocumento);
				$query->bindParam(':magazzino', $magazzino);
				$query->bindParam(':riferimento', $riferimento);
				$query->bindParam(':causale', $causale);
				$query->bindParam(':datariferimento', $datariferimento);
				$query->bindParam(':note', $note);
				$query->bindParam(':tipologia', $tipologia);
				$query->execute();
				$iddoc = $connessione->lastInsertId();
				$connessione->commit();
			}	 
			catch (PDOException $errorePDO) { 
	    		echo "Errore: " . $errorePDO->getMessage();
				$connessione->rollBack();
				exit();
				$iddoc = false;
			}
			return $iddoc;
		}

		public function getDocument($limit) {
			global $connessione;
			$query = $connessione->query("SELECT * FROM documenti_magazzino ORDER BY id DESC LIMIT $limit");
			$documenti = array();
			while ($res = $query->fetch()) {
				array_push($documenti,$res);
			}
			return $documenti;
		}

		public function getDocumentFilter($doc, $mag, $causale, $num, $rif, $note, $ordine) {
			global $connessione;
			$where = '';
			$w = 0;
			if ($doc != '')
			{
				$where = 'WHERE id = ' . $doc;
				$w = 1;
			}
			if ($mag != '')
			{
				if($w == 0)
				{
					$where = "WHERE magazzino = '" . $mag . "'";
					$w = 1; 
				}
				else 
				{
					$where = $where . " AND magazzino = '" . $mag . "'";
				}
			}
			if ($causale != '')
			{
				if($w == 0)
				{
					$where = "WHERE causale = '" . $causale . "'";
					$w = 1; 
				}
				else 
				{
					$where = $where . " AND causale = '" . $causale . "'";
				}
			}
			if ($rif != '')
			{
				if($w == 0)
				{
					$where = "WHERE riferimento LIKE '%" . $rif . "%'";
					$w = 1; 
				}
				else 
				{
					$where = $where . " AND riferimento LIKE '%" . $rif . "%'";
				}
			}
			if ($note != '')
			{
				if($w == 0)
				{
					$where = "WHERE note LIKE '%" . $note . "%'";
					$w = 1; 
				}
				else 
				{
					$where = $where . " AND note LIKE '%" . $note . "%'";
				}
			}
			$query = $connessione->query("SELECT * FROM documenti_magazzino $where $ordine LIMIT $num");
			$documenti = array();
			while ($res = $query->fetch()) {
				array_push($documenti,$res);
			}
			return $documenti;
		}

		public function getDocumentById($id) {
			global $connessione;
			$query = $connessione->query("SELECT * FROM documenti_magazzino WHERE id = '$id'");
			$res = $query->fetch();
			return $res;
		}

		public function getGiacenza($prodotto,$magazzino) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			global $connessione;
			$query = $connessione->query("SELECT giacenza FROM joinprodottimagazzini WHERE codicemagazzino = '$magazzino' AND idprodotto = '$prodotto'");
			$res = $query->fetch();
			return $res[0];
		}

		public function sumGiacenza($prodotto,$magazzino,$val) {
			global $connessione;
			$gnow = $this->getGiacenza($prodotto,$magazzino);
			$newg = $gnow + $val;
			try 
			{
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("UPDATE joinprodottimagazzini SET giacenza = :newg WHERE codicemagazzino = :magazzino AND idprodotto = :prodotto"); 
				$query->bindParam(':newg', $newg);
				$query->bindParam(':magazzino', $magazzino);
				$query->bindParam(':prodotto', $prodotto);
				$query->execute();
				$connessione->commit();
				$q = true;
			}	 
			catch (PDOException $errorePDO) 
			{ 
	    		echo "Errore: " . $errorePDO->getMessage();
				$connessione->rollBack();
				$q = false;
			}
			return $q;
		}

		public function subGiacenza($prodotto,$magazzino,$val) {
			global $connessione;
			$gnow = $this->getGiacenza($prodotto,$magazzino);
			$newg = $gnow - $val;
			try {
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("UPDATE joinprodottimagazzini SET giacenza = :newg WHERE codicemagazzino = :magazzino AND idprodotto = :prodotto"); 
				$query->bindParam(':newg', $newg);
				$query->bindParam(':magazzino', $magazzino);
				$query->bindParam(':prodotto', $prodotto);
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

		public function newRigaDocumento($documento, $prodotto, $quantita, $note, $tipologia, $magazzino) {
			global $connessione;
			try 
			{
	   			$connessione->beginTransaction();
				$query = $connessione->prepare("INSERT INTO joindocumentiprodotti VALUES (null, :documento, :prodotto, :quantita, :note) "); 
				$query->bindParam(':documento', $documento);
				$query->bindParam(':prodotto', $prodotto);
				$query->bindParam(':quantita', $quantita);
				$query->bindParam(':note', $note);
				$query->execute();
				$connessione->commit();
				$q = true;
				if ($tipologia == 'carico') 
				{
					$this->sumGiacenza($prodotto, $magazzino, $quantita);
				} 
				else 
				{
					$this->subGiacenza($prodotto, $magazzino, $quantita);	
				}
			}	 
			catch (PDOException $errorePDO) { 
	    		echo "Errore: " . $errorePDO->getMessage();
				$connessione->rollBack();
				exit();
				$q = false;
			}                    
			return $q;
		}

		public function getInfoRigaById($id) {
			global $connessione;
			$query = $connessione->query("SELECT * FROM joindocumentiprodotti WHERE id = '$id'");
			$res = $query->fetch();
			return $res;
		}

		public function eliminaDocumento($id, $tipologia, $magazzino) {
			global $connessione;
			$righe = $this->righeDocumento($id);
			foreach($righe as $val)
			{
				$this->eliminaRigaDocumento($val[0], $magazzino, $tipologia);
			}
			$query = $connessione->query("DELETE FROM documenti_magazzino WHERE id = '$id'");
			return $query;
		}

		public function eliminaRigaDocumento($idriga, $magazzino, $tipodocumento) {
			global $connessione;
			try 
			{
				$info = $this->getInfoRigaById($idriga);
				if($tipodocumento == 'carico') 
				{
					$this->subGiacenza($info[2], $magazzino, $info[3]);
				}
				else 
				{
					$this->sumGiacenza($info[2], $magazzino, $info[3]);	
				}

	   			$connessione->beginTransaction();
				$query = $connessione->prepare("DELETE FROM joindocumentiprodotti WHERE id = :idriga"); 
				$query->bindParam(':idriga', $idriga);
				$query->execute();
				$connessione->commit();
				$q = true;	
			}	 
			catch (PDOException $errorePDO) 
			{ 
	    		echo "Errore: " . $errorePDO->getMessage();
				$connessione->rollBack();
				exit();
				$q = false;
			}
			return $q;
		}

		public function righeDocumento($id) {
			global $connessione;
			$query = $connessione->query("SELECT * FROM joindocumentiprodotti, anagrafica_prodotto, documenti_magazzino WHERE joindocumentiprodotti.prodotto = anagrafica_prodotto.codice AND joindocumentiprodotti.documento = documenti_magazzino.id AND documenti_magazzino.id = '$id' ORDER BY joindocumentiprodotti.id DESC");
			$righe = array();
			while ($res = $query->fetch()) {
				array_push($righe,$res);
			}
			return $righe;
		}
	}
?>