<?php 
class Carica-incarico extends Anagrafica
	{



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






