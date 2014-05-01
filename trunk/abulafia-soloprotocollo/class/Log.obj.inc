<?php 
class Log 
	{
	private $username='';
	private $operazione='';
	private $esito='';
	private $client='';
	private $accesslog='';
	private $numerorighe='';
	private $partenza='';
	private $accesslogines='';
	private $accessloginesnumber='';
	private $ciclo='';
	private $riga='';
	private $filtro='';

	private function scrivilog ($username, $operazione, $esito, $client, $logfile) 
		{
		
		if (!is_dir($_SESSION['logdirectory']))//se la directory non esiste, la crea
			{
			$creadir=mkdir($_SESSION['logdirectory'], 0777, true);
			if (!$creadir) die ("Impossibile creare la directory: log/");
			}
		
		if (file_exists($_SESSION['logdirectory'].$logfile)==false)//se il file non esiste, lo crea
			{
			$filehandle=fopen($_SESSION['logdirectory'].$logfile, 'w');
			fclose($filehandle);
			}	
		$accesslog=fopen($_SESSION['logdirectory'].$logfile,"a"); //apertura del file di log
		if (!$accesslog) die ("Impossibile scrivere nel file di log: $logfile ");
		$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
		$my_calendario->publggmmaaaa('-'); //acquisisco la data dall'oggetto Calendario
		$my_calendario->publhhmmss(':'); //acquisisco l'orario dall'oggetto Calendario
		$logline='Date/Hour: '.$my_calendario->ggmmaaaa.'/'.$my_calendario->hhmmss.' - Username: '.$username.' - Request: '.$operazione.' - Answer: '.$esito.' - Details: '.$client."\n"; //compongo la riga di log
		fwrite($accesslog, "$logline"); //scrivo il log
		fclose($accesslog); //chiudo il file
		}

		function publscrivilog ($username, $operazione, $esito, $client, $logfile)// <man>Scrive nel log $logfile le informazioni elencate; $client descrive le info dell'utente (ip, sistema operativo...)</man>
			{
			$this->scrivilog($username, $operazione, $esito, $client, $logfile);
			}


	private function leggilog ($partenza, $numerorighe, $filtro, $logfile)
		{
		$accessloglines= (file($_SESSION['logdirectory'].$logfile));
		$accessloglinesnumber= count($accessloglines);
		$ciclo=0;
		while (($ciclo < $numerorighe) and ( $accessloglinesnumber-($ciclo+$partenza) > 0)) 
			{
			$ciclo= $ciclo+1;
			$riga= $accessloglines[$accessloglinesnumber-($ciclo+$partenza)];
			if (strpos($riga, $filtro,0) > 0)
				{ 
				echo '<br>'. $ciclo.') '.$riga.'<br>';
				
				}
			else { $numerorighe = $numerorighe +1; }
			}
		}

		function publleggilog ($partenza, $numerorighe, $filtro, $logfile) //<man>Legge dal file $logfile dalla riga $partenza per un certo $numerorighe numero di righe, filtrando solo quelle dove compare $filtro</man>
			{
			$this->leggilog ($partenza, $numerorighe, $filtro, $logfile);
			}

	}
?>



