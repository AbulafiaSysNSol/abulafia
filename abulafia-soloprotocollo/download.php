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

	if ($idlettera!='') 
	{
		$tabella = 'lettere';
		$path='/';
		$fileprename='protocollo-';
	} 
	else 
	{ 
		$tabella =''; 
		$path=''; 
		if ($lud== 'log/access.log')
		{
			$fileprename='access';
		}
		else if ($lud== 'log/mail.log')
		{
			$fileprename='mail';
		}
		else if ($lud== 'log/history.log')
		{
			$fileprename='history';
		}
		else $fileprename='abl';
	}

	if (isset($_GET['annoricercaprotocollo'])) {
		$annoricercaprotocollo = $_GET['annoricercaprotocollo'];
	}
	
	$lud2= stripslashes($lud);
	$lud3=stripslashes($fileprename.$idlettera); // nome assegnato al file per il download
	$fp = fopen($lud2, 'rb');
	
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Cache-Control: private",false); 
		header("Content-Type: application/octetstream");
		header("Content-Disposition: attachment; filename=\"$lud3.$est\"");
		header("Content-Transfer-Encoding:­ binary");
		header("Content-Length: " . filesize($lud2));
		header("Connection: close");
		fpassthru($fp);
		//readfile($fp); 
	
	exit;

?>
