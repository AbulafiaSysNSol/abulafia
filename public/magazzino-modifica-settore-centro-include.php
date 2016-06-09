<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-bars"></i> Gestione Settori Magazzino - Modifica</b></h3>
	</div>
  <div class="panel-body">
  
<?php
	$m = new Magazzino();
	$id = $_GET['id'];
	$descrizione = $m->getSettoreById($id);
?>
   
   <div class="row">

	<div class="col-sm-6">   
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
						<div class="btn-group btn-group-xs">
							<a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica Settore" href="login0.php?corpus=magazzino-modifica-settore&id=<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-pencil"></span></button></a> 
							<a class="btn btn-danger"data-toggle="tooltip" data-placement="left" title="Elimina Settore" onClick="return confirm('Vuoi veramente cancellare questo settore?');" href="login0.php?corpus=magazzino-elimina-settore&id=<?php echo $val['id']; ?>"><span class="glyphicon glyphicon-trash"></button></a>
						</div>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div>
	
	<div class="col-sm-6">   
	 <label><span class="glyphicon glyphicon-plus"></span> Modifica Settore: "<?php echo $id . ' - ' . $descrizione; ?>"</label><br><br>
	    <form action="login0.php?corpus=magazzino-modifica-settore2&id=<?php echo $id; ?>" method="post" role="form">
		  <div class="form-group">
			<div class="row">
				<div class="col-sm-12">
					<label>Descrizione Settore:</label><input class="form-control" type="text" value="<?php echo $descrizione; ?>" name="descrizione" required />			
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<br><button type="submit" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-plus"></span> Modifica Settore</button>
				</div>
			</div>
		  </div>
	</form>
	<a href="login0.php?corpus=magazzino-settori"><b>Indietro</b></a>
	</div>
	
</div>

</div>
</div>
<?php 
	$_SESSION['my_database']=serialize($my_database);
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO MODIFICA SETTORE - ' . $descrizione , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
?>