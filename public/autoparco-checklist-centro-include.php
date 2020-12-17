<?php

    //inserire controllo per evitare che si possa generare più di una check per ogni prenotazione veicolo, la check puo essere fatta solo da autista
    $data = date('d-m-Y');
    $ora = date('H:i');
    $id = $_GET['veicolo'];
    $v = new Veicolo();
    $info = $v->infoVeicolo($id);
    $u = new Anagrafica;
    $utente = $u->getName($_SESSION['loginid']);

?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <h4><i class="fa fa-tag"></i> Targa: <?php echo $info['targa']; ?></h4>
                    <h4><i class="fa fa-podcast"></i> Selettiva: <?php echo $info['selettiva']; ?></h4>
                    <h4><i class="fa fa-car"></i> Tipologia veicolo: <?php echo $info['tipologia']; ?></h4>
                </div>
                <div class="col-sm-6">
                    <h4><i class="fa fa-user-o"></i> Autista: <?php echo $utente; ?></h4>
                    <h4><i class="fa fa-calendar-o"></i> Data: <?php echo $data; ?></h4>
                    <h4><i class="fa fa-clock-o"></i> Ora: <?php echo $ora; ?></h4>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <label> <span class="glyphicon glyphicon-road"></span> Km:</label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="note" id="km">
                            </div>
                        </div>
                    </div>
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
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="carburante" id="carb1">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="carburante" id="carb2">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="carburante" id="carb3">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="carburante" id="carb4">
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
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="olio" id="olio_min">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="olio" id="olio_med">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="olio" id="olio_max">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Liquido dei freni</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="liquidofreni" id="liquidofreni_min">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="liquidofreni" id="liquidofreni_med">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="liquidofreni" id="liquidofreni_max">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Liquido Radiatore</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="liquidoradiatore" id="liquidoradiatore_min">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="liquidoradiatore" id="liquidoradiatore_med">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="liquidoradiatore" id="liquidoradiatore_max">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Pneumatici (stato)</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pneumatici" id="pneumatici_min">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pneumatici" id="pneumatici_med">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pneumatici" id="pneumatici_max">
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
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ruotascorta" id="ruotascorta_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="ruotascorta" id="ruotascorta_no">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h3><b><i class="fa fa-lightbulb-o"></i> Controllo Elettrico </b></h3>
                    <hr>
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
                            <th scope="row">Luci di posizione</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="luciposizione" id="luciposizione_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="luciposizione" id="luciposizione_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Luci anabbaglianti</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lucianabbaglianti" id="lucianabbaglianti_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lucianabbaglianti" id="lucianabbaglianti_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Fendinebbia</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lucianabbaglianti" id="lucianabbaglianti_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lucianabbaglianti" id="lucianabbaglianti_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Stop</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="stop" id="stop_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="stop" id="stop_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Fari posteriori di carico</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="faricarico" id="faricarico_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="faricarico" id="faricarico_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Lampeggiatori</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lampeggiatori" id="lampeggiatori_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="lampeggiatori" id="lampeggiatori_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Sirena</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sirena" id="sirena_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sirena" id="sirena_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Frecce</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frecce" id="frecce_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frecce" id="frecce_no">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h3><b><i class="fa fa-tachometer"></i> Dotazioni vano guida </b></h3>
                    <hr>
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
                            <th scope="row">Radio portatile</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioportatile" id="radioportatile_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioportatile" id="radioportatile_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Borsa attrezzi (cric e chiave)</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="borsaattrezzi" id="borsaattrezzi_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="borsaattrezzi" id="borsaattrezzi_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Kit da scasso</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kitdascasso" id="kitdascasso_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kitdascasso" id="kitdascasso_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Card carburante</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cardcarburante" id="cardcarburante_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cardcarburante" id="cardcarburante_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Carta di circolazione</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cartacircolazione" id="cartacircolazione_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cartacircolazione" id="cartacircolazione_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Assicurazione</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="assicurazione" id="assicurazione_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="assicurazione" id="assicurazione_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Revisione annuale</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="revisione" id="revisione_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="revisione" id="revisione_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Frigorifero</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frigorifero" id="frigorifero_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frigorifero" id="frigorifero_no">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Estintore</th>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estintore" id="estintore_si">
                                </div>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estintore" id="estintore_no">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <?php if($info['tipologia'] == "Ambulanza"){ ?>
                    <div class="col-sm-6">
                        <h3><b><i class="fa fa-ambulance"></i> Dotazioni vano sanitario </b></h3>
                        <hr>
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
                                <th scope="row">Barella autocaricante</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="barellaautocaricante" id="barellaautocaricante_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="barellaautocaricante" id="barellaautocaricante_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Sedia portantina con 2 cinghie</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sediaportantina" id="sediaportantina_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sediaportantina" id="sediaportantina_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Tavola spinale</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tavolaspinale" id="tavolaspinale_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tavolaspinale" id="tavolaspinale_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Imbracatura ragno</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imbracaturaragno" id="imbracaturaragno_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="imbracaturaragno" id="imbracaturaragno_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Fermacapo</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fermacapo" id="fermacapo_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fermacapo" id="fermacapo_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Collari cervicali</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="collaricervicali" id="collaricervicali_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="collaricervicali" id="collaricervicali_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Stecche rigide</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="steccherigide" id="steccherigide_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="steccherigide" id="steccherigide_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Stecche a depressione con pompa</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="stecchedepressione" id="stecchedepressione_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="stecchedepressione" id="stecchedepressione_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Ked</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ked" id="ked_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ked" id="ked_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Materasso a depressione con pompa</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="materassodepressione" id="materassodepressione_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="materassodepressione" id="materassodepressione_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Telo portaferiti</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="teloportaferiti" id="teloportaferiti_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="teloportaferiti" id="teloportaferiti_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Monitor Multiparametrico</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="monitormultiparametrico" id="monitormultiparametrico_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="monitormultiparametrico" id="monitormultiparametrico_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Defibrillatore semiautomatico</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="defibrillatore" id="defibrillatore_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="defibrillatore" id="defibrillatore_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Respiratore automatico fisso</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="respiratoreautomatico" id="respiratoreautomatico_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="respiratoreautomatico" id="respiratoreautomatico_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Aspiratore fisso</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aspiratorefisso" id="aspiratorefisso_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aspiratorefisso" id="aspiratorefisso_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Aspiratore portatile</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aspiratoreportatile" id="aspiratoreportatile_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aspiratoreportatile" id="aspiratoreportatile_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Va e vieni adulto</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="vaevieniadulto" id="vaevieniadulto_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="vaevieniadulto" id="vaevieniadulto_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Va e vieni pediatrico</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="vaevienipediatrico" id="vaevienipediatrico_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="vaevienipediatrico" id="vaevienipediatrico_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Laringoscopio 4 lame</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="laringoscopio" id="laringoscopio_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="laringoscopio" id="laringoscopio_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1 Bombola O2 lt. 2</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bombola2lt" id="bombola2lt_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bombola2lt" id="bombola2lt_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2 Bombole O2 lt. 7 impianto fisso</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bombola7lt" id="bombola7lt_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="bombola7lt" id="bombola7lt_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kit ferri chirurgici</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kitferrichirurgici" id="kitferrichirurgici_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kitferrichirurgici" id="kitferrichirurgici_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Forbice di Robin</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="forbicerobin" id="forbicerobin_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="forbicerobin" id="forbicerobin_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Cinture di sicurezza</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cinturesicurezza" id="cinturesicurezza_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cinturesicurezza" id="cinturesicurezza_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Coperta isotermica</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="copertaisotermica" id="copertaisotermica_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="copertaisotermica" id="copertaisotermica_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">COntenitore porta rifiuti</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rifiuti" id="rifiuti_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rifiuti" id="rifiuti_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3 Paia di occhiali protettivi</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="occhialiprotettivi" id="occhialiprotettivi_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="occhialiprotettivi" id="occhialiprotettivi_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Mascherine protettive</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mascherineprotettive" id="mascherineprotettive_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mascherineprotettive" id="mascherineprotettive_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Guanti</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guanti" id="guanti_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="guanti" id="guanti_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3 Caschi</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="caschi" id="caschi_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="caschi" id="caschi_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Estintore</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="estintore2" id="estintore2_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="estintore2" id="estintore2_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Kit biocontenimento (visiere + tute complete)</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kitbio" id="kitbio_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kitbio" id="kitbio_no">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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



                            <button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Registrazione in corso..." type="button" class="btn btn-success btn-lg" onClick="Controllo()"><span class="glyphicon glyphicon-plus-sign"></span> Registra Lettera</button>
                        </form>
                    </div>
                <?php } ?>
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
    </script>