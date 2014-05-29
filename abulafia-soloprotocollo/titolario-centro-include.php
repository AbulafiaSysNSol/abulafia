<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" bgcolor="red"><b>Gestione posizioni</b></h3>
  </div>
  <div class="panel-body">
  
     <?php
    if( isset($_GET['add']) && $_GET['add'] == "ok") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Nuova posizione aggiunta!</div></div></div>
	<?php
   }
    if( isset($_GET['add']) && $_GET['add'] == "no") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-danger">Si è verificato un errore, controlla di aver inserito tutti i campi oppure riprova più tardi.</div></div></div>
	<?php
   }
    if( isset($_GET['add']) && $_GET['add'] == "duplicato") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-danger">Impossibile aggiungere: esiste già una posizione con lo stesso nome!</div></div></div>
	<?php
   }
   if( isset($_GET['mod']) && $_GET['mod'] == "ok") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Posizione modificata con successo!</div></div></div>
	<?php
   }
   if( isset($_GET['mod']) && $_GET['mod'] == "no") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella modifica della posizione.</div></div></div>
	<?php
   }
   if( isset($_GET['canc']) && $_GET['canc'] == "ok") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Posizione eliminata con successo!</div></div></div>
	<?php
   }
   if( isset($_GET['canc']) && $_GET['canc'] == "no") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella cancellazione della posizione</div></div></div>
	<?php
   }
   ?>
   
   <div class="row">

	<div class="col-xs-6">   
		<?php
		$fascicolo=mysql_query("select count(*) from titolario"); //ricerca tutti i valori del titolario
		if ($fascicolo) { $num=mysql_fetch_row($fascicolo);} //se ce ne sono, li conta
		else { $num[0]=0; } //altrimenti azzera il contatore
		if($num[0]<=0) {
			echo '<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> Nessuna posizione registrata.</div>';
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
		while ($risultati2=mysql_fetch_array($risultati))	{
			$risultati2 = array_map ("stripslashes",$risultati2);
			echo '<tr>';
			echo '<td>' . $risultati2['codice'] . '</td><td>' . $risultati2['descrizione'] . '</td>
				<td>
				<div class="btn-group btn-group-xs">
					<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Visualizza protocolli per questa posizione" href="login0.php?corpus=corrispondenza-titolario&currentpage=1&iniziorisultati=0&id=' . $risultati2['codice'] . '"><i class="fa fa-bars"></i></button></a>
					<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica posizione" href="login0.php?corpus=titolario-modifica&id=' . $risultati2['id'] . '"><span class="glyphicon glyphicon-pencil"></span></button></a> 
					<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina posizione" onClick="return confirm(\'Vuoi veramente cancellare questa posizione?\');" href="login0.php?corpus=titolario-elimina&id='. $risultati2['id'] . '"><span class="glyphicon glyphicon-trash"></button></a>
				</div>
				</td>
				</tr>';
		}
		}
		?>
		</table>
	</div>
	
	<div class="col-xs-6">   
	 <label><span class="glyphicon glyphicon-plus"></span> Aggiungi posizione:</label><br><br>
	    <form action="login0.php?corpus=titolario2" method="post" role="form">
		  <div class="form-group">
			
			<div class="row">
				<div class="col-xs-4">
					<label>Codice posizione:</label> <input class="form-control" size="10" type="text" name="codice" required />
				</div>
				<div class="col-xs-8">
					<label>Descrizione posizione:</label><input class="form-control" size="40" type="text" name="descrizione" required />			
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<br><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span> Aggiungi Posizione</button>
				</div>
			</div>
			
		  </div>
	</form>
	</div>
	
</div>

</div>
</div>
<?php $_SESSION['my_database']=serialize($my_database);?>

