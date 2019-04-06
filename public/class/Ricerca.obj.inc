<?php 

class Ricerca {

	public $where ='';
	
	function publricercaespolosa ($q, $campo) { //<man>Esplode la stringa di ricerca nel db, separando tramite gli spazi e creando una variabile $where per la query'</man>
		if ($q != '') {
			if (substr_count($q, "*") > 0) {
				list($cognomecercato, $nomecercato) = explode("*", $q);
				$this->where = "where nome = '".$nomecercato."' AND anagrafica.cognome = '".$cognomecercato."'";
			}
			else {
				$qexpl = explode (" ",$q);
				$this->where = '';
				$this->where = "where ".$campo.'='.$campo;
				foreach ($qexpl as $chiave => $valore) {
					if ($valore!=' ') {
							$this->where = $this->where." and ".$campo." like '%".$valore."%'";
					}
				}
			}		
		}
	}
}

?>