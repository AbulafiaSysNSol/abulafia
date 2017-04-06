<html>

<head>
  <!-- CSS -->
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <!-- CSS -->  
  
</head>

<body>

<?php
	session_start();

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	require_once "class/Lettera.obj.inc";
	require_once "class/Calendario.obj.inc";
	
	$my_lettera = new Lettera();
	$calendario = new Calendario();
	
	$id = $_GET['id'];
	
	if (isset($_GET['anno'])) {
		$anno = $_GET['anno'];
	}
	else {
		$anno = $_SESSION['annoricercaprotocollo'];
	}
	
	$mailsend = $my_lettera->getMailSend($id, $anno);
?>

<div class="row">
	<div class="col-md-8">
		<h3><i class="fa fa-paper-plane-o"></i> Protocollo inoltrato a:</h3>
		<div class="row">
			<div class="col-md-11 col-md-offset-1">
				<ul>
				<?php
				if (!$mailsend) {
					echo '<li>Nessun inoltro per il protocollo selezionato</li>';
				}
				else {
					foreach($mailsend as $valore) {
						echo '<li><b>' . $valore['email'] . '</b> da ' .
						$valore['nome'] . '  ' . $valore['cognome'] . '</a> il ' . $calendario->dataSlash($valore['data']);
					}
				}
				?>
				</ul>
			</div>
		</div>
	</div>
</div>

</body>
</html>