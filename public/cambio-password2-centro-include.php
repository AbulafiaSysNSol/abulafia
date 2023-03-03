<?php

	$loginid = $_SESSION['loginid'];
	$vecchiapassword = $_POST['vecchiapassword'];
	$nuovapassword1 = $_POST['nuovapassword1'];
	$nuovapassword2 = $_POST['nuovapassword2'];
	$errorecambiopassword = 0;
	$controllodb = $connessione->query("SELECT DISTINCT * FROM users WHERE idanagrafica = '$loginid'");
	$controllodb2 = $controllodb->fetch();
	$nuovapassword3 = MD5($nuovapassword1);
	
	if ($nuovapassword1 != $nuovapassword2) { 
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=cambio-password&pass=nomatch";
		</script>
		<?php 
		$errorecambiopassword= 1;
	}	

	if (($nuovapassword1 == '') or ($nuovapassword2 == '') or ($vecchiapassword == '')) { 
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=cambio-password&pass=empty";
		</script>
		<?php 
		$errorecambiopassword= 1;
	}

	if (strlen($nuovapassword1) < 6) { 
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=cambio-password&pass=leng";
		</script>
		<?php 
		$errorecambiopassword = 1;
	}

	if (md5($vecchiapassword) === $controllodb2['password']) {

	}
	else {
		?>
		<script language = "javascript">
			window.location = "login0.php?corpus=cambio-password&pass=old";
		</script>
		<?php 
		$errorecambiopassword = 1;
	} 

	if ($errorecambiopassword == 0) { 

		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE users SET users.password = :nuovapassword3 WHERE users.idanagrafica = :loginid LIMIT 1"); 
			$query->bindParam(':nuovapassword3', $nuovapassword3);
			$query->bindParam(':loginid', $loginid);
			$query->execute();
			$connessione->commit();
			$inserimento = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$inserimento = false;
		}	
		?>
		<script language = "javascript">
			window.location = "login0.php?corpus=cambio-password&pass=ok";
		</script>
		<?php 
	}

?>