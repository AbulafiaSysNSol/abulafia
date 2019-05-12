<?php

	session_start();
	error_reporting(E_ERROR);

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	$id = $_GET['id'];

	$c = new Calendario();
	$m = new Magazzino();
	$p = new Prodotto();
	$s = new Servizio();
	$documento = $m->getDocumentById($id);

	$finale = 'Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].' - https://www.abulafiaweb.it - info@abulafiaweb.it';
	
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
			$this->Write('','Documento generato digitalmente da Abulafia Web Ver.' . $_SESSION['version'].' - https://www.abulafiaweb.it - info@abulafiaweb.it');
		}

		var $widths;
		var $aligns;

		function SetWidths($w)
		{
		    //Set the array of column widths
		    $this->widths=$w;
		}

		function SetAligns($a)
		{
		    //Set the array of column alignments
		    $this->aligns=$a;
		}

		function Row($data)
		{
		    //Calculate the height of the row
		    $nb=0;
		    for($i=0;$i<count($data);$i++)
		        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		    $h=8*$nb;
		    //Issue a page break first if needed
		    $this->CheckPageBreak($h);
		    //Draw the cells of the row
		    for($i=0;$i<count($data);$i++)
		    {
		        $w=$this->widths[$i];
		        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		        //Save the current position
		        $x=$this->GetX();
		        $y=$this->GetY();
		        //Draw the border
		        $this->Rect($x,$y,$w,$h);
		        //Print the text
		        $this->MultiCell($w,8,$data[$i],0,$a);
		        //Put the position to the right of the cell
		        $this->SetXY($x+$w,$y);
		    }
		    //Go to the next line
		    $this->Ln($h);
		}

		function CheckPageBreak($h)
		{
		    //If the height h would cause an overflow, add a new page immediately
		    if($this->GetY()+$h>$this->PageBreakTrigger)
		        $this->AddPage($this->CurOrientation);
		}

		function NbLines($w,$txt)
		{
		    //Computes the number of lines a MultiCell of width w will take
		    $cw=&$this->CurrentFont['cw'];
		    if($w==0)
		        $w=$this->w-$this->rMargin-$this->x;
		    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		    $s=str_replace("\r",'',$txt);
		    $nb=strlen($s);
		    if($nb>0 and $s[$nb-1]=="\n")
		        $nb--;
		    $sep=-1;
		    $i=0;
		    $j=0;
		    $l=0;
		    $nl=1;
		    while($i<$nb)
		    {
		        $c=$s[$i];
		        if($c=="\n")
		        {
		            $i++;
		            $sep=-1;
		            $j=$i;
		            $l=0;
		            $nl++;
		            continue;
		        }
		        if($c==' ')
		            $sep=$i;
		        $l+=$cw[$c];
		        if($l>$wmax)
		        {
		            if($sep==-1)
		            {
		                if($i==$j)
		                    $i++;
		            }
		            else
		                $i=$sep+1;
		            $sep=-1;
		            $j=$i;
		            $l=0;
		            $nl++;
		        }
		        else
		            $i++;
		    }
		    return $nl;
		}

	}
		
	$euro = iconv('UTF-8', 'windows-1252', '€');
	$pdf = new PDF();
	$pdf->AddPage('P','A4');
	$pdf->SetTitle('Documento_' . $id);
	$pdf->Image("images/logo-azienda.png",77,3,55);
	$pdf->Ln(48);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(189,10,'DOCUMENTO DI ' . strtoupper($documento['tipologia']),0,1,'C',false);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(189,8,'Numero Documento: ' . $documento[0] . ' del ' . $c->dataSlash($documento[1]),0,1,'L',false);
	if($documento[3]) 
	{
		$pdf->Cell(189,8,'Riferimento: ' . $documento[3] . ' del ' . $c->dataSlash($documento[5]),0,1,'L',false);
	}
	$pdf->Cell(189,8,'Magazzino: '. $documento[2] . ' - ' . $s->getServizioById($documento[2]) ,0,1,'L',false);
	$pdf->Cell(189,8,'Causale: ' . ucwords($documento[4]),0,1,'L',false);

	$pdf->Ln(6);
	$pdf->Cell(25,8,'Cod.',1,0,'L',false);
	$pdf->Cell(100,8,'Descrizione',1,0,'L',false);
	$pdf->Cell(25,8,'Q.ta\'',1,0,'L',false);
	$pdf->Cell(39,8,'Costo',1,1,'L',false);

	$res = $m->righeDocumento($id);
	$tot = 0;
	$prod = 0;
	$pdf->SetWidths(array(25,100,25,39));	
	foreach($res as $val) 
	{
		$prezzo = $p->getPrezzo($val['codice']) * $val['quantita'];
		$tot = $tot + $prezzo;
		$prod++;
		$pdf->Row(array($val['codice'], strtoupper($val['descrizione']), $val['quantita'], $euro . ' ' . number_format($prezzo, 2,",",".")));

	}
	$pdf->Ln(4);
	$pdf->Cell(94.5,8,'Prodotti nel documento: ' . $prod,0,0,'L',false);
	$pdf->Cell(94.5,8,'Totale Documento: ' . $euro . ' ' . number_format($tot, 2,",","."),0,1,'R',false);
	$pdf->Output('Documento_'.$id.'_'.time().'.pdf','I');
?>