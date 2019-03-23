<?php

$id = $_GET['id'];

?>


<div class="panel panel-default">
 	<div class="panel-heading">
    	<h3 class="panel-title" bgcolor="red"><b><i class="fa fa-archive"></i> Gestione Titolario - Modifica</b></h3>
  	</div>
  	<div class="panel-body">
  
  		<div class="row">
		  	<div class="col-sm-12">   
			 
				 <?php
					$risultati = $connessione->query("SELECT * FROM titolario WHERE id='$id'");
					$risultati2 = $risultati->fetch();
					$risultati2=array_map("stripslashes",$risultati2);
				?>
				<label><span class="glyphicon glyphicon-pencil"></span> Modifica posizione: "<?php echo $risultati2['codice'] . ' - ' . $risultati2['descrizione']; ?>" --- <a href="login0.php?corpus=titolario"><i class="fa fa-arrow-left"></i> <b>Indietro</b></a></label><br><br>
				
				<form action="login0.php?corpus=titolario-modifica2&id=<?php echo $id ?>" method="post" role="form">
				<div class="form-group">	
					<div class="row">
						<div class="col-sm-3">
							<label>Codice posizione:</label> <input value="<?php echo $risultati2['codice']; ?>" class="form-control" size="10" type="text" name="codice" />
						</div>
						<div class="col-sm-6">
							<label>Descrizione posizione:</label><input value="<?php echo str_replace("\"", '&quot;',$risultati2['descrizione']); ?>" class="form-control" size="40" type="text" name="descrizione" />			
						</div>
						<div class="col-sm-3">
							<br><button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-pencil"></span> Modifica Posizione</button>
						</div>
					</div>
				</div>
				</form>
			 
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12">   
				<?php
				$fascicolo = $connessione->query("SELECT COUNT(*) FROM titolario");
				$num = $fascicolo->fetch();
				if($num[0] <= 0) {
					echo '<br><label><span class="glyphicon glyphicon-warning-sign"></span> Nessuna posizione registrata.</label>';
				}
				else {
					?>
					<label><span class="glyphicon glyphicon-list"></span> Elenco posizioni:</label><br><br>
					<?php
					$risultati = $connessione->query("SELECT DISTINCT * FROM titolario");
					?>
					<table class="table table-striped table-hover">
						<tr>
							<td><b>Codice</b></td><td><b>Descrizione</b></td><td><b>Opzioni</b></td>
						</tr>
						<?php
						while($risultati2 = $risultati->fetch()) {
							$risultati2=array_map("stripslashes",$risultati2);
							echo '<tr>';
							echo '<td>' . $risultati2['codice'] . '</td><td>' . $risultati2['descrizione'] . '</td>
							<td>
								<div class="btn-group btn-group-block btn-group-sm">
									<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Visualizza protocolli per questa posizione" href="login0.php?corpus=corrispondenza-titolario&currentpage=1&iniziorisultati=0&id=' . $risultati2['codice'] . '"><i class="fa fa-bars"></i></button> Protocolli</a>
									<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica posizione" href="login0.php?corpus=titolario-modifica&id=' . $risultati2['id'] . '"><span class="glyphicon glyphicon-pencil"></span></button> Modifica</a> 
									<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina posizione" onClick="return confirm(\'Vuoi veramente cancellare questa posizione?\');" href="login0.php?corpus=titolario-elimina&id='. $risultati2['id'] . '"><span class="glyphicon glyphicon-trash"></span></button> Elimina</a>
								</div>
							</td>
							</tr>';
						}
						?>
					</table>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>