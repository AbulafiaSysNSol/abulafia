<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><b><i class="fa fa-th-large"></i> Gestione Categorie</b></h3>
  </div>
  <div class="panel-body">
  
     <?php
    if( isset($_GET['add']) && $_GET['add'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Categoria aggiunta!</div></div></div>
	<?php
   }
    if( isset($_GET['add']) && $_GET['add'] == "no") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-danger">Si è verificato un errore, controlla di aver inserito tutti i campi oppure riprova più tardi.</div></div></div>
	<?php
   }
    if( isset($_GET['add']) && $_GET['add'] == "duplicato") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-danger">Impossibile aggiungere: esiste già una categoria con lo stesso nome!</div></div></div>
	<?php
   }
   if( isset($_GET['mod']) && $_GET['mod'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Categoria modificata con successo!</div></div></div>
	<?php
   }
   if( isset($_GET['mod']) && $_GET['mod'] == "no") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-danger"><i class="fa fa-times"></i> Si &egrave; verificato un errore nella modifica della categoria.</div></div></div>
	<?php
   }
   if( isset($_GET['canc']) && $_GET['canc'] == "ok") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Categoria eliminata con successo!</div></div></div>
	<?php
   }
   if( isset($_GET['canc']) && $_GET['canc'] == "no") {
	?>
	<div class="row">
	<div class="col-sm-12">
	<div class="alert alert-danger"><i class="fa fa-times"></i></span> Si &egrave; verificato un errore nella cancellazione della categoria</div></div></div>
	<?php
   }
   ?>
   
   <div class="row">
   
	<div class="col-sm-12">   
	    <form action="login0.php?corpus=documenti-categorie2" method="post" role="form">
		  <div class="form-group">
			
			<div class="row">
				<div class="col-sm-6">
					<label>Descrizione categoria:</label><input class="form-control" size="40" type="text" name="descrizione" required />			
				</div>
				<div class="col-sm-3">
					<br><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span> Aggiungi Categoria</button>
				</div>
			</div>
			
		  </div>
	</form>
	</div>

	<div class="col-sm-12">   
		<?php
		$categorie = $connessione->query("SELECT COUNT(*) FROM categorie");
		if ($categorie) { 
			$num = $categorie->fetch();
		}
		else { 
			$num[0] = 0; 
		}
		if($num[0] <= 0) {
			echo '<div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> Nessuna categoria registrata.</div>';
		}
		else {

			?>
			<br><label><span class="glyphicon glyphicon-list"></span> Elenco Categorie:</label><br><br>
			<?php

			$risultati = $connessione->query("SELECT DISTINCT * FROM categorie");
			?>
			<table class="table table-striped table-hover">
			<tr>
			<td><b>Descrizione</b></td><td><b>Opzioni</b></td>
			</tr>
			<?php
			while($risultati2 = $risultati->fetch()) {
				$risultati2 = array_map ("stripslashes",$risultati2);
				echo '<tr>';
				echo '<td>' . $risultati2['categoria'] . '</td>
					<td>
					<div class="btn-group btn-group-xs">
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
<?php 
	$_SESSION['my_database']=serialize($my_database);
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO CATEGORIE' , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
?>