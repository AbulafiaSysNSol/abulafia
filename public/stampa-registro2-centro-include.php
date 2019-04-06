<?php
error_reporting(~E_WARNING);
session_start();
function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
	require_once "class/" . $class_name.".obj.inc";
}
$my_log = new Log();
$lettera = new Lettera();
include '../db-connessione-include.php';
include 'maledetti-apici-centro-include.php';
require('lib/fpdf/fpdf.php');
	
class PDF extends FPDF {
	
	// Page header
	function Header() {
		// Logo
		$this->Image('images/intestazione.jpg',0,0,209.97);
		// Line break
		$this->Ln(35);
	}

	// Page footer
	function Footer() {
	    // Logo
	    //$this->Image('images/footer.jpg',5,278,209.97);
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Page number
	    $this->SetFont('Arial','',9);
	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	    $this->SetY(-9);
		$this->SetX(9);
		$this->SetFont('Arial','I',8);
		$this->Write('','Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].'. - https://www.abulafiaweb.it - info@abulafiaweb.it');
	}
}
	
	$from = $_GET['search'];
	if($from == "num") {
		$inizio = $_POST['numeroinizio'];
		$fine = $_POST['numerofine'];
		$anno = $_POST['annoprotocollo'];
		$annoricerca = $anno;
		$intestazione = 'Registro di protocollo '. $anno . ' dal numero '. $inizio .' al numero '. $fine.':';
		$query = $connessione->query("SELECT COUNT(*) FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.idlettera >= '$inizio' AND lettere$anno.idlettera <= '$fine'"); 
		$numerorisultati = $query->fetch();
		if($numerorisultati[0] < 1) {
			$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO STAMPA REGISTRO' , 'FAILED: NESSUN VALORE TROVATO' , 'DAL ' . $inizio . ' AL ' . $fine . ' ANNO ' . $anno , $_SESSION['logfile'], 'protocollo');
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
			$query = $connessione->query("SELECT * FROM lettere$anno WHERE lettere$anno.idlettera >= '$inizio' AND lettere$anno.idlettera <= '$fine' ORDER BY lettere$anno.idlettera"); 
			$my_log -> publscrivilog( $_SESSION['loginname'], 'STAMPATO REGISTRO' , 'OK' , 'DAL ' . $inizio . 'AL ' . $fine . ' ANNO ' . $anno , $_SESSION['logfile'], 'protocollo');
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
		$query = $connessione->query("SELECT COUNT(*) FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine'"); 
		$numerorisultati = $query->fetch();
		if($numerorisultati[0] < 1) {
			$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO STAMPA REGISTRO' , 'FAILED: NESSUN VALORE TROVATO' , 'DAL ' . $inizio . ' AL ' . $fine . ' ANNO ' . $anno , $_SESSION['logfile'], 'protocollo');
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
			$query = $connessione->query("SELECT * FROM lettere$anno WHERE lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine' ORDER BY lettere$anno.idlettera"); 
			$my_log -> publscrivilog( $_SESSION['loginname'], 'STAMPATO REGISTRO' , 'OK' , 'DAL ' . $inizio . 'AL ' . $fine . ' ANNO ' . $anno , $_SESSION['logfile'], 'protocollo');
		}	
	}
	
	if($from == "day") {
		if(isset($_POST['day'])) {
			$inizio = $_POST['day'];
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
			$dataf = explode("/", $inizio);
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
		$anno = $annoi;
		$annoricerca = $anno;
		$intestazione = 'Registro di protocollo giornaliero del ' . $inizio . ':';
		$inizio = $annoi.'-'.$mesei.'-'.$giornoi;
		$fine = $annof.'-'.$mesef.'-'.$giornof;
		$query = $connessione->query("SELECT COUNT(*) FROM lettere$anno, anagrafica, joinletteremittenti$anno WHERE anagrafica.idanagrafica = joinletteremittenti$anno.idanagrafica AND lettere$anno.idlettera = joinletteremittenti$anno.idlettera AND lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine'"); 
		$numerorisultati = $query->fetch();
		if($numerorisultati[0] < 1) {
			$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO STAMPA REGISTRO' , 'FAILED: NESSUN VALORE TROVATO' , 'DEL ' . $inizio , $_SESSION['logfile'], 'protocollo');
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
			$query = $connessione->query("SELECT * FROM lettere$anno WHERE lettere$anno.dataregistrazione BETWEEN '$inizio' AND '$fine' ORDER BY lettere$anno.idlettera"); 
			$my_log -> publscrivilog( $_SESSION['loginname'], 'STAMPATO REGISTRO' , 'OK' , 'DAL ' . $inizio . 'AL ' . $fine . ' ANNO ' . $anno , $_SESSION['logfile'], 'protocollo');
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
$pdf->Text(10,57,$intestazione);
$pdf->Ln(20);

while($query2 = $query->fetch()) {
	$query2 = array_map('stripslashes', $query2);
	if ( $contatorelinee % 2 == 1 ) { 
		$r = 255; $g = 253; $b = 170; 
	}
	else { 
		$r = 255; $g = 255; $b = 255; 
	}
	
	//intestazione
	$pdf->SetFillColor($r,$g,$b);
	$pdf->Cell(22,7,'N.',1,0,'C',true);
	$pdf->Cell(25,7,'Data Reg.',1,0,'C',true);
	$pdf->Cell(25,7,'Sped./Ric.',1,0,'C',true);
	$pdf->Cell(25,7,'Data Lettera',1,0,'C',true);
	$pdf->Cell(43,7,'Mezzo di Trasmissione',1,0,'C',true);
	$pdf->Cell(25,7,'Posizione',1,0,'C',true);
	$pdf->Cell(25,7,'Numero All.',1,1,'C',true);

	//campi
	$pdf->Cell(22,7,$query2['idlettera'],1,0,'C',true);
	list($anno, $mese, $giorno) = explode("-", $query2['dataregistrazione']);
	$data = $giorno.'/'.$mese.'/'.$anno;
	$pdf->Cell(25,7,$data,1,0,'C',true);
	$pdf->Cell(25,7,$query2['speditaricevuta'],1,0,'C',true);
	list($anno, $mese, $giorno) = explode("-", $query2['datalettera']);
	$data = $giorno.'/'.$mese.'/'.$anno;
	$pdf->Cell(25,7,$data,1,0,'C',true);
	$pdf->Cell(43,7,$query2['posizione'],1,0,'C',true);
	$pdf->Cell(25,7,$query2['riferimento'],1,0,'C',true);
	$pdf->Cell(25,7,$lettera->contaAllegati($query2['idlettera'], $annoricerca),1,1,'C',true);
	
	//campi dimensione variabile
	$pdf->MultiCell(0,7,'Oggetto: ' . $query2['oggetto'],1,1,'L',true);
	if($query2['speditaricevuta'] == 'ricevuta') { 
		$sd = 'Mittenti'; 
	} 
	else { 
		$sd = 'Destinatari'; 
	}
	$destinatari = $connessione->query("SELECT * FROM anagrafica, joinletteremittenti$annoricerca WHERE anagrafica.idanagrafica = joinletteremittenti$annoricerca.idanagrafica AND joinletteremittenti$annoricerca.idlettera = '$query2[0]' ");
	$d = '';

	while ($dest = $destinatari->fetch()) {
		$dest = array_map('stripslashes', $dest);
		$d = $d.' '.$dest['cognome'];
		if($dest['nome'] != '') { 
			$d =$d . ' ' . $dest['nome']; 
		}
		$d = $d.';';
	}
	$pdf->MultiCell(0,7,$sd . ': ' . $d,1,1,'L',true);
	if ($query2['note'] != '') {
		$pdf->MultiCell(0,7,'Note: '.$query2['note'],1,1,'L',true);
	}
	$pdf->Ln(5);
	$contatorelinee = $contatorelinee + 1;
}
//$pdf->Ln(15);
//$pdf->Write('',$finale);
$pdf->Output('I','registroprotocollo'.$now.'.pdf');
exit();
?>
