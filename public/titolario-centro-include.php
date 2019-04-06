<div class="panel panel-default">
  	
  	<div class="panel-heading">
   		<h3 class="panel-title"><b><i class="fa fa-archive"></i> Gestione Titolario</b></h3>
  	</div>
  	
  	<div class="panel-body">
  
	    <?php
	    if( isset($_GET['add']) && $_GET['add'] == "ok") {
			?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-success"><b><i class="fa fa-check fa-fw"></i></b> Nuova posizione aggiunta!</div></div></div>
			<?php
	   	}
	    
	    if( isset($_GET['add']) && $_GET['add'] == "no") {
			?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-danger"><b><i class="fa fa-warning fa-fw"></i></b> Si è verificato un errore, controlla di aver inserito tutti i campi oppure riprova più tardi.</div></div></div>
			<?php
	   	}
	    
	    if( isset($_GET['add']) && $_GET['add'] == "duplicato") {
		?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-danger"><b><i class="fa fa-warning fa-fw"></i> Impossibile aggiungere:</b> esiste già una posizione con lo stesso Codice!</div></div></div>
			<?php
		}
	   
	   	if( isset($_GET['mod']) && $_GET['mod'] == "ok") {
			?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-success"><b><i class="fa fa-check fa-fw"></i></b> Posizione modificata con successo!</div></div></div>
			<?php
	    }
	   
	    if( isset($_GET['mod']) && $_GET['mod'] == "no") {
			?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-success"><b><i class="fa fa-warning fa-fw"></i></b> Si è verificato un errore nella modifica della posizione.</div></div></div>
			<?php
	    }
	   
	    if( isset($_GET['canc']) && $_GET['canc'] == "ok") {
			?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-success"><b><i class="fa fa-check fa-fw"></i></b> Posizione eliminata con successo!</div></div></div>
			<?php
	   	}
	   
	    if( isset($_GET['canc']) && $_GET['canc'] == "no") {
			?>
			<div class="row">
			<div class="col-sm-12">
			<div class="alert alert-success"><b><i class="fa fa-warning fa-fw"></i></b> Si è verificato un errore nella cancellazione della posizione</div></div></div>
			<?php
		}
	   	?>
	   
	   	<div class="row">
			<div class="col-sm-12">   
			    <form action="login0.php?corpus=titolario2" method="post" role="form">
				  <div class="form-group">
					
					<div class="row">
						<div class="col-sm-3">
							<label>Codice posizione:</label> <input class="form-control" size="10" type="text" name="codice" required />
						</div>
						<div class="col-sm-6">
							<label>Descrizione posizione:</label><input class="form-control" size="40" type="text" name="descrizione" required />			
						</div>
						<div class="col-sm-3">
							<br><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span> Aggiungi Posizione</button>
						</div>
					</div>
				
				  </div>
				</form>
			</div>

			<div class="col-sm-12">   
				<?php
				$fascicolo = $connessione->query("SELECT COUNT(*) FROM titolario"); //ricerca tutti i valori del titolario
				
				if ($fascicolo) { 
					$num=$fascicolo->fetch();
				} //se ce ne sono, li conta
				else { 
					$num[0]=0; 
				} //altrimenti azzera il contatore
				
				if($num[0]<=0) {
					echo '<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> Nessuna posizione registrata.</div>';
				}
				else {

					?>
					<br><label><span class="glyphicon glyphicon-list"></span> Elenco Posizioni:</label><br><br>
					<?php

					$risultati = $connessione->query("SELECT DISTINCT * FROM titolario");
					?>
					<table class="table table-striped table-hover">
						<tr>
							<td><b>Codice</b></td><td><b>Descrizione</b></td><td><b>Opzioni</b></td>
						</tr>
						<?php
						while ($risultati2 = $risultati->fetch())	{
							$risultati2 = array_map ("stripslashes",$risultati2);
							echo '<tr>';
							echo '<td>' . $risultati2['codice'] . '</td><td>' . stripslashes($risultati2['descrizione']) . '</td>
								<td>
								<div class="btn-group btn-group-sm">
									<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Visualizza protocolli per questa posizione" href="login0.php?corpus=corrispondenza-titolario&currentpage=1&iniziorisultati=0&id=' . $risultati2['codice'] . '"><i class="fa fa-bars"></i> Protocolli</button></a>
									<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica posizione" href="login0.php?corpus=titolario-modifica&id=' . $risultati2['id'] . '"><span class="glyphicon glyphicon-pencil"></span> Modifica</button></a> 
									<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina posizione" onClick="return confirm(\'Vuoi veramente cancellare questa posizione?\');" href="login0.php?corpus=titolario-elimina&id='. $risultati2['id'] . '"><span class="glyphicon glyphicon-trash"></span> Elimina</button></a>
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

<?php 
	$_SESSION['my_database']=serialize($my_database);
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO TITOLARIO' , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'page request');
?>
