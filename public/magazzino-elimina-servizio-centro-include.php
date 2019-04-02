<?php

	$id = $_GET['id'];
	$s = new Servizio();
	$del = $s->eliminaServizio($id);
	
	if ($del) {
		$my_log -> publscrivilog($_SESSION['loginname'], 'ELIMINATO PRODOTTO '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['logname'], 'magazzino');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=magazzino-servizi&canc=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog($_SESSION['loginname'], 'TENTATIVO DI ELIMINARE PRODOTTO '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['logname'], 'magazzino');
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=magazzino-servizi&canc=no";
		</script>
		<?php
	}
	
?>
