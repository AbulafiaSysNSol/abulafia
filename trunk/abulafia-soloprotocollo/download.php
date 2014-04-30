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
readfile($fp); 
exit;

/*
	VERIFICARE
    //Identificativo del file
    $file_id = @$_GET["id"];
    
    //Controllo dei parametri
    if($file_id == "1")
    {
        //Nome virtuale del file
        $file_name = "test.zip";
        //Posizione reale del file del file
        $file_path = "cartella/f001.dat";
        //Formato MIME del file
        $file_mime = "application/zip";
        
        //Controllo esistenza del file
        if(file_exists($file_path))
        {
            //Ottieni la dimensione del file
            $file_size = filesize($file_path);
            
            //Preparazione del protocollo di comunicazione tra browser e server
            header("Content-Type: application; name=" . $file_name);
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $file_size);
            header("Content-Type: " . $file_mime);
            header("Content-Disposition: inline; filename=" . $file_name);
            header("Expires: 0");
            header("Cache-Control: no-cache, must-revalidate");
            header("Cache-Control: private");
            header("Pragma: public");
            
            //Invio file al browser
            readfile($file_path);
            
            //Redirect alla pagina di partenza
            header("Location: index.php");
            exit();
        }
        else
        {
            //Redirect alla pagina di errore
            header("Location: error.php");
            exit();
        }
    }
    else
    {
        //Redirect alla pagina di errore
        header("Location: error.php");
        exit();
    }
*/
?>
