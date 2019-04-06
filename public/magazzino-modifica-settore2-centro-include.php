<?php
	
	$m = new Magazzino();
	$id = $_GET['id'];
	$descrizione = $_POST['descrizione'];
	$update = $m->updateSettore($id, $descrizione);
	
	if ($update) {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATO SETTORE '. $id, 'OK', 'NUOVO VALORE '. $descrizione, $_SESSION['logfile'], 'magazzino');
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=magazzino-settori&mod=ok"; 
		else 
			window.location="login0.php?corpus=magazzino-settori&mod=ok";
		</SCRIPT>
		<?php
	}
	else {
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA SETTORE '. $id, 'FAILED', 'VALORE '. $descrizione, $_SESSION['logfile'], 'magazzino');
		?>
		<SCRIPT LANGUAGE="Javascript">
		browser= navigator.appName;
		if (browser == "Netscape")
			window.location="login0.php?corpus=magazzino-settori&mod=no"; 
		else 
			window.location="login0.php?corpus=magazzino-settori&mod=no";
		</SCRIPT>
		<?php
	}
?>
