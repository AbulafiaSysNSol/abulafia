<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$dataregistrazione = strftime("%Y-%m-%d");
	$loginid=$_SESSION['loginid'];
	$inserimento = mysql_query("insert into lettere$annoprotocollo values
					('', 
					'',
					'',
					'$dataregistrazione',
					'',
					'', 
					'', 
					'', 
					'', 
					'')
					");
	$ultimoid = mysql_insert_id();
	$utentemod =mysql_query("	INSERT INTO 
								joinlettereinserimento$annoprotocollo 
							VALUES ( 
								'$ultimoid',
								'$loginid',
								'',
								''
							)
						");
	include('lib/qrcode/qrlib.php');
		$id = $ultimoid;
		$anno = $annoprotocollo;
		
		if (!is_dir('lettere'.$anno.'/qrcode/')) {
			$creadir=mkdir('lettere'.$anno.'/qrcode/', 0777, true);
			if (!$creadir) die ("Impossibile creare la directory: qrcode/");
		}
		
		$pathqrcode = 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
		$param = 'Protocollo n° '.$id.' del '.$dataregistrazione;
		$codeText = $param; 
		$debugLog = ob_get_contents(); 
		QRcode::png($codeText, $pathqrcode);
		
		$_SESSION['block'] = true;
?>

<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
		window.location="login0.php?corpus=modifica-protocollo&from=blocca&id=<?php echo $ultimoid ?>&anno=<?php echo $annoprotocollo ?>"; 
	else 
		window.location="login0.php?corpus=modifica-protocollo&from=blocca&id=<?php echo $ultimoid ?>&anno=<?php echo $annoprotocollo ?>"; 
</SCRIPT>