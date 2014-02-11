<?php
session_start();
include '../db-connessione-include.php';
function __autoload ($class_name) //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
{ require_once $class_name.".obj.inc";
}
$q=$_GET['q'];

$id=$_GET['id'];
$scelta=$_GET['scelta'];

if($scelta == 'carica')
{
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'cognome');
	$where= $my_ricerca->where;
	$sql=mysql_query("SELECT * FROM anagrafica $where and tipologia='carica' limit 5");

	while($row = mysql_fetch_array($sql))
	  {
	echo "<br>";?>
	<a href="login0.php?corpus=curriculum-aggiungi-carica&id=<?php echo $id;?>&idcarica=<?php echo $row['idanagrafica'];?>&test=ok<?php echo $q;?>">
	<?php echo $row['cognome'].' '.$row['nome'];?></a>

	<?php echo "<br>";
	  }

}

if($scelta == 'titolostudio')
{
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'titolo');
	$where= $my_ricerca->where;
	$sql=mysql_query("SELECT * FROM titoli $where and tipologiatitolo='titolo di studio' limit 5");

	while($row = mysql_fetch_array($sql))
	  {
	echo "<br>";?>
	<a href="login0.php?corpus=curriculum-aggiungi-titolo&id=<?php echo $id;?>&idtitolo=<?php echo $row['idtitoli'];?>&test=ok<?php echo $q;?>">
	<?php echo $row['titolo']?></a>

	<?php echo "<br>";
	  }

}

if($scelta == 'titolocri')
{
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'titolo');
	$where= $my_ricerca->where;
	$sql=mysql_query("SELECT * FROM titoli $where and tipologiatitolo='titolo cri' limit 5");

	while($row = mysql_fetch_array($sql))
	  {
	echo "<br>";?>
	<a href="login0.php?corpus=curriculum-aggiungi-titolo&id=<?php echo $id;?>&idtitolo=<?php echo $row['idtitoli'];?>&test=ok<?php echo $q;?>">
	<?php echo $row['titolo']?></a>

	<?php echo "<br>";
	  }

}

if($scelta == 'competenza')
{
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'titolo');
	$where= $my_ricerca->where;
	$sql=mysql_query("SELECT * FROM titoli $where and tipologiatitolo='competenza' limit 5");

	while($row = mysql_fetch_array($sql))
	  {
	echo "<br>";?>
	<a href="login0.php?corpus=curriculum-aggiungi-titolo&id=<?php echo $id;?>&idtitolo=<?php echo $row['idtitoli'];?>&test=ok<?php echo $q;?>">
	<?php echo $row['titolo']?></a>

	<?php echo "<br>";
	  }

}

if($scelta == 'patente')
{
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'titolo');
	$where= $my_ricerca->where;
	$sql=mysql_query("SELECT * FROM titoli $where and (tipologiatitolo='patente civile' or tipologiatitolo='patente cri') limit 5");

	while($row = mysql_fetch_array($sql))
	  {
	echo "<br>";?>
	<a href="login0.php?corpus=curriculum-aggiungi-titolo&id=<?php echo $id;?>&idtitolo=<?php echo $row['idtitoli'];?>&test=ok<?php echo $q;?>">
	<?php echo $row['titolo']?></a>

	<?php echo "<br>";
	  }

}

mysql_close ($verificaconnessione);

?>
