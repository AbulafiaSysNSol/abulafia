<?php 

	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}

	include '../db-connessione-include.php';
	include 'class/Magazzino.obj.inc';
	include 'class/Calendario.obj.inc';
	$m = new Magazzino();
	$id = $_GET['id'];
	$tipologia = $_GET['tipologia'];
	$magazzino = $_GET['magazzino'];
	$prodotto=$_POST['prodotto'];
	$descrizione=$_POST['descrizione'];
	$quantita=$_POST['quantita'];
	$nota=$_POST['nota'];

	$ins = $m->newRigaDocumento($id, $prodotto, $quantita, $nota, $tipologia, $magazzino);

	if($ins) {
		header("Location: login0.php?corpus=magazzino-documenti-carico-scarico-prodotti&id=$id&tipologia=$tipologia");
	}
	else {
		echo 'Errore nella registrazione dei dati<br><br>' . mysql_error();
	}

?>
