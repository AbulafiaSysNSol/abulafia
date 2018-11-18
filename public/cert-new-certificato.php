<?php

	session_start();
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	$idvisita = $_POST['idvisita'];
	$v = new Ambulatorio();
	$visita = $v->getVisita($idvisita);

	$idanagrafica = $_POST['idanagrafica'];
	$a = new Anagrafica();	
	$paziente = $a->infoAssistito($idanagrafica);

	$c = new Calendario();

	$tipo = $_POST['tipocertificato'];
	if(isset($_POST['incanamnesi'])) {
		$anamnesi = 1;	
	}
	else {
		$anamnesi = 0;
	}
	if(isset($_POST['incdiagnosi'])) {
		$diagnosi = 1;	
	}
	else {
		$diagnosi = 0;
	}
	if(isset($_POST['incterapia'])) {
		$terapia = 1;	
	}
	else {
		$terapia = 0;
	}
	if(isset($_POST['incnote'])) {
		$note = 1;	
	}
	else {
		$note = 0;
	}
	$testo = $_POST['testocertificato'];

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
			$this->SetFont('Arial','I',8);
			$this->Write('','Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].'. - https://www.abulafiaweb.it - info@abulafiaweb.it');
		}
	}
		
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,15);
	$pdf->AddPage('P','A4',90);
	$pdf->SetFont('Arial','',9);
	$pdf->SetTitle('Certificato_' . time());

	if($tipo == 'generico') {

		$pdf->Image("images/intestazione_certificato.png",23,11,33);
		$pdf->Cell(60,40,'',1,0,'C',false);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(69,40,'CERTIFICATO',1,0,'C',false);
		$pdf->SetFont('Arial','BI',12);
		$pdf->Cell(60,20,'CER',1,2,'C',false);
		$pdf->Cell(60,20,'Rev. 1 del 06/02/2017',1,1,'C',false);

		$pdf->Ln(5);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(40,10,'Data: ' . date("d/m/Y", time()),0,0,'L',false);
		$pdf->Cell(50,10,'Rif. Visita: ' . $visita['id'],0,0,'L',false);
		$pdf->Cell(90,10,'Medico: ' . $a->getNome($_SESSION['loginid']) . ' ' . $a->getCognome($_SESSION['loginid']),0,1,'L',false);
	}

	if($tipo == 'ps') {
		$pdf->Image("images/intestazione_certificato.png",23,11,33);
		$pdf->Cell(60,40,'',1,0,'C',false);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(69,40,'Invio Paziente PS',1,0,'C',false);
		$pdf->SetFont('Arial','BI',12);
		$pdf->Cell(60,20,'IPS',1,2,'C',false);
		$pdf->Cell(60,20,'Rev. 1 del 03/02/2017',1,1,'C',false);

		$pdf->Ln(5);
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(40,10,'Data: ' . date("d/m/Y", time()),0,0,'L',false);
		$pdf->Cell(30,10,'Ora: ' . date("G:i", time()),0,0,'L',false);
		$pdf->Cell(90,10,'Medico: ' . $a->getNome($_SESSION['loginid']) . ' ' . $a->getCognome($_SESSION['loginid']),0,1,'L',false);
	}

	$pdf->SetFont('Arial','',10);
	$pdf->Ln(5);
	$pdf->Cell(189,10,'Nome e Cognome Paziente: '. ucwords($paziente['nome']) .' ' . ucwords($paziente['cognome']),1,1,'L',false);
	$pdf->Cell(94.5,10,'Nato/a a: ' . ucwords($paziente['luogonascita']),1,0,'L',false);
	$pdf->Cell(94.5,10,'il: ' . $c->dataSlash($paziente['datanascita']),1,1,'L',false);
	$pdf->Cell(86.5,10,'Residente in: ' . ucwords($paziente['residenzacitta']),1,0,'L',false);
	$pdf->Cell(86,10,'Via: ' . ucwords($paziente['residenzavia']),1,0,'L',false);
	$pdf->Cell(16.5,10,'n. ' . ucwords($paziente['residenzanumero']),1,1,'L',false);
	$pdf->Cell(94.5,10,'Documento: ' . ucwords($paziente['documento']),1,0,'L',false);
	$pdf->Cell(94.5,10,'N. Documento: ' . strtoupper($paziente['documentonumero']),1,1,'L',false);

	if($anamnesi) {
		$pdf->MultiCell(189,7,'Anamnesi: ' . strip_tags($visita['anamnesi']),1,'L',false);
	}
	if($diagnosi) {
		$pdf->MultiCell(189,7,'Sospetto Diagnostico: ' . strip_tags($visita['diagnosi']),1,'L',false);
	}
	if($terapia) {
		$pdf->MultiCell(189,7,'Terapia: ' . strip_tags($visita['terapia']),1,'L',false);
	}
	if($note) {
		$pdf->MultiCell(189,7,'Note: ' . strip_tags($visita['note']),1,'L',false);
	}

	if($testo != '') {
		$pdf->MultiCell(189,7,stripslashes(strip_tags($testo)),1,'L',false);
	}

	if($tipo == 'generico') {
		$pdf->Ln(8);
		$pdf->SetFont('Arial','',10);
		$pdf->Write('','Rilasciato in carta semplice e su richiesta dell\'interessato per tutti gli usi consentiti dalla Legge.'); 
		$pdf->Ln(5);
		$pdf->Write('','Si autorizza al trattamento dei dati personali.');
	}

	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetX(130);
	$pdf->Write('','Il Medico di Guardia');

	$pdf->Output('Certificato_'.time().'.pdf','I');
	exit();
	?>