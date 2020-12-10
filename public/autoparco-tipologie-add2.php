<?php

    session_start();

    if ($_SESSION['auth'] < 1 ) {
        header("Location: index.php?s=1");
        exit();
    }

    include 'class/Log.obj.inc';
    include '../db-connessione-include.php';
    include 'class/Tipologia-veicolo.obj.inc';
    $p = new Tipologia_veicolo();
    $descrizione = $_POST['descrizione'];

    $result = $p -> inserisciTipologiaveicolo($descrizione);

    if($result) {
        ?>
        <script>
            window.location="login0.php?corpus=autoparco-tipologie&insert=ok";
        </script>
        <?php
    }
    else {
        ?>
        <script>
            window.location="login0.php?corpus=autoparco-tipologie&insert=error";
        </script>
        <?php
    }

?>