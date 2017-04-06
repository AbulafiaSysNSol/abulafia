<?php

	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}

	include 'lib/barcode/barcode.php';
	require('lib/html2pdf/html2pdf.class.php');
	
	$id = $_GET['id'];
	$anno = $_GET['anno'];
	
	barcode($id, $anno, 45, "code128");
	$image = "images/barcode/".$id.".".$anno.".png";
	$header = "CRI - ".$_SESSION['denominazione'];
	$footer = "Protocollo n. ".$id."/".$anno;
	
	$content = '<div align="center">'.$header.'<br><img src="'.$image.'"><br>'.$footer.'</div>';
	$html2pdf = new HTML2PDF('L',array(33,75),'it');
	$html2pdf->setDefaultFont("times");
	$html2pdf->WriteHTML($content);
	ob_end_clean();
	$html2pdf->Output('barcode.pdf', 'I');
	
?>