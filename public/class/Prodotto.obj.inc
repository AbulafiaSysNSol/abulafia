<?php 

	class Prodotto {
	
		public function inserisciProdotto($descrizione, $prezzo, $note, $unita, $barcode) {
			$query = mysql_query("INSERT INTO anagrafica_prodotto VALUES ('', '$descrizione', '$prezzo', '$note', '$unita', '$barcode')");
			return $query;
		}
		
		public function modificaProdotto($codice, $descrizione, $prezzo, $note, $unita, $barcode) {
			$query = mysql_query("UPDATE anagrafica_prodotto SET descrizione='$descrizione', prezzo='$prezzo', note='$note', unita_misura='$unita', codicebarre='$barcode' WHERE codice='$codice'");
			return $query;
		}
		
		public function eliminaProdotto($codice) {
			$query = mysql_query("DELETE FROM anagrafica_prodotto WHERE codice='$codice'");
			return $query;
		}
		
		public function assegnaProdotto($codiceprodotto, $magazzino, $settore, $scortaminima, $riordino, $giacenzainiziale, $confezionamento) {
			$query = mysql_query("INSERT INTO joinprodottimagazzini VALUES ('', '$codiceprodotto', '$magazzino', '$settore', '$scortaminima', '$riordino', '$giacenzainiziale', '$giacenzainiziale', '$confezionamento' )");
			return $query;
		}
		
		public function contaProdotto($descrizione) {
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = mysql_query("SELECT COUNT(*) FROM anagrafica_prodotto");
			}
			else {
				$query = mysql_query("SELECT COUNT(*) FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') OR (codicebarre LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$count = mysql_fetch_row($query);
			return $count[0];
		}
		
		public function getInfo($id) {
			$query = mysql_query("SELECT * FROM anagrafica_prodotto WHERE codice = '$id'");
			$result = mysql_fetch_array($query);
			return $result;
		}

		public function getProdottoById($id) { //<man>Restituisce la descrizione del prodottoe pasando l'id</man>
			$query = mysql_query("SELECT * FROM anagrafica_prodotto WHERE codice = '$id'");
			$res = mysql_fetch_row($query);
			return $res[1];
		}
		
		public function ricercaProdotto($descrizione) {
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = mysql_query("SELECT * FROM anagrafica_prodotto ORDER BY descrizione ASC");
			}
			else {
				$query = mysql_query("SELECT * FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') OR (codicebarre LIKE '%$descrizione%') ORDER BY descrizione ASC");
			}
			
			$result = array();
			while ($query2 = mysql_fetch_array($query)) {
				array_push($result, $query2);
			}
			return $result;		
		}
		
		public function ricercaDeposito($prodotto, $magazzino) {
			if ($magazzino == "") {
				$query = mysql_query("SELECT * FROM servizi, anagrafica_prodotto, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			else {
				$query = mysql_query("SELECT * FROM servizi, anagrafica_prodotto, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND joinprodottimagazzini.codicemagazzino = '$magazzino' AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			$result = array();
			while ($query2 = mysql_fetch_array($query)) {
				array_push($result, $query2);
			}
			return $result;		
		}
		
		public function contaDeposito($prodotto, $magazzino) {
			if ($magazzino == "") {
				$query = mysql_query("SELECT COUNT(*) FROM anagrafica_prodotto, servizi, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			else {
				$query = mysql_query("SELECT COUNT(*) FROM anagrafica_prodotto, servizi, joinprodottimagazzini WHERE joinprodottimagazzini.codicemagazzino = servizi.codice AND joinprodottimagazzini.idprodotto = anagrafica_prodotto.codice AND joinprodottimagazzini.codicemagazzino = '$magazzino' AND ((anagrafica_prodotto.codice LIKE '%$prodotto%') OR (anagrafica_prodotto.descrizione LIKE '%$prodotto%') OR (anagrafica_prodotto.codicebarre LIKE '$prodotto'))  ORDER BY anagrafica_prodotto.descrizione ASC");
			}
			$count = mysql_fetch_row($query);
			return $count[0];
		}
		
		public function ricercaProdottoInizioFine($descrizione, $inizio, $max, $ordine) {
			if( ($descrizione == '') OR ($descrizione == NULL) ) {
				$query = mysql_query("SELECT * FROM anagrafica_prodotto $ordine LIMIT $inizio, $max");
			}
			else {
				$query = mysql_query("SELECT * FROM anagrafica_prodotto WHERE (codice LIKE '%$descrizione%') OR (descrizione LIKE '%$descrizione%') OR (codicebarre LIKE '%$descrizione%') $ordine LIMIT $inizio, $max");
			}
			
			$result = array();
			while ($query2 = mysql_fetch_array($query)) {
				array_push($result, $query2);
			}
			return $result;		
		}

	}

?>