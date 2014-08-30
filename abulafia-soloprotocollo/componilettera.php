<?php
	session_start();
	include '../db-connessione-include.php'; //connessione al db-server
	include "class/Calendario.obj.inc";
	$calendario = new Calendario();
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
		if($protocollo != 0) {
			$data2 = mysql_query("SELECT dataregistrazione FROM lettere$anno WHERE idlettera = $protocollo");
			$data3 = mysql_fetch_row($data2);
			$dataprot = $calendario->dataSlash($data3[0]);
		}
	}
	if (($allegati == '') OR ($allegati == 0)) {
		$allegati = '/';
	}
	require('lib/html2pdf/html2pdf.class.php');
	$content = '
	<page backtop="35mm" backbottom="55mm" backleft="10mm" backright="10mm">
		
		<page_header>
			<img align="right" src="images/headerlettere2.jpg" width="700">
		</page_header>
		
		<page_footer>
			<img align="center" src="images/footerlettere.jpg" width="753">
		</page_footer>
		
		<div style="font-size: 15;">
		
		<table border="0" cellspacing="0">
			<tr>
				<td colspan="2" width="380">
					Catania, '.$data.'
					<br><br><br>';
					if($protocollo != 0) {
						$content = $content.'Protocollo n&ordm; '.$protocollo.' del '.$dataprot.'<br><br>';
					}
					else {
						$content = $content.'Protocollo n&ordm; ________ del ______________<br><br>';
					}
					$content = $content.'
					Allegati: '.$allegati.'<br><br><br>
				</td>
				
				<td rowspan="2" width="285">
					<br>
					<table border="0">';
						
						$destlettera = '';
						//destinatari
						$dest = mysql_query("	SELECT anagrafica.cognome, anagrafica.nome, comp_destinatari.attributo
										FROM anagrafica, comp_destinatari
										WHERE comp_destinatari.idlettera = $id
										AND comp_destinatari.idanagrafica = anagrafica.idanagrafica
										AND comp_destinatari.conoscenza = 0 ");echo mysql_error();
						while($destinatari=mysql_fetch_array($dest)) {
							$destinatari = array_map('stripslashes', $destinatari);
							if($destinatari['attributo'] == 'Al Volontario') {
								$destlettera = $destlettera. '<tr>	<td width="60">Al</td>
														<td width="208">Volontario '.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
														</td>
													<br><br>
													</tr>';
							}
							else if($destinatari['attributo'] == 'Alla Volontaria') {
								$destlettera = $destlettera. '<tr>	<td width="60">Alla</td>
														<td width="208">Volontaria '.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
														</td>
													<br><br>
													</tr>';
							}
							else if($destinatari['attributo'] == 'Ai Volontari') {
								$destlettera = $destlettera. '<tr>	<td width="60">Ai</td>
														<td width="208">Volontari '.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
														</td>
													</tr>';
							}
							else {
								$destlettera = $destlettera. '<tr>	<td width="60">'.$destinatari['attributo'].'</td>
														<td width="208">'.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
														</td>
													</tr>';
							}
						}
			
						//destinatari x conoscenza
						$dest2 = mysql_query("	SELECT anagrafica.cognome, anagrafica.nome, comp_destinatari.attributo
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
								$destlettera = $destlettera. '<tr>	<td width="60">Al</td>
														<td width="208">Volontario '.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
														</td>
													<br><br>
													</tr>';
								}
								else if($destinatari['attributo'] == 'Alla Volontaria') {
									$destlettera = $destlettera. '<tr>	<td width="60">Alla</td>
															<td width="208">Volontaria '.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
															</td>
														<br><br>
														</tr>';
								}
								else if($destinatari['attributo'] == 'Ai Volontari') {
									$destlettera = $destlettera. '<tr>	<td width="60">Ai</td>
															<td width="208">Volontari '.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
															</td>
														</tr>';
								}
								else {
									$destlettera = $destlettera. '<tr>	<td width="60">'.$destinatari['attributo'].'</td>
															<td width="208">'.$destinatari['cognome'] . ' ' . $destinatari['nome'].'<br><br>
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
				<td width="60">
					Oggetto:
				</td>
				<td width="310">
					<div style="margin-right: 10px;">'.str_replace('<p>', '', str_replace('</p>', '', $oggetto)).'</div>
				</td>
			</tr>
		</table>
		
		<br><br>
		'.$testo.'
		</div>
		<div style="font-size: 16;">
			<div style="margin-left: 500px;">
				IL PRESIDENTE';
				if($firma == 1) {
					$content = $content.'	</div>
									<div style="margin-left: 350px;">
									<img src="images/firma.png" width="400">';
				}
				$content = $content.'
			</div>
		</div>
	</page>';

	$html2pdf = new HTML2PDF('P','A4','it');
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