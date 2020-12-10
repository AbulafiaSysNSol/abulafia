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

$query = $connessione->query("SELECT * FROM anagrafica WHERE autorizzato is true  AND (nome LIKE '%$ogg%' OR cognome LIKE '%$ogg%' OR codicefiscale LIKE '%$ogg%' ) ORDER BY cognome DESC LIMIT $num");
?>

<table class="table table-bordered">
    <tr style="vertical-align: middle">
        <td><b>Nome</b></td>
        <td><b>Cognome</b></td>
        <td><b>Codice Fiscale</b></td>
        <td><b>Cellulare</b></td>
        <?php if($a->isRespco($_SESSION['loginid'])){ ?> <td align="center"><b>Opzioni</b></td> <?php } ?>
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
            <td style="vertical-align: middle"><?php echo ucwords($risultati2['nome']);?></td>
            <td style="vertical-align: middle"><?php echo ucwords($risultati2['cognome']);?></td>
            <td style="vertical-align: middle"><?php echo ucwords($risultati2['codicefiscale']);?></td>
            <td style="vertical-align: middle">
                <?php $anag = new Anagrafica(); $cell = $anag->getCellulare($risultati2['idanagrafica']); echo $cell; //implementare il multinumero ?>
            </td>
            <?php if($a->isRespco($_SESSION['loginid']) || $a->isAdmin($_SESSION['loginid']) ){ ?>
                <td style="vertical-align: middle" align="center">
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Revoca autorizzazione" onclick="return confirm('Sicuro di voler revocare autorizzazione al volontario?')" href="co-volontari-revoca.php?id=<?php echo $risultati2['idanagrafica']; ?>">
                            <i class="fa fa-trash-o fa-fw"></i>
                        </a>
                    </div>
                </td>
            <?php } ?>
        </tr>
        <?php
    }
    ?>
</table>