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
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';
	 

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	require_once('lib/fpdf/fpdf.php');
	require_once('lib/fpdi/fpdi.php');
	
	$my_lettera = new Lettera();
	$my_file = new File();

	$id = $_GET['id'];
	$anno = $_GET['anno'];
	$tabella = 'lettere'.$anno;
	$data2 = mysql_query("SELECT dataregistrazione FROM $tabella WHERE idlettera = '$id'");
	$data = mysql_fetch_row($data2);
	$date = explode('-', $data[0]);
	$datareg = $date[2]."/".$date[1]."/".$date[0];

	$pdf = new FPDI();
	
	$urlfile = $my_lettera->cercaAllegati($id, $anno);
	if ($urlfile) {
		foreach ($urlfile as $valore) {
			if($my_file->estensioneFile($valore[2]) == 'pdf' OR $my_file->estensioneFile($valore[2]) == 'PDF' OR $my_file->estensioneFile($valore[2]) == 'Pdf') {
				$path = "lettere".$anno."/".$id."/".$valore[2];

				//aggiungo alla prima pagina il barcode
				
				//aggiungo una pagina al pdf
				$pdf->AddPage(); 
				
				//conto le pagine e setto il pdf sorgente
				$pageCount = $pdf->setSourceFile($path);
				
				// importazione della prima pagina
				$tplIdx = $pdf->importPage(1);  
				$pdf->useTemplate($tplIdx, 5, 23, 200, 0, true); 
				$pdf->SetFont('Arial', '', '9'); 
				$pdf->SetTextColor(0,0,0);
				$pdf->SetX(28);
				$pdf->Write(0, 'Croce Rossa Italiana');
				$pdf->Ln(4);
				$pdf->SetX(28);
				$pdf->Write(0, 'Comitato Provinciale Catania');
				$pdf->Ln(4);
				$pdf->SetX(28);
				$pdf->Write(0, 'Protocollo n° '.$id.' del '.$datareg);
				$pdf->Image($pathqrcode, 1, 1);
				
	
				//aggiunta delle altre pagine del pdf
				$i = 2;
				while($i<= $pageCount) {
					$pdf->AddPage(); 
					$tplIdx = $pdf->importPage($i); 
					$pdf->useTemplate($tplIdx, 0, 0, 200, 0, true);
					$i++;
				}
			}
			//in caso di un allegato nel formato immagine
			if($my_file->estensioneFile($valore[2]) == 'jpg' OR $my_file->estensioneFile($valore[2]) == 'JPG' 
			OR $my_file->estensioneFile($valore[2]) == 'jpeg' OR $my_file->estensioneFile($valore[2]) == 'JPEG'
			OR $my_file->estensioneFile($valore[2]) == 'gif' OR $my_file->estensioneFile($valore[2]) == 'GIF'
			OR $my_file->estensioneFile($valore[2]) == 'png' OR $my_file->estensioneFile($valore[2]) == 'PNG') {
				$path = "lettere".$anno."/".$id."/".$valore[2];

				//aggiungo alla prima pagina il barcode
				
				//aggiungo una pagina al pdf
				$pdf->AddPage(); 
				$pdf->Image($path, 12, 27, 185, 0);
				$pdf->SetFont('Arial', '', '9'); 
				$pdf->SetTextColor(0,0,0);
				$pdf->Write(0, 'Croce Rossa Italiana - Comitato Provinciale Catania');
				$pdf->Ln(4);
				$pdf->Write(0, 'Protocollo n° '.$id.' del '.$datareg);
				$pdf->Code39(11, 16, $id.' - '.$datareg);
			}
		}
		$nome = 'protocollon'.$id;
		//force the browser to download the output
		$pdf->Output($nome, 'I');
	}
?>