<?php
$level = $_SESSION['auth'];
$id= $_GET['id'];
//filtro per consentire agli ispettori (che hanno un livello auth basso) di leggere i dettagli dell'anagrafica dei soli componenti del proprio gruppo
$gruppo=mysql_query("select distinct * from joinanagraficagruppo where idanagrafica='$id'");
$gruppo2= mysql_fetch_array($gruppo); //definizione del gruppo di cui mostrare i componenti

$gruppoutente=$_SESSION['gruppo']; //definizione del gruppo cui appartiene l'utente di abulafia loggato al momento

//limitazione per gli utenti di basso livello che possono vedere solo gli appartenenti al proprio gruppo
if (($level < 11) and ($gruppoutente != $gruppo2['idgruppo'])) { 
echo "Non hai l'autorizzazione necessaria per accedere a questa pagina. Se ritieni di averne diritto, contatta l'amministratore.";
exit();
}
?>
	
    
<div id="primarycontent">

	<div class="post">
		<div class="header">
			<h3><u>Dettagli Anagrafica:</u></h3>
		</div>
                
		<div class="content">
			<p>
<?php
$risultati=mysql_query("select * from anagrafica where idanagrafica='$id'");
$risultati2=mysql_query("select * from jointelefonipersone where idanagrafica='$id'");
$row = mysql_fetch_array($risultati);
$data = $row['nascitadata'] ;
list($anno, $mese, $giorno) = explode("-", $data);
?>

<div class="content">


<table width="100%" border="0" style="border:solid 3px; border-color:#090; background-repeat:repeat-x; background-position:top" cellspacing="0" background="images/tesserino/sfondo.png">
	
    <tr>
    
    	<td rowspan="2" width="170px" height="210px" background="images/tesserino/foto.png" style="background-repeat:no-repeat; background-position:center; padding:10px 5px 10px 5px"" align="center">
<img src="foto/<?php echo $row['urlfoto'] ; ?>" width="145">
		</td>
        
        <td valign="middle" style="border-left:solid 3px; border-color:#090; padding:10px 5px 10px 5px">
<?php if ($row['tipologia']=='persona') {?><font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Cognome: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['cognome'])) ; ?></font></strong><?php }?>
            
<?php if ($row['tipologia']!='persona') {?><font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Denominazione: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['cognome'])) ; ?></font></strong><?php }?>

<?php if ($row['tipologia']=='persona') {?><font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Nome: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['nome'])) ; ?></font></strong><?php }?>

<?php if (($row['tipologia']=='persona') or ($row['tipologia']=='gruppo')){?><font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Data di Nascita: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo $giorno .'-'. $mese .'-'. $anno ; ?></font></strong><?php }?>

<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><?php if ($row['tipologia']=='persona') {?><br>Luogo di Nascita: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['nascitacomune'])); 
if ($row['nascitaprovincia'] !=''){ echo ' (' . strtoupper($row['nascitaprovincia']) . ')'; } 
if ($row['nascitastato'] !='') { echo ' - ' . ucwords(strtolower($row['nascitastato'])) ; ?></font></strong><?php ;}
 }?>
 
<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Codice Fiscale: </font><font style="font-family:'Comic Sans MS', cursive" size="+1"><strong><?php echo strtoupper($row['codicefiscale']); ?></strong></font>
		</td>
        
<?php if ($row['tipologia']=='persona') {
	
list($tipo, $rh)=explode('rh', $row['grupposanguigno']); ?>
<td width="60px" height="60px" background="images/tesserino/<?php echo $rh; ?>.png" style="background-repeat:no-repeat; background-position:top; padding-top:18px; padding-right:2px" align="center" valign="top">
<strong><font style="font-family:'Comic Sans MS', cursive" size="+3"><?php echo $tipo; ?></font></strong>
</td>
<?php }?>
	
    
    </tr>

	<tr>
    	<td colspan="2" valign="middle" style="border-top:solid 3px; border-left:solid 3px; border-color:#090; padding:10px 5px 10px 5px">
<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><?php if ($row['tipologia']=='persona') {?>Residente in: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo ucwords(strtolower($row['residenzavia'])); if ($row['residenzacivico']!='') {echo ' n. ' . $row['residenzacivico'] ;} ?><?php }?></font></strong>

<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><?php if ($row['tipologia']!='persona') {?>Indirizzo: </font><strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php echo $row['residenzavia']; if ($row['residenzacivico']!='') {echo ' n. ' . $row['residenzacivico'] ;} ?></font></strong>  <?php }?>

<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>Comune: </font><font style="font-family:'Comic Sans MS', cursive" size="+1"><strong><?php echo $row['residenzacitta']; if ($row['residenzaprovincia']!='') {echo ' ('. $row['residenzaprovincia'] . ')' ;} ?></strong></font>

<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1"><br>CAP: </font><font style="font-family:'Comic Sans MS', cursive" size="+1"><strong><?php echo $row['residenzacap']; ?></strong></font>

        </td>
    </tr>
    
    

  	<tr>
      	<td width="" style="border-top:solid 3px; border-color:#090; padding:10px 5px 10px 5px">  
<font style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif" size="+1">Recapiti: </font>
		</td>
                
        <td colspan="2" width="" style="border-top:solid 3px; border-color:#090; padding:10px 5px 10px 5px">
<strong><font style="font-family:'Comic Sans MS', cursive" size="+1"><?php
while ($row2 = mysql_fetch_array($risultati2)) {
if ($row2['numero'] != '') {
echo '<img src="images/'.$row2['tipo'].'.png" width="20" height="20"> '; echo strtolower($row2['numero']). '  -  ' .strtoupper($row2['tipo']) ;}?><br> <?php
}
?></font></strong>
		</td>
	</tr>
</table>

</div>

</div>
					
	<br />	<br />
			
<!-- post end -->
<?php if ($row['tipologia'] == 'carica') { ?>
	<div class="post">
		<div class="header">
			<h3><u>Persona attualmente in carica:</u></h3>
        </div>
	</div>
	
    <div class="content">
<?php
$idcarica=$row['idanagrafica'];
$attuale = mysql_query ("select * from anagrafica, joinanagraficacariche where anagrafica.idanagrafica=joinanagraficacariche.idanagrafica and  joinanagraficacariche.idcarica='$idcarica' and joinanagraficacariche.datafine='0000-00-00' order by joinanagraficacariche.datainizio, joinanagraficacariche.datafine");
while ($attuale2=mysql_fetch_array($attuale)) 
	  { ?>
<img src="foto/<?php echo $attuale2['urlfoto'];?>" class="picd floatleft" alt=""  height="50"/><?php	echo $attuale2['cognome'].' '.$attuale2['nome'].' - ';?><a href="login0.php?corpus=dettagli-anagrafica&amp;id=<?php echo $attuale2['idanagrafica'];?>">Dettagli</a><br /> 
<?php } ?>
	</div>
    
<?php }?>

    <br /><br />

<?php if ($row['tipologia'] == 'carica') { ?>
	<div class="post">
		<div class="header">
			<h3><u>Predecessori:</u></h3>
        </div>
	</div>
    
    <div class="content">
<?php 
$idcarica=$row['idanagrafica'];
$attuale = mysql_query ("select * from anagrafica, joinanagraficacariche where anagrafica.idanagrafica=joinanagraficacariche.idanagrafica and  joinanagraficacariche.idcarica='$idcarica' and joinanagraficacariche.datafine!='0000-00-00' order by joinanagraficacariche.datainizio, joinanagraficacariche.datafine");
while ($attuale2=mysql_fetch_array($attuale)) 
	  {	?>
<img src="foto/<?php echo $attuale2['urlfoto'];?>" class="picd floatleft" alt=""  height="50"/><?php	echo $attuale2['cognome'].' '.$attuale2['nome'].' - ';?><a href="login0.php?corpus=dettagli-anagrafica&amp;id=<?php echo $attuale2['idanagrafica'];?>">Dettagli</a><br />
<?php } ?>
	</div> 

<?php }?>

<br /><br />

</div>


<div id="primarycontent">

			<div class="post">
				<div class="header">
					<h3><u>Opzioni:</u></h3>
				</div>
			</div>
            
<div class="content">
	
    <ul class="linklist">

<li class="first"><a href="login0.php?corpus=modifica-anagrafica&amp;from=risultati&amp;id=<?php echo $id;?>">Modifica questa Anagrafica</a></li>
        
<?php if ($row['tipologia'] == 'persona') { ?>
<li><a href="login0.php?corpus=gruppo&amp;id=<?php echo $id;?>">Gruppo CRI di appartenenza </a></li>
<?php }?>

<?php if ($row['tipologia'] == 'persona') { ?>
<li><a href="login0.php?corpus=curriculum&amp;id=<?php echo $id;?>">Gestione CURRICULUM</a></li>
<?php }?>

<?php
//creazione link per tornare all'elenco del gruppo di appartenenza con indicazione se il volontario è attivo o meno
$componenti= mysql_query("select * from anagrafica, joinanagraficagruppo where anagrafica.idanagrafica=joinanagraficagruppo.idanagrafica and anagrafica.idanagrafica='$id'"); 
while ($row= mysql_fetch_array($componenti)) 
	{
	if ($row['datafine']== '0000-00-00') { $status='attivo'; $link='componenti'; }
	else { $status='storico'; $link='storia';}
	$gruppo3=$row['idgruppo'];
	$nomegruppo=mysql_query("select distinct * from anagrafica where idanagrafica='$gruppo3'");
	$nomegruppo2= mysql_fetch_array($nomegruppo);
?>

<?php if ($row['tipologia'] == 'persona') { ?>
<li><a href="login0.php?corpus=repgruppi-<?php echo $link;?>&amp;id=<?php echo $gruppo3;?>">Pioniere <?php echo $status;?> del <?php echo $nomegruppo2['cognome'];?> - vai all'elenco</a></li> 
<?php }?>

<?php }?>

<li><a href="login0.php?corpus=anagrafica">Nuovo inserimento ANAGRAFICA</a></li>

	</ul>
</div>

<br><br>


</p></div>
					
			
            
            
<div class="footer">
</div>

</div>

