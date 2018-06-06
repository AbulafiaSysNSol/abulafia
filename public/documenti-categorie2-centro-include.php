<?php 

$owner=$_SESSION['loginid'];
$descrizione=$_POST['descrizione'];

$inserimento=mysql_query("insert into categorie values('', '$descrizione', '$owner')");

if($inserimento) {
	?>
	<script language="javascript">
		window.location="?corpus=documenti-categorie&add=ok";
	</script>
	<?php
}

else {
	?>
	<script language="javascript">
		window.location="?corpus=documenti-categorie&add=no";
	</script>
	<?php 
}

?>