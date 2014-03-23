<?php
include 'maledetti-apici-centro-include.php';

Class File
	{



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

		
		

  
	private function downloadlink ($nomefile, $idlettera, $annoricercaprotocollo)
		{
			if (!$nomefile) 
				{ 
			echo "<br>Nessun file associato";
				} //nel caso di nessun file associato al protocollo
			else 	{
		?><br><b>File associato:</b><a target ="_new" href="download.php?annoricercaprotocollo=<?php echo $annoricercaprotocollo; ?>
	&lud=<?php echo $nomefile; ?>
	&idlettera=<?php echo $idlettera; ?>
	&est=<?php echo $this->estensionefile ($nomefile);?> "> <!-- richiamo del metodo "ricava estensione dal file" di questo stesso oggetto-->
	 <?php echo substr($nomefile,0,36).'...';?> <!-- pubblica il nome abbreviato del file -->
		</a>
		<?
				}
		}
      
    private function downloadlink2 ($nomefile, $idlettera, $annoricercaprotocollo)
		{
			if (!$nomefile) 
				{ 
			echo "Nessun file associato";
				} //nel caso di nessun file associato al protocollo
			else 	{
		?><a target ="_new" href="download.php?annoricercaprotocollo=<?php echo $annoricercaprotocollo; ?>
	&lud=<?php echo $nomefile; ?>
	&idlettera=<?php echo $idlettera; ?>
	&est=<?php echo $this->estensionefile ($nomefile);?> "> <!-- richiamo del metodo "ricava estensione dal file" di questo stesso oggetto-->
	 <?php echo stripslashes($nomefile);?> <!-- pubblica il nomecompleto del file -->
		</a>
		<?
				}
		}  

	function publdownloadlink  ($nomefile, $idlettera, $annoricercaprotocollo)  //<man>Stampa il link ad un certo file nel protocollo, passando come argomenti il nome del file, il suo id e l'anno di registrazione</man>
		{
		$this->downloadlink ($nomefile, $idlettera, $annoricercaprotocollo);
			
		}

function publdownloadlink2  ($nomefile, $idlettera, $annoricercaprotocollo)  //<man>Stampa il link ad un certo file nel protocollo, passando come argomenti il nome del file, il suo id e l'anno di registrazione</man>
		{
		$this->downloadlink2 ($nomefile, $idlettera, $annoricercaprotocollo);
			
		}
      
	}//fine classe
?>
