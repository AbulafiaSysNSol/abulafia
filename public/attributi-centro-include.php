<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><b><i class="fa fa-font"></i> Gestione Attributi</b></h3>
  </div>
  <div class="panel-body">
  
     <?php
    if( isset($_GET['add']) && $_GET['add'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Nuovo attributo aggiunto!</div></div></div>
	<?php
   }
    if( isset($_GET['add']) && $_GET['add'] == "no") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-danger">Si è verificato un errore, controlla di aver inserito tutti i campi oppure riprova più tardi.</div></div></div>
	<?php
   }
   if( isset($_GET['mod']) && $_GET['mod'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Attributo modificato con successo!</div></div></div>
	<?php
   }
   if( isset($_GET['mod']) && $_GET['mod'] == "no") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella modifica dell'attributo.</div></div></div>
	<?php
   }
   if( isset($_GET['canc']) && $_GET['canc'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Attributo cancellato con successo!</div></div></div>
	<?php
   }
   if( isset($_GET['canc']) && $_GET['canc'] == "no") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella cancellazione dell'attributo.</div></div></div>
	<?php
   }
   ?>
   
   <div class="row">

	<div class="col-sm-6">   
		<?php
		$attributo = $connessione->query("SELECT COUNT(*) FROM attributi");
		
		if ($attributo) { 
			$num = $attributo->fetch();
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
			$risultati = $connessione->query("SELECT DISTINCT * FROM attributi");
			?>
			<table class="table table-striped table-hover">
			<tr>
			<td><b>ID</b></td><td><b>Attributo</b></td><td><b>Opzioni</b></td>
			</tr>
			<?php
			while ($risultati2 = $risultati->fetch())	{
				$risultati2 = array_map ("stripslashes",$risultati2);
				echo '<tr>';
				echo '<td>' . $risultati2['id'] . '</td><td>' . $risultati2['attributo'] . '</td>
					<td>
					<div class="btn-group btn-group-sm">
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
	
	<div class="col-sm-6">   
	 <label><span class="glyphicon glyphicon-plus"></span> Aggiungi attributo:</label><br><br>
	    <form action="login0.php?corpus=attributi2" method="post" role="form">
		  <div class="form-group">
			
			<div class="row">
				<div class="col-sm-12">
					<label>Valore:</label><input required class="form-control" size="40" type="text" name="descrizione" placeholder="Al, Alla, Al Volontario, Ill.mo, Egregio, A Tutti, etc..." required />			
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<br><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span> Aggiungi Attributo</button>
				</div>
			</div>
			
		  </div>
	</form>
	</div>
	
</div>

</div>
</div>
<?php 
	$_SESSION['my_database']=serialize($my_database);
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO ATTRIBUTI' , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'page request');
?>

