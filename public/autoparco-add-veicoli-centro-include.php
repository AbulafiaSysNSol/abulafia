<?php

include 'class/Tipologia-veicolo.obj.inc';
$t = new Tipologia_veicolo();

$tipologie = $t->richiamaTipologie();

if( isset($_GET['insert']) && $_GET['insert'] == "ok") {
    ?>
    <div class="row">
        <div class="col-sm-12">
            <center><div class="alert alert-success"><i class="fa fa-check"></i> Veicolo inserito <b>correttamente!</b></div></center>
        </div>
    </div>
    <?php
}

if( isset($_GET['insert']) && $_GET['insert'] == "error") {
    ?>
    <div class="row">
        <div class="col-sm-12">
            <center><div class="alert alert-danger"><i class="fa fa-alert"></i> <b>Attenzione:</b> si &egrave; verificato un errore nell'inserimento. Verifica che il veicolo non sia gi&agrave; inserito.</div></center>
        </div>
    </div>
    <?php
}
?>

<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title"><strong><i class="fa fa-plus-circle"></i> Inserimento di un Veicolo</strong></h3>
    </div>

    <div class="panel-body">

        <form class="form-horizontal" action="autoparco-add-veicoli2.php" role="form" name="modulo" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <div class="row">

                    <label class="col-sm-2 control-label">Targa:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm" name="targa" required>
                    </div>

                    <label class="col-sm-2 control-label">Tipologia:</label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm" name="tipologia">
                            <?php
                                foreach ( $tipologie as $rows ) {
                                    $a = $rows['descrizione'];
                                        echo "<option value = $a> $a </option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

            </div>


            <div class="form-group">
                <div class="row">
                    <label class="col-sm-2 control-label">Selettiva Radio:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control input-sm" minlength="7" maxlength="8" name="selettiva">
                    </div>

                    <label class="col-sm-2 control-label"> Carica Libretto:</label>
                    <div class="col-sm-5">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
                        <input name="uploadedfile[]" type="file" multiple="multiple" class="filestyle" data-buttonBefore="true" data-placeholder="nessun file selezionato.">
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <center>
                    <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-check"></i> Aggiungi Veicolo</button>
                </center>
            </div>


        </form>

    </div>
</div>