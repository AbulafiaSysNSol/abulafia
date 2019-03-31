<?php 

$owner=$_SESSION['loginid'];
$codice=$_POST['codice'];
$descrizione=$_POST['descrizione'];

if (($codice == "") OR ($descrizione =="")) { 
	?>
	<script language="javascript">
		window.location="login0.php?corpus=titolario&add=no"
	</script>
	<?php 
	exit();
}

$my_database=unserialize($_SESSION['my_database']);

if ($my_database->controllaEsistenza($codice, 'titolario', 'codice') == True) {
	?>
	<script language="javascript">
		window.location="login0.php?corpus=titolario&add=duplicato";
	</script>
	<?php 
	exit();
}

try {
   	$connessione->beginTransaction();
	$query = $connessione->prepare("INSERT INTO titolario VALUES(null, :codice, :descrizione, :owner)"); 
	$query->bindParam(':codice', $codice);
	$query->bindParam(':descrizione', $descrizione);
	$query->bindParam(':owner', $owner);
	$query->execute();
	$connessione->commit();
	$ins = true;
}	 
catch (PDOException $errorePDO) { 
   	echo "Errore: " . $errorePDO->getMessage();
   	$connessione->rollBack();
   	$ins = false;
}

if($ins) {
	?>
	<script language="javascript">
		window.location="login0.php?corpus=titolario&add=ok";
	</script>
	<?php
}
else {
	?>
	<script language="javascript">
		window.location="login0.php?corpus=titolario&add=no";
	</script>
	<?php 
}

?>