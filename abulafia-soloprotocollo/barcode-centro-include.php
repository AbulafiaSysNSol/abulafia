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
	
	$pdf = new FPDI();
	
	$urlfile = $my_lettera->cercaAllegati($id, $anno);
	if ($urlfile) {
		foreach ($urlfile as $valore) {
			if($my_file->estensioneFile($valore[2]) == 'pdf' OR $my_file->estensioneFile($valore[2]) == 'PDF' OR $my_file->estensioneFile($valore[2]) == 'Pdf') {
				$path = "lettere".$anno."/".$id."/".$valore[2];

				//aggiungo alla prima pagina il barcode
				$pdf->AddPage(); 
				$pageCount = $pdf->setSourceFile($path);
				// import page 1 
				$tplIdx = $pdf->importPage(1); 
				//use the imported page and place it at point 0,0; calculate width and height
				//automaticallay and ajust the page size to the size of the imported page 
				$pdf->useTemplate($tplIdx, 5, 23, 200, 0, true); 
				// now write some text above the imported page 
				$pdf->SetFont('Arial', '', '9'); 
				$pdf->SetTextColor(0,0,0);
				//set position in pdf document
				//$pdf->SetXY(17, 7);
				//first parameter defines the line height
				$pdf->Write(0, 'Croce Rossa Italiana - Comitato Provinciale Catania');
				$pdf->Ln(4);
				$pdf->Write(0, 'Protocollo n° '.$id.' del 01/01/2014');
				$pdf->Code39(11, 16, $id.' - 01.01.2014');

				//aggiunta delle altre pagine del pdf
				$i = 2;
				while($i<= $pageCount) {
					$pdf->AddPage(); 
					$tplIdx = $pdf->importPage($i); 
					$pdf->useTemplate($tplIdx, 0, 0, 200, 0, true);
					$i++;
				}

				//force the browser to download the output
				$nome = 'protocollon'.$id;
			}
		}
		$pdf->Output($nome, 'I');
	}
?>