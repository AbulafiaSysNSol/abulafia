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

		public function downloadlink ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri)
		{
			if (!$nomefile) {
             			$this->link = "Nessun file associato";
			} //nel caso di nessun file associato al protocollo
			else {
			
             			$this->opzionidownloadlink= "annoricercaprotocollo=".$annoricercaprotocollo 
								      ."&lud=".$nomefile
								      ."&idlettera=".$idlettera
								      ."&est=".$this->estensioneFile($nomefile);//richiamo del metodo ricava estensione dal file di questa stessa classe
								      
              			$this->testodownloadlink=stripslashes(substr($nomefile,0,$numerocaratteri)); //passa come link visibile solo un certo numero di caratteri pasato come parametro

<<<<<<< .mine
				 $this->link = "<a target=_new href=" . str_replace(' ', '%20', $this->href . $this->opzionidownloadlink) . ">" . $this->testodownloadlink . "</a>";
				 }
				 
			return $this->link;
=======
	 private function downloadlink ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri)
		{
			if (!$nomefile)
              			{
             			$this->testodownloadlink="Nessun file associato";
             			$this->opzionidownloadlink="";
             			$this->href="#";
              			} //nel caso di nessun file associato al protocollo
			else 	
             			{
             			$this->publestensionefile($nomefile);
             			$this->opzionidownloadlink="annoricercaprotocollo=".$annoricercaprotocollo
                                       	 ."&lud=".$nomefile
                                       	 ."&idlettera=".$idlettera
                                       	 ."&est=".$this->estensione;//richiamo del metodo "ricava estensione dal file"
                                                                                         //di questa stessa classe
                                                   
              			$this->testodownloadlink=stripslashes(substr($nomefile,0,$numerocaratteri).'...'.$this->estensione); //passa come link visibile solo 
              												//un certo numero di caratteri 
              												//pasato come parametro
            			 }
>>>>>>> .r203
		}

	}//fine classe
?>

