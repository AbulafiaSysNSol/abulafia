<?php 
class Anagrafica
	{

var $contacomponenti;


	private function scegliregione ($ambito) // modulo per la scelta delle regione
		{
		?>
		<label>  Regione (<?php echo $ambito;?>):<br>
		<SELECT size=1 cols=4 NAME="regione<?php echo $ambito;?>"><br>
		<OPTION selected value="">Scegli...
		<?php $regioni= mysql_query("select distinct * from comuni group by comuni.regione");
		while ($regione = mysql_fetch_array($regioni)) 
			{ 
				?><OPTION value=" <?php echo $regione['regione'];?> "> <?php echo $regione['regione'];
			}?>
		</select>
		<?php
		}





	function publscegliregione ($ambito)
		{
		$this->scegliregione($ambito);
		}




	private function scegliprovincia ($ambito)
		{
		?>
		<label>  Provincia (<?php echo $ambito;?>):<br>
		<SELECT size=1 cols=4 NAME="provincia<?php echo $ambito;?>"><br>
		<OPTION selected value="">Scegli...
		<?php $province= mysql_query("select distinct * from comuni where regione='' order by comuni.province");
		while ($provincia = mysql_fetch_array($province)) 
			{ 
				?><OPTION value=" <?php echo $regione['regione'];?> "> <?php echo $regione['regione'];
			}?>
		</select>
		<?php
		}

	function publscegliprovincia ($ambito)
		{
		$this->scegliprovincia($ambito);
		}

	function publcontaanagrafica ($tipologia) //<man> Restituisce il numero di anagrafiche presenti nel database, passando come argomento la tipologia (es. persona, carica etc...)</man>
		{
		$contacomponenti2= mysql_query("select count(*) from anagrafica where tipologia='$tipologia'"); //query per contare le anagrafiche per tipologia
		$contacomponenti1= mysql_fetch_row($contacomponenti2);
		$this->contacomponenti= $contacomponenti1[0];
		}


		function publcognomidiffusi () //<man> Restituisce un array di cognomi in ordine di diffusione</man>
		{
		$this->contacognomi2= mysql_query("
				select cognome,
				count(*) as conteggio
				from anagrafica 
				where tipologia='persona' 
				group by cognome
				order by conteggio desc"); //query per contare i cognomi per diffusione
		}

		function publnomidiffusi () //<man> Restituisce un array di nomi in ordine di diffusione</man>
		{
		$this->contanomi2= mysql_query("
				select nome,
				count(*) as conteggio
				from anagrafica 
				where tipologia='persona' 
				group by nome
				order by conteggio desc"); //query per contare i cognomi per diffusione
		}



	}
?>



