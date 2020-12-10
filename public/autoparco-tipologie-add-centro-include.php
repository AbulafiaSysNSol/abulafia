<?php

if ($_SESSION['auth'] < 1 ) {
    header("Location: index.php?s=1");
    exit();
}

?>

<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title"><strong><i class="fa fa-plus-circle"></i> Aggiungi tipologia veicoli</strong></h3>
            </div>

            <div class="panel-body">

                <form class="form-horizontal" role="form" name="modulo" method="post" action="autoparco-tipologie-add2.php">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Descrizione:</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" class="form-control input-sm" name="descrizione" required>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm-2 col-sm-offset-3">
                            <button class="btn btn-lg btn-success" type="submit"><span class="glyphicon glyphicon-check"></span> Inserisci</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
