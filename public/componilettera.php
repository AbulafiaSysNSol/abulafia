<?php
	session_start();

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php'; //connessione al db-server
	include "class/Calendario.obj.inc";
	$immagine = "images/footerlettere.jpg";
	$dimensioni = getimagesize($immagine);
	$altezza = (($dimensioni[1] / 150) * 25.4) + 0.3;
	$calendario = new Calendario();
	$margin = 470 - ((strlen($_SESSION["denominazione"]) / 2) * 4.3);
	$id = $_GET['id'];
	if(isset($_GET['from'])) {
		$from = $_GET['from'];
	}
	else {
		$from = '';
	}
	$cerca = mysql_query("SELECT * FROM comp_lettera WHERE id = $id");

	while($risultati = mysql_fetch_array($cerca)) {
		$allegati = $risultati['allegati'];
		$oggetto = stripslashes($risultati['oggetto']);
		$testo = stripslashes($risultati['testo']);
		$data = $calendario->dataSlash($risultati['data']);
		$firma = $risultati['firmata'];
		$protocollo = $risultati['protocollo'];
		$anno = $risultati['anno'];
		$ufficio = $risultati['ufficio'];
		if($protocollo != 0) {
			$data2 = mysql_query("SELECT dataregistrazione FROM lettere$anno WHERE idlettera = $protocollo");
			$data3 = mysql_fetch_row($data2);
			$dataprot = $calendario->dataSlash($data3[0]);
		}
	}
	$firme = mysql_query("SELECT * FROM uffici WHERE id = $ufficio");
	$firmeresult = mysql_fetch_array($firme);
	$firmagrafo = $firmeresult['firma'];
	$firmagrafoprova = $firmeresult['firmaprova'];
	if (($allegati == '') OR ($allegati == 0)) {
		$allegati = '/';
	}
	require('lib/html2pdf/html2pdf.class.php');
	$content = '
	<page backtop="35mm" backbottom="' . $altezza . 'mm" backleft="10mm" backright="10mm">
		
		<page_header>
			<img align="right" src="images/header'.$firmagrafo.'" width="700">
		</page_header>
		
		<page_footer>
			<img align="center" src="images/footerlettere.jpg" width="753">
		</page_footer>
		
		<span style="font-family: Times, Verdana, Georgia, Serif; font-size: 16;">
		
			<table style="vertical-align: top;" border="0" cellspacing="0">
				<tr>
					<td colspan="2" width="360">
						' . $_SESSION["sede"] . ', '.$data.'
						<br><br>';
						if($protocollo != 0) {
							$content = $content.'<br>Protocollo n&ordm; <b>'.$protocollo.'</b> del <b>'.$dataprot.'</b><br><br>';
						}
						else {
							$content = $content.'<br>Protocollo n&ordm; ________ del ______________<br><br>';
						}
						$content = $content.'
						Allegati: '.$allegati.'<br><br><br>
					</td>
					
					<td rowspan="2" width="305">
						<br><br>
						<table style="vertical-align: top;" border="0">';
							
							$destlettera = '';
							//destinatari
							$dest = mysql_query("SELECT anagrafica.cognome, anagrafica.nome, comp_destinatari.attributo, comp_destinatari.riga1, comp_destinatari.riga2
											FROM anagrafica, comp_destinatari
											WHERE comp_destinatari.idlettera = $id
											AND comp_destinatari.idanagrafica = anagrafica.idanagrafica
											AND comp_destinatari.conoscenza = 0 ");echo mysql_error();
							while($destinatari=mysql_fetch_array($dest)) {
								$destinatari = array_map('stripslashes', $destinatari);
								if($destinatari['attributo'] == 'Al Volontario') {
									$destlettera = $destlettera. '<tr>	<td width="60"> Al</td>
															<td width="208">Volontario '.$destinatari['cognome'] . ' ' . $destinatari['nome'];
															if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
															if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
															$destlettera = $destlettera . '<br><br>
															</td>
														</tr>';
								}
								else if($destinatari['attributo'] == 'Alla Volontaria') {
									$destlettera = $destlettera. '<tr>	<td width="60"> Alla</td>
															<td width="208">Volontaria '.$destinatari['cognome'] . ' ' . $destinatari['nome'];
															if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
															if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
															$destlettera = $destlettera . '<br><br>
															</td>
														</tr>';
								}
								else if($destinatari['attributo'] == 'Ai Volontari') {
									$destlettera = $destlettera. '<tr>	<td width="60"> Ai</td>
															<td width="208">Volontari:<br><br>'.$destinatari['cognome'] . ' ' . $destinatari['nome'];
															if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
															if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
															$destlettera = $destlettera . '<br><br>
															</td>
														</tr>';
								}
								else {
									$destlettera = $destlettera. '<tr>	<td width="60"> '.$destinatari['attributo'].'</td>
															<td width="208">'.$destinatari['cognome'] . ' ' . $destinatari['nome'];
															if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
															if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
															$destlettera = $destlettera . '<br><br>
															</td>
														</tr>';
								}
							}
				
							//destinatari x conoscenza
							$dest2 = mysql_query("SELECT anagrafica.cognome, anagrafica.nome, comp_destinatari.attributo, comp_destinatari.riga1, comp_destinatari.riga2
											FROM anagrafica, comp_destinatari
											WHERE comp_destinatari.idlettera = $id
											AND comp_destinatari.idanagrafica = anagrafica.idanagrafica
											AND comp_destinatari.conoscenza = 1 ");

							$count = mysql_query("SELECT COUNT(anagrafica.idanagrafica)
											FROM anagrafica, comp_destinatari
											WHERE comp_destinatari.idlettera = $id
											AND comp_destinatari.idanagrafica = anagrafica.idanagrafica
											AND comp_destinatari.conoscenza = 1 ");
							$num=mysql_fetch_row($count);
							if($num[0]>0) {
								$destlettera = $destlettera. '<tr>	<td width="60">E, p.c.</td>
															<td width="208"><br><br>
															</td>
														<br><br>
													</tr>';
								while($destinatari=mysql_fetch_array($dest2)) {
									$destinatari = array_map('stripslashes', $destinatari);
									if($destinatari['attributo'] == 'Al Volontario') {
									$destlettera = $destlettera. '<tr>	<td width="60"> Al</td>
															<td width="208">Volontario '.$destinatari['cognome'] . ' ' . $destinatari['nome'];
															if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
															if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
															$destlettera = $destlettera . '<br><br>
															</td>
														</tr>';
									}
									else if($destinatari['attributo'] == 'Alla Volontaria') {
										$destlettera = $destlettera. '<tr>	<td width="60"> Alla</td>
																<td width="208">Volontaria '.$destinatari['cognome'] . ' ' . $destinatari['nome'];
																if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
																if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
																$destlettera = $destlettera . '<br><br>
																</td>
															<br><br>
															</tr>';
									}
									else if($destinatari['attributo'] == 'Ai Volontari') {
										$destlettera = $destlettera. '<tr>	<td width="60"> Ai</td>
																<td width="208">Volontari:<br><br>'.$destinatari['cognome'] . ' ' . $destinatari['nome'];
																if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
																if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
																$destlettera = $destlettera . '<br><br>
																</td>
															</tr>';
									}
									else {
										$destlettera = $destlettera. '<tr>	<td width="60"> '.$destinatari['attributo'].'</td>
																<td width="208">'.$destinatari['cognome'] . ' ' . $destinatari['nome'];
																if($destinatari['riga1'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga1']; } 
																if($destinatari['riga2'] != '') { $destlettera = $destlettera . '<br>' . $destinatari['riga2']; }
																$destlettera = $destlettera . '<br><br>
																</td>
															</tr>';
									}
								}
							}
							
							$content = $content.$destlettera;
							$content = $content.'
						</table>
					</td>
				</tr>
				<tr>
					<td width="58">
						<b>Oggetto</b>:
					</td>
					<td width="312">
						<div style="text-align: left; margin-right: 15px; line-height: 1.3;">'.str_replace('<p>', '', str_replace('</p>', '', $oggetto)).'</div>
					</td>
				</tr>
			</table>
			<br>
			<span style="line-height: 1.5">'.$testo.'</span><br>';
			
					if($firma == 1) {
						$content = $content.'	<div style="margin-left: 350px;">
											<img src="../'. $_SESSION['signaturepath'] . '/' . $firmagrafo .'" width="280">
										</div>';
					}
					else {
						$content = $content.' <div style="margin-left: 350px;">
											<img src="../' . $firmagrafoprova.'" width="280">
										</div>';
					}
					$content = $content.'
		</span>
	</page>';

	$html2pdf = new HTML2PDF('P','A4','it');
	$html2pdf->setDefaultFont("times");
	$html2pdf->WriteHTML($content);

	if($from == 'protocolla-lettera') {
		if (!is_dir("lettere$anno/".$protocollo)) { 
			mkdir("lettere$anno/".$protocollo, 0777, true);
		}
		$name = time() . '.pdf';
		$insert = mysql_query("INSERT INTO joinlettereallegati VALUES ('$protocollo', '$anno', '$name')");
		$html2pdf->Output('lettere'.$anno.'/'.$protocollo.'/'.$name,'F');
		header("Location: login0.php?corpus=dettagli-protocollo&id=".$protocollo."&anno=".$anno);
	}
	else {
		ob_end_clean();
		$html2pdf->Output('lettera'.$id.'.pdf', 'I');
	}
	
?>