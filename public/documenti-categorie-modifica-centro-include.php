<?php

$id = $_GET['id'];

?>


<div class="panel panel-default">
 	<div class="panel-heading">
    	<h3 class="panel-title" bgcolor="red"><b><i class="fa fa-archive"></i> Gestione Categorie - Modifica</b></h3>
  	</div>
  	<div class="panel-body">
  
  		<div class="row">
		  	<div class="col-sm-12">   
			 
				 <?php
					$risultati=mysql_query("select * from categorie where id='$id'");
					$risultati2=mysql_fetch_array($risultati);
					$risultati2=array_map("stripslashes",$risultati2);
				?>
				<label><span class="glyphicon glyphicon-pencil"></span> Modifica categoria: "<?php echo $risultati2['categoria']; ?>" --- <a href="login0.php?corpus=documenti-categorie"><i class="fa fa-arrow-left"></i> <b>Indietro</b></a></label><br><br>
				
				<form action="login0.php?corpus=documenti-categorie-modifica2&id=<?php echo $id ?>" method="post" role="form">
				<div class="form-group">	
					<div class="row">
						<div class="col-sm-6">
							<label>Descrizione categoria:</label><input value="<?php echo str_replace("\"", '&quot;',$risultati2['categoria']); ?>" class="form-control" name="descrizione" />			
						</div>
						<div class="col-sm-3">
							<br><button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-pencil"></span> Modifica Categoria</button>
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
				$fascicolo=mysql_query("select count(*) from categorie");
				$num=mysql_fetch_row($fascicolo);
				if($num[0]<=0) {
					echo '<br><label><span class="glyphicon glyphicon-warning-sign"></span> Nessuna categoria registrata.</label>';
				}
				else {

				?>
				<label><span class="glyphicon glyphicon-list"></span> Elenco categorie:</label><br><br>
				<?php

				$risultati=mysql_query("select distinct * from categorie");
				?>
				<table class="table table-striped table-hover">
				<tr>
				<td><b>Descrizione</b></td><td><b>Opzioni</b></td>
				</tr>
				<?php
				while ($risultati2=mysql_fetch_array($risultati))
				{
					$risultati2=array_map("stripslashes",$risultati2);
					echo '<tr>';
					echo '<td>' . $risultati2['categoria'] . '</td>
					<td>
					<div class="btn-group btn-group-sm">
						<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Visualizza documenti per questa categoria" href=""><i class="fa fa-bars"></i> Documenti</button></a>
						<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica categoria" href="?corpus=documenti-categorie-modifica&id=' . $risultati2['id'] . '"><span class="glyphicon glyphicon-pencil"></span> Modifica</button></a> 
						<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina categoria" onClick="return confirm(\'Vuoi veramente cancellare questa categoria?\');" href="?corpus=documenti-categorie-elimina&id='. $risultati2['id'] . '"><span class="glyphicon glyphicon-trash"></span> Elimina</button></a>
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

