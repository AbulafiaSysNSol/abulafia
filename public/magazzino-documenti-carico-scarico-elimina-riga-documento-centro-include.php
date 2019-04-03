<?php
	$idriga = $_GET['id'];
	$iddocumento = $_GET['documento'];
	$m = new Magazzino();
	$infodocumento = $m->getDocumentById($iddocumento);
	$del = $m->eliminaRigaDocumento($idriga, $infodocumento[2], $infodocumento[7]);
	
	if ($del) 
	{
		$my_log -> publscrivilog( $_SESSION['loginname'], 
								'ELIMINATA RIGA DOCUMENTO '. $iddocumento , 
								'OK' , 
								$_SESSION['ip'] , 
								$_SESSION['logfile'], 
								'magazzino');
		?>
		<script language="javascript">
			window.location="login0.php?corpus=magazzino-documenti-carico-scarico-prodotti
							&id=<?php echo $iddocumento; ?>
							&tipologia=<?php echo $infodocumento[7]; ?>"; 
		</script>
		<?php
	}
	else 
	{
		$my_log -> publscrivilog( $_SESSION['loginname'], 
									'TENTATIVO DI ELIMINARE RIGA DOCUMENTO '. $iddocumento , 
								'FAILED' , $_SESSION['ip'] , 
								$_SESSION['logfile'], 
								'magazzino');
		?>
		<script language="javascript">
			window.location="login0.php?corpus=magazzino-documenti-carico-scarico-prodotti
							&id=<?php echo $iddocumento; ?>
							&tipologia=<?php echo $infodocumento[7]; ?>"; 
		</script>
		<?php
	}	
?>
