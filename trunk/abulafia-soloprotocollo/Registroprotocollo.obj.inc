<?php 
class Registroprotocollo
	{ //apertura classe

var $annodb; 


	private function selezionaanno ($var) // modulo per la selezione dell'anno di uso del registro protocollo
		{
		$this->annodb = mysql_fetch_array (mysql_query("select annoprotocollo FROM defaultsettings where idanagrafica='1'" ));
		}





	function publselezionaanno ($var) //<man>Legge dal DB l'anno corrente di uso del protocollo</man>
		{
		$this->selezionaanno($var);
		}


	private function controlloanno() //controllo fra l'anno corrente e l'anno del sistema
		{
		$this->selezionaanno('0');
		$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
		$my_calendario-> publadesso();
		if ( $this->annodb['annoprotocollo'] !=  $my_calendario->anno ) 
			{ ?>
				<script type="text/javascript">
				function show_confirm()
				{
				var r=confirm("Attenzione: il registro di protocollo riporta un anno diverso da quello corrente. Vuoi avviare la procedura di riallineamento? (Scelta consigliata: OK)");
				if (r==true)
 					{
					window.location = "login0.php?corpus=cambioanno"
					
  					}
				else
 					{
 					 alert("Contatta gli amministratori di sistema per assistenza nel passaggio d'anno.");
						window.location = "index.html"

  					}
				}
				show_confirm();
				</script>


				
			<?php
			}
		
		 }


	function publcontrolloanno () //<man>Controlla la corrispondenza tra l'anno del protocollo e l'anno solare corrente</man>
		{
		$this->controlloanno ();
		}





	}//chiusura classe
?>



