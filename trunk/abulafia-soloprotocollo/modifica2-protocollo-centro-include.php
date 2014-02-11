	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Dati inviati</u></h3>
				
				</div>
				<div class="content">
					<p>
<?php

$annoprotocollo = $_SESSION['annoprotocollo'];

//inizio passaggio dati da pagina inserimento
$speditaricevuta = $_POST['spedita-ricevuta'];
$oggetto= $_POST['oggetto'];
$lettera_data_giorno = $_POST['lettera-data-giorno'];
$lettera_data_mese = $_POST['lettera-data-mese'];
$lettera_data_anno = $_POST['lettera-data-anno'];
$posizione = $_POST['posizione'];
$note  = $_POST['note'];
$urlpdf = $_GET['urlpdf'];

list($anno, $mese, $giorno) = explode("-", $dataregistrazione);
$dataregistrazione2= $anno.'-'.$mese.'-'.$giorno;
$idlettera=$_GET['idlettera'];
echo $dataregistrazione2;
echo $dataregistrazione;
$lettera_data = $lettera_data_anno . '-' . $lettera_data_mese . '-' . $lettera_data_giorno   ;
//fine passaggio dati

//controllo esistenza




$inserimento = mysql_query("UPDATE lettere$annoprotocollo set lettere$annoprotocollo.speditaricevuta ='$speditaricevuta', lettere$annoprotocollo.oggetto ='$oggetto', lettere$annoprotocollo.datalettera='$lettera_data', lettere$annoprotocollo.posizione='$posizione', lettere$annoprotocollo.riferimento='$riferimento', lettere$annoprotocollo.note='$note' WHERE lettere$annoprotocollo.idlettera='$idlettera'     " );
echo  mysql_error();
if (!$inserimento) { echo "Inserimento non riuscito" ; }
$ultimoid = mysql_insert_id();
?>


<div class="content">
<p>Oggetto: <strong><?php echo $oggetto ; ?></strong> <br></p>


</div>
<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=anagrafica">Nuovo inserimento ANAGRAFICA</a></li>
</ul>
			</div>
<br><br>


</p></div>
					
			
<div class="footer">

					
				</div>
		</div>
			
			<!-- post end -->

		</div>

