<?php

	$id = $_GET['id'];
	$p = new Prodotto();
	$del = $p->eliminaProdotto($id);
	
	if ($del) {
		$my_log -> publscrivilog($_SESSION['loginname'], 'ELIMINATO PRODOTTO '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=magazzino-prodotti&canc=ok";
		</script>
		<?php
	}
	else {
		$my_log -> publscrivilog($_SESSION['loginname'], 'TENTATIVO DI ELIMINARE PRODOTTO '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['historylog']);
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=magazzino-prodotti&canc=no";
		</script>
		<?php
	}
	
?>