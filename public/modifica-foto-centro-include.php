<?php

	$target_path = "foto/";
	$id = $_GET['id'];
	$target_path = $target_path . $id . basename( $_FILES['uploadedfile']['name']); 
	$urlfoto = $id.basename( $_FILES['uploadedfile']['name']); 
	$f = new File();
	$est = $f->estensioneFile(basename( $_FILES['uploadedfile']['name']));

	if($est != 'jpg' && $est != 'JPG' && $est != 'jpeg' && $est != 'JPEG' && $est != 'png' && $est != 'PNG')
	{
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=modifica-anagrafica&id=<?php echo $id;?>&from=foto-modifica&upfoto=errest";
		</script>
		<?php
		exit();
	}

	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
	{
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=modifica-anagrafica&url-foto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica&upfoto=success";
		</script>
		<?php
	} 
	else 
	{
		?>
		<script language = "javascript">
			window.location="login0.php?corpus=modifica-anagrafica&id=<?php echo $id;?>&from=foto-modifica&upfoto=error";
		</script>
		<?php
		exit();
	}
?>