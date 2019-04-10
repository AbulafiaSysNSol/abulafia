<html>
<head>
	<link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
 	<link href="css/font-awesome.min.css" rel="stylesheet">
  	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  	<link href="css/grid.css" rel="stylesheet">
</head>
<body>
<?php

	session_start();
	
	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	include 'class/Log.obj.inc';
	include '../db-connessione-include.php'; //connessione al db-server
		
	$id = $_GET['id'];
	$risultati = $connessione->query("SELECT * FROM anagrafica WHERE idanagrafica = '$id'");
	$risultati2 = $connessione->query("SELECT * FROM jointelefonipersone WHERE idanagrafica = '$id'");
	$countrecapiti = $connessione->query("SELECT COUNT(*) FROM jointelefonipersone WHERE idanagrafica = '$id'");
	$row = $risultati->fetch();
	$row = array_map ("stripslashes",$row);
	$data = $row['nascitadata'] ;
	list($anno, $mese, $giorno) = explode("-", $data);
	$datanascita = $giorno .'/'. $mese .'/'. $anno;
?>

	<div class="panel panel-default">
       		<div class="panel-heading">
       			<h3 class="panel-title"><strong><i class="fa fa-address-card-o"></i> Dettagli Anagrafica:</strong></h3>
       		</div>
                       			
      		<div class="panel-body">
            	<div class="col-sm-3">
            		<center>
                    <br><img class="img-circle" src="<?php if($row['urlfoto']) {echo 'foto/'.$row['urlfoto'];} else {echo 'foto/sagoma.png';} ?>" width="150">   <br>          
                	</center>
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
</body>
</html>