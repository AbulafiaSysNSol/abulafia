<?php

require_once('../db-connessione-include.php');

class Veicolo {

    public function insertVeicolo($targa, $tipologia, $selettiva) {

        global $connessione;

        try {
                $connessione->beginTransaction();
                $query = $connessione->prepare("INSERT INTO aut_veicoli VALUES ('0',:targa, :tipologia, :selettiva)");
                $query->bindParam(':targa', strtoupper($targa));
                $query->bindParam(':tipologia', $tipologia);
                $query->bindParam(':selettiva', strtoupper($selettiva));
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

    public function editVeicolo($id, $targa, $tipologia, $selettiva) {

        global $connessione;

        try {
            $connessione->beginTransaction();
            $query = $connessione->prepare("UPDATE aut_veicoli SET targa = :targa, tipologia = :tipologia, selettiva = :selettiva WHERE id = :id");
            $query->bindParam(':targa', strtoupper($targa));
            $query->bindParam(':tipologia', $tipologia);
            $query->bindParam(':selettiva', strtoupper($selettiva));
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

    public function infoVeicolo($id) {
        global $connessione;
        $query = $connessione->query("SELECT * FROM aut_veicoli WHERE id = $id");
        $res = $query->fetch();;
        return $res;
    }

    public function deleteVeicolo($id) {
        global $connessione;
        try {
            $connessione->beginTransaction();
            $query = $connessione->prepare("DELETE FROM aut_veicoli WHERE id = :id");
            $query->bindParam(':id', $id);
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

}
?>