<?php
	$reg = new Registroprotocollo();
	$log = new Log();
	$anni = $reg->getAnni();
	$anniusoapplicazione = (strtotime("now") - strtotime($_SESSION['inizio']))/60/60/24/365;
	$giorniusoapplicazione = ((strtotime("now") - strtotime($_SESSION['inizio']))/60/60/24)-(int)$anniusoapplicazione*365;
	$lettere = mysql_query("SELECT COUNT(*) FROM comp_lettera");
	$numlettere = mysql_fetch_row($lettere);
	$allegati = mysql_query("SELECT COUNT(*) FROM joinlettereallegati");
	$numallegati = mysql_fetch_row($allegati);
	$utenti = mysql_query("SELECT COUNT(*) FROM users");
	$numutenti = mysql_fetch_row($utenti);
	$anagrafiche = mysql_query("SELECT COUNT(*) FROM anagrafica");
	$numanagrafiche = mysql_fetch_row($anagrafiche);
	$email = mysql_query("SELECT COUNT(*) FROM mailsend");
	$numemail = mysql_fetch_row($email);
	$numaccessi = $log->contaLog("access.log");
	$numprot = 0;
	$numanni = array();
	foreach($anni as $annoprot) {
		$lettere = mysql_query("SELECT COUNT(*) FROM lettere$annoprot");
		$numlett = mysql_fetch_row($lettere);
		$numprot = $numprot + $numlett[0];
		$numanni[$annoprot] = $numlett[0];
	}
?>

<?php 

	include("lib/pchart/pChart/pData.class");  
	include("lib/pchart/pChart/pChart.class"); 

	$anno = $_SESSION['annoprotocollo'];

	//grafico protocollo
	$DataSet = new pData;  
						 
		$statsusers1=mysql_query("SELECT COUNT(joinlettereinserimento$anno.idinser) AS numerolettere, anagrafica.cognome, anagrafica.nome FROM anagrafica, joinlettereinserimento$anno WHERE  joinlettereinserimento$anno.idinser = anagrafica.idanagrafica AND datamod != '0000/00/00' GROUP BY anagrafica.idanagrafica ORDER BY numerolettere DESC");
		while ($statsusers2= mysql_fetch_array($statsusers1)) {
				$statsusers2 = array_map('stripslashes', $statsusers2);
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

	//grafico anagrafica
	$DataSet = new pData;
						
	$statsanagrafica=mysql_query("select count(*) from anagrafica");
	$res_anagrafica = mysql_fetch_row($statsanagrafica);
						
	$my_anagrafica->publcontaanagrafica('persona');
	$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie1");
					
	$my_anagrafica->publcontaanagrafica('carica');
	$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie2");
						
	$my_anagrafica->publcontaanagrafica('ente');
	$DataSet->AddPoint($my_anagrafica->contacomponenti,"Serie3");
	
	$my_anagrafica->publcontaanagrafica('fornitore');
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

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-bar-chart"></i> Un po' di numeri di <?php echo $_SESSION['nomeapplicativo'] . ' - ' . $_SESSION['headerdescription'];?></strong></h3>
	</div>
			
	<div class="panel-body">
		<label><i class="fa fa-line-chart fa-fw"></i> Statistiche sull'utilizzo del software:</label><br><br>
		<div class="row">
			<center>
			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-hourglass-half"></i></h2>
					<?php 
						echo 'Abulafia Web<br>e\' in uso da:<h4><b>'; 
						if( (int)$anniusoapplicazione > 0) { 
							echo (int)$anniusoapplicazione . ' anni e ' .(int)$giorniusoapplicazione.' giorni</b></h3>'; 
						} 
						else { 
							echo (int)$giorniusoapplicazione.' giorni</b></h4>;'; 
						} 
					?>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-book"></i></h2>
					Numero di protocolli registrati nel sistema: 
					<h4><b><?php echo $numprot; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-file-text-o"></i></h2>
					Numero di lettere scritte dal sistema: 
					<h3><b><?php echo $numlettere[0]; ?></b></h3>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-paperclip"></i></h2>
					File allegati ai protocolli caricati nel sistema: 
					<h3><b><?php echo $numallegati[0]; ?></b></h3>
				</div>
			</div>
			</center>
		</div>

		<div class="row">
			<center>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-id-card"></i></h2>
					Anagrafiche registrate nel sistema: 
					<h4><b><?php echo $numanagrafiche[0]; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-users"></i></h2>
					Utenti abilitati all'utilizzo del software: 
					<h4><b><?php echo $numutenti[0] - 1; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-warning">
					<h2><i class="fa fa-sign-in"></i></h2>
					Numero di accessi eseguiti nel sistema: 
					<h4><b><?php echo $numaccessi; ?></b></h4>
				</div>
			</div>

			<div class="col-sm-3">
				<div class="alert alert-info">
					<h2><i class="fa fa-envelope"></i></h2>
					Numero di email inviate dal sistema: 
					<h4><b><?php echo $numemail[0]; ?></b></h4>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-6">
				<label><i class="fa fa-bar-chart fa-fw"></i> Grafico delle tipologie di anagrafica:</label><br><br>
				<center><img src="graphs/anagrafica.png" width="100%"></center><br>
			</div>
			<div class="col-sm-6">
				<label><i class="fa fa-pie-chart fa-fw"></i> Grafico degli utenti che hanno effettuato registrazioni nel protocollo:</label><br><br>
				<center><img src="graphs/homegraph.png" width="100%"></center><br>
			</div>
		</div>
	</div>
</div>