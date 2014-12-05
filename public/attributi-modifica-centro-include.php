<?php

$id = $_GET['id'];

?>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><b><i class="fa fa-font"></i> Gestione Attributi</b></h3>
  </div>
  <div class="panel-body">
  
  <div class="row">

	<div class="col-xs-6">   
		<?php
		$attributo=mysql_query("select count(*) from attributi");
		
		if ($attributo) { 
			$num=mysql_fetch_row($attributo);
		} //se ce ne sono, li conta
		else { 
			$num[0]=0; 
		} //altrimenti azzera il contatore
		
		if($num[0]<=0) {
			echo '<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> Nessun attributo registrato.</div>';
		}
		else {
			?>
			<label><span class="glyphicon glyphicon-list"></span> Elenco attributi:</label><br><br>
			<?php
			$risultati=mysql_query("select distinct * from attributi");
			?>
			<table class="table table-striped table-hover">
			<tr>
			<td><b>ID</b></td><td><b>Attributo</b></td><td><b>Opzioni</b></td>
			</tr>
			<?php
			while ($risultati2=mysql_fetch_array($risultati))	{
				$risultati2 = array_map ("stripslashes",$risultati2);
				echo '<tr>';
				echo '<td>' . $risultati2['id'] . '</td><td>' . $risultati2['attributo'] . '</td>
					<td>
					<div class="btn-group btn-group-xs">
						<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica attributo" href="login0.php?corpus=attributi-modifica&id=' . $risultati2['id'] . '"><span class="glyphicon glyphicon-pencil"></span></button></a> 
						<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina attributo" onClick="return confirm(\'Vuoi veramente cancellare questo attributo?\');" href="login0.php?corpus=attributi-elimina&id='. $risultati2['id'] . '"><span class="glyphicon glyphicon-trash"></button></a>
					</div>
					</td>
					</tr>';
			}
		}
		?>
		</table>
	</div>
	
	<div class="col-xs-6">   
	 
		 <?php
			$risultati=mysql_query("select * from attributi where id='$id'");
			$risultati2=mysql_fetch_array($risultati);
			$risultati2=array_map("stripslashes",$risultati2);
		?>
		<label><span class="glyphicon glyphicon-pencil"></span> Modifica attributo: "<?php echo $risultati2['id'] . ' - ' . $risultati2['attributo']; ?>"</label><br><br>
		
		 <form action="login0.php?corpus=attributi-modifica2&id=<?php echo $id ?>" method="post" role="form">
		  <div class="form-group">
			
			<div class="row">
				<div class="col-xs-12">
					<label>Descrizione attributo:</label><input value="<?php echo str_replace("\"", '&quot;',$risultati2['attributo']); ?>" class="form-control" size="40" type="text" name="descrizione" />			
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<br><button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-pencil"></span> Modifica Attributo</button>
				</div>
			</div>
			
		  </div>
		</form>
		<a href="login0.php?corpus=attributi"><b>Indietro</b></a>
	 
	</div>
	
</div>

</div>
</div>

