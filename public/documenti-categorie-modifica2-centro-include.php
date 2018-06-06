<?php

$id = $_GET['id'];
$descrizione = $_POST['descrizione'];
$update=mysql_query("update categorie set categoria='$descrizione' where id='$id' ");
if ($update) {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATA CATEGORIA '. $id , 'OK' , 'NUOVO VALORE '. $descrizione , $_SESSION['historylog']);
	?>
	<script language="javascript">
		window.location="?corpus=documenti-categorie&mod=ok";
	</script>
	<?php
}
else {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA CATEGORIA '. $id , 'FAILED' , 'VALORE '. $descrizione , $_SESSION['historylog']);
	?>
	<script language="javascript">
		window.location="?corpus=documenti-categorie&mod=no";
	</script>
	<?php
}

?>
