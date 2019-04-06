<?php 
	$id=$_GET['id'];
	$nuovapassword1=$_POST['nuovapassword1'];
	$nuovapassword2=$_POST['nuovapassword2'];
	$nuovapassword3 =MD5($nuovapassword1);
	$authlevel=$_POST['authlevel1'];
	$nomeutente=$_POST['nomeutente'];
	$email=$_POST['email'];
	
	if(isset($_POST['admin'])) {
		$admin = $_POST['admin'];
	}
	else {
		$admin = 0;
	}

	if(isset($_POST['anagrafica'])) {
		$anagrafica = $_POST['anagrafica'];
	}
	else {
		$anagrafica = 0;
	}

	if(isset($_POST['protocollo'])) {
		$protocollo = $_POST['protocollo'];
	}
	else {
		$protocollo = 0;
	}

	if(isset($_POST['documenti'])) {
		$documenti = $_POST['documenti'];
	}
	else {
		$documenti = 0;
	}

	if(isset($_POST['lettere'])) {
		$lettere = $_POST['lettere'];
	}
	else {
		$lettere = 0;
	}

	if(isset($_POST['magazzino'])) {
		$magazzino = $_POST['magazzino'];
	}
	else {
		$magazzino = 0;
	}

	if(isset($_POST['ambulatorio'])) {
		$ambulatorio = $_POST['ambulatorio'];
	}
	else {
		$ambulatorio = 0;
	}

	if(isset($_POST['contabilita'])) {
		$contabilita = $_POST['contabilita'];
	}
	else {
		$contabilita = 0;
	}

	if(isset($_POST['checkprofile'])) {
		$check = $_POST['checkprofile'];
	}
	else {
		$check = 0;
	}

	if ($nuovapassword1 != $nuovapassword2) { 
		echo 'Errore: le due password nuove non coincidono'; 
		$errorecambiopassword = 1; 
	}	

	if (($nuovapassword1 != '') and ($nuovapassword2 != '')) { 
		try {
		   	$connessione->beginTransaction();
			$query = $connessione->prepare("UPDATE users SET users.password = :nuovapassword3 WHERE users.idanagrafica = :id LIMIT 1"); 
			$query->bindParam(':nuovapassword3', $nuovapassword3);
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$cambiopassword = true;
		}	 
		catch (PDOException $errorePDO) { 
		   	echo "Errore: " . $errorePDO->getMessage();
		   	$connessione->rollBack();
		 	$cambiopassword = false;
		}	
	}

	try {
	   	$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE users SET users.loginname = :nomeutente, users.mainemail = :email, users.auth = :authlevel, users.admin = :admin, users.anagrafica = :anagrafica, users.protocollo = :protocollo, users.documenti = :documenti, users.lettere = :lettere, users.magazzino = :magazzino, users.ambulatorio = :ambulatorio, users.contabilita = :contabilita, users.updateprofile = :check WHERE users.idanagrafica = :id LIMIT 1"); 
		$query->bindParam(':nomeutente', $nomeutente);
		$query->bindParam(':email', $email);
		$query->bindParam(':authlevel', $authlevel);
		$query->bindParam(':admin', $admin);
		$query->bindParam(':anagrafica', $anagrafica);
		$query->bindParam(':protocollo', $protocollo);
		$query->bindParam(':documenti', $documenti);
		$query->bindParam(':lettere', $lettere);
		$query->bindParam(':magazzino', $magazzino);
		$query->bindParam(':ambulatorio', $ambulatorio);
		$query->bindParam(':contabilita', $contabilita);
		$query->bindParam(':check', $check);
		$query->bindParam(':id', $id);
		$query->execute();
		$connessione->commit();
		$update = true;
	}	 
	catch (PDOException $errorePDO) { 
	   	echo "Errore: " . $errorePDO->getMessage();
	   	$connessione->rollBack();
	 	$update = false;
	}
	if($update) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=gestione-utenti&mod=ok";
		</script>
		<?php
	}
?>