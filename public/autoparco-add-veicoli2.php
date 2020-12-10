<?php

    session_start();

    function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
        require_once "class/" . $class_name.".obj.inc";
    }

    include 'class/Log.obj.inc';
    include '../db-connessione-include.php';
    include 'maledetti-apici-centro-include.php';

    if ($_SESSION['auth'] < 1 ) {
        header("Location: index.php?s=1");
        exit();
    }

    $a = new Veicolo();
    $c = new Calendario();


    $targa = $_POST['targa'];
    $tipologia = $_POST['tipologia'];
    $selettiva = $_POST['selettiva'];

    $result = $a->insertVeicolo($targa, $tipologia, $selettiva);

    if($result) {
        ?>
        <script>
            window.location="login0.php?corpus=autoparco-add-veicoli&insert=ok";
        </script>
        <?php
    }
    else {
        ?>
        <script>
            window.location="login0.php?corpus=autoparco-add-veicoli&insert=error";
        </script>
        <?php
    }
?>