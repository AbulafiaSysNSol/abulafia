<?php

	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include 'class/Log.obj.inc';
	include 'class/Lettera.obj.inc';
	include 'class/Calendario.obj.inc';
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	$my_log = new Log();
	$lettera = new Lettera();
	$calendario = new Calendario();
	$id = $_GET['id'];
	$anno = $_GET['anno'];

	require('lib/fpdf/fpdf.php');
		
	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
		    // Logo
		    $this->Image('images/intestazione.jpg',0,0,209.97);
		    // Line break
		    $this->Ln(40);
		}
		// Page footer
		function Footer()
		{
		    // Logo
		    $this->SetY(-10);
			$this->SetX(29);
			$this->SetFont('Arial','I',8);
			$this->Write('','Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].'. - https://www.abulafiaweb.it - info@abulafiaweb.it');
		}
	}

	$now = date("d".'/'."m".'/'."Y");
	$iniziale = 'Con la presente, si attesta l\'avvenuta ricezione all\'ufficio del documento in oggetto.';
	$dettagli = $lettera->getDettagli($id,$anno);
	$mittente = $lettera->getMittenti($id,$anno);
	$pdf = new PDF('P','mm', 'A4');
	$pdf->AddPage();
	$pdf->SetTitle('ricevutaprotocollo');
	$pdf->Ln(16);
	$pdf->SetFont('Arial','',12);
	$pathqrcode = 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
	$pdf->Image($pathqrcode, 7, 56);
	$pdf->SetX(33);
	$pdf->Write('','Protocollo N. ' . $dettagli['idlettera'] );
	$pdf->Ln(7);
	$pdf->SetX(33);
	$pdf->Write('','del ' . $calendario->dataSlash($dettagli['dataregistrazione']) );
	$pdf->Ln(18);
	$pdf->Write('6','Mittente: ' . $mittente[0]['cognome'] . ' ' . $mittente[0]['nome']);
	$pdf->Ln(10);
	$pdf->Write('6','Oggetto: ' . $dettagli['oggetto']);
	$pdf->Ln(25);
	$pdf->Write('',$iniziale);
	$pdf->Ln(25);
	$pdf->Write('',$_SESSION['sede'] . ', ' . $now);
	$pdf->SetXY(140,190);
	$pdf->Write('','L\'ADDETTO');
	$pdf->Output('ricevutaprotocollo.pdf','I');
?>