<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

<?php

	$id = $_GET['id'];

?>

<!-- Modal -->
	<form action="registra-protocollo.php?id=<?php echo $id; ?>" method="POST" name="modaleprotocolla">
		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-book"></i> Inserisci dettagli mancanti lettera <?php echo $id; ?></h4>
					</div>
	      
					<div class="modal-body">
						<div class="form-group">
							<label> <span class="glyphicon glyphicon-briefcase"></span> Mezzo di trasmissione:</label>
							<div class="row">
								<div class="col-xs-5">
									<select class="form-control" size=1 cols=4 NAME="posizione">
									<OPTION selected value="">
									<OPTION value="posta ordinaria"> posta ordinaria
									<OPTION value="raccomandata"> raccomandata
									<OPTION Value="telegramma"> telegramma
									<OPTION value="fax"> fax
									<OPTION value="email"> email
									<OPTION value="consegna a mano"> consegna a mano
									<OPTION value="PEC"> PEC
									</select>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-xs-8">
							<label> <i class="fa fa-archive"></i> Titolazione:</label>
							<?php
							$risultati=mysql_query("select distinct * from titolario");
							?>
							<select class="form-control" size=1 cols=4 NAME="riferimento">
							<option value="">nessuna titolazione
							<?php
							while ($risultati2=mysql_fetch_array($risultati))
							{
								$risultati2 = array_map("stripslashes",$risultati2);
								echo '<option value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
							}
							echo '</select>';
							?>
							</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="row">
							<div class="col-xs-8">
							<label> <i class="fa fa-tag"></i> Pratica:</label>
							<?php
							$risultati=mysql_query("select distinct * from pratiche");
							?>
							<select class="form-control" size=1 cols=4 NAME="pratica">
							<option value="">nessuna pratica
							<?php
							while ($risultati2=mysql_fetch_array($risultati))
							{
								$risultati2 = array_map("stripslashes",$risultati2);
								echo '<option value="' . $risultati2['id'] . '">' .  $risultati2['descrizione'];
							}
							echo '</select>';
							?>
							</div>
							</div>
						</div>
						
						<label> <span class="glyphicon glyphicon-comment"></span> Note:</label>
						<input type="text" class="form-control" name="note">
			
					</div>
			
					<div class="modal-footer">
						<a href="?corpus=elenco-lettere"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i> Chiudi</button></a>
						<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Registra Lettera</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->