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
            	<div class="col-sm-3">
            		<center>
                    <br><img class="img-circle" src="<?php if($row['urlfoto']) {echo 'foto/'.$row['urlfoto'];} else {echo 'foto/sagoma.png';} ?>" width="150">             
                	</center><br>
                </div>
                      
                <div class="col-sm-9 smartphone">
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
                    
                    <div class="container">
           				<?php 
	                	if ($row['residenzavia'] != '')
						{
		                	echo '<hr><i class="fa fa-map-marker fa-fw"></i> ' . ucwords(strtolower($row['residenzavia'])); 
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
                    
                    <?php
                    $cr = $countrecapiti->fetch();
					if ($cr[0] > 0) 
					{
						?>
						<hr>
	                	<div class="container">
	                		<?php
							while ($row2 = $risultati2->fetch()) 
							{
								if ($row2['numero'] != '') 
								{
									echo '<i class="fa fa-'.$row2['tipo'].' fa-fw"></i> ';
									echo strtolower($row2['numero']).'<br>';

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