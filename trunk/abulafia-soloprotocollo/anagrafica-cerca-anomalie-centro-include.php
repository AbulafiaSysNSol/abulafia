<div id="primarycontent">
		

<?php
$filtro=$_GET['filtro'];
?>
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Elenco delle presunte anomalie: <?php echo '('.$filtro.')';?></u></h3>
				
				</div>
				<div class="content">
					<p>

<?php

if ($filtro == 'cognomenome') { ?> <!--inizio scelta filtro ='cognomenome'-->

<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr><b>
<td><b>ID</td><td><b>Cognome</td><td><b>Nome</td><td><b>Data di Nascita</td></tr>

<?php
$risultati= mysql_query("select * from anagrafica order by anagrafica.cognome, anagrafica.nome");
if (!$risultati) {echo 'Nessun risultato dalla query';}
while ($row = mysql_fetch_array($risultati)) { //inizio ciclo while1
$cognome= $row['cognome'];
$nome= $row['nome'];
$id= $row['idanagrafica'];
$datagrezza=$row['nascitadata'];
$datadinascita= list($anno, $mese, $giorno) = explode("-", $datagrezza);
$datadinascita2 = "$giorno-$mese-$anno";
$verificaduplicati= mysql_query("select COUNT(*) from anagrafica where anagrafica.cognome='$cognome' and anagrafica.nome='$nome'");
$res_count=mysql_fetch_row($verificaduplicati);
if ($res_count[0] > 1) { //caso in cui il gruppo cognome+nome risulti duplicato - primo if
//$duplicati = mysql_query("select distinct * from anagrafica where anagrafica.cognome='$cognome' and anagrafica.nome='$nome'");
//while ($duplicati2 = mysql_fetch_array($duplicati)) { //inizio secondo while

?><tr bgcolor = " <?php echo $colorelinee; ?> "><td><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php
echo $id ;?>"><?php
echo $id ;
?></td>

<td valign="middle"><?php
echo $cognome; ?>
</td>

<td valign="middle"><?php
echo $nome ; ?> 
</td>

<td  valign="middle"><?php
echo $datadinascita2;
?></td>

</tr><?php

//} //fine ciclo while2
} //fine primo if
} //fine ciclo while1
?>
</table>

<?php } //fine scelta filtro ='cognomenome'-->

if ($filtro == 'inmolteplicigruppi') { ?> <!--inizio scelta filtro ='inmolteplicigruppi'-->

<table border="0" cellpadding="1" cellspacing="1" width="70%">
<tr><b>
<td><b>ID</td><td><b>Cognome</td><td><b>Nome</td><td><b>ID Gruppo</td></tr>

<?php
$risultati= mysql_query("select * from anagrafica ");
if (!$risultati) {echo 'Nessun risultato dalla query';}
while ($row = mysql_fetch_array($risultati)) { //inizio ciclo while1
$idanagrafica = $row['idanagrafica'];
$riferimenti = mysql_query("select * from anagrafica, joinanagraficagruppo where anagrafica.idanagrafica='$idanagrafica' and anagrafica.idanagrafica=joinanagraficagruppo.idanagrafica");
$molteplicigruppi = mysql_query("select count(*) from joinanagraficagruppo where idanagrafica ='$idanagrafica'");
$molteplicigruppi2 = mysql_fetch_row($molteplicigruppi);
$molteplicigruppi3 = $molteplicigruppi2[0];
if ($molteplicigruppi3 > 1) { //inizio if 2
while ($riferimenti2 = mysql_fetch_array($riferimenti)) {//inizio while2

?><tr bgcolor = " <?php echo $colorelinee; ?> "><td><a href="login0.php?corpus=gruppo&id=<?php
echo $riferimenti2['idanagrafica'] ;
?>"><?php
echo $riferimenti2['idanagrafica'] ;
?></a></td>

<td  valign="middle"><?php
echo $riferimenti2['cognome'] ; ?>
</td>

<td a valign="middle"><?php
echo $riferimenti2['nome'] ; ?> 
</td>

<td valign="middle"><a href="http://localhost/public_html/wpsite/protocollo-reg/login0.php?corpus=dettagli-anagrafica&id=<?php
echo $riferimenti2['idgruppo'] ; ?> "><?php
echo $riferimenti2['idgruppo'] ; ?> 
</a></td>

</tr><?php

} //fine while2
}//fine if 2
} //fine ciclo while1
?>
</table>
<?php } //fine scelta filtro ='inmolteplicigruppi'-->

?>
</p>
</div></div>
					

			
			<!-- post end -->



</div>

