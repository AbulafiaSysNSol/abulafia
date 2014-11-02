<?php
$target_path = $_SESSION['fototargetpath']; //assegnazione del percorso per l'upload delle foto per l'anagrafica
$id=$_GET['id']; //acquisizione dell'id dell'anagrafica cui si riferisce la foto
$target_path = $target_path . $id.'--'.basename( $_FILES['uploadedfile']['name']); 
$urlfoto=  $id.'--'.basename( $_FILES['uploadedfile']['name']); //creazione del nuovo nome del file uploadato usando l'id, un separatore e il nome originale

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'AGGIUNTA FOTO ANAGRAFICA '. $id , 'OK' , 'NOME FILE '. $urlfoto , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=anagrafica&urlfoto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica&upfoto=success"; else window.location="login0.php?corpus=anagrafica&urlfoto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica&upfoto=success";
	</SCRIPT>
	<?php
} 
else {
	$my_log -> publscrivilog( $_SESSION['loginname'], 'AGGIUNTA FOTO ANAGRAFICA '. $id , 'FAILED' , 'NOME FILE '. $urlfoto , $_SESSION['historylog']);
	?>
	<SCRIPT LANGUAGE="Javascript">
	browser= navigator.appName;
	if (browser == "Netscape")
	window.location="login0.php?corpus=anagrafica&id=<?php echo $id;?>&from=foto-modifica&upfoto=error"; else window.location="login0.php?corpus=anagrafica&id=<?php echo $id;?>&from=foto-modifica&upfoto=error";
	</SCRIPT>
	<?php
}

?>