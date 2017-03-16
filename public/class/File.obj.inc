<?php

Class File
	{

		private $href = "download.php?" ;
		
		public function estensioneFile($nomefile)
		{
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

		public function downloadlink($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri)
		{
			if (!$nomefile) {
             			$this->link = "Nessun file associato";
			} //nel caso di nessun file associato al protocollo
			else {
			
             			$this->opzionidownloadlink= "anno=".$annoricercaprotocollo 
								      ."&lud=" . $nomefile
								      ."&idlettera=".$idlettera
								      ."&est=".$this->estensioneFile($nomefile);//richiamo del metodo ricava estensione dal file di questa stessa classe
								      
              			
              			if (strlen($nomefile)<=$numerocaratteri)
              				{
              				$this->testodownloadlink=stripslashes($nomefile); //passa come link visibile 
              										//tutti i caratteri del link
              				}
              			
              			else	
              				{
              				$this->testodownloadlink=stripslashes(substr($nomefile,0,$numerocaratteri)
              							.'[...].'
              							.$this->estensioneFile($nomefile)); //passa come link visibile solo un certo 
              											//numero di caratteri pasato come parametro
              				}
              			

				 $this->link = "<a target=new href=" . str_replace(' ', '%20', $this->href . $this->opzionidownloadlink) . ">" . $this->testodownloadlink . " <i class=\"fa fa-download\"></i></a>";
				 }
				 
			return $this->link;
		}
		
		public function cancellaAllegato($idlettera, $anno, $nome) {
			$deletepath = "lettere".$anno."/".$idlettera."/".$nome;
			$delete = unlink($deletepath);
			return $delete;
		}
		
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
		
		public function unitaMisura($dim) {
			if($dim >= 1000000)
				return round(($dim / 1000000),2) . ' TB';
			else if($dim >= 1000)
				return round(($dim / 1000),2) . ' GB';
			else 
				return round($dim,2) . ' MB';
		}

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

