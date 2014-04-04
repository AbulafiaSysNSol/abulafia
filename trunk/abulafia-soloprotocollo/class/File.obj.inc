<?php
include 'maledetti-apici-centro-include.php';

Class File
	{

private $href="download.php";


	private function uploadfile ($nomefile, $tipofile) 
		{
		}

		
	private function estensionefile ($nomefile)
		{
			$elementiurlpdf= explode( ".", $nomefile); 
			$numelementiurlpdf=count($elementiurlpdf);
			if ($numelementiurlpdf > 1)  
				{
				$estensione= $elementiurlpdf[$numelementiurlpdf-1];
				}
			else 
				{
				$estensione='abu';
				}
			echo $estensione;
			
		}

	function publestensionefile  ($nomefile) //<man> stampa l'estensione di un file passato come argomento</man>
		{
		$this->estensionefile  ($nomefile);
			
		}

		private function downloadlink ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri, $target)
		{
			if (!$nomefile)
              {
             $this->testodownloadlink="Nessun file associato";
              } //nel caso di nessun file associato al protocollo
			else 	
             {
              $this->opzionidownloadlink="annoricercaprotocollo=".$annoricercaprotocollo
                                        ."&lud=".$nomefile
                                        ."&idlettera=".$idlettera
                                        ."&est=".$this->estensionefile ($nomefile);//richiamo del metodo "ricava estensione dal file"
                                                                                         di questa stessa classe
                                                   
              $this->testodownloadlink=stripslashes(substr($nomefile,0,$numerocaratteri).'...'); //passa come link visibile solo un certo
                                                                                                  //numero di caratteri pasato come parametro
             }
		}
		



	function publdownloadlink  ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri, $target)  //<man>Stampa il link ad un certo file nel protocollo, passando come argomenti il nome del file, il suo id e l'anno di registrazione</man>
		{
		$this->downloadlink ($nomefile, $idlettera, $annoricercaprotocollo, $numerocaratteri, $target);
			
		}

      
	}//fine classe
?>
