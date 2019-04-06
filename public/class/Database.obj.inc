<?php

require_once('../db-connessione-include.php');

class Database {

	public $verificaserver;
	public $verificadatabase;
    public $resultarray=array();
	
	private function cercaserver() {
		global $connessione;
		if (!$connessione) { //messaggio di errore in caso di fallita connessione al db-server
			echo 'Tentativo di connessione al server fallito<br><br>';
			?> 
			<a href="index.php"><?php echo 'Ritenta. Se l\'errore dovesse persistere, contatta un amministratore'; $_SESSION['logintruefalse']= 'false'; ?></a>
			<?php 
			$_SESSION['logintruefalse']= 'false';
			exit() ; 
		}
	} //fine metodo
			
	private function cercadatabase() {
		global $connessione;
		if (!$connessione) {
			echo 'Database non individuato sul server<br><br>Controllare di aver effettuato il login ad un database di cui si possiedono i privilegi di accesso';
			exit();
		}
	}//fine metodo
			
	public function connessione() {
		$this->cercaserver();
		$this->cercadatabase();
	}//fine metodo	
		
	public function disconnessione() {
		global $connessione;
		$connessione = null;
	}

    public function arrayfromquery($ricerca) {
    	global $connessione;
        $this->resultarray = array();
        while ($this->righe = $ricerca->fetch()) {
	        array_push($this->resultarray, $this->righe);
        }
    }
                
    public function controllaEsistenza($valore, $tabella, $colonna) {//<man> controlla se un valore è già presente in una colonna di una tabella del db</man>
    	global $connessione;
		$this->ricerca = $connessione->query("SELECT DISTINCT * FROM $tabella WHERE $colonna = '$valore'");
		$this->arrayfromquery($this->ricerca);
		if (count($this->resultarray) > 0) { 
			$this->occorrenza= True ; 
		}
		else { 
			$this->occorrenza = False ;
		}
		return $this->occorrenza ;
    }

}//fine classe

?>