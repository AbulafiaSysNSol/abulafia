<?php 

	$e = new Mail();
	$username=$_POST['username'];
	$password=base64_encode($_POST['password']);
	$smtp=$_POST['smtp'];
	$porta=$_POST['porta'];
	$protocollo=$_POST['protocollo'];
	$replyto=$_POST['replyto'];
	$headermail = $_POST['headermail'];
	$footermail = $_POST['footermail'];

	$res = $e->updateSetting($username, $password, $smtp, $porta, $protocollo, $replyto, $headermail, $footermail);
	
	if(!$res) {
		echo 'ERRORE NELLA MODIFICA';
	}
	else {
		$_SESSION['usernamemail'] = $username;
		$_SESSION['passwordmail'] = base64_decode($password);
		$_SESSION['smtp'] = $smtp;
		$_SESSION['porta'] = $porta;
		$_SESSION['protocolloemail'] = $protocollo;
		$_SESSION['replyto'] = $replyto;
		$_SESSION['headermail'] = $headermail; 
		$_SESSION['footermail'] = $footermail;
?>

<script language="javascript">
	window.location="login0.php?corpus=home&email=ok";
</script>

<?php
	}
?>