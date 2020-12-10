
<!-- Modal -->
<form action="?corpus=inserimento.rapido.anagrafica&idlettera=<?php echo $idlettera; ?>" method="POST" name="modale">
    <div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Inserimento rapido in anagrafica</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipologia:</label>
                        <div class="row">
                            <div class="col-sm-5">
                                <select class="form-control input-sm" name="anagraficatipologia" onChange="changeSelect()">
                                    <OPTION value="persona"> Persona Fisica</OPTION>
                                    <OPTION value="carica"> Carica Elettiva o Incarico</OPTION>
                                    <OPTION Value="ente"> Ente</OPTION>
                                    <OPTION Value="fornitore"> Fornitore</OPTION>
                                </select>
                            </div>
                        </div>
                        <br>
                        <label id="lblcognome">Cognome:</label>
                        <label id="lblden" style="display: none;">Denominazione:</label>
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm" name="cognome" required>
                            </div>
                        </div>
                        <br>
                        <label id="lblnome">Nome:</label>
                        <div class="row">
                            <div class="col-sm-8">
                                <input id="txtnome" type="text" class="form-control input-sm" name="nome" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Chiudi</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-arrow-down"></i> Salva ed associa al protocollo</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--End Modal-->

<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title"><strong><i class="fa fa-user-circle"></i> Volontari autorizzabili</strong></h3>
    </div>

    <div class="panel-body">

        <?php

        $a = new Anagrafica();

        if(!$a->isRespco($_SESSION['loginid']) || !$a->isAdmin($_SESSION['loginid']) ){ //migliorare la sicurezza
            header("Location: index.php?s=1");
            exit();
        }

        if (isset($_GET['delete']) &&($_GET['delete'] == 'ok')) {
            ?>
            <center><div class="alert alert-danger"><i class="fa fa-trash"></i> Autorizzazione volontario rimossa <b>correttamente!</b></div></center>
            <?php
        }

        if (isset($_GET['add']) &&($_GET['add'] == 'ok')) {
            ?>
            <center><div class="alert alert-success"><i class="fa fa-save"></i> Autorizzazione volontario inserita <b>correttamente!</b></div></center>
            <?php
        } ?>

        <div align="right">
            <a href="?corpus=inserimento.rapido.anagrafica&idlettera=<?php echo $idlettera; ?>"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Aggiungi volontario</button></a><br><br>
        </div>

        <script type="text/javascript" src="livesearch-co-volontari-aggiungi.js" onLoad="showResult('','25')"></script>
        <form name="cercato" onSubmit="return false">
            <div class="row">
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-search"></i></div><input placeholder="digita il nome, il cognome o il codice fiscale" type="text" name="valore" class="form-control" onkeyup="showResult(this.value,numero.value)">
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
