<?php
class PDObj
	{
        
        public function avviaConnessione($dbname, $host, $dbusername, $dbpassword)
		{
	            $connessione = new PDO("mysql:dbname=$this->dbname;
						host=$this->host", 
						$this->dbusername, 
						$this->dbpassword);
	            return $connessione;
	        }

        protected function queryList($sql, $args)
		{
	            $connection = $this->getConnection();
	            $stmt = $connessione->prepare($sql);
	            $stmt->execute($args);
	            return $stmt;
	        }
    	}

?>
