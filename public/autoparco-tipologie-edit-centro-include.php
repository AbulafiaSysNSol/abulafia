<?php

    if ($_SESSION['auth'] < 1 ) {
        header("Location: index.php?s=1");
        exit();
    }

    include 'class/Tipologia-veicolo.obj.inc';

    $id = $_GET['id'];

    $a = new Anagrafica();
    $c = new Calendario();
    $t = new Tipologia_veicolo();

    $info = $t->infoTipologia($id);
?>

<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><strong><i class="fa fa-plus-circle"></i> Modifica tipologia veicoli</strong></h3>
            </div>

            <div class="panel-body">

                <form class="form-horizontal" role="form" name="modulo" method="post" action="autoparco-tipologie-edit2.php">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Descrizione:</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" class="form-control input-sm" name="descrizione" value="<?php echo $info['descrizione']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-3">
                            <button class="btn btn-lg btn-success" type="submit"><span class="glyphicon glyphicon-check"></span> Modifica</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
