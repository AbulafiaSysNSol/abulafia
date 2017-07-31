<?php 

class Registroprotocollo { //apertura classe

	var $annodb; 
	
	public function getAnni() {
		$anni = array();
		$tablettere=mysql_query("show tables like 'lettere%'");
		while ($tablettere2 = mysql_fetch_array($tablettere, MYSQL_NUM)) {
			$anno = explode("lettere", $tablettere2[0]);
			array_push($anni, $anno[1]);
		}
		return $anni;
	}

	private function selezionaanno ($var, $verificaconnessione) { // modulo per la selezione dell'anno di uso del registro protocollo
		//$this->annodb = mysql_fetch_array($verificaconnessione->query("SELECT annoprotocollo 
		//								FROM defaultsettings"));
		$this->selezionaanno=$verificaconnessione->query("SELECT annoprotocollo FROM defaultsettings");		
		$this->annodb=$this->selezionaanno->fetch_array();
	
	
	}

	function publselezionaanno ($var, $verificaconnessione) { //<man>Legge dal DB l'anno corrente di uso del protocollo</man>
		$this->selezionaanno($var, $verificaconnessione);
	}

	private function controlloanno($verificaconnessione) { //controllo fra l'anno corrente e l'anno del sistema
		$this->selezionaanno('0', $verificaconnessione);
		$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
		$my_calendario-> publadesso();
		if ( $this->annodb['annoprotocollo'] !=  $my_calendario->anno ) {
			?>
				<script type="text/javascript">
					function show_confirm() {
						var r=confirm("Attenzione: il registro di protocollo riporta un anno diverso da quello corrente. Vuoi avviare la procedura di riallineamento? (Scelta consigliata: OK)");
						if (r==true) {
							window.location = "login0.php?corpus=cambioanno"
						}
						else {
							alert("Contatta gli amministratori di sistema per assistenza nel passaggio d'anno.");
							window.location = "index.php"
						}
					}
					show_confirm();
				</script>
				
			<?php
		}
	}

	function publcontrolloanno($verificaconnessione) { //<man>Controlla la corrispondenza tra l'anno del protocollo e l'anno solare corrente</man>
		$this->controlloanno ($verificaconnessione);
	}

}//chiusura classe

?>



