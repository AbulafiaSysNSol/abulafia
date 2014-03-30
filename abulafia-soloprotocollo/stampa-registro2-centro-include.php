<?php
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
		    $this->Image('images/footer.jpg',0,274,209.97);
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
		$intestazione = 'Registro di protocollo dal numero '. $inizio .' al numero '. $fine.':';
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
			$query = mysql_query("SELECT * FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.idlettera >= '$inizio' AND lettere$anno.idlettera <= '$fine' ORDER BY lettere$anno.idlettera"); 
		}
	}
	if($from == "date") {
		$inizio = $_POST['datainizio'];
		$fine = $_POST['datafine'];
		$intestazione = 'Registro di protocollo dal '. $inizio .' al '. $fine.':';
		list($giornoi, $mesei, $annoi) = explode("/", $inizio);
		list($giornof, $mesef, $annof) = explode("/", $fine);
		if ($annoi != $annof) {
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
			$query = mysql_query("SELECT * FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine' ORDER BY lettere$anno.idlettera"); 
		}	
	}
$finale = 'Documento generato digitalmente da Abulafia ' . $_SESSION['version'].', il ' . date("d".'/'."m".'/'."Y");
$contatorelinee = 1;
ob_clean();
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->SetTitle('registroprotocollo');
$pdf->Text(10,50,$intestazione);
$pdf->Ln(20);
$pdf->Cell(13,7,'N.',1,0,'C');
$pdf->Cell(23,7,'Data Reg.',1,0,'C');
$pdf->Cell(22,7,'Sped./Ric.',1,0,'C');
$pdf->Cell(0,7,'Oggetto',1,1,'C');
$pdf->Ln(5);
while($query2 = mysql_fetch_array($query)) {
	if ( $contatorelinee % 2 == 1 ) { $r = 255; $g = 253; $b = 208; }
	else { $r = 255; $g = 255; $b = 255; }
	$pdf->SetFillColor($r,$g,$b);
	$pdf->Cell(13,7,$query2['idlettera'],1,0,'L',true);
	list($anno, $mese, $giorno) = explode("-", $query2['dataregistrazione']);
	$data = $giorno.'/'.$mese.'/'.$anno;
	$pdf->Cell(23,7,$data,1,0,'L',true);
	$pdf->Cell(22,7,$query2['speditaricevuta'],1,0,'L',true);
	$pdf->Cell(0,7,$query2['oggetto'],1,1,'L',true);
	$pdf->MultiCell(0,7,'Mittenti/Destinatari: ' . $query2['cognome'] . ' ' . $query2['nome'],1,'L',true);
	$pdf->Ln(4);
	$contatorelinee = $contatorelinee + 1;
    }
$pdf->Ln(15);
$pdf->Write('',$finale);
$pdf->Output();
?>