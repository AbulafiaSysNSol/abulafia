<?php
class PDObj
	{
        
        public function avviaConnessione($dbname, $dbhost, $dbusername, $dbpassword)
		{
	            $connessione = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
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
