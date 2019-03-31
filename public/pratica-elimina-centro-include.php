<?php

	$id = $_GET['id'];

	$cancellazione = $connessione->query("DELETE from pratiche where id = '$id' limit 1");
	if ($cancellazione) {
		?>
		<SCRIPT LANGUAGE="Javascript">
			window.location="login0.php?corpus=pratiche&canc=ok";
		</SCRIPT>
		<?php
	}
	else {
		?>
		<SCRIPT LANGUAGE="Javascript">
			window.location="login0.php?corpus=pratiche&canc=no";
		</SCRIPT>
		<?php
	}

?>
