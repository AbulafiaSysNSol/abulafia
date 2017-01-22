<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><b><i class="fa fa-bars"></i> Gestione Settori Magazzino</b></h3>
  </div>
  <div class="panel-body">
  
<?php
	$m = new Magazzino();
	
	if( isset($_GET['add']) && $_GET['add'] == "ok") {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Nuovo settore aggiunto!</div></div></div>
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
		<div class="alert alert-danger">Impossibile aggiungere: esiste già un settore con lo stesso nome!</div></div></div>
		<?php
	}
	if( isset($_GET['mod']) && $_GET['mod'] == "ok") {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Settore modificato con successo!</div></div></div>
		<?php
	}
	if( isset($_GET['mod']) && $_GET['mod'] == "no") {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella modifica della descrizione.</div></div></div>
		<?php
	}
	if( isset($_GET['canc']) && $_GET['canc'] == "ok") {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Settore eliminato con successo!</div></div></div>
		<?php
	}
	if( isset($_GET['canc']) && $_GET['canc'] == "no") {
		?>
		<div class="row">
		<div class="col-sm-12">
		<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Si è verificato un errore nella cancellazione del settore</div></div></div>
		<?php
	}
?>
  	
	<div class="row">
		<div class="col-sm-12">   
		    <form action="login0.php?corpus=magazzino-settori2" method="post" role="form">
			  <div class="form-group">
				<div class="row">
					<div class="col-sm-8">
						<label>Descrizione Settore:</label><input class="form-control" type="text" name="descrizione" required />			
					</div>
			
					<div class="col-sm-4">
						<br><button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span> Aggiungi Settore</button>
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
				$settori = $m->getSettori();
			?>
			
			<label><i class="fa fa-cubes"></i> Elenco Settori:</label><br><br>
			<table class="table table-striped table-hover">
				<tr>
					<td><b>Codice</b></td><td><b>Descrizione</b></td><td><b>Opzioni</b></td>
				</tr>
				<?php
				foreach ($settori as $val) { 
					?>
					<tr>
						<td><?php echo $val['id']; ?></td><td><?php echo stripslashes($val['descrizione']); ?></td>
						<td>
							<div class="btn-group btn-group-sm">
								<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica Settore" href="login0.php?corpus=magazzino-modifica-settore&id=<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></button> Modifica</a> 
								<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina Settore" onClick="return confirm('Vuoi veramente cancellare questo settore?');" href="login0.php?corpus=magazzino-elimina-settore&id=<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-trash"></span></button> Elimina</a>
							</div>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		</div>
	</div>

</div>
</div>
<?php 
	$_SESSION['my_database']=serialize($my_database);
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO SETTORI' , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
?>