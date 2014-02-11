	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Dati inviati</u></h3>
				
				</div>
				<div class="content">
					<p>
<?php

//inizio passaggio dati da pagina inserimento
$insertok = $_POST['insertok'];
$cognome = $_POST['cognome'];
$nome = $_POST['nome'];
$nascita_data_giorno = $_POST['nascitadatagiorno'];
$nascita_data_mese = $_POST['nascitadatamese'];
$nascita_data_anno = $_POST['nascitadataanno'];
$nascita_comune = $_POST['nascitacomune'];
$nascita_provincia  = $_POST['nascitaprovincia'];
$nascita_stato = $_POST['nascitastato'];
$residenza_via = $_POST['residenzavia'];
$residenza_civico = $_POST['residenzacivico'];
$residenza_comune = $_POST['residenzacomune'];
$residenza_cap = $_POST['residenzacap'];
$residenza_provincia = $_POST['residenzaprovincia'];
$residenza_stato = $_POST['residenzastato'];
$url_foto = $id.$_GET['url-foto'];
$gruppo_sanguigno = $_POST['grupposanguigno'];
$codice_fiscale = $_POST['codicefiscale'];
$telefono = $_POST['numero'];
$tipo = $_POST['tipo'];
$telefono2 = $_POST['numero2'];
$tipo2 = $_POST['tipo2'];
$nascita_data = $nascita_data_anno . '-' . $nascita_data_mese . '-' . $nascita_data_giorno   ;
$anagraficatipologia= $_POST['anagraficatipologia'];

//fine passaggio dati
//controllo esistenza
echo $controlloesistenza;
$controlloesistenza = mysql_query("SELECT COUNT(*) from anagrafica where cognome='$cognome' and nome ='$nome' and nascitadata='$nascita_data' ");
$res_count = mysql_fetch_row($controlloesistenza);
//echo $res_count[0];


if ($res_count[0] < 1) {echo "Il soggetto non era presente in anagrafica<br>" ;

$inserimento = mysql_query("INSERT INTO anagrafica VALUES ('','$nome','$cognome','$residenza_stato','$residenza_provincia','$residenza_comune','$residenza_via','$residenza_civico','$residenza_cap',
'$nascita_data','$nascita_stato','$nascita_provincia','$nascita_comune','$url_foto','$gruppo_sanguigno','$codice_fiscale','$anagraficatipologia') " );
echo  mysql_error();
$lastid=mysql_insert_id();

if ($_SESSION['auth'] < 11) {
$group = $_SESSION['gruppo'];
$inserimentogruppo = mysql_query("INSERT INTO joinanagraficagruppo VALUES ('$lastid','$group','0000-00-00','0000-00-00')");
if (!$inserimentogruppo) { echo "<br>Inserimento gruppo non riuscito" ; }
} 

$old_compl_url='foto/'.$url_foto;
$new_compl_url='foto/'.$lastid.$url_foto;
$newname=$lastid.$url_foto;
@rename ("$old_compl_url", "$new_compl_url");
$inserimento3=mysql_query("update anagrafica set anagrafica.urlfoto='$newname' where anagrafica.idanagrafica='$lastid'");
if (!$inserimento3) { echo "<br>Inserimento foto non riuscito" ; }
if (!$inserimento) { echo "<br>Inserimento non riuscito" ; }
$ultimoid = mysql_insert_id();
//inserimento di un recapito associato all'anagrafica solo se il recapito non è vuoto
if (($telefono != '' ) and ($lastid != '' )) {$inserimento2 = mysql_query("INSERT INTO jointelefonipersone VALUES ('$lastid','$telefono','$tipo') " );
if (!$inserimento2) { echo "<br>Inserimento recapito non riuscito" ; }
}
if (($telefono2 != '' ) and ($lastid != '' )) {$inserimento2 = mysql_query("INSERT INTO jointelefonipersone VALUES ('$lastid','$telefono2','$tipo2') " );
if (!$inserimento2) { echo "<br>Inserimento secondo recapito non riuscito" ; }
}





}

else 
{ echo "Elemento gia' presente in anagrafica" ; }



?>
<div class="content">
<p><img src="foto/<?php echo $url_foto ; ?>"><br><br>Cognome: <strong><?php echo $cognome ; ?></strong> <br>Nome: <strong><?php echo $nome ; ?></strong><br>Data di Nascita: <strong><?php echo $nascita_data_giorno .'-'. $nascita_data_mese .'-'. $nascita_data_anno ; ?></strong></p>


</div>
<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=anagrafica">Nuovo inserimento ANAGRAFICA</a></li>
</ul>
			</div>
<br><br>


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

<li class="first"><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&id=<?php echo $lastid;?>">Visualizza Dettagli di questa anagrafica</a></li>
					<li><a href="login0.php?corpus=modifica-anagrafica&from=risultati&id=<?php echo $lastid;?>">Modifica questa anagrafica</a><br>(Anche per aggiungere email, cellulare o altri contatti)</li>
<?php if ($anagraficatipologia=='persona') { ?>	<li><a href="login0.php?corpus=gruppo&id=<?php echo $lastid;?>">Gruppo CRI di appartenenza</a></li> <li><a href="login0.php?corpus=curriculum&id=<?php echo $lastid;?>">Gestione curriculum CRI</a></li><?php }?>
					
					<li><a href="login0.php?corpus=anagrafica">Inserisci nuova ANAGRAFICA</a></li>
</ul>
			</div>
<br><br>


</p></div>
					
			
<div class="footer">

					
				</div>
		</div>




		</div>
