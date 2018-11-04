<?php
	
	session_start();

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}

	include '../db-connessione-include.php';
	include 'maledetti-apici-centro-include.php';

	if ($_SESSION['auth'] < 1 ) {
		header("Location: index.php?s=1");
		exit(); 
	}

	$a = new Anagrafica();
	$c = new Calendario();
	$acc = new Ambulatorio();

	
	$idanagrafica = $_POST['idanagrafica'];
	$medico = $_POST['idmedico'];
	$data = $c->dataDB($_POST['data']);
	$ora = $_POST['ora'];
	if(isset($_POST['dipendente'])) {
		$dipendente = 1;
	}
	else {
		$dipendente = 0;
	}
	$anamnesi = nl2br($_POST['anamnesi']);
	$diagnosi = nl2br($_POST['diagnosi']);
	$terapia = nl2br($_POST['terapia']);
	$note = nl2br($_POST['note']);
	if(isset($_POST['intervento'])) {
		$intervento = 1;
	}
	else {
		$intervento = 0;
	}

	$result = $acc->insertAccess($idanagrafica, $medico, $data, $ora, $dipendente, $anamnesi, $diagnosi, $terapia, $note, $intervento);
echo mysql_error();
	if($result) {
		?>
		<script>
			window.location="login0.php?corpus=cert-search-anag&inserimento=ok";
		</script>
		<?php
	}

?>