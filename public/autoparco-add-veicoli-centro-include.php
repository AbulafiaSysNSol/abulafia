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

        <form class="form-horizontal" action="autoparco-add-veicoli2.php" role="form" name="modulo" method="post" >

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
                                        echo "<option value=$a>$a</option>";
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
                        <input type="text" class="form-control input-sm" minlength="7" maxlength="8" name="selettiva">
                    </div>

                    <label class="col-sm-2 control-label"> Carica libretto:</label>
                    <div class="col-sm-5">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
                        <input required id="uploadedfile" name="uploadedfile[]" type="file" multiple="multiple" class="filestyle" data-buttonBefore="true" data-placeholder="nessun file selezionato.">
                        <br>
                        <button id="buttonload" onclick="showbar();" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Caricamento in corso...attendere!" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span> Allega File </button>
                        <br><br>
                        <div class="progress" id="progress" style="display: none;">
                            <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            </div>
                        </div>
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

<script>
    $("#buttonl").click(function() {
        var $btn = $(this);
        var oggetto = document.modulo.oggetto.value;
        if ((oggetto == "") || (oggetto == "undefined")) {
            return false;
        }
        else {
            $btn.button('loading');
        }
    });

    $("#buttonload").click(function() {
        var $btn = $(this);
        if(document.getElementById("uploadedfile").value != '') {
            $btn.button('loading');
        }
    });
</script>

<script language="javascript">

    <!--
    function showbar() {
        if(document.getElementById("uploadedfile").value != '') {
            document.getElementById("progress").style.display="block";
        }
    }


    function loading()

    {
        if(document.getElementById("exampleInputFile").value != '') {
            document.getElementById("content").style.display="table";
        }
    }


    //-->
</script>