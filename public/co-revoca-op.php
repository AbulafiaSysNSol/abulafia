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

    $a = new Anagrafica();

    if(!$a->isRespco($_SESSION['loginid']) || !$a->isAdmin($_SESSION['loginid']) ){ //migliorare la sicurezza
        header("Location: index.php?s=1");
        exit();
    }

    $id = $_GET['id'];

    $result = $a->revocaOP($id);

    if($result) {
        ?>
        <script>
            window.location="login0.php?corpus=co-volontari&revop=ok";
        </script>
        <?php
    }

?>