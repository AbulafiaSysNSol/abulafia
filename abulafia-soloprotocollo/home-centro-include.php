<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-inbox"></span> <strong><?php echo $_SESSION['nomeapplicativo'] .' ' . $_SESSION['version'];?>: saper conservare, saper ritrovare.</strong></h3>
		</div>
		<div class="panel-body">
			<p>
			Si evolvono gli uffici, pubblici e privati, per stare al passo con i tempi e con le rinnovate esigenze di gestione amministrativa
			e del personale.<br><?php echo $_SESSION['nomeapplicativo'];?> vuole essere un piccolo contributo, aperto a chiunque abbia voglia di suggerire 
			miglioramenti, per la gestione degli affari correnti delle segreterie dei volontari della CRI.
			<br>Chiunque fosse interessato al progetto, puo' contattare l'amministratore del sito all'indirizzo email <strong><?php echo $_SESSION['email']; ?></strong> <span class="glyphicon glyphicon-envelope"></span></p>
			<div class="text-right"><small>03 dicembre 2008</small></div>
		</div>
		
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-stats"></span> Stats:</strong></h3>
		</div>
		<div class="panel-body">
		
			<p><?php 
                        $anniusoapplicazione = (strtotime("now") - strtotime("apr 1 2008"))/60/60/24/365;
                        $giorniusoapplicazione = ((strtotime("now") - strtotime("apr 1 2008"))/60/60/24)-(int)$anniusoapplicazione*365;
                        echo 'Questa web-application e\' in uso da '.(int)$anniusoapplicazione.' anni e '.(int)$giorniusoapplicazione.' giorni.';?></p>
		
			<p><?php 
				$annoprotocollo = $_SESSION['annoprotocollo'];
			
				$statslettere=mysql_query("select count(*) from lettere$annoprotocollo");
				$res_lettere = mysql_fetch_row($statslettere);
				echo 'Nell\'anno corrente sono state registrate '.($res_lettere[0]) .' lettere.';?></p>

				<p><?php 
				if ($res_lettere[0] > 0) {
				$statsusers1=mysql_query("select distinct * from users");
				echo 'In dettaglio: <br>';
				while ($statsusers2= mysql_fetch_array($statsusers1)) {
				$statsusers2a=$statsusers2['idanagrafica'];
				$statsusers3 = mysql_query("select count(*) from joinlettereinserimento$annoprotocollo where joinlettereinserimento$annoprotocollo.idinser = '$statsusers2a'");
				$res_statsusers3 = mysql_fetch_row($statsusers3);
				if ($res_statsusers3[0] > 0) {
				echo ($res_statsusers3[0]).' inserite da '.$statsusers2['loginname'].'<br>';
				}
				}
				}?></p>

				<p><?php $statsanagrafica=mysql_query("select count(*) from anagrafica");
				$res_anagrafica = mysql_fetch_row($statsanagrafica);
				echo 'Nella tabella ANAGRAFICA sono presenti '.($res_anagrafica[0] - 1) .' occorrenze, di cui<br>';
				$my_anagrafica->publcontaanagrafica('persona');
				echo $my_anagrafica->contacomponenti.' persone fisiche<br>';
				$my_anagrafica->publcontaanagrafica('carica');
				echo $my_anagrafica->contacomponenti.' cariche o incarichi<br>';
			    ?>
			
			</p>
		</div>
		
		<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-calendar"></span> Log degli ultimi 5 accessi:</strong></h3>
		</div>
		<div class="panel-body">
			<p><?php $my_log -> publleggilog('1', '5', 'login', $_SESSION['logfile']); //legge dal log degli accessi ?></p>
		</div>
		
	</div>
