<?php 
class Calendario
	{ //apertura classe


public $dataitaliana;
public $ggmmaaaa;

	private function adesso () 
		{
		$this->anno= date("Y");
		$this->mese= date("m");
		$this->meseesteso= date("F");
		$this->giorno= date("d");
		$this->ora= date("H");
		$this->minuti= date("i");
		$this->secondi= date("s");
		}//fine metodo





	function publadesso () // <man>metodo per determinare il riferimento temporale attuale: vengono restituiti anno, mese, meseesteso, giorno, ore, minuti, e secondi </man>
		{
		if(function_exists('date_default_timezone_set') AND (!ini_get('date.timezone')))
			{
			
			date_default_timezone_set('Europe/Rome');
 
			}

		$this->adesso();
		}//fine metodo




	public function publdataitaliana ($datainglese,$separatore) { //<man>metodo per stampare all'italiana la data, mettendo nel giusto ordine giorno, mese, anno, e passando come parametri la data inglese e il separatore che si vuole adottare</man>
		$this->dataesplosa= explode('-',$datainglese);
		$this->datagiorno= $this->dataesplosa[2];
		$this->datamese= $this->dataesplosa[1];
		$this->dataanno=$this->dataesplosa[0];
		$this->dataitaliana =$this->datagiorno.$separatore.$this->datamese.$separatore.$this->dataanno;
		$datanull = '00'.$separatore.'00'.$separatore.'0000';
		if ($this->dataitaliana == $datanull) {
			return '';
		}
		else {
			return $this->dataitaliana;
		}
	}//fine metodo
		

	function publggmmaaaa ($separatore)//<man> Restituisce la data attuale nel formato numerico GG/MM/AAAA con $separatore come separatore</man>
		{
		$this->publadesso();
		$this->ggmmaaaa=$this->giorno.$separatore.$this->mese.$separatore.$this->anno;
		
		}//fine metodo

	function publhhmmss ($separatore)//<man> Restituisce l'orario attuale nel formato numerico hh/mm/ss con $separatore come separatore</man>
		{
		$this->publadesso();
		$this->hhmmss=$this->ora.$separatore.$this->minuti.$separatore.$this->secondi;
		
		}//fine metodo
		
	public function dataSlash($data) {
		$date = explode("-",$data);
		$dataslash = $date[2]."/".$date[1]."/".$date[0];
		return $dataslash;
	}
	
	public function dataDB($data) {
		$date = explode("/",$data);
		$datadb = $date[2]."-".$date[1]."-".$date[0];
		return $datadb;
	}


	}//chiusura classe
?>



