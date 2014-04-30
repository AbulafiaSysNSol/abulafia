<?php

	session_start();
	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php'; //ATTIVA O DISATTIVA IL MAGIC QUOTE PER GLI APICI
	
	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$q=$_GET['q'];
	$tipologia=$_GET['tipologia'];
	$idlettera=$_GET['idlettera'];
	
	if ($tipologia =='') {
		$filtro = '';
	}
	else { 
		$filtro = "and tipologia='".$tipologia."'";
	}
	
	$my_ricerca= new Ricerca;
	$my_ricerca->publricercaespolosa($q, 'cognome');
	$where= $my_ricerca->where;
	
	/*echo '<b><i><br>"' . $q . '"</i></b> non è presente nel database. <a href="#" data-toggle="modal" data-target="#myModal">Vai all\'inserimento rapido <span class="glyphicon glyphicon-share-alt"></span></a>
				<br>oppure seleziona un elemento dall\'elenco seguente:<br>';
	*/
	$sql=mysql_query("SELECT * FROM anagrafica $where $filtro limit 5");
	while($row = mysql_fetch_array($sql)) {
		?>
		<br>
		<a href="login0.php?corpus=modifica-protocollo&from=aggiungi&idanagrafica=<?php echo $row['idanagrafica'];?>&id=<?php echo $idlettera;?>">
			<span class="glyphicon glyphicon-plus-sign"></span> <?php echo $row['cognome'].' '.$row['nome'];?>
		</a>
		<br>
		<?php
	}

	mysql_close ($verificaconnessione);

?>