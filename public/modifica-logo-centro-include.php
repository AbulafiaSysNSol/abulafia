<?php
	$target_path = "images/logo-azienda.png";

	$f = new File();

	if ($f->estensioneFile($_FILES['uploadedfile']['name']) != 'png' && $f->estensioneFile($_FILES['uploadedfile']['name']) != 'PNG' && $f->estensioneFile($_FILES['uploadedfile']['name']) != 'Png' && $f->estensioneFile($_FILES['uploadedfile']['name']) != 'pNg') {
		?>
		<script language="javascript">
			window.location="?corpus=loghi&logo=epng";
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