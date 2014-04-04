<?php

Class File
	{

public $href="download.php?";


	private function uploadfile ($nomefile, $tipofile) 
		{
		}

		
	private function estensionefile ($nomefile)
		{
			$this->elementiurlpdf= explode( ".", $nomefile); 
			$this->numelementiurlpdf=count($this->elementiurlpdf);
			if ($this->numelementiurlpdf > 1)  
				{
				$this->estensione= $this->elementiurlpdf[$this->numelementiurlpdf-1];
				}
			else 
				{
				$this->estensione='abu';
				}
			
		}

	function publestensionefile  ($nomefile) //<man> stampa l'estensione di un file passato come argomento</man>
		{
		$this->estensionefile  ($nomefile);
			
		}

	 private function downloadlink ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri)
		{
			if (!$nomefile)
              			{
             			$this->testodownloadlink="Nessun file associato";
             			$this->opzionidownloadlink="";
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
		}
		



	function publdownloadlink  ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri)  //<man>Stampa il link ad un certo 
												//file nel protocollo, passando come 
												//argomenti il nome del file, 
												//il suo id e l'anno di registrazione</man>
		{
		$this->downloadlink ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri);
			
		}

      
	}//fine classe
?>

