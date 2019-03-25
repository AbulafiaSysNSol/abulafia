<?php

	$calendario = new Calendario();

	$idlettera = $_GET['id'];
	$anno = $_GET['anno'];
	$email = $_POST['email'];
	$data = $_POST['data'];
	$datains = $calendario->dataDB($data);
	$userid = $_SESSION['loginid'];
/*deprecato	$insert = mysq>l_query("INSERT INTO mailsend VALUES ( '', '$userid', '$email', '$datains', '$idlettera', '$anno')");*/

	try 
		{
   		$connessione->beginTransaction();
		$query = $connessione->prepare("INSERT INTO mailsend
						VALUES( '', 
						:userid, 
						:email, 
						:datains, 
						:idlettera, 
						:anno)"); 
		$query->bindParam(':userid', $userid);
		$query->bindParam(':email', $email);
		$query->bindParam(':datains', $datains);
		$query->bindParam(':idlettera', $idlettera);
		$query->bindParam(':anno', $anno);
		$query->execute();
		$connessione->commit();
		} 
		
		//gestione dell'eventuale errore della connessione
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
		$connessione->rollback();
		exit();
		}
	

		?>
		<SCRIPT LANGUAGE="Javascript">
		window.location="login0.php?corpus=dettagli-protocollo
				&id=<?php echo $idlettera;?>
				&anno=<?php echo $anno;?>
				&inoltro=ok"; 
		</SCRIPT>
