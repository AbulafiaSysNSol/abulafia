<?php

$id = $_GET['id'];
$cancellazione=mysql_query("delete from categorie where id='$id' limit 1");
if ($cancellazione) {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATA CATEGORIA '. $id , 'OK' , $_SESSION['ip'] , $_SESSION['historylog']);
	?>
	<script language="javascript">
		window.location="?corpus=documenti-categorie&canc=ok";
	</script>
	<?php
}
else {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATIVO DI ELIMINARE POSIZIONE '. $id , 'FAILED' , $_SESSION['ip'] , $_SESSION['historylog']);
	?>
	<script language="javascript">
		window.location="?corpus=documenti-categorie&canc=no";
	</script>
	<?php
}

?>
