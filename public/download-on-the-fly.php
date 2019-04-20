<?php
/*acquisisce dal form della pagina precedente i valori HIDDEN tramite POST con noe del file, 
prima riga del file ed array da spampare. Crea un file di testo al volo e lo propone per il download*/

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


if (isset($_POST['textonthefly'])) //acquisisce il valore dalla pagina precedente
{

	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=".$_POST['filename']."");
 
	// do your Db stuff here to get the content into $content
	print $_POST['logname']." ";
	print_r(unserialize(base64_decode($_POST['textonthefly'])));
	unset($_POST['textonthefly']);
	exit();
}
?>