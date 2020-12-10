<?php
    include 'class/Tipologia-veicolo.obj.inc';

	$id = $_GET['id'];

	$a = new Veicolo();
	$c = new Calendario();
    $t = new Tipologia_veicolo();

	$info = $a->infoVeicolo($id);
	$tipologie = $t->richiamaTipologie();

	if( isset($_GET['edit']) && $_GET['edit'] == "ok") {
		?>
		<div class="row">
			<div class="col-sm-12">
				<center><div class="alert alert-success"><i class="fa fa-check"></i> Anagrafica aggiornata <b>correttamente!</b></div></center>
			</div>
		</div>
		<?php
	}
?>

<div class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-user-plus"></i> Modifica di un Veicolo</strong></h3>
	</div>

	<div class="panel-body">

		<form class="form-horizontal" action="autoparco-edit-veicoli2.php" role="form" name="modulo" method="post" >

			<input type="hidden" name="id" value="<?php echo $id; ?>">

			<div class="form-group">
				<div class="row">

					<label class="col-sm-2 control-label">Targa:</label>
                    <div class="col-sm-2">
                        <input type="text" value="<?php echo $info['targa']; ?>" class="form-control input-sm" name="targa" required>
                    </div>

                    <label class="col-sm-2 control-label">Tipologia:</label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm" name="tipologia">
                            <?php
                                foreach ( $tipologie as $rows )
                                {
                                    $a = $rows['descrizione'];
                                    $selezionato = '';
                                    if ( $a === $info['tipologia'] ) {
                                        $selezionato = 'selected';
                                    }
                                    echo '<option value="'.$a.'" '.$selezionato.' >'.$a.'</option>';
                                }
                            ?>
                        </select>
                    </div>

				</div>
			</div>

			<div class="form-group">
				<div class="row">

					<label class="col-sm-2 control-label">Selettiva radio:</label>
                    <div class="col-sm-2">
                        <input type="text" value="<?php echo $info['selettiva']; ?>" class="form-control input-sm" minlength="7" maxlength="8" name="selettiva">
                    </div>

				</div>
			</div>

			<br>
			<div class="row">
				<center>
					<button type="submit" class="btn btn-warning btn-lg"><i class="fa fa-edit"></i> Modifica</button>
				</center>
			</div>

		</form>

	</div>
</div>