<?php
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPKeepAlive = "true";
	$mail->SMTPSecure = $_SESSION['protocolloemail'];
	$mail->Host = $_SESSION['smtp'];
	$mail->Port = $_SESSION['porta'];
	$mail->Username = $_SESSION['usernamemail'];
	$mail->Password = $_SESSION['passwordmail'];
	$mail->Debugoutput = 'html';
?>