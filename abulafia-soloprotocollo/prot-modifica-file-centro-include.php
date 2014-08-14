<?php

	set_time_limit(0);
	
	if(isset($_GET['idlettera'])) {
		$idlettera = $_GET['idlettera'];
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
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$target_path = "lettere$annoprotocollo/"; //setta la directory di destinazione del file da caricare
	$time = time();
	$name = $time.".".$my_file->estensioneFile (basename( $_FILES['uploadedfile']['name']));
	if($from == 'modifica-protocollo') {
		$target_path = $target_path . $idlettera . '/' .$name;
	}
	else {
		$target_path = $target_path ."temp/".$name;
	}
												/*
												aggiunge alla directory, 
												una sotto-directory con l'id della lettera
												e il nome del file da caricare
												*/
										
	/*if (!is_dir("lettere$annoprotocollo/".$idlettera)) { //se non esiste una directory con il l'id della lettera, la crea per ospitare gli allegati
		mkdir("lettere$annoprotocollo/".$idlettera, 0777, true);
	}*/
			
	if (!is_dir("lettere$annoprotocollo/"."/temp/")) {//controlla se la directory TEMP esiste dentro la dir LETTERE, altrimenti la crea
		mkdir("lettere$annoprotocollo/"."/temp/", 0777, true);
	}
						
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) { //se lo spostamento del file va a buon fine
		$target_path2=mysql_real_escape_string($target_path);
		if($from == 'modifica-protocollo') {
			$inserisci=mysql_query("insert into joinlettereallegati values($idlettera, $annoprotocollo, '$name')");
			$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICA PROTOCOLLO '. $idlettera , 'OK' , 'AGGIUNTO ALLEGATO '. $name , $_SESSION['historylog']);
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-protocollo&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success"; 
			else window.location="login0.php?corpus=protocollo2&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success";
			</SCRIPT>
			<?php
		}
		else {
			$my_lettera->arrayallegati[$name]=$target_path2;
			$_SESSION['my_lettera']=serialize($my_lettera);
			$my_log -> publscrivilog( $_SESSION['loginname'], 'AGGIUNTO ALLEGATO PROTOCOLLO '.$idlettera , 'OK' , 'ALLEGATO '.$name , $_SESSION['historylog']);
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&from=urlpdf&upfile=success"; 
			else window.location="login0.php?corpus=protocollo2&from=urlpdf&upfile=success";
			</SCRIPT>
			<?php
		}
	} 
	else { //se lo spostamento non va a buon fine
		if($from == 'modifica-protocollo') {
			$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI MODIFICA ALLEGATO PROTOCOLLO '. $my_lettera->idtemporaneo , 'FAILED' , 'AGGIUNTA ALLEGATO '. $name , $_SESSION['historylog']);
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-protocollo&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error"; 
			else window.location="login0.php?corpus=protocollo2&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error";
			</SCRIPT>
			<?php
		}
		else {
			$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI AGGIUNTA ALLEGATO PROTOCOLLO '. $my_lettera->idtemporaneo , 'FAILED' , 'AGGIUNTA ALLEGATO '. $name , $_SESSION['historylog']);
			$_SESSION['my_lettera']=serialize($my_lettera);
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&from=urlpdf&upfile=error"; 
			else window.location="login0.php?corpus=protocollo2&from=urlpdf&upfile=error";
			</SCRIPT>
			<?php
		}
	}
?>
