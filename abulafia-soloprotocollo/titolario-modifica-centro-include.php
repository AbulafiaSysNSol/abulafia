<?php

$id = $_GET['id'];

?>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" bgcolor="red"><b>Gestione posizioni</b></h3>
  </div>
  <div class="panel-body">
  
  <div class="row">

	<div class="col-xs-6">   
		<?php
		$fascicolo=mysql_query("select count(*) from titolario");
		$num=mysql_fetch_row($fascicolo);
		if($num[0]<=0) {
			echo '<br><label><span class="glyphicon glyphicon-warning-sign"></span> Nessuna posizione registrata.</label>';
		}
		else {

		?>
		<label><span class="glyphicon glyphicon-list"></span> Elenco posizioni:</label><br><br>
		<?php

		$risultati=mysql_query("select distinct * from titolario");
		?>
		<table class="table table-striped table-hover">
		<tr>
		<td><b>Codice</b></td><td><b>Descrizione</b></td><td><b>Opzioni</b></td>
		</tr>
		<?php
		while ($risultati2=mysql_fetch_array($risultati))
		{
			echo '<tr>';
			echo '<td>' . $risultati2['codice'] . '</td><td>' . $risultati2['descrizione'] . '</td><td><a href="login0.php?corpus=titolario-modifica&id=' . $risultati2['id'] . '"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></button></a> <a onClick="return confirm(\'Vuoi veramente cancellare questa posizione?\');" href="login0.php?corpus=titolario-elimina&id='. $risultati2['id'] . '"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></button></a></td></tr>';
		}
		}
		?>
		</table>
	</div>
	
	<div class="col-xs-6">   
	 
		 <?php
			$risultati=mysql_query("select * from titolario where id='$id'");
			$risultati2=mysql_fetch_array($risultati);
		?>
		<label><span class="glyphicon glyphicon-pencil"></span> Modifica posizione: "<?php echo $risultati2['codice'] . ' - ' . $risultati2['descrizione']; ?>"</label><br><br>
		
		 <form action="login0.php?corpus=titolario-modifica2&id=<?php echo $id ?>" method="post" role="form">
		  <div class="form-group">
			
			<div class="row">
				<div class="col-xs-4">
					<label>Codice posizione:</label> <input value="<?php echo $risultati2['codice'] ?>" class="form-control" size="10" type="text" name="codice" />
				</div>
				<div class="col-xs-8">
					<label>Descrizione posizione:</label><input value="<?php echo $risultati2['descrizione'] ?>" class="form-control" size="40" type="text" name="descrizione" />			
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<br><button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-pencil"></span> Modifica Posizione</button>
				</div>
			</div>
			
		  </div>
		</form>
		<a href="login0.php?corpus=titolario"><b>Indietro</b></a>
	 
	</div>
	
</div>

</div>
</div>

