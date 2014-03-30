<?php
class Database
	{
	public $verificaserver;
	public $verificadatabase;
        public $resultarray=array();
	
	private function cercaserver ()
		{
		 $this->verificaserver = mysql_connect( $this->host , $this->usernamedb , $this->passworddb ); //connessione al db-server
		if (!$this->verificaserver) 
			{ //messaggio di errore in caso di fallita connessione al db-server
			echo 'Tentativo di connessione al server fallito<br><br>';
			?> 
			<a href="index.php"><?php echo 'Ritenta. Se l\'errore dovesse persistere,
						 contatta un amministratore'; $_SESSION['logintruefalse']= 'false' ;  ?></a>
			<?php 
			$_SESSION['logintruefalse']= 'false' ;
			exit() ; 
			}
		} //fine metodo
		
		
	private function cercadatabase()
	
		{
		
		$this->verificadatabase = mysql_select_db($this->databasename, $this->verificaserver);//selezione del db
		if (!$this->verificadatabase) 
			{
			echo 'Database non individuato sul server<br><br>Controllare di aver effettuato il login
			 ad un database di cui si possiedono i privilegi di accesso';
			exit();
			}
		}//fine metodo
		
		
		
	public function connessione()
	
		{
		$this->cercaserver();
		$this->cercadatabase();
		}//fine metodo
		
		
	public function disconnessione()
	
		{
		mysql_close ($this->verificaserver);
		}

        public function arrayfromquery($ricerca)

                {
                $this->resultarray=array();
                while ($this->righe=mysql_fetch_row($ricerca))
                        {
                        array_push($this->resultarray, $this->righe);
                        }
                }

	
	
	
	
	}//fine classe


?>
