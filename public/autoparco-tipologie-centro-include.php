<?php

    if ($_SESSION['auth'] < 1 ) {
            header("Location: index.php?s=1");
            exit();
        }

?>

<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title"><strong><i class="fa fa-car"></i> Elenco tipologie veicoli:</strong></h3>
    </div>

    <div class="panel-body">

        <?php
            if (isset($_GET['insert']) && $_GET['insert'] == 'ok') {
                ?>
                <center><div class="alert alert-success"><i class="fa fa-check"></i> Tipologia veicolo inserita <b>correttamente!</b></div></center>
                <?php
            }

            if (isset($_GET['insert']) && $_GET['insert'] == 'error') {
                ?>
                <center><div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Tipologia veicolo non inserita <b>correttamente!</b> Controlla che non sia già presente!</div></center>
                <?php
            }

            if (isset($_GET['mod']) && $_GET['mod'] == 'ok') {
                ?>
                <center><div class="alert alert-success"><i class="fa fa-check"></i> Tipologia veicolo modificata <b>correttamente!</b></div></center>
                <?php
            }

            if (isset($_GET['mod']) && $_GET['mod'] == 'error') {
                ?>
                <center><div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Tipologia veicolo non modificata! Controlla che non sia già presente!</div></center>
                <?php
            }

        ?>

        <div align="left">
            <a href="?corpus=autoparco-tipologie-add"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Aggiungi Tipologia Veicolo</button></a><br><br>
        </div>

        <script type="text/javascript" src="livesearch-autoparco-tipologie.js" onLoad="showResult('','25')"></script>
        <form name="cercato" onSubmit="return false">
            <div class="row">
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita la tipologia di veicolo..." type="text" name="valore" class="form-control" onkeyup="showResult(this.value,numero.value)">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-list-ol"></i> N. Risultati:</div>
                        <select class="form-control" name="numero" onChange="showResult(valore.value,this.value)">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <br>
        <div id="livesearch">
            <!-- spazio riservato ai risultati live della ricerca -->
        </div>

    </div>
</div>


