<?php
	$id = $_GET['id'];
	$p = new Prodotto();
	$del = $p->eliminaProdotto($id);
	
	if ($del) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATO PRODOTTO '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=magazzino-prodotti&canc=ok"; 
		else 
			window.location="login0.php?corpus=magazzino-prodotti&canc=ok";
		</SCRIPT>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE PRODOTTO '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['historylog']);
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=magazzino-prodotti&canc=no"; 
		else 
			window.location="login0.php?corpus=magazzino-prodotti&canc=no";
		</SCRIPT>
		<?php
	}
	
?>