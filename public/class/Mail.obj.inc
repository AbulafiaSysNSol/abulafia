<?php

require_once('../db-connessione-include.php');

Class Mail {

	public function getMail() {
		global $connessione;
		$query = $connessione->query("SELECT * FROM mailsettings");
		$res = $query->fetch();
		return $res;
	}

	public function isSetMail() {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(username) FROM mailsettings WHERE username != '' AND password != '' AND smtp != '' ");
		$res = $query->fetch();
		if ($res[0] > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function updateSetting( $username, $password, $smtp, $porta, $protocollo, $replyto, $headermail, $footermail) {
		global $connessione;
		try {
   				$connessione->beginTransaction();
				$query = $connessione->prepare(" UPDATE mailsettings SET username = :username, password = :password, smtp = :smtp, porta = :porta, protocollo = :protocollo, replyto = :replyto, headermail = :headermail, footermail = :footermail "); 
				$query->bindParam(':username', $username);
				$query->bindParam(':password', $password);
				$query->bindParam(':smtp', $smtp);
				$query->bindParam(':porta', $porta);
				$query->bindParam(':protocollo', $protocollo);
				$query->bindParam(':replyto', $replyto);
				$query->bindParam(':diagnosi', $diagnosi);
				$query->bindParam(':headermail', $headermail);
				$query->bindParam(':footermail', $footermail);
				$query->execute();
				$connessione->commit();
				$result = true;
			}	 
			catch (PDOException $errorePDO) { 
    			echo "Errore: " . $errorePDO->getMessage();
    			$result = false;
			}
		return $result;
	}

}

?>

