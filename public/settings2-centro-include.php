<?php

	//passaggio variabili
	$id = $_GET['id'];
	$risultati_per_pagina = $_POST['risultatiperpagina'];
	$color1 = $_POST['color1'];
	$color2 = $_POST['color2'];
	$ins = $_POST['ins'];
	$mod = $_POST['mod'];

	try {
   		$connessione->beginTransaction();
		$query = $connessione->prepare("UPDATE usersettings SET risultatiperpagina = :risultati_per_pagina, primocoloretabellarisultati = :color1, secondocoloretabellarisultati = :color2, notificains = :ins, notificamod = :mod WHERE idanagrafica = :id"); 
		$query->bindParam(':risultati_per_pagina', $risultati_per_pagina);
		$query->bindParam(':color1', $color1);
		$query->bindParam(':color2', $color2);
		$query->bindParam(':ins', $ins);
		$query->bindParam(':mod', $mod);
		$query->execute();
		$connessione->commit();
		$up = true;
	}	 
	catch (PDOException $errorePDO) { 
    	echo "Errore: " . $errorePDO->getMessage();
    	$connessione->rollBack();
    	$up = false;
	}
	
	if (!$up) {
		?>
		<script language="javascript">
			window.location="login0.php?corpus=settings&update=error";
		</script>
		<?php
	}
	else {
		$_SESSION['risultatiperpagina'] = $risultati_per_pagina;
		$_SESSION['primocoloretabellarisultati'] = $color1;
		$_SESSION['secondocoloretabellarisultati'] = $color2;
		$_SESSION['notificains'] = $ins;
		$_SESSION['notificamod'] = $mod;
	}
?>

<script language="javascript"> 
		window.location="login0.php?corpus=settings&update=success";
</script>