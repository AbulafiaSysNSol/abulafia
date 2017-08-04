<?php 
	class Magazzino{
	
		public function insertSettore($descrizione, $owner, $verificaconnessione) { //<man>Inserisce un nuovo settore nel DB passando la descrizione e l'id di chi lo inserisce</man>
			$query = $verificaconnessione->query("INSERT INTO settori (id, descrizione, owner) 
								VALUES ('', '$descrizione', '$owner')");
			return $query;
		}
		
		public function getSettoreById($id, $verificaconnessione) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			$query = $verificaconnessione->query("SELECT * 
								FROM settori 
								WHERE id = '$id'");
			$res = $query->fetch_row();
			return $res[1];
		}

		public function getDepositoById($id, $verificaconnessione) {
			$query = $verificaconnessione->query("SELECT * FROM joinprodottimagazzini WHERE id = '$id'");
			$res = $query->fetch_array();
			return $res;
		}

		public function modificaDeposito($id, $settore, $scortaminima, $riordino, $confezionamento, $verificaconnessione) {
			$query = $verificaconnessione->query("UPDATE joinprodottimagazzini SET settore = '$settore', scortaminima = '$scortaminima', puntoriordino = '$riordino', confezionamento = '$confezionamento' WHERE id = '$id'");
			return $query;
		}
		
		public function getSettori($verificaconnessione) { //<man>Restituisce un array contente tutti i settori registrati nel DB</man>
			$query = $verificaconnessione->query("SELECT * FROM settori");
			$settori = array();
			while ($res = $query->fetch_array()) {
				array_push($settori,$res);
			}
			return $settori;
		}
		
		public function delSettore($id, $verificaconnessione) { //<man>Elimina un settore passando l'id</man>
			$query = $verificaconnessione->query("DELETE FROM settori WHERE id = '$id'");
			return $query;
		}
		
		public function updateSettore($id, $descrizione, $verificaconnessione) { //<man>Aggiorna la descrizione di un settore passando l'id</man>
			$query = $verificaconnessione->query("UPDATE settori 
								SET descrizione = '$descrizione' 
								WHERE id = '$id'");
			return $query;
		}

		public function newDocument($datadocumento, $magazzino, $riferimento, $causale, $datariferimento, $note, $tipologia, $verificaconnessione) { //<man>Inserisce un nuovo documento</man>
			$query = $verificaconnessione->query("INSERT INTO documenti_magazzino 
								VALUES ('', 
									'$datadocumento', 
									'$magazzino', 
									'$riferimento', 
									'$causale', 
									'$datariferimento', 
									'$note', 
									'$tipologia') ");                     
			return $query;
		}

		public function getDocument($limit, $verificaconnessione) {
			$query = $verificaconnessione->query("SELECT * 
								FROM documenti_magazzino 
								ORDER BY id DESC LIMIT $limit");
			$documenti = array();
			while ($res = $query->fetch_array()) {
				array_push($documenti,$res);
			}
			return $documenti;
		}

		public function getDocumentById($id, $verificaconnessione) {
			$query = $verificaconnessione->query("SELECT * 
								FROM documenti_magazzino 
								WHERE id = '$id'");
			$res = $query->fetch_row();
			return $res;
		}

		public function getGiacenza($prodotto,$magazzino, $verificaconnessione) { //<man>Restituisce la descrizione del settore pasando l'id</man>
			$query = $verificaconnessione->query("SELECT giacenza 
								FROM joinprodottimagazzini 
								WHERE codicemagazzino = '$magazzino' 
								AND idprodotto = '$prodotto'");
			$res = $query->fetch_row();
			return $res[0];
		}

		public function sumGiacenza($prodotto,$magazzino,$val) {
			$gnow = $this->getGiacenza($prodotto,$magazzino);
			$newg = $gnow + $val;
			$query = mysql_query("UPDATE joinprodottimagazzini SET giacenza = '$newg' WHERE codicemagazzino = '$magazzino' AND idprodotto = '$prodotto'");
			return $query;
		}

		public function subGiacenza($prodotto,$magazzino,$val, $verificaconnessione) {
			$gnow = $this->getGiacenza($prodotto,$magazzino);
			$newg = $gnow - $val;
			$query = $verificaconnessione->query("UPDATE joinprodottimagazzini 
								SET giacenza = '$newg' 
								WHERE codicemagazzino = '$magazzino' 
								AND idprodotto = '$prodotto'");
			return $query;
		}

		public function newRigaDocumento($documento, $prodotto, $quantita, $note, $tipologia, $magazzino, $verificaconnessione) { //<man>Inserisce una nuova riga nel documento</man>
			$query = $verificaconnessione->query("INSERT INTO joindocumentiprodotti 
									VALUES ('', 
										'$documento', 
										'$prodotto', 
										'$quantita', 
										'$note') ");
			if ($tipologia == 'carico') {
				$this->sumGiacenza($prodotto, $magazzino, $quantita);
			} 
			else {
				$this->subGiacenza($prodotto, $magazzino, $quantita);	
			}                    
			return $query;
		}

		public function getInfoRigaById($id, $verificaconnessione) {
			$query = $verificaconnessione->query("SELECT * 
								FROM joindocumentiprodotti 
								WHERE id = '$id'");
			$res = $query->fetch_row();
			return $res;
		}

		public function eliminaRigaDocumento($idriga, $magazzino, $verificaconnessione) { //<man>Inserisce una nuova riga nel documento</man>
			$info = $this->getInfoRigaById($idriga);
			$this->subGiacenza($info[2], $magazzino, $info[3]);
			$query = $verificaconnessione->query("DELETE FROM joindocumentiprodotti 
								WHERE id = '$idriga'");
			return $query;
		}

		public function righeDocumento($id, $verificaconnessione) {
			$query = $verificaconnessione->query("SELECT * 
						FROM joindocumentiprodotti, anagrafica_prodotto, documenti_magazzino 
						WHERE joindocumentiprodotti.prodotto = anagrafica_prodotto.codice 
						AND joindocumentiprodotti.documento = documenti_magazzino.id 
						AND documenti_magazzino.id = '$id' 
						ORDER BY joindocumentiprodotti.id DESC");
			$righe = array();
			while ($res = $query->fetch_array()) {
				array_push($righe,$res);
			}
			return $righe;
		}
	}
?>
