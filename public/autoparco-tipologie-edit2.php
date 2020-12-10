<?php

    session_start();

    function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
        require_once "class/" . $class_name.".obj.inc";
    }

    if ($_SESSION['auth'] < 1 ) {
        header("Location: index.php?s=1");
        exit();
    }

    include 'class/Log.obj.inc';
    include '../db-connessione-include.php';
    include 'class/Tipologia-veicolo.obj.inc';

    $p = new Tipologia_veicolo();

    $id = $_POST['id'];
    $descrizione = $_POST['descrizione'];

    $result = $p -> editTipologia($id, $descrizione);

    if($result) {
        ?>
        <script>
            window.location="login0.php?corpus=autoparco-tipologie&mod=ok";
        </script>
        <?php
    }
    else {
        ?>
        <script>
            window.location="login0.php?corpus=autoparco-tipologie&mod=error";
        </script>
        <?php
    }

?>
