<?php
	$target_path = "foto/";
	$id=$_GET['id'];
	$target_path = $target_path . $id.basename( $_FILES['uploadedfile']['name']); 
	$urlfoto= $id.basename( $_FILES['uploadedfile']['name']); 

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
		?>
		<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-anagrafica&url-foto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica&upfoto=success"; else window.location="ogin0.php?corpus=modifica-anagrafica&url-foto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica&upfoto=success";
		</SCRIPT>
		<?php
	} 
	else {
		?>
		<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-anagrafica&id=<?php echo $id;?>&from=foto-modifica&upfoto=error"; else window.location="login0.php?corpus=modifica-anagrafica&id=<?php echo $id;?>&from=foto-modifica&upfoto=error";
		</SCRIPT>
		<?php
	}
?>