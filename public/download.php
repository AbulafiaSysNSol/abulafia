<?php
	session_start();

	if ($_SESSION['auth'] < 1 ) 
	{
		header("Location: index.php?s=1"); //termina lo script se non si è loggati con valore almeno 1
		exit(); 
	}
	
	function __autoload ($class_name) //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
	{ 
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$my_log = new Log(); //istanzio la classe Log()

	$est=$_GET['est']; // acquisisce l'estensione del file da passare in download, da aggiungere al nome del file rinominato in prot-(num).est
	$lud = $_GET['lud'];
	
	if (isset($_GET['idlettera'])) //acquisisce l'id del protocollo da passare in download
	{ 
		$idlettera = $_GET['idlettera'];
		$anno = $_GET['anno'];
		$fileprename='protocollo-';
		$path = 'lettere'. $anno . '/' . $idlettera . '/' . stripslashes($lud);
		$lud3=stripslashes($fileprename.$idlettera);
		$filename = $lud3.'.'.$est;
	}
	else 
	{
		$path = 'log/'. $lud;
		$filename = $lud;
	}
	
	$my_log -> publscrivilog( $_SESSION['loginname'], 'DOWNLOAD ALLEGATO '. $lud , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'download');
      
	/* otteniamo alcune info sul file */    
	$info = pathinfo( $path );    
	$extension = $info['extension']; // estensione    
	$size = filesize($path); // dimensione in byte    
	$time_file = date( 'r', filemtime( $path ) ); // time ultima modifica    
	   
	/* inviamo gli opportuni headers */     
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
