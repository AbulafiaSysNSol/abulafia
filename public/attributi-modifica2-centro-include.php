<?php

$id = $_GET['id'];
$attributo = $_POST['descrizione'];
$update=mysql_query("update attributi set attributo='$attributo' where id='$id' ");
if ($update) {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATO ATTRIBUTO '. $id , 'OK' , 'NUOVO VALORE '. $attributo , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=attributi&mod=ok"; else window.location="login0.php?corpus=attributi&mod=ok"
	</SCRIPT>
	<?php
}
else {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA ATTRIBUTO '. $id , 'FAILED' , 'VALORE '. $attributo , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=attributi&mod=no"; else window.location="login0.php?corpus=attributi&mod=no"
	</SCRIPT>
	<?php
}

?>
