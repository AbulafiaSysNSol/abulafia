<?php
	$level = $_SESSION['auth'];
	$id= $_GET['id'];
	$risultati=mysql_query("select * from anagrafica where idanagrafica='$id'");
	$risultati2=mysql_query("select * from jointelefonipersone where idanagrafica='$id'");
	$row = mysql_fetch_array($risultati);
	$data = $row['nascitadata'] ;
	list($anno, $mese, $giorno) = explode("-", $data);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Dettagli Anagrafica:</strong></h3>
	</div>
	
	<div class="panel-body">
		<table width="100%" border="0" style="border:solid 3px; border-color:#C0C0C0; background-repeat:repeat-x; background-position:top" cellspacing="0" background="images/tesserino/sfondo.png">
			<tr>
				<td width="170px" height="180px" style="background-repeat:no-repeat; background-position:center; padding:10px 5px 10px 5px"" align="center">
					<img src="foto/<?php echo $row['urlfoto']; ?>" width="145">
				</td>
			
				<td valign="middle" style="border-left:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">
					<?php 
					
					if ($row['tipologia']=='persona') {
						?>
						<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Cognome: </font>
						<strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['cognome'])) ; ?></font></strong>
						<?php 
					}
					
					if ($row['tipologia']!='persona') {
						?>
						<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Denominazione: </font>
						<strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['cognome'])) ; ?></font></strong>
						<?php 
					}
					
					if ($row['tipologia']=='persona') {
						?>
						<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Nome: </font><strong>
						<font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['nome'])) ; ?></font></strong>
						<?php 
					}
				
					if ($row['tipologia']=='persona') {
						?>
						<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Data di Nascita: </font>
						<strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo $giorno .'/'. $mese .'/'. $anno ; ?></font></strong>
						<?php 
					}
					?>

					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">
						<?php 
						if ($row['tipologia']=='persona') {
							?>
							<br>Luogo di Nascita: </font>
							<strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['nascitacomune'])); 
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
							
					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Codice Fiscale: </font>
					<font style="font-family:'Comic Sans MS', cursive" size="+1"><strong><?php echo strtoupper($row['codicefiscale']); ?></strong></font>
				</td>
			
				<?php 
				if ($row['tipologia']=='persona') {
					list($tipo, $rh)=explode('rh', $row['grupposanguigno']); 
					?>
					<td width="60px" height="60px" background="images/tesserino/<?php echo $rh; ?>.png" style="background-repeat:no-repeat; background-position:top; padding-top:18px; padding-right:2px" align="center" valign="top">
						<strong><font style="font-family:'Comic Sans MS', cursive" size="+3"><?php echo $tipo; ?></font></strong>
					</td>
					<?php 
				}
				?>
			</tr>

			<tr>
				<td colspan="3" valign="middle" style="border-top:solid 3px; border-left:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">
					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">
					<?php 
					if ($row['tipologia']=='persona') {
						?>
						Residente in: </font><strong>
						<font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['residenzavia'])); 
						if ($row['residenzacivico']!='') {
							echo ' n. ' . $row['residenzacivico'] ;
						} 
					}
					?>
					</font></strong>

					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">
					<?php 
						if ($row['tipologia']!='persona') { 
							?>
							Indirizzo: </font><strong>
							<font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo $row['residenzavia']; 
							if ($row['residenzacivico']!='') { 
								echo ' n. ' . $row['residenzacivico'];
							} 
							?>
							</font></strong>  
							<?php 
						}
						?>

					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Comune: </font>
					<font style="font-family:'Comic Sans MS', cursive" size="+1"><strong><?php echo $row['residenzacitta']; 
					if ($row['residenzaprovincia']!='') {
						echo ' ('. $row['residenzaprovincia'] . ')';
					} 
					?>
					</strong></font>

					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>CAP: </font>
					<font style="font-family:'Comic Sans MS', cursive" size="+1"><strong><?php echo $row['residenzacap']; ?></strong></font>

				</td>
			</tr>
		    
			<tr>
				<td width="" style="border-top:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">  
					<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Recapiti: </font>
				</td>
				
				<td colspan="2" width="" style="border-top:solid 3px; border-color:#C0C0C0; padding:10px 5px 10px 5px">
					<strong><font style="font-family:'Comic Sans MS', cursive" size="+1">
					<?php
					while ($row2 = mysql_fetch_array($risultati2)) {
						if ($row2['numero'] != '') {
							echo '<img src="images/'.$row2['tipo'].'.png" width="20" height="20"> '; echo strtolower($row2['numero']). '  -  ' .strtoupper($row2['tipo']);
						}
						?>
						<br> 
						<?php
					}
					?>
					</font></strong>
				</td>
			</tr>
		</table>
	</div>
  
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Opzioni:</strong></h3>
	</div>
	
	<div class="panel-body">
		<p><a href="login0.php?corpus=modifica-anagrafica&amp;from=risultati&amp;id=<?php echo $id;?>"><span class="glyphicon glyphicon-edit"></span> Modifica questa Anagrafica</a></p>
		<a href="login0.php?corpus=anagrafica"><span class="glyphicon glyphicon-plus-sign"></span> Nuovo inserimento in Anagrafica</a>
	</div>
  
</div>