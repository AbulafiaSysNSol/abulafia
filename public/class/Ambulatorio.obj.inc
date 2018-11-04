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

	public function countAccessi($idanagrafica) {
		$query = mysql_query("SELECT COUNT(*) FROM cert_accesso WHERE anagrafica = '$idanagrafica'");
		$res = mysql_fetch_row($query);
		return $res[0];
	}

	public function getVisita($id) {
		$query = mysql_query("SELECT * FROM cert_accesso WHERE id = $id");
		$res = mysql_fetch_array($query);
		return $res;
	}

}

?>