<?php

$id = $_GET['id'];
$cancellazione=$verificaconnessione->query("delete from attributi where id='$id' limit 1");
if ($cancellazione) {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATO ATTRIBUTO '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=attributi&canc=ok"; else window.location="login0.php?corpus=attributi&canc=ok"
	</SCRIPT>
	<?php
}
else {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE ATTRIBUTO '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=attributi&canc=no"; else window.location="login0.php?corpus=attributi&canc=no"
	</SCRIPT>
	<?php
}

?>
