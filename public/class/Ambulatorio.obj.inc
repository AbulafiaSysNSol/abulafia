<?php 

require_once('../db-connessione-include.php');

class Ambulatorio {

	public function insertAccess($idanagrafica, $idmedico, $data, $ora, $dipendente, $anamnesi, $diagnosi, $terapia, $note, $intervento) { 
			global $connessione;
			try {
   				$connessione->beginTransaction();
				$query = $connessione->prepare('INSERT INTO cert_accesso VALUES (null, :idanagrafica, :idmedico, :data, :ora, :dipendente, :anamnesi, :diagnosi, :terapia, :note, :intervento)'); 
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
				$connessione->commit();
			}	 
			catch (PDOException $errorePDO) { 
    			echo "Errore: " . $errorePDO->getMessage();
    			$connessione->rollBack();
			}
			$query2 = $query->fetchAll();
			return $query2;
	}

	public function getAccessi($idanagrafica) {
		global $connessione;
		$query = $connessione->query("SELECT * FROM cert_accesso WHERE anagrafica = '$idanagrafica' ORDER BY data DESC");
		$accessi = array();
		while ($res = $query->fetch()) {
			array_push($accessi,$res);
		}
		return $accessi;
	}

	public function getCertificati($idanagrafica) {
		global $connessione;
		$query = $connessione->query("SELECT * FROM cert_certificati WHERE anagrafica = '$idanagrafica' ORDER BY numero DESC");
		$certificati = array();
		while ($res = $query->fetch()) {
			array_push($certificati,$res);
		}
		return $certificati;
	}

	public function getRichieste() {
		global $connessione;
		$query = $connessione->query("SELECT * FROM cert_richieste, cert_accesso WHERE cert_accesso.id = cert_richieste.visita AND stato = 0 ORDER BY cert_richieste.id ASC");
		$richieste = array();
		while ($res = $query->fetch()) {
			array_push($richieste,$res);
		}
		return $richieste;
	}

	public function countAccessi($idanagrafica) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso WHERE anagrafica = '$idanagrafica'");
		$res = $query->fetch();
		return $res[0];
	}

	public function countRichieste() {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_richieste WHERE stato = '0'");
		$res = $query->fetch();
		return $res[0];
	}

	public function countCertificati($idanagrafica) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_certificati WHERE anagrafica = '$idanagrafica'");
		$res = $query->fetch();
		return $res[0];
	}

	public function getVisita($id) {
		global $connessione;
		$query = $connessione->query("SELECT * FROM cert_accesso WHERE id = $id");
		$res = $query->fetch();
		return $res;
	}

	public function contaPrestazioni($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso WHERE cert_accesso.data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioni118($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso WHERE intervento = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniFarmaci($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso WHERE terapia != '' AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniDip($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniIT($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'it' AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniDipIT($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'it' AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniEE($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'ee' AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

	public function contaPrestazioniDipEE($inizio, $fine) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'ee' AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = $query->fetch();
		return $res[0];
	}

}

?>