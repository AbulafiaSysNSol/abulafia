<?php

	$id = $_GET['id'];
	$tipologia = $_GET['tipologia'];
	$magazzino = $_GET['magazzino'];
	$m = new Magazzino();
	$del = $m->eliminaDocumento($id, $tipologia, $magazzino);
	
	if ($del) {
		$my_log -> publscrivilog($_SESSION['loginname'], 'ELIMINATO DOCUMENTO '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['logfile'], 'magazzino');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=magazzino-documenti&canc=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog($_SESSION['loginname'], 'TENTATIVO DI ELIMINARE DOCUMENTO '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['logfile'], 'magazzino');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=magazzino-documenti&canc=no";
		</script>
		<?php
	}
	
?>
