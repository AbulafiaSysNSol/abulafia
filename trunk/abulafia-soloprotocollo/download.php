<?php
	session_start();
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$my_log = new Log();

	$est=$_GET['est']; // acquisisce l'estensione del file da passare in download, da aggiungere al nome del file rinominato in prot-(num).est
	$lud = $_GET['lud'];
	$my_log -> publscrivilog( $_SESSION['loginname'], 'DOWNLOAD ALLEGATO '. $lud , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
	
	if (isset($_GET['idlettera'])) { //acquisisce l'id del protocollo da passare in download
		$idlettera = $_GET['idlettera'];
	}
	else {
		$idlettera = '';
	}

	if ($idlettera!='') {
		$fileprename='protocollo-';
	} 
	else { 
		if ($lud== 'log/access.log') {
			$fileprename='access';
		}
		else if ($lud== 'log/mail.log') {
			$fileprename='mail';
		}
		else if ($lud== 'log/history.log') {
			$fileprename='history';
		}
	}
	
	$lud2= stripslashes($lud);
	$lud3=stripslashes($fileprename.$idlettera); // nome assegnato al file per il download
	$path = $lud2;
	$filename = $lud3.'.'.$est;
	
	/*
	$fp = fopen($lud2, 'rb');
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Cache-Control: private",false); 
	header("Content-Type: application/octetstream");
	header("Content-Disposition: attachment; filename=\"".$filename."\"");
	header("Content-Transfer-Encoding:­ binary");
	header("Content-Length: " . filesize($lud2));
	header("Connection: close");
	fpassthru($fp);
	readfile($fp); 
	exit;
	*/
	      
	/* otteniamo alcune info sul file */    
	$info = pathinfo( $path );    
	$extension = $info['extension']; // estensione    
	$size = filesize($path); // dimensione in byte    
	$time_file = date( 'r', filemtime( $path ) ); // time ultima modifica    
	   
	/* inviamo gli opportuni headers */    
	/* alcuni di questi sono degli hack (trucchi)   
	per farlo funzionare correttamente anche su alcune versioni di IE*/    
	header('Content-Type: application/octet-stream');    
	header('Content-Disposition: attachment; filename="'. $filename .'"');     
	header('Content-Transfer-Encoding: binary');    
	header('Content-Length: ' . $size);    
	header('Last-Modified: ' . $time_file);    
	header('Expires: 0');    
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');    
	header('Pragma: public');    
	      
	/* eliminiamo eventuale output inviato */    
	ob_clean();    
	flush();    
	    
	/* leggiamo il file inviamo l'output */    
	@readfile($path) or die('SERVER ERROR!');    
	exit;    
?>   

?>
