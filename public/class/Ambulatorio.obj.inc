<?php 

class Ambulatorio {

	private function connessione() {
		include '../db-connessione-include.php';
		$this->conn = $connessione;
	}

	public function insertAccess($idanagrafica, $idmedico, $data, $ora, $dipendente, $anamnesi, $diagnosi, $terapia, $note, $intervento) { 
			try {
   				$conn->beginTransaction();
				$query = $conn->prepare('INSERT INTO cert_accesso VALUES ('', :idanagrafica, :idmedico, :data, :ora, :dipendente, :anamnesi, :diagnosi, :terapia, :note, :intervento)'); 
				$query->bindParam(':idanagrafica', $idanagrafica);
				$query->bindParam(':idmedico', $idmedico);
				$query->bindParam(':data', $data);
				$query->bindParam(':ora', $ora);
				$query->bindParam(':dipendente', $dipendente);
				$query->bindParam(':anamnesi', $anamnesi);
				$query->bindParam(':diagnosi', $diagnosi);
				$query->bindParam(':terapia', $terapia);
				$query->bindParam(':note', $note);
				$query->bindParam(':intervento', $intervento);
				$query->execute();
				$conn->commit();
			}	 
			catch (PDOException $errorePDO) { 
    			echo "Errore: " . $errorePDO->getMessage();
			}
			$query2 = $query->fetchAll();
			return $query2;
	}

	public function getAccessi($idanagrafica) {
		$query = $conn->query("SELECT * FROM cert_accesso WHERE anagrafica = '$idanagrafica' ORDER BY data DESC");
		$accessi = array();
		while ($res = $query->fetch()) {
			array_push($accessi,$res);
		}
		return $accessi;
	}

	public function getCertificati($idanagrafica) {
		$query = $conn->query("SELECT * FROM cert_certificati WHERE anagrafica = '$idanagrafica' ORDER BY numero DESC");
		$certificati = array();
		while ($res = $query->fetch()) {
			array_push($certificati,$res);
		}
		return $certificati;
	}

	public function getRichieste() {
		$query = $conn->query("SELECT * FROM cert_richieste, cert_accesso WHERE cert_accesso.id = cert_richieste.visita AND stato = 0 ORDER BY cert_richieste.id ASC");
		$richieste = array();
		while ($res = $query->fetch()) {
			array_push($richieste,$res);
		}
		return $richieste;
	}

	public function countAccessi($idanagrafica) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso WHERE anagrafica = '$idanagrafica'");
		$res = $query->fetch();
		return $res[0];
	}

	public function countRichieste() {
		$query = $conn->query("SELECT COUNT(*) FROM cert_richieste WHERE stato = '0'");
		$res = $query->fetch();
		return $res[0];
	}

	public function countCertificati($idanagrafica) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_certificati WHERE anagrafica = '$idanagrafica'");
		$res = $query->fetch();
		return $res[0];
	}

	public function getVisita($id) {
		$query = $conn->query("SELECT * FROM cert_accesso WHERE id = $id");
		$res = $query->fetch();
		return $res;
	}

	public function contaPrestazioni($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso WHERE cert_accesso.data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioni118($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso WHERE intervento = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniFarmaci($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso WHERE terapia != '' AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniDip($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniIT($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'it' AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniDipIT($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'it' AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniEE($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'ee' AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniDipEE($inizio, $fine) {
		$query = $conn->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'ee' AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

}

?>