<?php

	session_start();
	
	include 'lib/barcode/barcode.php';
	include 'lib/fpdf/fpdf.php';
	
	$id = $_GET['id'];
	$anno = $_GET['anno'];
	
	barcode($id, $anno, 45, "code128");
	$image = "images/barcode/".$id.".".$anno.".png";
	$header = "CRI - ";
	$footer = "Protocollo n. ".$id."/".$anno;
	
	$pdf = new FPDF('L', 'mm', array(30,50));
	$pdf->SetMargins(3, 3, 3);
	$pdf->SetFontSize(5);
	$pdf->SetX(0);
	$pdf->Write(5, $header);
	$pdf->SetX(0);
	$pdf->Image($image);
	$pdf->SetX(0);
	$pdf->Write(5, $footer);
	$pdf->Output('barcode.pdf', 'I');
	
?>