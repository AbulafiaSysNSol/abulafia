<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php';
	include 'lib/barcode/barcode.php';
	require('class/Lettera.obj.inc');
	require('class/Calendario.obj.inc');
	require('lib/html2pdf/html2pdf.class.php');
	
	$id = $_GET['id'];
	$anno = $_GET['anno'];

	$p = new Lettera();
	$c = new Calendario();
	if ($p->isSpedita($id, $anno)) {
		$text = 'Uscita';
	}
	else {
		$text = 'Entrata';
	}

	$data = $p->getDettagli($id,$anno);

	barcode($id, $anno, $c->dataSlash($data[3]), 45, "code128");
	$image = "images/barcode/".$id.".".$anno.".png";
	$header = $_SESSION['denominazione'];
	$footer = "Prot. ".$text." N° ".$id." del ".$c->dataSlash($data[3]);
	
	$content = '<div style="text-align: center; vertical-align: middle; font-size: 16px; margin-top: 5px; margin-bottom: 10px;">'.$header.'</div>
				<div align="center"><img width="" src="'.$image.'"></div>
				<div style="text-align: center; vertical-align: middle; font-size: 16px; margin-top: 10px;"><b>'.$footer.'</b></div>';
	$html2pdf = new HTML2PDF('L', array(42,110), 'it');
	$html2pdf->setDefaultFont("times");
	$html2pdf->WriteHTML($content);
	ob_end_clean();
	$html2pdf->Output('barcode'.$id.'-'.$anno.'.pdf', 'I');
	
?>