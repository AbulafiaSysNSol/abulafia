<?php 

class Ambulatorio {

	public function insertAccess($idanagrafica, $idmedico, $data, $ora, $dipendente, $anamnesi, $diagnosi, $terapia, $note, $intervento) { 
			$query = mysql_query("INSERT INTO cert_accesso VALUES ('', '$idanagrafica', '$idmedico', '$data', '$ora', '$dipendente', '$anamnesi', '$diagnosi', '$terapia', '$note', '$intervento')");
			return $query;
	}

	public function getAccessi($idanagrafica) {
		$query = mysql_query("SELECT * FROM cert_accesso WHERE anagrafica = '$idanagrafica' ORDER BY data DESC");
		$accessi = array();
		while ($res = mysql_fetch_array($query)) {
			array_push($accessi,$res);
		}
		return $accessi;
	}

	public function getCertificati($idanagrafica) {
		$query = mysql_query("SELECT * FROM cert_certificati WHERE anagrafica = '$idanagrafica' ORDER BY numero DESC");
		$certificati = array();
		while ($res = mysql_fetch_array($query)) {
			array_push($certificati,$res);
		}
		return $certificati;
	}

	public function getRichieste() {
		$query = mysql_query("SELECT * FROM cert_richieste, cert_accesso WHERE cert_accesso.id = cert_richieste.visita AND stato = 0 ORDER BY cert_richieste.id ASC");
		$richieste = array();
		while ($res = mysql_fetch_array($query)) {
			array_push($richieste,$res);
		}
		return $richieste;
	}

	public function countAccessi($idanagrafica) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso WHERE anagrafica = '$idanagrafica'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function countRichieste() {
		$query = mysql_query("SELECT COUNT(*) FROM cert_richieste WHERE stato = '0'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function countCertificati($idanagrafica) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_certificati WHERE anagrafica = '$idanagrafica'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function getVisita($id) {
		$query = mysql_query("SELECT * FROM cert_accesso WHERE id = $id");
		$res = mysql_fetch_array($query);
		return $res;
	}

	public function contaPrestazioni($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso WHERE cert_accesso.data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioni118($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso WHERE intervento = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioniFarmaci($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso WHERE terapia != '' AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioniDip($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioniIT($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'it' AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioniDipIT($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'it' AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioniEE($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'ee' AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function contaPrestazioniDipEE($inizio, $fine) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso, cert_assistito WHERE cert_accesso.anagrafica = cert_assistito.id AND cert_assistito.cittadinanza = 'ee' AND cert_accesso.dipendente = 1 AND data BETWEEN '$inizio' AND '$fine'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

}

?>