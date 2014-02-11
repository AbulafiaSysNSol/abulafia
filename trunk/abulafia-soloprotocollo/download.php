<?php

$est=$_GET['est']; // acquisisce l'estensione del file da passare in download, da aggiungere al nome del file rinominato in prot-(num).est
$lud = $_GET['lud'];
$idlettera =$_GET['idlettera']; //acquisisce l'id del protocollo da passare in download
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
	if ($lud== 'access.log')
	{
		$fileprename='access';
	}
	else if ($lud== 'mail.log')
	{
		$fileprename='mail';
	}
	else $fileprename='abl';
}

$annoricercaprotocollo=$_GET['annoricercaprotocollo'];
$lud2= $tabella.$annoricercaprotocollo.$path.$lud;
$lud3=$fileprename.$idlettera; // nome assegnato al file per il download
$fp = fopen($lud2, 'rb');
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Cache-Control: private",false); 
header("Content-Type: application/octetstream");
header("Content-Disposition: attachment\; filename=\"$lud3.$est\"");
header("Content-Transfer-Encoding:­ binary");
header("Content-Length: " . filesize($lud2));
header("Connection: close");
fpassthru($fp);
//readfile($fp); 
exit;
?>



