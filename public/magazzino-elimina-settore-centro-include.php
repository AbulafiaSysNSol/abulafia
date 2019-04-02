<?php
	$id = $_GET['id'];
	$m = new Magazzino();
	$del = $m->delSettore($id);
	
	if ($del) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATA SETTORE '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['logname'], 'magazzino');
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=magazzino-settori&canc=ok"; 
		else 
			window.location="login0.php?corpus=magazzino-settori&canc=ok";
		</SCRIPT>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE SETTORE '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['logname'], 'magazzino');
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=magazzino-settori&canc=no"; 
		else 
			window.location="login0.php?corpus=magazzino-settori&canc=no";
		</SCRIPT>
		<?php
	}
	
?>
