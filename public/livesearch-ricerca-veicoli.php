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

$query = $connessione->query("SELECT * FROM aut_veicoli WHERE targa LIKE '%$ogg%' OR tipologia LIKE '%$ogg%' OR selettiva LIKE '%$ogg%' ORDER BY id DESC LIMIT $num");
?>

<table class="table table-bordered">
    <tr style="vertical-align: middle">
        <td><b>Targa</b></td>
        <td><b>Tipologia</b></td>
        <td><b>Selettiva radio</b></td>
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
            <td style="vertical-align: middle"><?php echo ucwords($risultati2['targa']);?></td>
            <td style="vertical-align: middle"><?php echo ucwords($risultati2['tipologia']);?></td>
            <td style="vertical-align: middle"><?php echo ucwords($risultati2['selettiva']);?></td>
            <td style="vertical-align: middle" align="center">
                <div class="btn-group btn-group-sm">
                    <a class="btn btn-info btn" data-toggle="tooltip" data-placement="left" title="Visualizza Libretto" href="login0.php?corpus=autoparco-show-libretto&id=<?php echo $risultati2['id']; //convertire in visualizzazione+download ?> " data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-info-circle fa-fw"></i>
                    </a>
                    <a class="btn btn-warning" data-toggle="tooltip" data-placement="left" title="Modifica Veicolo" href="login0.php?corpus=autoparco-edit-veicoli&id=<?php echo $risultati2['id']; ?>">
                        <i class="fa fa-edit fa-fw"></i>
                    </a>
                    <?php /*<a class="btn btn-success" data-toggle="tooltip" data-placement="left" title="Aggiungi Visita" href="login0.php?corpus=cert-modale-add-access&id=<?php echo $risultati2['id']; ?>" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-medkit fa-fw"></i>
                    </a> */ ?>
                    <?php if($a->isAdmin($_SESSION['loginid'])) {
                        ?>
                        <a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Elimina Veicolo" onclick="return confirm('Sicuro di voler cancellare il veicolo?')" href="autoparco-delete-veicolo.php?id=<?php echo $risultati2['id']; ?>">
                            <i class="fa fa-trash-o fa-fw"></i>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
</table>