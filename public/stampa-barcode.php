<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include 'lib/barcode/barcode.php';
	require('lib/html2pdf/html2pdf.class.php');
	
	$id = $_GET['id'];
	$anno = $_GET['anno'];
	
	barcode($id, $anno, 40, "code128");
	$image = "images/barcode/".$id.".".$anno.".png";
	$header = $_SESSION['denominazione'];
	$footer = "Prot. N. ".$id."-".$anno;
	
	$content = '<div style="text-align: center; vertical-align: middle; font-size: 16px; margin-top: 5px; margin-bottom: 10px;">'.$header.'</div>
				<div align="center"><img width="" src="'.$image.'"></div>
				<div style="text-align: center; vertical-align: middle; font-size: 16px; margin-top: 10px;">'.$footer.'</div>';
	$html2pdf = new HTML2PDF('L', array(40,85), 'it');
	$html2pdf->setDefaultFont("times");
	$html2pdf->WriteHTML($content);
	ob_end_clean();
	$html2pdf->Output('barcode'.$id.'-'.$anno.'.pdf', 'I');
	
?>