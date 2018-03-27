<html>
<head>
	  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
</head>
<body>
<?php

	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include '../db-connessione-include.php'; //connessione al db-server
		
	$id= $_GET['id'];
	$risultati=mysql_query("select * from anagrafica where idanagrafica='$id'");
	$risultati2=mysql_query("select * from jointelefonipersone where idanagrafica='$id'");
	$countrecapiti = mysql_query("select count(*) from jointelefonipersone where idanagrafica='$id'");
	$row = mysql_fetch_array($risultati);
	$row = array_map ("stripslashes",$row);
	$data = $row['nascitadata'] ;
	list($anno, $mese, $giorno) = explode("-", $data);
	$datanascita = $giorno .'/'. $mese .'/'. $anno;
?>

<div class="panel panel-default">
	
	<div class="panel-body">
		<table width="100%" border="0" style="border:solid 3px; border-color:#C0C0C0; background-repeat:repeat-x; background-position:top" cellspacing="0" background="images/dettagli/sfondo.png">
			<tr>
				<td width="170px" height="180px" style="background-repeat:no-repeat; background-position:center; padding:10px 5px 10px 5px" align="center">
					<img src="<?php if($row['urlfoto']) {echo 'foto/'.$row['urlfoto'];} else {echo 'images/nessuna.jpg';} ?>" width="145">
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
			
			$cr = mysql_fetch_row($countrecapiti);
			if ($cr[0] > 0) {
				?>
				<tr>
					<td width="" style="border-top:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">  
						<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Recapiti: </font>
					</td>
					
					<td colspan="2" width="" style="border-top:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">
						<strong><font style="font-family:'Arial', cursive" size="+1">
						<?php
						while ($row2 = mysql_fetch_array($risultati2)) {
							if ($row2['numero'] != '') {
								echo '<i class="fa fa-'.$row2['tipo'].'"></i> '; echo strtolower($row2['numero']);
							}
							?>
							<br> 
							<?php
						}
						?>
						</font></strong>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>  
</div>
</body>
</html>