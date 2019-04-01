<?php

	$a = new Anagrafica();

	if( isset($_GET['from']) && $_GET['from'] == 'insert') {
		if($_GET['exist'] == "true") {
			?>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> <b>Errore:</b> il soggetto &egrave; gi&agrave; presente in anagrafica, controlla.</div>
					</div>
				</div>
			</div>
			<?php
			include 'sotto-include.php';
			exit();
		}
		else {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Anagrafica registrata <b>correttamente!</b></div>
				</div>
			</div>
			<?php
		}
	}
	if( isset($_GET['from']) && $_GET['from'] == 'modifica') {
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Anagrafica modificata <b>correttamente!</b></div>
			</div>
		</div>
		<?php
	}
	$level = $_SESSION['auth'];
	$id= $_GET['id'];
	$risultati = $connessione->query("SELECT * FROM anagrafica WHERE idanagrafica = '$id'");
	$risultati2 = $connessione->query("SELECT * FROM jointelefonipersone WHERE idanagrafica = '$id'");
	$countrecapiti = $connessione->query("SELECT COUNT(*) FROM jointelefonipersone WHERE idanagrafica = '$id'");
	$row = $risultati->fetch();
	$row = array_map ('stripslashes', $row);
	$data = $row['nascitadata'];
	list($anno, $mese, $giorno) = explode("-", $data);
	$datanascita = $giorno .'/'. $mese .'/'. $anno;
?>

<div class="row">
	<div class="col-sm-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-address-card-o"></i> Dettagli Anagrafica:</strong></h3>
			</div>
			
			<div class="panel-body">
				<table width="100%" border="0" style="border:solid 3px; border-color:#C0C0C0; background-repeat:repeat-x; background-position:top" cellspacing="0" background="images/dettagli/sfondo.png">
					<tr>
						<td width="170px" height="180px" style="background-repeat:no-repeat; background-position:center; padding:10px 5px 10px 5px" align="center">
							<img class="img-circle" src="<?php if($row['urlfoto']) {echo 'foto/'.$row['urlfoto'];} else {echo 'foto/sagoma.png';} ?>" width="145">
						</td>
					
						<td valign="middle" style="border-left:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">
							<?php 
								
							if ($row['tipologia']=='persona') {
								?>
								<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Cognome: </font>
								<strong><font style="font-family:'Arial', cursive" size="+1"><?php echo ucwords(strtolower($row['cognome'])) ; ?></font></strong>
								<?php 
							}
							
							if ($row['tipologia']!='persona') {
								?>
								<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Denominazione: </font>
								<strong><font style="font-family:'Arial', cursive" size="+1"><?php echo ucwords(strtolower($row['cognome'])) ; ?></font></strong>
								<?php 
							}
							
							if ($row['tipologia']=='persona' AND $row['nome'] != '') {
								?>
								<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Nome: </font><strong>
								<font style="font-family:'Arial', cursive" size="+1"><?php echo ucwords(strtolower($row['nome'])) ; ?></font></strong>
								<?php 
							}
						
							if ($row['tipologia']=='persona' AND ( $datanascita != '' AND $datanascita != '00/00/0000' AND $datanascita != '01/01/1901') ) {
								?>
								<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Data di Nascita: </font>
								<strong><font style="font-family:'Arial', cursive" size="+1"><?php echo $datanascita ; ?></font></strong>
								<?php 
							}
							?>

							<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">
								<?php 
								if ($row['tipologia']=='persona' AND $row['nascitacomune'] != '') {
									?>
									<br>Luogo di Nascita: </font>
									<strong><font style="font-family:'Arial', cursive" size="+1"><?php echo ucwords(strtolower($row['nascitacomune'])); 
									if ($row['nascitaprovincia'] !='') { 
										echo ' (' . strtoupper($row['nascitaprovincia']) . ')'; 
									} 
									if ($row['nascitastato'] !='') { 
										echo ' - ' . ucwords(strtolower($row['nascitastato'])) ; ?></font>
										<?php
									}
								}
								?>
									</strong>
							
							<?php
							if($row['codicefiscale'] != '') {
								?>
								<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Codice Fiscale: </font>
								<font style="font-family:'Arial', cursive" size="+1"><strong><?php echo strtoupper($row['codicefiscale']); ?></strong></font>
								<?php
							}
							?>
							
						</td>
					
						<?php 
						if ($row['tipologia']=='persona') {
							$gr = explode('rh', $row['grupposanguigno']);
							if(isset($gr[0])) {
								$tipo = $gr[0];
							}
							if(isset($gr[1])) {
								$rh = $gr[1];
							}
							?>
							<td width="60px" height="60px" background="images/dettagli/<?php echo $rh; ?>.png" style="background-repeat:no-repeat; background-position:top; padding-top:18px; padding-right:2px" align="center" valign="top">
								<strong><font style="font-family:'Arial', cursive" size="+3"><?php echo $tipo; ?></font></strong>
							</td>
							<?php 
						}
						?>
					</tr>

					<?php
					if($row['residenzavia'] != '' OR $row['residenzacitta'] != '' OR $row['residenzacap'] != '') {
						?>
						<tr>
							<td colspan="3" valign="middle" style="border-top:solid 3px; border-left:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">
								
								<?php 
								if ($row['tipologia']=='persona' AND $row['residenzavia'] != '') {
									?>
									<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">
										Residente in: 
									</font>
									<strong><font style="font-family:'Arial', cursive" size="+1"><?php echo ucwords(strtolower($row['residenzavia'])); 
									if ($row['residenzacivico']!='') {
										echo ' n. ' . $row['residenzacivico'] ;
									} 
									echo '</font></strong><br>';
								}
								
								if ($row['tipologia']!='persona' AND $row['residenzavia'] != '') { 
									?>
									<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">
										Indirizzo: 
									</font>
									<strong><font style="font-family:'Arial', cursive" size="+1"><?php echo ucwords(strtolower($row['residenzavia'])); 
									if ($row['residenzacivico']!='') { 
										echo ' n. ' . $row['residenzacivico'];
									} 
									?>
									</font></strong><br>
									<?php 
								}
								
								if($row['residenzacitta'] != '') {
									?>
									<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Comune: </font>
									<font style="font-family:'Arial', cursive" size="+1"><strong><?php echo ucwords(strtolower($row['residenzacitta'])); 
									if ($row['residenzaprovincia']!='') {
										echo ' ('. strtoupper($row['residenzaprovincia']) . ')';
									} 
									?>
									</strong></font><br>
									<?php
								}
								

								if($row['residenzacap'] != '') {
									?>
									<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">CAP: </font>
									<font style="font-family:'Arial', cursive" size="+1"><strong><?php echo $row['residenzacap']; ?></strong></font>
									<?php
								}
								?>

							</td>
						</tr>
						<?php
					}
					
					
					?>
				</table>

				

			</div>
		</div>
	</div>

	<div class="col-sm-3">
		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title"><strong><i class="fa fa-cog"></i> Opzioni:</strong></h3>
			</div>
			
			<div class="panel-body">
				<?php 
				if (!$a->isUser($row['idanagrafica'])) {
				?>
					<p><a href="login0.php?corpus=modifica-anagrafica&amp;from=risultati&amp;id=<?php echo $id;?>"><i class="fa fa-edit fa-fw"></i> Modifica questa anagrafica</a></p>
					<?php
				}
				?>				
				<p><a href="login0.php?corpus=corrispondenza-anagrafica&currentpage=1&iniziorisultati=0&id=<?php echo $id;?>"><i class="fa fa-exchange fa-fw"></i> Visualizza corrispondenza</a></p>
			</div>
		  
		</div>
	</div>
</div>

				 
                  	<div class="row">
                  		<div class="col-sm-9">
                      	<div class="panel panel-default">
                      		<div class="panel-heading">
                      			<h3 class="panel-title"><strong><i class="fa fa-address-card-o"></i> Dettagli Anagrafica:</strong></h3>
                      		</div>
                       			
                       		<div class="panel-body">
                      			<div class="col-sm-3">
                       				<br><img class="img-circle" src="<?php if($row['urlfoto']) {echo 'foto/'.$row['urlfoto'];} else {echo 'foto/sagoma.png';} ?>" width="150">             
                      			</div>
                      
                      			<div class="col-sm-9">
                          			<div class="container">
                            			<h3>
                            				<?php echo '<i class="fa fa-user fa-fw"></i> ' . ucwords(strtolower($row['cognome'])) . ' ' . ucwords(strtolower($row['nome'])); ?><?php if($row['codicefiscale'] != '') { echo ' ('.strtoupper($row['codicefiscale']).')'; } ?>		
                            			</h3>
                            			<?php
                            			if ($datanascita != '' AND $datanascita != '00/00/0000' AND $datanascita != '01/01/1901') 
										{
                            				echo '<br><i class="fa fa-birthday-cake fa-fw"></i> '.$datanascita.' ';
                            			}
                            			if ($row['nascitacomune'] != '')
                            			{
                            				echo ucwords(strtolower($row['nascitacomune'])); 
										}
										if ($row['nascitaprovincia'] !='') 
										{ 
											echo ' (' . strtoupper($row['nascitaprovincia']) . ')'; 
										} 
										if ($row['nascitastato'] !='') 
										{ 
											echo ' - ' . ucwords(strtolower($row['nascitastato']));
										}
										?>
                         			</div>
                           			<hr>
                           			<div class="container">

	                           			<?php 
	                           			if ($row['residenzavia'] != '')
										{
		                           			echo '<i class="fa fa-map-marker fa-fw"></i> ' . ucwords(strtolower($row['residenzavia'])); 
											if ($row['residenzacivico']!='') 
											{ 
												echo ', ' . $row['residenzacivico'];
											}
											echo '<br>';
										}
										if($row['residenzacap'] != '') 
										{
									 		echo '<i class="fa fa-fw"></i> ' . $row['residenzacap']. ' - ';
									 	} 
										if($row['residenzacitta'] != '')
										{
											echo ucwords(strtolower($row['residenzacitta'])); 
											if ($row['residenzaprovincia']!='') 
											{
												echo ' ('. strtoupper($row['residenzaprovincia']) . ')';
											}
										} 
										?>
									</div>
                           			<hr>
                           			<?php
                           			$cr = $countrecapiti->fetch();
									if ($cr[0] > 0) 
									{
										?>
	                          			<div class="container">
	                          				<?php
											while ($row2 = $risultati2->fetch()) 
											{
												if ($row2['numero'] != '') 
												{
													echo '<p><i class="fa fa-'.$row2['tipo'].' fa-fw"></i> ';
													echo strtolower($row2['numero']);
													echo '</p>';
												}
											}
											?>
	                          			</div>
	                          			<?php
	                          		}
	                          		?>
                      			</div>
                			</div>
            			</div>
            		</div>
            		</div>
           