
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
$loginid=$_SESSION['loginid'];
$dataoriginalegiorno= $_GET['dataoriginalegiorno'];
$dataoriginalemese = $_GET['dataoriginalemese'];
$dataoriginaleanno= $_GET['dataoriginaleanno'];
$from = $_GET['from'];
$speditaricevuta = $_POST['spedita-ricevuta'];
$oggetto= $_POST['oggetto'];
$lettera_data_giorno = $_POST['lettera-data-giorno'];
$lettera_data_mese = $_POST['lettera-data-mese'];
$lettera_data_anno = $_POST['lettera-data-anno'];
$posizione = $_POST['posizione'];
$note  = $_POST['note'];
$urlpdf = $_GET['urlpdf'];
$dataregistrazione = strftime("%Y-%m-%d");
list($anno, $mese, $giorno) = explode("-", $dataregistrazione);
$dataregistrazione2= $anno.'-'.$mese.'-'.$giorno;
if ($from =='modifica') { $dataregistrazione = $dataoriginaleanno.'-'.$dataoriginalemese.'-'.$dataoriginalegiorno; }
$idlettera=$_GET['idlettera'];
$lettera_data = $lettera_data_anno . '-' . $lettera_data_mese . '-' . $lettera_data_giorno   ;
$loginid = $_SESSION['loginid'];
$auth = $_SESSION['auth'] ;
//fine passaggio dati

//controllo esistenza




$inserimento = mysql_query("UPDATE lettere$annoprotocollo set lettere$annoprotocollo.speditaricevuta ='$speditaricevuta', lettere$annoprotocollo.oggetto ='$oggetto', lettere$annoprotocollo.datalettera='$lettera_data', lettere$annoprotocollo.urlpdf='$urlpdf', lettere$annoprotocollo.posizione='$posizione', lettere$annoprotocollo.riferimento='$riferimento', lettere$annoprotocollo.note='$note', lettere$annoprotocollo.dataregistrazione='$dataregistrazione' WHERE lettere$annoprotocollo.idlettera='$idlettera'     " );
echo  mysql_error();
if (!$inserimento) { echo "Inserimento non riuscito" ; }
$ultimoid = mysql_insert_id();
$modifica =mysql_query("update joinlettereinserimento$annoprotocollo set joinlettereinserimento$annoprotocollo.idmod='$loginid', joinlettereinserimento$annoprotocollo.datamod='$dataregistrazione2' where joinlettereinserimento$annoprotocollo.idlettera='$idlettera' limit 1");
echo  mysql_error();
$conteggiomittenti=mysql_query("select count(*) from joinletteremittenti$annoprotocollo where idlettera='$idlettera'"); 
$conteggiomittenti2 = mysql_fetch_row($conteggiomittenti);
if ($conteggiomittenti2[0] < 1) { $inserimentomittenti=mysql_query("insert into joinletteremittenti$annoprotocollo values ('$idlettera',1)");}
?>


<div class="content">

<?php 	$my_lettera = new Lettera(); //crea un nuovo oggetto 'lettera'
	$my_lettera -> publdisplaylettera ($_GET['idlettera'], $annoprotocollo); //richiamo del metodo "mostra" dell'oggetto Lettera
?>
</div>


</p></div>
					
			

		</div>
			
			<!-- post end -->
<div id="primarycontent">
		
			<!-- secondary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Opzioni:</u></h3>
				
				</div>
				<div class="content">
					<p>



</p>


</div>
<div class="content">
				<ul class="linklist">

<li class="first"><a href="login0.php?corpus=dettagli-protocollo&from=risultati&id=<?php echo $idlettera;?>"><br>Visualizza Dettagli</a></li>
					<li><a href="login0.php?corpus=protocollo">Registrazione nuovo PROTOCOLLO</a></li>
</ul>
			</div>
<br><br>


</p></div>
					
			
<div class="footer">

					
				</div>
		</div>




		</div>
