	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Dati inviati</u></h3>
				
				</div>
				<div class="content">
					<p>
<?php

$risultato = $_GET['inserimento'];
$id = $_GET['id'];
if($risultato == "true")
{
	$query = $connessione->query("SELECT DISTINCT * FROM anagrafica WHERE idanagrafica= '$id' ");
	$row = $query->fetch();
	$datanascita = $row['nascitadata'];
	$date = explode("-" , $datanascita);
	$giorno = $date[2];
	$mese = $date[1];
	$anno = $date[0];
?>

<div class="content">
<p><img src="foto/<?php echo $row['urlfoto'] ; ?> " height="100"><br><br>Cognome: <strong><?php echo $row['cognome'] ; ?></strong> <br>Nome: <strong><?php echo $row['nome'] ; ?></strong><br>Data di Nascita: <strong><?php echo $giorno .'-'. $mese .'-'. $anno ;?></strong></p>
<?php
}
else
{
?>
<div class="content">
<br>
<p> Impossibile modificare i dati </p>
<?php
}
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
			
<div class="content"><br>
				<ul class="linklist">

<li class="first"><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&id=<?php echo $id;?>">Visualizza Dettagli di questa anagrafica</a></li>
					<li><a href="login0.php?corpus=modifica-anagrafica&from=risultati&id=<?php echo $id;?>">Modifica questa anagrafica</a><br>(Anche per aggiungere email, cellulare o altri contatti)</li>
<?php if ($anagraficatipologia=='persona') { ?>	<li><a href="login0.php?corpus=gruppo&id=<?php echo $id;?>">Gruppo CRI di appartenenza</a></li> <li><a href="login0.php?corpus=curriculum&id=<?php echo $id;?>">Gestione curriculum CRI</a></li><?php }?>
					
					<li><a href="login0.php?corpus=anagrafica">Inserisci nuova ANAGRAFICA</a></li>
</ul>
			</div>
<br><br>


</p></div>
					
			
<div class="footer">

					
				</div>
		</div>




		</div>
