<?php

require_once('../db-connessione-include.php');

class Tipologia_veicolo{

    public function inserisciTipologiaveicolo($descrizione) {
        global $connessione;
        try {
            $connessione->beginTransaction();
            $query = $connessione->prepare("INSERT INTO aut_tipologie VALUES ('0', :descrizione)");
            $query->bindParam(':descrizione',$descrizione);
            $query->execute();
            $connessione->commit();
            $q = true;
        }
        catch (PDOException $errorePDO) {
            echo "Errore: " . $errorePDO->getMessage();
            $connessione->rollBack();
            $q = false;
        }
        return $q;
    }

    public function richiamaTipologie() {
        global $connessione;
        $query = $connessione->query("SELECT descrizione FROM aut_tipologie");
        $tipologie = array();
        while ($tip = $query->fetch()) {
            array_push($tipologie, $tip);
        }
        return $tipologie;
    }

    public function infoTipologia($id) {
        global $connessione;
        $query = $connessione->query("SELECT * FROM aut_tipologie WHERE id = $id");
        $res = $query->fetch();;
        return $res;
    }

    public function editTipologia($id, $descrizione) {

        global $connessione;

        try {
            $connessione->beginTransaction();
            $query = $connessione->prepare("UPDATE aut_tipologie SET descrizione = :descrizione WHERE id = :id");
            $query->bindParam(':descrizione',$descrizione);
            $query->bindParam(':id', $id);
            $query->execute();
            $connessione->commit();
            $q3 = true;
        }
        catch (PDOException $errorePDO) {
            echo "Errore: " . $errorePDO->getMessage();
            $connessione->rollBack();
            $q3 = false;
        }

        return $q3;
    }

}

?>