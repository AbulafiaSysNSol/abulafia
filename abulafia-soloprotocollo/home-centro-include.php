<div id="primarycontent">
		
			<div class="post">
				
				<div class="header">
					<h3><?php echo $_SESSION['nomeapplicativo'];?><sup><?php echo $_SESSION['version'];?></sup>: saper conservare, saper ritrovare</h3>
				</div>
				
				<div class="content">
					<p><strong>Si evolvono gli uffici,</strong> pubblici e privati, per stare al passo con i tempi e con le rinnovate esigenze di gestione amministrativa e del personale. <?php echo $_SESSION['nomeapplicativo'];?> vuole essere un piccolo contributo, aperto a chiunque abbia voglia di suggerire miglioramenti, per la gestione degli affari correnti delle segreterie dei volontari della CRI.</p>
				</div>
					
			</div>

			<div class="post">
			
				<div class="header">
					<h3>Stats:</h3>
				</div>
				
				<div class="content">
					
					<p><?php 
					
					$annoprotocollo = $_SESSION['annoprotocollo'];
					
						$statslettere=mysql_query("select count(*) from lettere$annoprotocollo");
						$res_lettere = mysql_fetch_row($statslettere);
						echo 'Nell\'anno corrente sono state registrate '.$res_lettere[0].' lettere.';?></p>

						<p><?php 
						if ($res_lettere[0] > 0) {
						$statsusers1=mysql_query("select distinct * from users");
						echo 'In dettaglio: <br>';
						while ($statsusers2= mysql_fetch_array($statsusers1)) {
						$statsusers2a=$statsusers2['idanagrafica'];
						$statsusers3 = mysql_query("select count(*) from joinlettereinserimento$annoprotocollo where joinlettereinserimento$annoprotocollo.idinser = '$statsusers2a'");
						$res_statsusers3 = mysql_fetch_row($statsusers3);
						if ($res_statsusers3[0] > 0) {
						echo $res_statsusers3[0].' inserite da '.$statsusers2['loginname'].'<br>';
						}
						}
						}?></p>

					<p><?php $statsanagrafica=mysql_query("select count(*) from anagrafica");
						$res_anagrafica = mysql_fetch_row($statsanagrafica);
						echo 'Nella tabella ANAGRAFICA sono presenti '.$res_anagrafica[0].' occorrenze, di cui<br>';
						$my_anagrafica->publcontaanagrafica('persona');
						echo $my_anagrafica->contacomponenti.' persone fisiche<br>';
						$my_anagrafica->publcontaanagrafica('carica');
						echo $my_anagrafica->contacomponenti.' cariche o incarichi<br>';
					    ?>
					
					</p>

				</div>	
			</div>

			<div class="post">
				<div class="header">
					<h3>Log degli ultimi 3 accessi:</h3>
				</div>
				
				<div class="content">
					<p><?php $my_log -> publleggilog('1', '3', 'login', $_SESSION['logfile']); //legge dal log degli accessi ?></p>
				</div>
	
			</div>

</div>