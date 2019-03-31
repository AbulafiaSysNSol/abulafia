<?php

$id = $_GET['id'];

?>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" bgcolor="red"><b>Gestione pratiche - Modifica</b></h3>
  </div>
  <div class="panel-body">
  
	<div class="row">
		<div class="col-sm-12">   
		 
			 <?php
				$risultati = $connessione->query("SELECT * from pratiche where id='$id'");
				$risultati2 = $risultati->fetch();
				$risultati2 = array_map("stripslashes",$risultati2);
			?>
			<label><span class="glyphicon glyphicon-pencil"></span> Modifica pratica: "<?php echo $risultati2['descrizione']; ?>" --- <a href="login0.php?corpus=pratiche"><b><i class="fa fa-arrow-left"></i> Indietro</b></a></label><br><br>
			
			 <form action="login0.php?corpus=pratica-modifica2&id=<?php echo $id ?>" method="post" role="form">
			  <div class="form-group">
				
				<div class="row">
					<div class="col-sm-8">
						<label>Descrizione pratica:</label><input value="<?php echo str_replace("\"", '&quot;',$risultati2['descrizione']); ?>" class="form-control" size="40" type="text" name="descrizione" />			
					</div>
				
					<div class="col-sm-4">
						<br><button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-pencil"></span> Modifica Pratica</button>
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
			$pratica = $connessione->query("SELECT count(*) from pratiche");
			$num = $pratica->fetch();
			if($num[0]<=0) {
				echo '<br><label><span class="glyphicon glyphicon-warning-sign"></span> Nessuna pratica registrata.</label>';
			}
			else {

			?>
			<label><span class="glyphicon glyphicon-list"></span> Elenco pratiche:</label><br><br>
			<?php

			$risultati = $connessione->query("SELECT distinct * from pratiche");
			?>
			<table class="table table-striped table-hover">
			<tr>
			<td><b>Id</b></td><td><b>Descrizione</b></td><td><b>Opzioni</b></td>
			</tr>
			<?php
			while ($risultati2 = $risultati->fetch())
			{
				$risultati2 = array_map("stripslashes",$risultati2);
				echo '<tr>';
				echo '<td>' . $risultati2['id'] . '</td><td>' . $risultati2['descrizione'] . '</td>
				<td>
					<div class="btn-group btn-group-sm">
						<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Visualizza protocolli per questa pratica" href="login0.php?corpus=corrispondenza-pratica&currentpage=1&iniziorisultati=0&id=' . $risultati2['id'] . '"><i class="fa fa-bars"></i> Protocolli</a>
						<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica pratica" href="login0.php?corpus=pratica-modifica&id=' . $risultati2['id'] . '"><span class="glyphicon glyphicon-pencil"></span> Modifica</a> 
						<a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Elimina pratica" onClick="return confirm(\'Vuoi veramente cancellare questa pratica?\');" href="login0.php?corpus=pratica-elimina&id='. $risultati2['id'] . '"><span class="glyphicon glyphicon-trash"> Elimina</a>
					</div>
				</td>
				</tr>';
			}
			}
			?>
			</table>
		</div>
	</div>

</div>
</div>

