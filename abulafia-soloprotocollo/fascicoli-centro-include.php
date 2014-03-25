<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title" bgcolor="red"><b>Gestione fascicoli</b></h3>
  </div>
  <div class="panel-body">
  
     <?php
    if($_GET['add'] == "ok") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Nuovo fascicolo aggiunto!</div></div></div>
	<?php
   }
    if($_GET['add'] == "no") {
	?>
	<div class="row">
	<div class="col-xs-12">
	<div class="alert alert-danger">Si è verificato un errore, controlla di aver inserito tutti i campi oppure riprova più tardi.</div></div></div>
	<?php
   }
   ?>
 
    <form action="login0.php?corpus=fascicoli2" method="post" role="form">
	  <div class="form-group">
		
		<div class="row">
			<div class="col-xs-2">
				<label>Codice fascicolo:</label> <input class="form-control" size="10" type="text" name="codice" />
			</div>
			<div class="col-xs-4">
				<label>Descrizione Fascicolo:</label><input class="form-control" size="40" type="text" name="descrizione" />			
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<br><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span> Aggiungi Fascicolo</button>
			</div>
		</div>
		
	  </div>
</form>

<?php
$fascicolo=mysql_query("select count(*) from fascicoli");
$num=mysql_fetch_row($fascicolo);
if($num[0]<=0) {
	echo '<br><label><span class="glyphicon glyphicon-warning-sign"></span> Nessun fascicolo registrato.</label>';
}
else {

?>
<br><label><span class="glyphicon glyphicon-list"></span> Fascicoli gia presenti:</label><br><br>
<?php

$risultati=mysql_query("select distinct * from fascicoli");
?>
<div class="row">
<div class="col-xs-6">
<table class="table table-striped table-hover">
<tr>
<td><b>Codice</b></td><td><b>Descrizione</b></td><td><b>Opzioni</b></td>
</tr>
<?php
while ($risultati2=mysql_fetch_array($risultati))
{
	echo '<tr>';
	echo '<td>' . $risultati2['codice'] . '</td><td>' . $risultati2['descrizione'] . '</td><td><a href="login0.php?corpus=modifca-fascicolo&id=' . $risultati2['id'] . '">Modifica</a> - <a href="login0.php?corpus=elimina-fascicolo&id='. $risultati2['id'] . '">Elimina</a></td></tr>';
}
}
?>
</table>
</div></div>

</div>
</div>

