<?php

Class Mail {

	public function isSetMail() {
		$query = mysql_query("SELECT COUNT(username) FROM mailsettings WHERE username != '' AND password != '' AND smtp != '' ");
		$res = mysql_fetch_row($query);
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

