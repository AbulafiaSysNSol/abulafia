<?php

	session_start();
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	
	$v = new Ambulatorio();
	$a = new Anagrafica();	
	$c = new Calendario();

	$datainizio = $c->dataDB($_POST['datainizio']);
	$datafine = $c->dataDB($_POST['datafine']);

	$finale = 'Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].'. - https://www.abulafiaweb.it - info@abulafiaweb.it';
	
	require('lib/fpdf/fpdf.php');
	
	class PDF extends FPDF
	{
		// Page header
		function Header()
		{

		}

		// Page footer
		function Footer() {
			$this->SetY(-10);
			$this->SetX(29);
			$this->SetFont('Times','I',9);
			$this->Write('','Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].'. - https://www.abulafiaweb.it - info@abulafiaweb.it');
		}
	}
		
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,15);
	$pdf->AddPage('P','A4',90);
	$pdf->SetFont('Arial','',9);
	$pdf->SetTitle('ReportPrestazioni_' . time());

	$pdf->Image("images/intestazione_certificato.png",23,11,33);
	$pdf->Cell(60,40,'',1,0,'C',false);
	$pdf->SetFont('Arial','B',17);
	$pdf->Cell(69,40,'REPORT',1,0,'C',false);
	$pdf->SetFont('Arial','BI',13);
	$pdf->Cell(60,20,'RPE',1,2,'C',false);
	$pdf->Cell(60,20,'Rev. 0 del 26/08/2015',1,1,'C',false);

	$pdf->Ln(10);
	$pdf->SetX(36);
	$pdf->SetFont('Arial','B',16);
	$pdf->Cell(30,10,'Prestazioni Erogate dal ' . $_POST['datainizio'] . ' al ' . $_POST['datafine'],0,0,'L',false);
	
	$pdf->Ln(20);
	
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(189,10,'Interventi',1,1,'C',false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(94.5,10,'Interventi effettuati',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioni($datainizio,$datafine),1,1,'C',false);
	$pdf->Cell(94.5,10,'Interventi che hanno richiesto il 118',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioni118($datainizio,$datafine),1,1,'C',false);
	$pdf->Cell(94.5,10,'Interventi in cui sono stati somministrati farmaci',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioniFarmaci($datainizio,$datafine),1,1,'C',false);

	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(189,10,'Destinatari Prestazioni',1,1,'C',false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(94.5,10,'Cittadini Italiani',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioniIT($datainizio,$datafine),1,1,'C',false);
	$pdf->Cell(94.5,10,'Cittadini Stranieri',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioniEE($datainizio,$datafine),1,1,'C',false);

	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',13);
	$pdf->Cell(189,10,'Imprese Aeroportuali',1,1,'C',false);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(94.5,10,'Prestazioni erogate a dipendenti aeroportuali',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioniDip($datainizio,$datafine),1,1,'C',false);
	$pdf->Cell(94.5,10,'Cittadini Italiani dipendenti di imprese aeroportuali',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioniDipIT($datainizio,$datafine),1,1,'C',false);
	$pdf->Cell(94.5,10,'Cittadini Stranieri dipendenti di imprese aeroportuali',1,0,'L',false);
	$pdf->Cell(94.5,10,$v->contaPrestazioniDipEE($datainizio,$datafine),1,1,'C',false);

	$pdf->Ln(20);

	$pdf->Cell(94.5,10,'Medico Compilatore: ' . $a->getNome($_SESSION['loginid']) . ' ' . $a->getCognome($_SESSION['loginid']),1,0,'L',false);
	$pdf->Cell(94.5,10,'Data Generazione Report: ' . date("d/m/Y", time()),1,1,'L',false);
	$pdf->Cell(189,20,'Firma: ',1,1,'L',false);

	$pdf->Output('Certificato_'.time().'.pdf','I');
	exit();
	?>