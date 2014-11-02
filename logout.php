<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $_SESSION['titolopagina'];?></title>
	<meta name="keywords" content="<?php echo $_SESSION['keywords'];?>" />
	<meta name="description" content="<?php echo $_SESSION['description'];?>" />
	<link rel="stylesheet" type="text/css" href="style.php" rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>

<body>
	<?php
	$_SESSION=array(); // Resetta tutte le variabili di sessione. 
	$_SESSION['auth']= 0 ;
	  session_destroy(); //DISTRUGGE la sessione. 
	?>

	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="index.php"; else window.location="index.php"
	</SCRIPT>
</body>
</html>
