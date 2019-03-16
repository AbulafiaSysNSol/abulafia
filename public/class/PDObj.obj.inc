<?php
    	class PDObj{
        const USERNAME="betalafiauser";
        const PASSWORD="betalafiapassword";
        const HOST="localhost";
        const DB="betalafia";

        public function avviaConnessione(){
            $username = self::USERNAME;
            $password = self::PASSWORD;
            $host = self::HOST;
            $db = self::DB;
            $connessione = new PDO("mysql:dbname=$db;host=$host", $username, $password);
            return $connessione;
        }
        protected function queryList($sql, $args){
            $connection = $this->getConnection();
            $stmt = $connessione->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        }
    }

?>
