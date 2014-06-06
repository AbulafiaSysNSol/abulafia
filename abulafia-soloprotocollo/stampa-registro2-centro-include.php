<?php
session_start();
include '../db-connessione-include.php';
include 'maledetti-apici-centro-include.php';
require('lib/fpdf/fpdf.php');
	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
		    // Logo
		    $this->Image('images/intestazione.jpg',5,-6,209.97);
		    // Line break
		    $this->Ln(30);
		}

		// Page footer
		function Footer()
		{
		    // Logo
		    $this->Image('images/footer.jpg',0,281,209.97);
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Page number
		    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	$from = $_GET['search'];
	if($from == "num") {
		$inizio = $_POST['numeroinizio'];
		$fine = $_POST['numerofine'];
		$anno = $_POST['annoprotocollo'];
		$annoricerca = $anno;
		$intestazione = 'Registro di protocollo '. $anno . ' dal numero '. $inizio .' al numero '. $fine.':';
		$query = mysql_query("SELECT COUNT(*) FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.idlettera >= '$inizio' AND lettere$anno.idlettera <= '$fine'"); 
		$numerorisultati = mysql_fetch_row($query);
		if($numerorisultati[0] < 1) {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=stampa-registro&noresult=1"; else window.location="login0.php?corpus=stampa-registro&noresult=1";
			</SCRIPT>
			<?php 
			exit();
		}
		else {
			$query = mysql_query("SELECT * FROM lettere$anno WHERE lettere$anno.idlettera >= '$inizio' AND lettere$anno.idlettera <= '$fine' ORDER BY lettere$anno.idlettera"); 
		}
	}
	if($from == "date") {
		if(isset($_POST['datainizio'])) {
			$inizio = $_POST['datainizio'];
			$datai = explode("/", $inizio);
			if(isset($datai[0])) {
				$giornoi = $datai[0];
			}
			if(isset($datai[1])) {
				$mesei = $datai[1];
			}
			if(isset($datai[2])) {
				$annoi = $datai[2];
			}
			else {
				$annoi = 0;
			}
		}
		if(isset($_POST['datafine'])) {
			$fine = $_POST['datafine'];
			$dataf = explode("/", $fine);
			if(isset($dataf[0])) {
				$giornof = $dataf[0];
			}
			if(isset($dataf[1])) {
				$mesef = $dataf[1];
			}
			if(isset($dataf[2])) {
				$annof = $dataf[2];
			}
			else {
				$annof = 1;
			}
		}
		if ( $annoi != $annof ) {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=stampa-registro&noresult=2"; else window.location="login0.php?corpus=stampa-registro&noresult=2";
			</SCRIPT>
			<?php 
			exit();
		}
		$anno = $annoi;
		$annoricerca = $anno;
		$intestazione = 'Registro di protocollo ' . $anno . ' dal '. $inizio .' al '. $fine.':';
		$inizio = $annoi.'-'.$mesei.'-'.$giornoi;
		$fine = $annof.'-'.$mesef.'-'.$giornof;
		$query = mysql_query("SELECT COUNT(*) FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine'"); 
		$numerorisultati = mysql_fetch_row($query);
		if($numerorisultati[0] < 1) {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=stampa-registro&noresult=1"; else window.location="login0.php?corpus=stampa-registro&noresult=1";
			</SCRIPT>
			<?php 
			exit();
		}
		else {
			$query = mysql_query("SELECT * FROM lettere$anno WHERE lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine' ORDER BY lettere$anno.idlettera"); 
		}	
	}
$now = date("d".'.'."m".'.'."Y");
$finale = 'Documento generato digitalmente da Abulafia ' . $_SESSION['version'].', il ' . date("d".'/'."m".'/'."Y");
$contatorelinee = 1;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetTitle('registroprotocollo');
$pdf->Text(10,45,$intestazione);
$pdf->Ln(10);
while($query2 = mysql_fetch_array($query)) {
	$query2 = array_map('stripslashes', $query2);
	if ( $contatorelinee % 2 == 1 ) { $r = 255; $g = 253; $b = 170; }
	else { $r = 255; $g = 255; $b = 255; }
	$pdf->SetFillColor($r,$g,$b);
	$pdf->Cell(13,7,'N.',1,0,'C',true);
	$pdf->Cell(23,7,'Data Reg.',1,0,'C',true);
	$pdf->Cell(22,7,'Sped./Ric.',1,0,'C',true);
	$pdf->Cell(23,7,'Data Lettera',1,0,'C',true);
	$pdf->Cell(10,7,'Pos.',1,0,'C',true);
	$pdf->Cell(10,7,'All.',1,0,'C',true);
	$pdf->Cell(0,7,'Note',1,1,'C',true);
	$pdf->Cell(13,7,$query2['idlettera'],1,0,'C',true);
	list($anno, $mese, $giorno) = explode("-", $query2['dataregistrazione']);
	$data = $giorno.'/'.$mese.'/'.$anno;
	$pdf->Cell(23,7,$data,1,0,'C',true);
	$pdf->Cell(22,7,$query2['speditaricevuta'],1,0,'C',true);
	list($anno, $mese, $giorno) = explode("-", $query2['datalettera']);
	$data = $giorno.'/'.$mese.'/'.$anno;
	$pdf->Cell(23,7,$data,1,0,'C',true);
	$pdf->Cell(10,7,$query2['riferimento'],1,0,'C',true);
	$pdf->Cell(10,7,'X',1,0,'C',true);
	$pdf->Cell(0,7,$query2['note'],1,1,'L',true);
	$pdf->MultiCell(0,7,'Oggetto: ' . $query2['oggetto'],1,'L',true);
	if($query2['speditaricevuta'] == 'ricevuta') { $sd = 'Mittenti'; } else { $sd = 'Destinatari'; }
	$destinatari = mysql_query("Select * From anagrafica, joinletteremittenti$annoricerca Where anagrafica.idanagrafica=joinletteremittenti$annoricerca.idanagrafica AND joinletteremittenti$annoricerca.idlettera=$query2[0]");
	echo mysql_error();
	$d='';
	while ( $dest = mysql_fetch_array($destinatari)) {
		$dest = array_map('stripslashes', $dest);
		$d = $d.' '.$dest['cognome'];
		if($dest['nome'] != '') { 
			$d =$d . ' ' . $dest['nome']; 
		}
		$d = $d.';';
	}
	$pdf->MultiCell(0,7,$sd . ': ' . $d,1,'L',true);
	$pdf->Ln(5);
	$contatorelinee = $contatorelinee + 1;
}
$pdf->Ln(15);
$pdf->Write('',$finale);
$pdf->Output('registroprotocollo'.$now.'.pdf','I');
exit();
?>