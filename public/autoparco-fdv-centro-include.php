<?php
    //inserire controllo per evitare che si possa generare più di una check per ogni prenotazione veicolo, la check puo essere fatta solo da autista
    $data = date('d-m-Y');
    $ora = date('H:i');
    $id = $_GET['veicolo'];
    $v = new Veicolo();
    $info = $v->infoVeicolo($id);

?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="col-sm-6">
                <h4><i class="fa fa-tag"></i> Targa: <?php echo $info['targa']; ?></h4>
                <h4><i class="fa fa-calendar-o"></i> Data: <?php echo $data; ?></h4>
                <h4><i class="fa fa-clock-o"></i> Ora: <?php echo $ora; ?></h4>
            </div>
            <div class="col-sm-6">
                <h4><i class="fa fa-user-o"></i> Autista:</h4>
            </div>
            <h3 class="panel-title">
                <center><h5><i class="fa fa-warning fa-fw"></i> Il numero di protocollo verr&agrave; assegnato dopo aver concluso l'inserimento dei dati.</h5>
                    <h5><i class="fa fa-info-circle fa-fw"></i> Identificativo Provvisorio Protocollo: <strong><?php echo $my_lettera->idtemporaneo;?>.</strong></h5></center>
                <?php if($errore) {
                    echo "<center><b><i class=\"fa fa-warning\"></i> ATTENZIONE:</b> Bisogna inserire almeno un mittente o un destinatario.</center>";
                } ?>
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <h3><b><i class="fa fa-wrench"></i> Controllo Meccanico </b></h3>
                    <hr>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Controllo</th>
                            <th scope="col">1/4</th>
                            <th scope="col">1/2</th>
                            <th scope="col">3/4</th>
                            <th scope="col">1</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Carburante</th>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Controllo</th>
                                <th scope="col">Min</th>
                                <th scope="col">Med</th>
                                <th scope="col">Max</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">Olio Motore</th>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Liquido dei freni</th>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Liquido Radiatore</th>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Pneumatici (stato)</th>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Controllo</th>
                            <th scope="col">Si</th>
                            <th scope="col">No</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Ruota di Scorta</th>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <!--form caricamento allegati-->
                        <form id="uploadForm" role="form" enctype="multipart/form-data" action="login0.php?corpus=prot-modifica-file" method="POST">
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />
                                    <label for="exampleInputFile"> <i class="fa fa-upload"></i> Carica allegati:</label>
                                    <small>&egrave; possibile scegliere pi&ugrave; file alla volta;</small>
                                    <input required id="uploadedfile" name="uploadedfile[]" type="file" multiple="multiple" class="filestyle" data-buttonBefore="true" data-placeholder="nessun file selezionato.">
                                    <br>
                                    <button id="buttonload" onclick="showbar();" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Caricamento in corso...attendere!" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span> Allega File </button>
                                    <br><br>
                                    <div class="progress" id="progress" style="display: none;">
                                        <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php
                    if (count($my_lettera->arrayallegati)> 0) {
                        ?>
                        <i class="fa fa-folder-o"></i> <b>File associati:</b>
                        <table class="table table-condensed">
                            <?php
                            foreach ($my_lettera->arrayallegati as $elencochiavi => $elencoallegati ) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $my_file->getIcon($my_file->estensioneFile($elencochiavi)); ?>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <?php echo $elencochiavi.' '; ?>
                                    </td>
                                    <td>
                                        <a class="fancybox btn btn-info btn-sm" data-fancybox-type="iframe" href="<?php echo 'lettere'.$annoprotocollo.'/temp/'.$elencochiavi;?>"><i class="fa fa-file-o fa-fw"></i></a>
                                        <a class="btn btn-danger btn-sm" href="login0.php?corpus=protocollo2&from=eliminaallegato&nome=<?php echo $elencochiavi;?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                    else {
                        echo "Nessun file associato.";
                    }
                    ?>

                    <div class="row">
                        <div class ="col-sm-12" id="content" style="display: none;">
                            <br>
                            <i class="fa fa-spinner fa-spin"></i><b> Caricamento allegato in corso...</b>
                            <br><img src="images/progress.gif">
                        </div>
                    </div>

                    <hr>
                    <?php

                    if($errore) { echo "<div class=\"alert alert-danger\">"; }
                    $my_lettera->publcercamittente($idlettera,''); //richiamo del metodo
                    if($errore) { echo "</div>"; }

                    if (count($my_lettera->arraymittenti)> 0) {
                        echo "<br><b><i class=\"fa fa-users\"></i> Mittenti/Destinatari attuali: </b>";
                        ?>
                        <table class="table table-condensed">
                            <?php
                            foreach ($my_lettera->arraymittenti as $elencochiavi => $elencomittenti ) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle" width="12%">
                                        <img src="<?php echo $my_anagrafica->getFoto($elencochiavi); ?>" class="img-circle img-responsive">
                                    </td>
                                    <td style="vertical-align: middle">
                                        <?php echo stripslashes($elencomittenti).' '; ?>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <a href="anagrafica-mini.php?id=<?php echo $elencochiavi ?>" class="fancybox btn btn-info btn-sm" data-fancybox-type="iframe">
                                            <i class="fa fa-info-circle fa-fw"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="login0.php?corpus=protocollo2&from=elimina-mittente&idanagrafica=<?php echo $elencochiavi;?>"><i class="fa fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                    else {
                        echo 'Nessun mittente/destinatario associato.<br>';
                    }
                    echo '<br>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <h3><b><small><i class="fa fa-square-o"></i></small> Secondo Step: <small>dettagli della lettera <i class="fa fa-file-text-o"></i></b></small></h3>
                    <hr>
                    <form name="modulo" method="post" >

                        <div class="form-group">
                            <label> <span class="glyphicon glyphicon-sort"></span> Spedita/Ricevuta</label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <select class="form-control" size="1" cols=4 type="text" name="spedita-ricevuta" />
                                    <option value="ricevuta" <?php if( ($errore || $add) && isset($_SESSION['spedita-ricevuta']) && $_SESSION['spedita-ricevuta'] == "ricevuta") {echo "selected";} ?>> Ricevuta</option>
                                    <option value="spedita" <?php if( ($errore || $add) && isset($_SESSION['spedita-ricevuta']) && $_SESSION['spedita-ricevuta'] == "spedita") {echo "selected";} ?>> Spedita</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label> <span class="glyphicon glyphicon-asterisk"></span> Oggetto della lettera:</label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <input required type="text" class="form-control" name="oggetto" <?php if( ($errore || $add) && isset($_SESSION['oggetto']) ) { echo "value=\"".$_SESSION['oggetto']."\"";} ?> >
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label> <span class="glyphicon glyphicon-calendar"></span> Data della lettera:</label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="text" class="form-control datepickerProt" name="data" <?php if( ($errore || $add) && isset($_SESSION['data']) ) { echo "value=\"".$_SESSION['data']."\"";} else { echo 'value='.date("d/m/Y"); } ?> >
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label> <span class="glyphicon glyphicon-briefcase"></span> Mezzo di trasmissione:</label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <select class="form-control" size=1 cols=4 NAME="posizione">
                                        <option value="posta ordinaria" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "posta ordinaria") {echo "selected"; $sel=1;} ?>> Posta Ordinaria</option>
                                        <option value="raccomandata"<?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "raccomandata") {echo "selected"; $sel=1;} ?>> Raccomandata</option>
                                        <option Value="telegramma" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "telegramma") {echo "selected"; $sel=1;} ?>> Telegramma</option>
                                        <option value="fax" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "fax") {echo "selected"; $sel=1;} ?>> Fax</option>
                                        <option value="email" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "email") {echo "selected"; $sel=1;} if(!$sel) {echo 'selected';} ?>> Email</option>
                                        <option value="consegna a mano" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "consegna a mano") {echo "selected"; $sel=1;} ?>> Consegna a Mano</option>
                                        <option value="PEC" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "PEC") {echo "selected"; $sel=1;} ?>> PEC</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-11">
                                    <label> <i class="fa fa-archive"></i> Titolazione:</label>
                                    <?php
                                    $risultati = $connessione->query("SELECT DISTINCT * FROM titolario");
                                    ?>
                                    <select class="form-control" size=1 cols=4 NAME="riferimento">
                                        <option value="">nessuna titolazione
                                            <?php
                                            while ($risultati2 = $risultati->fetch()) {
                                                $risultati2 = array_map("stripslashes",$risultati2);
                                                if( ($errore || $add) && isset($_SESSION['riferimento']) && $_SESSION['riferimento'] == $risultati2['codice'] ) {
                                                    echo '<option selected value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
                                                }
                                                else {
                                                    echo '<option value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-11">
                                    <label> <i class="fa fa-tag"></i> Pratica:</label>
                                    <?php
                                    $risultati = $connessione->query("SELECT DISTINCT * FROM pratiche");
                                    ?>
                                    <select class="form-control" size=1 cols=4 NAME="pratica">
                                        <option value="">nessuna pratica
                                            <?php
                                            while ($risultati2 = $risultati->fetch()) {
                                                $risultati2 = array_map("stripslashes",$risultati2);
                                                if( ($errore || $add) && isset($_SESSION['pratica']) && $_SESSION['pratica'] == $risultati2['id'] ) {
                                                    echo '<option selected value="' . $risultati2['id'] . '">' . $risultati2['descrizione'];
                                                }
                                                else {
                                                    echo '<option value="' . $risultati2['id'] . '">' .  $risultati2['descrizione'];
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label> <span class="glyphicon glyphicon-comment"></span> Note:</label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" name="note" <?php if( ($errore || $add) && isset($_SESSION['note'])) { echo "value=\"".$_SESSION['note']."\"";} ?>>
                                </div>
                            </div>
                        </div>

                        <button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Registrazione in corso..." type="button" class="btn btn-success btn-lg" onClick="Controllo()"><span class="glyphicon glyphicon-plus-sign"></span> Registra Lettera</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
$_SESSION['my_lettera']=serialize($my_lettera);//serializzazione per passaggio dati alla sessione
?>

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

        function changeSelect() {
            var type = document.modale.anagraficatipologia.options[document.modale.anagraficatipologia.selectedIndex].value;
            if (type == "persona") {
                document.getElementById("lblcognome").style.display="table";
                document.getElementById("lblden").style.display="none";
                document.getElementById("txtnome").style.display="table";
                document.getElementById("txtnome").required = true;
                document.getElementById("lblnome").style.display="table";
            }
            if (type == "carica") {
                document.getElementById("lblcognome").style.display="none";
                document.getElementById("lblnome").style.display="none";
                document.getElementById("lblden").style.display="table";
                document.getElementById("txtnome").style.display="none";
                document.getElementById("txtnome").required = false;
            }
            if (type == "ente") {
                document.getElementById("lblcognome").style.display="none";
                document.getElementById("lblnome").style.display="none";
                document.getElementById("lblden").style.display="table";
                document.getElementById("txtnome").style.display="none";
                document.getElementById("txtnome").required = false;
            }
            if (type == "fornitore") {
                document.getElementById("lblcognome").style.display="none";
                document.getElementById("lblnome").style.display="none";
                document.getElementById("lblden").style.display="table";
                document.getElementById("txtnome").style.display="none";
                document.getElementById("txtnome").required = false;
            }
        }
        function loading()

        {
            if(document.getElementById("exampleInputFile").value != '') {
                document.getElementById("content").style.display="table";
            }
        }

        function Controllo()
        {
            //acquisisco il valore delle variabili
            var oggetto = document.modulo.oggetto.value;


            //controllo coerenza dati

            if ((oggetto == "") || (oggetto == "undefined"))
            {
                alert("Il campo OGGETTO e' obbligatorio");
                document.modulo.oggetto.focus();
                return false;
            }

            //mando i dati alla pagina
            else
            {
                document.modulo.action = "login0.php?corpus=protocollo3";
                document.modulo.submit();
            }
        }
        //-->
    </script> <?php
