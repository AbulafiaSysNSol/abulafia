<?php

$id = $_GET['id'];
$cancellazione=mysql_query("delete from titolario where id='$id' limit 1");
if ($cancellazione) {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATA POSIZIONE '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=titolario&canc=ok"; else window.location="login0.php?corpus=titolario&canc=ok"
	</SCRIPT>
	<?php
}
else {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE POSIZIONE '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=titolario&canc=no"; else window.location="login0.php?corpus=titolario&canc=no"
	</SCRIPT>
	<?php
}

?>
