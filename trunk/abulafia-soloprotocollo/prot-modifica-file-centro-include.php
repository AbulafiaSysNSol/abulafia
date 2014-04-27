<?php

	if(isset($_GET['from'])) {
		$from = $_GET['from'];
	}
	else {
		$from = '';
	}

	include 'maledetti-apici-centro-include.php';
	$my_file= new File;
	$annoprotocollo = $_SESSION['annoprotocollo'];

	
		$target_path = "lettere$annoprotocollo/"; //setta la directory di destinazione del file da caricare
		$idlettera=$_GET['idlettera']; //setta l'id della lettera cui attribuire gli allegati
		$target_path = $target_path . $idlettera."/".time().".".$my_file->estensioneFile (basename( $_FILES['uploadedfile']['name'])); 
												/*
												aggiunge alla directory, 
												una sotto-directory con l'id della lettera
												e il nome del file da caricare
												*/
										
		if (!is_dir("lettere$annoprotocollo/".$idlettera)) //se non esiste una directory con il l'id della lettera, la crea per ospitare gli allegati
			{
			mkdir("lettere$annoprotocollo/".$idlettera, 0777, true);
			}
			
		if (!is_dir("lettere$annoprotocollo/"."/temp/"))//controlla se la directory TEMP esiste dentro la dir LETTERE, altrimenti la crea
		{
		mkdir("lettere$annoprotocollo/"."/temp/", 0777, true);
		}
				
		if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {	/*
											se lo spostamento del file va a buon fine
											*/ 
			$target_path2=mysql_real_escape_string($target_path);
			echo $target_path2;
			$inserisci=mysql_query("insert 
						into joinlettereallegati
						values($idlettera, $annoprotocollo, '$target_path2')
						");			
			?>			
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=<?php echo $_GET['from'];?>&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success"; 
			else window.location="login0.php?corpus=<?php echo $_GET['from'];?>&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=success";
			</SCRIPT>
			<?php

		} 
		else {	/*
			se lo spostamento del file NON va a buon fine
			*/ 
		
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=<?php echo $_GET['from'];?>&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error"; 
			else window.location="login0.php?corpus=<?php echo $_GET['from'];?>&annoprotocollo=<?php echo $annoprotocollo;?>&idlettera=<?php echo $idlettera;?>&from=urlpdf&upfile=error";
			</SCRIPT>
			<?php
		}
?>
