<?php
	include('lib/qrcode/qrlib.php');
	$id = $_GET['id'];
	$anno = $_GET['anno'];
	
	if (!is_dir('lettere'.$anno.'/qrcode/')) {
		$creadir=mkdir('lettere'.$anno.'/qrcode/', 0777, true);
		if (!$creadir) die ("Impossibile creare la directory: qrcode/");
	}
	
	$pathqrcode = 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
	$param = 'Protocollo n° '.$id.' anno '.$anno;
	$codeText = $param; 
	$debugLog = ob_get_contents(); 
	QRcode::png($codeText, $pathqrcode);
?>

<?php
session_start();
function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
	require_once "class/" . $class_name.".obj.inc";
}
$my_log = new Log();
$lettera = new Lettera();
$calendario = new Calendario();
$id = $_GET['id'];
$anno = $_GET['anno'];
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
		}
	}

$now = date("d".'/'."m".'/'."Y");
$iniziale = 'Con la presente, si attesta l\'avvenuta ricezione all\'ufficio del documento.';
$finale = 'Documento generato digitalmente da Abulafia ' . $_SESSION['version'];
$dettagli = $lettera->getDettagli($id,$anno);
$mittente = $lettera->getMittenti($id,$anno);
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true);
$pdf->SetTitle('ricevutaprotocollo');
$pdf->Ln(8);
$pdf->SetFont('Times','',15);
$pdf->Image($pathqrcode, 7, 38);
$pdf->SetX(33);
$pdf->Write('','Protocollo N. ' . $dettagli['idlettera'] );
$pdf->Ln(7);
$pdf->SetX(33);
$pdf->Write('','del ' . $calendario->dataSlash($dettagli['dataregistrazione']) );
$pdf->Ln(15);
$pdf->Write('','Mittente: ' . $mittente[0]['cognome'] . ' ' . $mittente[0]['nome']);
$pdf->Ln(8);
$pdf->Write('','Oggetto: ' . $dettagli['oggetto']);
$pdf->Ln(25);
$pdf->Write('',$iniziale);
$pdf->Ln(30);
$pdf->Write('','Catania, ' . $now);
$pdf->Ln(70);
$pdf->SetX(140);
$pdf->Write('','L\'ADDETTO');
$pdf->SetFont('Times','',11);
$pdf->Ln(60);
$pdf->Write('',$finale);
$pdf->Output('protocollo'.$now.'.pdf','I');
exit();
?>