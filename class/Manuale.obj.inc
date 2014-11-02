<?php 
class Manuale 
	{



	public function publclassi() //<man>Effettua il parsing di tutti i file contenenti CLASSI e ne elenca i metodi racchiusi fra i tag man e /man all'interno dei commenti</man>
	{
	
	$dir = '.'; //assegnazione della directory in cui cercare. In questo caso, la directory corrente
	$list = scandir($dir); //scansione della directory corrente in un array
	$count= count($list); //conta gli elementi della lista
	$indice= 0; //setta l'indice di scorrimento dell'array a zero
	while ($indice < $count) //scorre l'array
		{
		if(stristr($list[$indice], '.obj.inc') == true) //filtra i risultati della lista
			{
			
			echo 'Classe ';?><b><?php echo $list[$indice].'<br>'; //elenca le classi trovate dopo il filtro
			?></b><?php
			echo 'Metodi:'.'<br>';
			$this->metodi($list[$indice]); //richiama il metodo per elencare i metodi di una classe
			}
		$indice= $indice+1;
		}

	}//fine metodo

	function metodi($classe) //<man>Effettua il parsing dei metodi della classe specificata come argomento</man>
	{

	$fileName = "$classe";
        $fileData = @file($classe);
        if ($fileData != false) 
		{
	        foreach($fileData as $line_num => $line) 
			{
		        if ((stristr($line, '<man>')==true) and (stristr($line, 'true')==false) )
				{
			        echo "Riga {$line_num} : <b>" . $line . "</b><br /><br />\n";
        			}
    			}    
		?><br><?php
		}  
	


	}//fine metodo


	} //fine classe
?>



