	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Upload foto</u></h3>
				
				</div>
				<div class="content">
					
				
<b>Upload in corso...</b> <br><?php
$target_path = $_SESSION['fototargetpath']; //assegnazione del percorso per l'upload delle foto per l'anagrafica
$id=$_GET['id']; //acquisizione dell'id dell'anagrafica cui si riferisce la foto
$target_path = $target_path . $id.'--'.basename( $_FILES['uploadedfile']['name']); 
$urlfoto=  $id.'--'.basename( $_FILES['uploadedfile']['name']); //creazione del nuovo nome del file uploadato usando l'id, un separatore e il nome originale

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "File ".  basename( $_FILES['uploadedfile']['name']). 
    " caricato sul server regolarmente";
} else{
    echo "C'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.";
}

?>
<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=anagrafica&urlfoto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica">Torna ad INSERIMENTO ANAGRAFICA</a></li>
</ul>
			</div>

<br><br>
</p>
					
			</div>	
<div class="footer">

					
				</div>
		</div>
			
			<!-- post end -->
		</div>
