<?php
?>
	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Upload foto</u></h3>
				
				</div>
				<div class="content">
					
				
<b>Upload in corso...</b> <br><?php
$target_path = "foto/";
$id=$_GET['id'];
$target_path = $target_path . $id.basename( $_FILES['uploadedfile']['name']); 
$urlfoto= $id.basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "File ".  basename( $_FILES['uploadedfile']['name']). 
    " caricato sul server regolarmente";
} else{
    echo "C'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.";
}

?>
<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=modifica-anagrafica&url-foto=<?php echo $urlfoto ; ?>&id=<?php echo $id;?>&from=foto-modifica">Torna a MODIFICA ANAGRAFICA</a></li>
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
<php
?>
