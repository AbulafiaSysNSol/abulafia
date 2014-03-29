<?php
session_start();
include '../db-connessione-include.php';

include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
function __autoload ($class_name) //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
{ require_once "class/" .$class_name.".obj.inc";
}
$q=$_GET['q'];

$id=$_GET['id'];

$my_ricerca= new Ricerca;
$my_ricerca->publricercaespolosa($q, 'cognome');
$where= $my_ricerca->where;
$sql=mysql_query("SELECT * FROM anagrafica $where and tipologia='gruppo' limit 5");





while($row = mysql_fetch_array($sql))
  {
echo "<br>";?>
<a href="login0.php?corpus=gruppo-aggiungi&id=<?php echo $id;?>&idgruppo=<?php echo $row['idanagrafica'];?>&test=ok<?php echo $q;?>">
<?php echo $row['cognome'].' '.$row['nome'];?></a>

<?php echo "<br>";
  }


mysql_close ($verificaconnessione);

?>
