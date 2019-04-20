<?php

Class File {

	private $href = "download.php?" ;
	
	//restituisce l'estensione del nome passato alla funzione	
	public function estensioneFile($nomefile) {
		$this->elementiurlpdf= explode( ".", $nomefile); 
		$this->numelementiurlpdf=count($this->elementiurlpdf);
		if ($this->numelementiurlpdf > 1)  {
			$this->estensione= $this->elementiurlpdf[$this->numelementiurlpdf-1];
		}
		else {
			$this->estensione='abu';
		}
		return $this->estensione;
	}

	public function downloadlink($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri) {
		if (!$nomefile) {
            $this->link = "Nessun file associato";
		} //nel caso di nessun file associato al protocollo
		else {
			//richiamo del metodo ricava estensione dal file di questa stessa classe
			$this->opzionidownloadlink= "anno=".$annoricercaprotocollo."&lud=".$nomefile."&idlettera=".$idlettera."&est=".$this->estensioneFile($nomefile);
              			
         	if (strlen($nomefile)<=$numerocaratteri) {
              	$this->testodownloadlink=stripslashes($nomefile); //passa come link visibile tutti i caratteri del link 
            }
            else {
              $this->testodownloadlink=stripslashes(substr($nomefile,0,$numerocaratteri).'.'.$this->estensioneFile($nomefile));
            }
              			
			$this->link = "<div style='padding: 3px;'>" . $this->testodownloadlink." <a class='btn btn-xs btn-primary' title='Download File' href=".$this->href.$this->opzionidownloadlink."> <i class='fa fa-download fa-fw'></i></a>
			<a class='btn btn-xs btn-success fancybox' title='Visualizza File' data-fancybox-type='iframe' href='lettere".$annoricercaprotocollo."/".$idlettera."/".$nomefile."'><i class='fa fa-file-text-o fa-fw'></i></a><br></div>";
		}
		return $this->link;
	}
	
	//cancella un allegato di un protocollo passato come argomento	
	public function cancellaAllegato($idlettera, $anno, $nome) {
		$deletepath = "lettere".$anno."/".$idlettera."/".$nome;
		$delete = unlink($deletepath);
		return $delete;
	}
	
	//restituisce la dimensione di una directory	
	public function sizeDirectory($DirectoryPath) {
		$Size = 0;
		$Dir = opendir($DirectoryPath);
		if (!$Dir) {
			return -1;
		}
		while (($File = readdir($Dir)) !== false) {
			if ($File[0] == '.') continue;
			if (is_dir($DirectoryPath . $File))           
				$Size += $this->sizeDirectory($DirectoryPath . $File . '/');
			else
				$Size += filesize($DirectoryPath . $File);       
		}
		closedir($Dir);
		return $Size;
	}
	
	//restituisce l'unità di grandezza più vicina al valore passato in MB	
	public function unitaMisura($dim) {
		if($dim >= 1000000)
			return round(($dim / 1000000),2) . ' TB';
		else if($dim >= 1000)
			return round(($dim / 1000),2) . ' GB';
		else 
			return round($dim,2) . ' MB';
	}

	//restituisce l'icona fontawesome relativa all'estensione del file passata come argomento
	public function getIcon($ext) {
		if($ext == 'pdf')
			return '<i class="fa fa-file-pdf-o fa-2x"></i>';
		else if($ext == 'doc' || $ext == 'docx')
			return '<i class="fa fa-file-word-o fa-2x"></i>';
		else if($ext == 'zip' || $ext == 'rar' || $ext == 'tar')
			return '<i class="fa fa-file-archive-o fa-2x"></i>';
		else if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'tiff' || $ext == 'gif')
			return '<i class="fa fa-file-image-o fa-2x"></i>';
		else if($ext == 'xls' || $ext == 'xlsx')
			return '<i class="fa fa-file-excel-o fa-2x"></i>';
		else
			return '<i class="fa fa-file-text-o fa-2x"></i>';
	}

}//fine classe

?>
