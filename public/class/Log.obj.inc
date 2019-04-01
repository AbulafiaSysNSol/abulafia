<?php 

class Log {

	
	public function contaLog($logfile) {
		$num = count(file($_SESSION['logdirectory'].'/'.$logfile));
		return $num;
		}

	public function publscrivilog ($username, $operazione, $esito, $client, $logfile, $tag) // <man>Scrive nel log $logfile le informazioni elencate; $client descrive le info dell'utente (ip, sistema operativo...)</man>
		{
		if(!is_dir($_SESSION['logdirectory'])) //se la directory non esiste, la crea
			{ 
			
			$creadir=mkdir($_SESSION['logdirectory'], 0777, true);
			
			if (!$creadir) 
				{
				die ("Impossibile creare la directory: log/");
				}
			}
		
		if(file_exists($_SESSION['logdirectory'].$logfile)==false) //se il file non esiste, lo crea
			{ 
			$filehandle=fopen($_SESSION['logdirectory'].$logfile, 'w');
			fclose($filehandle);
			}

		$accesslog=fopen($_SESSION['logdirectory'].$logfile,"a"); //apertura del file di log
			
		if (!$accesslog) 
			{ 
			die ("Impossibile aprire il file di log: $logfile ");
			}

		$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
		$my_calendario->publggmmaaaa('/'); //acquisisco la data dall'oggetto Calendario
		$my_calendario->publhhmmss(':'); //acquisisco l'orario dall'oggetto Calendario
		$logline='['.$tag.'] Date: '.$my_calendario->ggmmaaaa.' - Hour: ' //compongo la riga di log
					.$my_calendario->hhmmss
					.' - Username: '.$username
					.' - Request: '.$operazione
					.' - Answer: '.$esito
					.' - Details: '.$client."\n";
		$this->write=fwrite($accesslog, "$logline"); //scrivo il log
		fclose($accesslog); //chiudo il file
		if (!$this->write) 
			{ 
			die ("Impossibile scrivere nel file di log: $logfile ");
			}
		}



	public function publleggilog ($partenza, $numerorighe, $filtro, $logfile) //<man>Legge dal file $logfile dalla riga $partenza per un certo $numerorighe numero di righe, filtrando solo quelle dove compare $filtro</man>
		{
		if (!is_dir($_SESSION['logdirectory'])) //se la directory non esiste, la crea
			{ 
				$creadir=mkdir($_SESSION['logdirectory'], 0777, true);	
				if (!$creadir) 
					{ 
						die ("Impossibile creare la directory: log/");
					}
			}
		
		if (file_exists($_SESSION['logdirectory'].$logfile)==false) //se il file non esiste, lo crea
			{ 
				$filehandle=fopen($_SESSION['logdirectory'].$logfile, 'w');
				fclose($filehandle);
			}
		
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
				else 
					{ 
						$numerorighe = $numerorighe +1; 
					}
				}
			}
		}

?>
