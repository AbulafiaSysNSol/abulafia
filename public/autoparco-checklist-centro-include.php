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
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <h3><b><i class="fa fa-medkit"></i> Check List Zaino Sanitario: </b></h3>
                    <hr>
                    <div class="col-sm-3">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><h4>Diagnostica</h4></th>
                                <th scope="col">Si</th>
                                <th scope="col">No</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Sfigmo adulto</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sfigmoadulto" id="sfigmoadulto_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sfigmoadulto" id="sfigmoadulto_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Sfigmo pediatrico</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sfigmopediatrico" id="sfigmopediatrico_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sfigmopediatrico" id="sfigmopediatrico_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Glucotest</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="glucotest" id="glucotest_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="glucotest" id="glucotest_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Saturimetro</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="saturimetro" id="saturimetro_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="saturimetro" id="saturimetro_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Fonendoscopio</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fonendoscopio" id="fonendoscopio_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fonendoscopio" id="fonendoscopio_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Garza sterile</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="garzasterile" id="garzasterile_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="garzasterile" id="garzasterile_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Termometro</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="termometro" id="termometro_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="termometro" id="termometro">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><h4>Kit Full-D</h4></th>
                                <th scope="col">Si</th>
                                <th scope="col">No</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Cannule di Guedel set</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cannuleguedel" id="cannuleguedel_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cannuleguedel" id="cannuleguedel_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Apri bocca</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="apribocca" id="apribocca_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="apribocca" id="apribocca_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Filtri Ambu</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="filtriambu" id="filtriambu_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="filtriambu" id="filtriambu_no">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><h4>Kit Medicazione</h4></th>
                                <th scope="col">Si</th>
                                <th scope="col">No</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Garza sterile</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="garzasterile2" id="garzasterile2_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="garzasterile2" id="garzasterile2_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                            <tr>
                                <th scope="row">Rotoli di garza</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rotoligarza" id="rotoligarza_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rotoligarza" id="rotoligarza_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Cerotto</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cerotto" id="cerotto_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cerotto" id="cerotto_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Acqua ossigenata</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="acquaossigenata" id="acquaossigenata_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="acquaossigenata" id="acquaossigenata_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Forbice</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="forbice" id="forbice_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="forbice" id="forbice_no">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><h4>Kit Infusione</h4></th>
                                <th scope="col">Si</th>
                                <th scope="col">No</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Fisiologica</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fisiologica" id="fisiologica_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="fisiologica" id="fisiologica_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Rubinetto</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rubinetto" id="rubinetto_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rubinetto" id="rubinetto_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Aghi infusione set</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aghiinfusione" id="aghiinfusione_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="aghiinfusione" id="aghiinfusione_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Siringhe</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="siringhe" id="siringhe_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="siringhe" id="siringhe_no">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Laccio emostatico</th>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="laccioemostatico" id="laccioemostatico_si">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="laccioemostatico" id="laccioemostatico_no">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"><h4>Tasca laterale dx</h4></th>
                                        <th scope="col">Si</th>
                                        <th scope="col">No</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">Ghiaccio</th>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ghiaccio" id="ghiaccio_si">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ghiaccio" id="ghiaccio_no">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"><h4>Tasca laterale sx</h4></th>
                                        <th scope="col">Si</th>
                                        <th scope="col">No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Glucosata</th>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="glucosata" id="glucosata_si">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="glucosata" id="glucosata_no">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Metalline</th>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="metalline" id="metalline_si">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="metalline" id="metalline_no">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"><h4>Tasca centrale</h4></th>
                                        <th scope="col">Si</th>
                                        <th scope="col">No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">Ambu Adulto</th>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ambuadulto" id="ambuadulto_si">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ambuadulto" id="ambuadulto_no">
                                        </div>
                                    </td>
                                </tr>
                                    <tr>
                                        <th scope="row">Ambu Pediatrico</th>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ambupediatrico" id="ambupediatrico_si">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="ambupediatrico" id="ambupediatrico_no">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-3">
                        </div>
                    </div>
                </div>
            </div>

                    <form name="modulo" method="post" >
                            <button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Salvataggio in corso..." type="button" class="btn btn-success btn-lg" onClick="Controllo()"><span class="glyphicon glyphicon-floppy-disk"></span> Salva Chek List</button>
                    </form>
                    <?php } ?>
    </div>
</div>