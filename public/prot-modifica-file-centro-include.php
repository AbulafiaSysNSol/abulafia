<?php

	set_time_limit(0);
	
	$annoprotocollo = $_SESSION['annoprotocollo'];
	
	if(isset($_GET['idlettera'])) {
		$idlettera = $_GET['idlettera'];
		if (!is_dir("lettere$annoprotocollo/".$idlettera)) { //se non esiste una directory con il l'id della lettera, la crea per ospitare gli allegati
			mkdir("lettere$annoprotocollo/".$idlettera, 0777, true);
		}
	}
	
	if(isset($_GET['from'])) {
		$from = $_GET['from'];
	}
	else {
		$from = '';
	}

	include 'maledetti-apici-centro-include.php';
	$my_file= new File;
	$my_lettera=unserialize($_SESSION['my_lettera']);
	
	if (!is_dir("lettere$annoprotocollo/"."/temp/")) {//controlla se la directory TEMP esiste dentro la dir LETTERE, altrimenti la crea
		mkdir("lettere$annoprotocollo/"."/temp/", 0777, true);
	}
	
	$tot = count($_FILES['uploadedfile']['name']);

	$file = 0;
	$count = 0;

	foreach ($_FILES['uploadedfile']['name'] as $filename) {

		$target_path = "lettere$annoprotocollo/";
		$time = time();
		$name = $time.$count.".".$my_file->estensioneFile(basename($filename));
		if($from == 'modifica-protocollo') {
			$target_path = $target_path . $idlettera . '/' .$name;
		}
		else {
			$target_path = $target_path ."temp/".$name;
		}        

		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$count], $target_path)) { //se lo spostamento del file va a buon fine
			//verificare funzionamento $target_path2 = mysq<_real_escape_string($target_path);
			if($from == 'modifica-protocollo') {
				$file++;

				try {
				   	$connessione->beginTransaction();
					$query = $connessione->prepare("INSERT INTO joinlettereallegati VALUES(:idlettera, :annoprotocollo, :name)"); 
					$query->bindParam(':idlettera', $idlettera);
					$query->bindParam(':annoprotocollo', $annoprotocollo);
					$query->bindParam(':name', $name);
					$query->execute();
					$connessione->commit();
					$inserisci = true;
				}	 
				catch (PDOException $errorePDO) { 
				   	echo "Errore: " . $errorePDO->getMessage();
				   	$connessione->rollBack();
				   	$inserisci = false;
				}
				$user = $_SESSION['loginid'];
				$time = time();
				try {
				   	$connessione->beginTransaction();
					$query = $connessione->prepare("INSERT INTO storico_modifiche VALUES(null, :idlettera, :annoprotocollo, 'Aggiunto allegato', :user, $time, '#DEFEB4', ' ', :name)"); 
					$query->bindParam(':idlettera', $idlettera);
					$query->bindParam(':annoprotocollo', $annoprotocollo);
					$query->bindParam(':user', $user);
					$query->bindParam(':name', $name);
					$query->execute();
					$connessione->commit();
					$regmodifica = true;
				}	 
				catch (PDOException $errorePDO) { 
				   	echo "Errore: " . $errorePDO->getMessage();
				   	$connessione->rollBack();
				   	$regmodifica = false;
				}
				$my_log -> publscrivilog( $_SESSION['loginname'], 
											'MODIFICA PROTOCOLLO '. $idlettera , 
											'OK' , 
											'AGGIUNTO ALLEGATO '. $name , 
											$_SESSION['logfile'], 
											'protocollo');
			}
			else {
				$file++;
				$my_lettera->arrayallegati[$name] = $target_path;
				$_SESSION['my_lettera']=serialize($my_lettera);
				$my_log -> publscrivilog( $_SESSION['loginname'], 
										'AGGIUNTO ALLEGATO PROTOCOLLO '.$my_lettera->idtemporaneo , 
										'OK' , 
										'ALLEGATO '.$name ,
										$_SESSION['logfile'], 
										'protocollo');
			}
		} 
		else { //se lo spostamento non va a buon fine
			if($from == 'modifica-protocollo') {
				$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI MODIFICA ALLEGATO PROTOCOLLO '. $idlettera , 'FAILED' , 'AGGIUNTA ALLEGATO '. $name , $_SESSION['logfile'], 'protocollo');
			}
			else {
				$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI AGGIUNTA ALLEGATO PROTOCOLLO '. $my_lettera->idtemporaneo , 'FAILED' , 'AGGIUNTA ALLEGATO '. $name , $_SESSION['logfile'], 'protocollo');
				$_SESSION['my_lettera']=serialize($my_lettera);
			}
		}
		$count++;
	}

	if(($from == 'modifica-protocollo') and ($file == $tot)) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=modifica-protocollo&anno=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success"; 
		</script>
		<?php
	}

	if(($from == 'modifica-protocollo') and ($file != $tot)) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=protocollo2&anno=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error";
		</script>
		<?php
	}

	if(($from != 'modifica-protocollo') and ($file == $tot)) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=protocollo2&from=urlpdf&upfile=success";
		</script>
		<?php
	}

	if(($from != 'modifica-protocollo') and ($file != $tot)) {
		?>
		<script language="Javascript">
			window.location="login0.php?corpus=protocollo2&from=urlpdf&upfile=error&path=<?php echo $target_path; ?>";
		</script>
		<?php
	}
?>
