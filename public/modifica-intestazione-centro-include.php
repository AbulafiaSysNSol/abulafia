<?php
	$target_path = "images/intestazione.jpg";

	$f = new File();

	if (($f->estensioneFile($_FILES['uploadedfile']['name']) != 'jpg') && ($f->estensioneFile($_FILES['uploadedfile']['name']) != 'JPG') && ($f->estensioneFile($_FILES['uploadedfile']['name']) != 'jpeg') && ($f->estensioneFile($_FILES['uploadedfile']['name']) != 'JPEG')) {
		?>
		<script language="javascript">
			window.location="?corpus=loghi&logo=ejpg";
		</script>
		<?php
		exit();
	}


	if(rename($_FILES['uploadedfile']['tmp_name'], $target_path)) {
		?>
		<script language="javascript">
			window.location="?corpus=loghi&logo=ok";
		</script>
		<?php
	} 
	else {
		?>
		<script language="javascript">
			window.location="?corpus=loghi&logo=error";
		</script>
		<?php
	}
?>