<?php

$id = $_GET['id'];
$cancellazione=mysql_query("delete from users where idanagrafica='$id' limit 1");
if (!$cancellazione) {echo 'Impossibile compiere l\'azione richiesta'; echo mysql_error(); exit();}
?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=gestione-utenti"; else window.location="login0.php?corpus=gestione-utenti"
</SCRIPT>
