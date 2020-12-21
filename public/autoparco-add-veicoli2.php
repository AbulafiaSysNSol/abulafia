<?php

    set_time_limit(0);

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
    $f = new File;

    foreach ($_FILES['uploadedfile']['name'] as $filename) {

        $time = time();
        $name = $time.".".$f->estensioneFile(basename($filename));  
        $target_path = "cartecircolazione/" . $name;
        $count = 0;
        
        //se lo spostamento del file va a buon fine
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$count], $target_path)) { 
            
            /*try {
                $connessione->beginTransaction();
                $query = $connessione->prepare("INSERT INTO joinlettereallegati VALUES(:idlettera, :annoprotocollo, :name)"); 
                $query->bindParam(':idlettera', $idlettera);
                $query->bindParam(':annoprotocollo', $annoprotocollo);
                $query->bindParam(':name', $name);
                $query->execute();
                $connessione->commit();
                $inserisci = true;
            }    
            catch (PDOException $errorePDO) { 
                echo "Errore: " . $errorePDO->getMessage();
                $connessione->rollBack();
                $inserisci = false;
            }*/
            $allegato = true;
            $count++;
        }
    }

    $targa = $_POST['targa'];
    $tipologia = $_POST['tipologia'];
    $selettiva = $_POST['selettiva'];
    $result = $a->insertVeicolo($targa, $tipologia, $selettiva, $name);

    if($result && $allegato) {
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