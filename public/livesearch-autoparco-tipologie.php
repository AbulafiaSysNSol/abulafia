<?php
    session_start();

    if ($_SESSION['auth'] < 1 ) {
        header("Location: index.php?s=1");
        exit();
    }

    include '../db-connessione-include.php';
    include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI

    function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
        require_once "class/" . $class_name.".obj.inc";
    }

    $a = new Anagrafica();
    $c = new Calendario();

    $ogg = $_GET['q'];
    $num = $_GET['num'];

    $query = $connessione->query("SELECT * FROM aut_tipologie WHERE descrizione LIKE '%$ogg%' ORDER BY descrizione ASC LIMIT $num");
    ?>

    <table class="table table-bordered">
        <tr style="vertical-align: middle">
            <td><b>Descrizione</b></td>
            <td align="center"><b>Opzioni</b></td>
        </tr>

        <?php
        $contatorelinee = 0;
        while ($risultati2 = $query->fetch())	{
            $risultati2 = array_map('stripslashes', $risultati2);
            if ( $contatorelinee % 2 == 1 ) {
                $colorelinee = $_SESSION['primocoloretabellarisultati'] ;
            } //primo colore
            else {
                $colorelinee = $_SESSION['secondocoloretabellarisultati'] ;
            } //secondo colore
            $contatorelinee = $contatorelinee + 1 ;
            ?>
            <tr bgcolor=<?php echo $colorelinee; ?>>
                <td style="vertical-align: middle"><?php echo ucwords($risultati2['descrizione']);?></td>
                <td style="vertical-align: middle" align="center">
                        <a class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="Modifica Tipologia" href="login0.php?corpus=autoparco-tipologie-edit&id=<?php echo $risultati2['id']; ?>">
                            <i class="fa fa-edit fa-fw"></i> Modifica
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }
    ?>
</table>