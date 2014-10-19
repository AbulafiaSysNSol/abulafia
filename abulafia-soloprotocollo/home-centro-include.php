<?php
	include("lib/pchart/pChart/pData.class");  
	include("lib/pchart/pChart/pChart.class"); 
	
	if(isset($_GET['pass']) && ($_GET['pass'] == 1)) {
		echo '<center><div class="alert alert-warning"><h3><b><i class="fa fa-exclamation-triangle"></i> Attenzione:</b> non hai ancora modificato la tua password di default!</h3>
			Per questioni di sicurezza ti invitiamo a cambiarla al più presto. <a href="?corpus=cambio-password&loginid='. $_SESSION['loginid'] . '">Cambia la tua password ora</a></div></center>';
	}
	
	$data = new Calendario();
	$lettera = new Lettera();
	
	$anno = $_SESSION['annoprotocollo'];
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$statslettere=mysql_query("select count(*) from lettere$annoprotocollo where datalettera != '0000/00/00'");
	$res_lettere = mysql_fetch_row($statslettere);
	$ultimoprot = $lettera->ultimoId($anno);
	
	//patch protocolli saltati
	if ($_SESSION['auth'] < 90) {
		$protocollatore = $_SESSION['loginid'];
		$query_prot_count = mysql_query("SELECT COUNT(lettere$anno.idlettera) FROM lettere$anno, joinlettereinserimento$anno WHERE lettere$anno.oggetto = '' AND joinlettereinserimento$anno.idinser = $protocollatore AND lettere$anno.idlettera = joinlettereinserimento$anno.idlettera");
		$query_prot = mysql_query("SELECT lettere$anno.idlettera FROM lettere$anno, joinlettereinserimento$anno WHERE lettere$anno.oggetto = '' AND joinlettereinserimento$anno.idinser = $protocollatore AND lettere$anno.idlettera = joinlettereinserimento$anno.idlettera ORDER BY lettere$anno.idlettera ASC");
	}
	else {
		$query_prot_count = mysql_query("SELECT idlettera FROM lettere$anno WHERE lettere$anno.oggetto = '' ");
		$query_prot = mysql_query("SELECT idlettera FROM lettere$anno WHERE lettere$anno.oggetto = '' ORDER BY lettere$anno.idlettera ASC");
	}
	
	$result = mysql_fetch_row($query_prot_count);
	
	if ($result[0] > 0) {
		?>
		<center><div class="alert alert-danger"><b><h3><i class="fa fa-exclamation-triangle"></i> Attenzione:</b> ci sono delle lettere <b>non</b> registrate correttamente!!!</h3>
		Clicca sui numeri per continuare la registrazione: 
		<?php
		while ($idprot = mysql_fetch_array($query_prot)){
			?>
			<a href="?corpus=modifica-protocollo&from=correggi&id=<?php echo $idprot['idlettera']; ?>"><?php echo $idprot['idlettera'].';'; ?> 
			<?php
		}
		?>
		</a></div></center>
		<?php
	}
	
	if (isset($_GET['firma']) &&($_GET['firma'] == 'ok')) {
		?>
		<center><div class="alert alert-success"><h3><i class="fa fa-check"></i> Lettera sottoposta alla firma <b>correttamente!</b></h3></div></center>
		<?php
	}
	
	if (isset($_GET['aggiornamento']) &&($_GET['aggiornamento'] == 'ok')) {
		?>
		<center><div class="alert alert-info">
			<h3><b><i class="fa fa-refresh"></i> Aggiornamento di Sistema</b></h3>
			<h4>E' stato rilasciato un aggiornamento di sistema riguardante la composizione delle lettere.
			<br>
			<br>E' possibile da oggi infatti comporre le lettere direttamente da Abulafia, attraverso il menu "Lettere" nella barra in alto.
			</h4>
			<small>Se notate anomalie o malfunzionamenti comunicateceli mediante la <a href="login0.php?corpus=segnala-bug">pagina di segnalazione errori.</a></small>
		</center>
		<?php
	}
	?>
	
<hr>
	<center>
		<h2>
			<i class="fa fa-calendar"></i>  Anno:<b> <?php echo $anno; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-book"></i>  Numero di protocollo attuale:<b> <?php echo $ultimoprot; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-text-o"></i>  Lettere registrate:<b> <?php echo $res_lettere[0]; ?></b>
		</h2>
	</center>
<hr>

<div class="row">
	<div class="col-xs-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><span class="glyphicon glyphicon-stats"></span> Stats:</strong></h3>
			</div>
			
			<div class="panel-body">
				<p><?php 
				//Utilizzo Abulafia
				$anniusoapplicazione = (strtotime("now") - strtotime("2008/4/1"))/60/60/24/365;
				$giorniusoapplicazione = ((strtotime("now") - strtotime("2008/4/1"))/60/60/24)-(int)$anniusoapplicazione*365;
				
				echo 'La Web-Application Abulafia e\' in uso da '; 
				
				if( (int)$anniusoapplicazione > 0) { 
					echo (int)$anniusoapplicazione . ' anni e ' .(int)$giorniusoapplicazione.' giorni.'; 
				} 
				else { 
					echo (int)$giorniusoapplicazione.' giorni.'; 
				} 
				
				?>
				</p>
				
				<p><?php 
				//Utilizzo Catania
				$anniusoapplicazione = (strtotime("now") - strtotime("2014/6/4"))/60/60/24/365;
				$giorniusoapplicazione = ((strtotime("now") - strtotime("2014/6/4"))/60/60/24)-(int)$anniusoapplicazione*365;
				echo $_SESSION['nomeapplicativo'] . ' e\' in uso da '; 
				
				if( (int)$anniusoapplicazione > 0) { 
					echo (int)$anniusoapplicazione . ' anni e ' .(int)$giorniusoapplicazione.' giorni.'; 
				} 
				else { 
					echo (int)$giorniusoapplicazione.' giorni.'; 
				} 
				
				?>
				</p>

					<p>

					<?php 
						$DataSet = new pData;  
						 
						if ($res_lettere[0] > 0) {
							$statsusers1=mysql_query("SELECT COUNT(joinlettereinserimento$anno.idinser) AS numerolettere, anagrafica.cognome, anagrafica.nome FROM anagrafica, joinlettereinserimento$anno WHERE  joinlettereinserimento$anno.idinser = anagrafica.idanagrafica AND datamod != '0000/00/00' GROUP BY anagrafica.idanagrafica ORDER BY numerolettere DESC");
							echo mysql_error();
							echo 'Dettaglio lettere registrate: <br>';
							while ($statsusers2= mysql_fetch_array($statsusers1)) {
									$statsusers2 = array_map('stripslashes', $statsusers2);
									echo $statsusers2['numerolettere'] . ' inserite da '. ucwords(strtolower($statsusers2['nome'] . ' ' . $statsusers2['cognome'])) . '<br>';
									$DataSet->AddPoint($statsusers2['numerolettere'],"Serie1");  
									$DataSet->AddPoint(ucwords(strtolower($statsusers2['nome'] . ' ' . $statsusers2['cognome'])),"Serie2");
							}

							$DataSet->AddAllSeries();  
							$DataSet->SetAbsciseLabelSerie("Serie2");  
							 
							// Initialise the graph  
							$Test = new pChart(450,200);  
							$Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);  
							$Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);  
							  
							// Draw the pie chart  
							$Test->setFontProperties("lib/pchart/Fonts/tahoma.ttf",8);  
							$Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
							$Test->drawPieLegend(310,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
							  
							$Test->Render("graphs/homegraph.png");  
							
						}

					?>
					</p>
	
					<center><img src="graphs/homegraph.png"></center><br>
		
					<?php

						$DataSet = new pData;
						
						$statsanagrafica=mysql_query("select count(*) from anagrafica");
						$res_anagrafica = mysql_fetch_row($statsanagrafica);
						echo 'Nella tabella ANAGRAFICA sono presenti '.($res_anagrafica[0] - 1) .' occorrenze, di cui<br>';
						
						$my_anagrafica->publcontaanagrafica('persona');
						echo $my_anagrafica->contacomponenti.' Persone Fisiche<br>';
						$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie1");
						
						$my_anagrafica->publcontaanagrafica('carica');
						echo $my_anagrafica->contacomponenti.' Cariche o Incarichi<br>';
						$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie2");
						
						$my_anagrafica->publcontaanagrafica('ente');
						echo $my_anagrafica->contacomponenti.' Enti<br>';
						$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie3");
						
						$my_anagrafica->publcontaanagrafica('fornitore');
						echo $my_anagrafica->contacomponenti.' Fornitori';
						$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie4");
						  
						$DataSet->AddAllSeries();  
						$DataSet->SetSerieName("Persone Fisiche","Serie1");  
						$DataSet->SetSerieName("Cariche o Incarichi","Serie2");  
						$DataSet->SetSerieName("Enti","Serie3");
						$DataSet->SetSerieName("Fornitori","Serie4");
						  
						// Initialise the graph  
						$Test = new pChart(500,230);  
						$Test->setFontProperties("lib/pchart/Fonts/tahoma.ttf",8);  
						$Test->setGraphArea(50,30,400,200);  
						$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);  
						$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);  
						$Test->drawGraphArea(255,255,255,TRUE);  
						$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
						$Test->drawGrid(4,TRUE,230,230,230,50);  
						  
						// Draw the 0 line  
						$Test->setFontProperties("lib/pchart/Fonts/tahoma.ttf",6);  
						$Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
						  
						// Draw the bar graph  
						$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
						  
						// Finish the graph  
						$Test->setFontProperties("lib/pchart/Fonts/tahoma.ttf",8);  
						$Test->drawLegend(370,15,$DataSet->GetDataDescription(),255,255,255);  
						$Test->setFontProperties("lib/pchart/Fonts/tahoma.ttf",10);  
						$Test->Render("graphs/anagrafica.png");  
						
					?>
					
					<br><br>
					<center><img src="graphs/anagrafica.png"></center>
			</div>
		</div>
	</div>

	<div class="col-xs-6">
		
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-hdd-o"></i> Quota su disco</strong></h3>
			</div>
			
			<div class="panel-body">
				<?php
				$file = new File();
				$dim =  round($file->sizeDirectory("../public/") / (1024*1024), 2) ;
				$max = 2000000;
				$percentuale = ( $dim / $max ) * 100;
				if($percentuale <=50)
					$class = "progress-bar-success";
				else if($percentuale <=80)
					$class = "progress-bar-warning";
				else
					$class = "progress-bar-danger";
				?>
				<div class="progress">
					<div class="progress-bar <?php echo $class; ?>" role="progressbar" aria-valuenow="<?php echo $dim; ?>" aria-valuemin="0" aria-valuemax="<?php echo $max; ?>" style="width: <?php echo $percentuale; ?>%;">
					</div>
				</div>
				<center><?php echo $dim.' MB su 2 TB (' . round($percentuale,3).'%)'; ?></center>
			</div>
		
		</div>
		
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-list-ul"></i> Ultimi protocolli registrati:</strong></h3>
			</div>
			
			<div class="panel-body">
				<?php
					$risultati = $lettera->ultimeLettere(5, $anno);
				?>
				<table class="table table-striped">
				<?php
				if($risultati) {
					echo "<tr><td></td><td><b>NUM.</b></td><td><b>DATA</b></td><td><b>OGGETTO</b></td><td></td></tr>";
					foreach ($risultati as $val) {
						if($val[3]=='spedita') {
							$icon = '<i class="fa fa-arrow-up"></i>';
						}
						else {
							$icon = '<i class="fa fa-arrow-down"></i>';
						}
						echo "<tr><td>".$icon."</td><td>".$val[0]."</td><td>".$data->dataSlash($val[1])."</td><td>".$val[2]."</td>
							<td width='55'><a href=\"?corpus=dettagli-protocollo&id=".$val[0]."&anno=".$anno."\">Vai <i class=\"fa fa-share\"></i></td></tr>";
					}
				}
				?>
				</table>
			</div>
		
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><span class="glyphicon glyphicon-calendar"></span> Log degli ultimi 3 accessi:</strong></h3>
			</div>
					
			<div class="panel-body">
				<p><?php $my_log -> publleggilog('1', '3', 'login', $_SESSION['logfile']); //legge dal log degli accessi ?></p>
			</div>
		</div>
		
	</div>
	
</div>

<?php
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO HOME' , 'OK' , $_SESSION['ip'], $_SESSION['historylog']);
?>