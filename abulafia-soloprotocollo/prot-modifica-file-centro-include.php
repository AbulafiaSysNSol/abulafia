<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
$from =$_GET['from'];
?>
	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Upload file Protocollo</u></h3>
				
				</div>
				<div class="content">
			<?php		
if ($from != 'modifica-protocollo') {?>				
<b>Upload in corso...</b> <br><?php
$target_path = "lettere$annoprotocollo/";
$idlettera=$_GET['idlettera'];
$target_path = $target_path . $idlettera.basename( $_FILES['uploadedfile']['name']); 
$urlpdf=  $idlettera.basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "File ".  basename( $_FILES['uploadedfile']['name']). 
    " caricato sul server regolarmente";
$inserisci=mysql_query("update lettere$annoprotocollo set urlpdf='$urlpdf' where idlettera ='$idlettera'");

} else{
    echo "C'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.";
}

?>
<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=protocollo2&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf">Torna a INSERISCI PROTOCOLLO</a></li>
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
<?php
}






else {
?>


<b>Upload in corso...</b> <br><?php
$target_path = "lettere$annoprotocollo/";
$idlettera=$_GET['idlettera'];
$target_path = $target_path . $idlettera.basename( $_FILES['uploadedfile']['name']); 
$urlpdf=  $idlettera.basename( $_FILES['uploadedfile']['name']); 

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "File ".  basename( $_FILES['uploadedfile']['name']). 
    " caricato sul server regolarmente";
} else{
    echo "C'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.";
}

?>
<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=modifica-protocollo&urlpdf=<?php echo $urlpdf ; ?>&idlettera=<?php echo $idlettera;?>&from=urlpdf">Torna a MODIFICA PROTOCOLLO</a></li>
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
<?php }?>