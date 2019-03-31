<?php
$iniziorisultati = $_GET['iniziorisultati'];
$risultatiperpagina = $_SESSION['risultatiperpagina']; 
$currentpage = $_GET['currentpage'];
if (!isset($_POST['cercato'])) {$_POST['cercato'] = $_GET['cercato'] ;} 
if (!isset($_POST['ordinerisultati'])) {$_POST['ordinerisultati'] = "anagrafica" ;}
if (!isset($_POST['tabella'])) {$_POST['tabella'] = $_GET['tabella'] ;}
$ordinerisultati = $_POST['ordinerisultati'];
$cercato = $_POST['cercato'];
$tabella = $_POST['tabella'];
$idlettera=$_GET['idlettera'];
$urlpdf=$_GET['urlpdf'];
$count = $connessione->query("SELECT COUNT(*) FROM anagrafica.nome like '%$cercato%' or anagrafica.cognome like '%$cercato%'");//conteggio per divisione in pagine dei risultati
$res_count = $count->fetch();//conteggio per divisione in pagine dei risultati
$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso
$iniziorisultati = $_GET['iniziorisultati'];
$contatorelinee = 1 ;// per divisione in due colori diversi in tabella



$risultati= $connessione->query("SELECT distinct * from anagrafica where anagrafica.nome like '%$cercato%' or anagrafica.cognome like '%$cercato%'limit $iniziorisultati , $risultatiperpagina" );
$num_righe = $risultati->rowCount();
if  ($num_righe > 0 ) {
echo " $tot_records occorrenze nel database per: $cercato";
?>

<table border="0" cellpadding="1" cellspacing="1" width="<?php echo $_SESSION['larghezzatabellarisultati'];?>">
<tr><b>
<td><b>ID</td><td><b>Cognome</td><td><b>Nome</td><td><b>Data di Nascita</td><td><b>Comune</td><td><b>Prov.</td><td><b>Codice Fiscale</td></tr>
<?php
while ($row = $risultati->fetch()) {
if ( $contatorelinee % 2 == 1 ) { $colorelinee = $_SESSION['primocoloretabellarisultati'] ; } //primo colore
else { $colorelinee = $_SESSION['secondocoloretabellarisultati'] ; } //secondo colore

$contatorelinee = $contatorelinee + 1 ;

?><tr bgcolor = " <?php echo $colorelinee; ?> "><td><?php
echo $row['idanagrafica'] ;
?></td><?php

?><td align="center" valign="middle"><?php
echo $row['cognome'] ; ?>
</td><?php

?><td align="center" valign="middle"><?php
echo $row['nome'] ; ?> 
</td><?php

?><td align="center" valign="middle"><?php
$data = $row['nascitadata'] ;
list($anno, $mese, $giorno) = explode("-", $data);
$data2 = "$giorno-$mese-$anno";
echo "$data2" ;
?></td>

<td align="center" valign="middle"><?php
echo $row['nascitacomune'] ;
?></td><?php

?><td align="center" valign="middle"><?php
echo $row['nascitaprovincia'] ;
?></td>

<td>
<a href="login0.php?corpus=protocollo2&from=aggiungi&tabella=anagrafica&idanagrafica=<?php echo $row['idanagrafica'];?>&idlettera=<?php echo $idlettera;?>&urlpdf=<?php echo $urlpdf;?>">Seleziona Mittente/destinatario</a>
</td>

</tr><?php
}
?>
</table>

<?php
echo "<br><br>Pagina $currentpage di $tot_pages <br>";
//controllo per pagina avanti-indietro
if ($iniziorisultati > 0) {
?> <a href="login0.php?corpus=prot-aggiungi-mittente&iniziorisultati=<?php $paginaprecedente = $iniziorisultati - $risultatiperpagina ; echo $paginaprecedente;?>&cercato=<?php echo $cercato;?>&tabella=<?php echo $tabella;?>&currentpage=<?php $previouspage= $currentpage - 1 ; echo $previouspage ;?>"><br><br>Pagina precedente </a> <?php } 
if (($iniziorisultati + $risultatiperpagina) < $tot_records ) {
?>  <a href="login0.php?corpus=prot-aggiungi-mittente&iniziorisultati=<?php $paginasuccessiva = $iniziorisultati + $risultatiperpagina ; echo $paginasuccessiva ;?>&cercato=<?php echo $cercato ;?>&tabella=<?php echo $tabella ;?>&currentpage=<?php $nextpage= $currentpage + 1 ; echo $nextpage 
;?>">Pagina successiva</a><?php }
//fine controllo pagine avanti-indietro

}

else {
echo "Non ci sono risultati "; ?> <a href="login0.php?corpus=protocollo2&idlettera=<?php echo $idlettera;?>&urlpdf=<?php echo $urlpdf;?>&from=aggiungi"><br><br>Effettua un'altra ricerca</a><?php
}

?>

