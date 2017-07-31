<?php

Class Mail {

	public function getMail() {
		$query = mysql_query("SELECT * FROM mailsettings");
		$res = mysql_fetch_row($query);
		return $res;
	}

	public function isSetMail($verificaconnessione) {
		$query = $verificaconnessione->query("SELECT COUNT(username) 
							FROM mailsettings 
							WHERE username != '' 
							AND password != '' 
							AND smtp != '' ");
		$res = $query->fetch_row();
		if ($res[0] > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function updateSetting( $username, $password, $smtp, $porta, $protocollo) {
		$query = mysql_query("UPDATE mailsettings SET username = '$username', password = '$password', smtp = '$smtp', porta = '$porta', protocollo = '$protocollo'");
		return $query;
	}

}

?>

