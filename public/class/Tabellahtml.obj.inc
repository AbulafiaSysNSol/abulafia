<?php
Class Tabellahtml



	{

public $border;
public $cellpadding;
public $cellspacing;
public $width;
public $intestazione=array();
public $cellaint;
public $rows=array();
public $contarighetabella;
public $cellarows=array();
public $cellarows2;
public $keycellarows2;
public $ultimariga=array();
public $cellaultimariga;


	function publapritabella () //<man> apre una tabella html</man>
		{
		?>
		<table 
		border="<?php echo $this->border; ?>" 
		cellpadding="<?php echo $this->cellpadding; ?>" 
		cellspacing="<?php echo $this->cellspacing; ?>" 
		width="<?php echo $this->width; ?>"


		<?php
		}
		
	function publintestazionetabella () //<man> passa la prima riga della tabella </man>
		{
		?>
		<tr>
		<?
		foreach ($this->intestazione as $this->cellaint)
			{
			echo $this->cellaint;
			}
		?>
		</tr>
		<?
		}
	
	
	function publrighetabella () //<man> passa le righe della tabella </man>
		{
		
		foreach ($this->rows as $this->cellarows )
			{
			?>
			<tr>
			<?
			
			foreach ($this->cellarows as $this->keycellarows2=>$this->cellarows2)
				{
				echo $this->cellarows2;
				} //fine secondo foreach
			?>
			</tr>
			<?	
			}//fine primo foreach
			

	
		
		}//fine metodo
		
		
				
	function publultimarigatabella () //<man> passa l'ultima riga della tabella </man>
		{
		?>
		<tr>
		<?
		foreach ($this->ultimariga as $this->cellaultimariga)
			{
			echo $this->cellaultimariga;
			}
		?>
		</tr>
		<?
		}//fine metodo
		
		
	function publchiuditabella () //<man> chiude una tabella html aperta</man>
		{
		?>
		</table>
		<?php
		}
		
		

    
    
    
		
	
	}//fine classe
?>
