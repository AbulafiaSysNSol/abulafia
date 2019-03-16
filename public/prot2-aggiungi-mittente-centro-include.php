<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
if (!isset($_POST['cercato'])) 
	{$_POST['cercato'] = $_GET['cercato'] ;} 
if (!isset($_POST['ordinerisultati'])) 
	{$_POST['ordinerisultati'] = "anagrafica" ;}
if (!isset($_POST['tabella'])) 
	{$_POST['tabella'] = $_GET['tabella'] ;}
if (!isset($_GET['iniziorisultati'])) 
	{ $_GET['iniziorisultati'] = 0;} 
if (!isset($_GET['currentpage'])) 
	{ $_GET['currentpage'] = 1;} 
$ordinerisultati = $_POST['ordinerisultati'];
$cercato = $_POST['cercato'];
$tabella = $_POST['tabella'];
$idlettera=$_GET['idlettera'];
$urlpdf=$_GET['urlpdf'];
$count = $verificaconnessione->query("SELECT COUNT(*) 
					FROM anagrafica 
					where anagrafica.nome like '%$cercato%' 
						or anagrafica.cognome like '%$cercato%'
					");//conteggio per divisione in pagine dei risultati

$res_count = mysqli_fetch_row($count);//conteggio per divisione in pagine dei risultati
$risultatiperpagina = ($_SESSION['risultatiperpagina']);
$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati
$tot_pages = ceil($tot_records / $_SESSION['risultatiperpagina']);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso
$iniziorisultati = $_GET['iniziorisultati'];
$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
$currentpage = $_GET['currentpage'];

$risultati= $verificaconnessione->query("select distinct * 
					from anagrafica 
					where anagrafica.nome like '%$cercato%' 
						or anagrafica.cognome like '%$cercato%'
					order by anagrafica.idanagrafica 
					limit $iniziorisultati , $risultatiperpagina 
					" );
$num_righe = mysqli_num_rows($risultati);
if  ($num_righe > 0 ) //se il numero di righe è maggiore di zero
	{
	echo " $tot_records occorrenze nel database per: $cercato <br><br>";
	?>

	<table border="0" cellpadding="1" cellspacing="1" width="100%">
		<tr><b>
			<td>ID</td>
			<td>Cognome</td>
			<td>Nome</td>
			<td>Data di Nascita</td>
			<td>Comune</td>
			<td>Prov.</td>
			<td>Seleziona</td>
		</b></tr>
	<?php
	while ($row = mysqli_fetch_array($risultati)) 
		{
		if ( $contatorelinee % 2 == 1 ) 
			{ $colorelinee = $_SESSION['primocoloretabellarisultati'] ; } //primo colore
		else 
		{ $colorelinee = $_SESSION['secondocoloretabellarisultati'] ; } //secondo colore
			$contatorelinee = $contatorelinee + 1 ;

	?>
		<tr bgcolor = " <?php echo "$colorelinee"; ?> ">
			<td><?php echo $row['idanagrafica'] ;?></td>
			<td align="center" valign="middle"><?php echo $row['cognome'] ; ?> </td>
			<td align="center" valign="middle"><?php echo $row['nome'] ; ?> </td>
			<td align="center" valign="middle"><?php $data = $row['nascitadata'] ;
								list($anno, $mese, $giorno) = explode("-", $data);
								$data2 = "$giorno-$mese-$anno";
								echo "$data2" ;
			?></td>

			<td align="center" valign="middle"><?php echo $row['nascitacomune'] ; ?></td>
			<td align="center" valign="middle"><?php echo $row['nascitaprovincia'] ;?></td>
			<td><a href="login0.php?
			corpus=modifica-protocollo
			&from=aggiungi
			&tabella=lettere<?php $annoprotocollo; ?>
			&idanagrafica=<?php echo $row['idanagrafica'];?>
			&id=<?php echo $idlettera;?>
			&urlpdf=<?php echo $urlpdf;?>">Seleziona Mittente/Destinatario</a>
			</td>

		</tr>
	</table>
	<?php
		} //fine while
	
	echo "<br>Pagina $currentpage di $tot_pages <br>";

	//controllo per pagina avanti-indietro
	if ($iniziorisultati > 0) 
		{
		?> <a href="login0.php?corpus=prot2-aggiungi-mittente
				&idlettera=19
				&urlpdf=19nota n. 000025.Pdf
				&iniziorisultati=<?php $paginaprecedente = $iniziorisultati - $risultatiperpagina ; 
						echo "$paginaprecedente" ;?>
				&cercato=<?php echo "$cercato" ;?>
				&tabella=<?php echo "$tabella" ;?>
				&currentpage=<?php $previouspage= $currentpage - 1 ; 
						echo "$previouspage" ;?>">
			Pagina precedente 
			</a> 
		<?php 
		}
 
	if (($iniziorisultati + 10) < $tot_records ))
		{
		?>  <a href="login0.php?corpus=prot2-aggiungi-mittente
				&idlettera=19
				&urlpdf=19nota n. 000025.Pdf
				&iniziorisultati=<?php $paginasuccessiva = $iniziorisultati + $risultatiperpagina ; 
							echo "$paginasuccessiva" ;?>
				&cercato=<?php echo "$cercato" ;?>
				&tabella=<?php echo "$tabella" ;?>
				&currentpage=<?php $nextpage= $currentpage + 1 ; 
						echo "$nextpage" ;?>">
			Pagina successiva
			</a>
		<?php 
		} //fine controllo pagine avanti-indietro
	echo '<br><br>';
	} //fine se il numero di righe è maggiore di zero

else 
	{
echo "Non ci sono risultati "; ?> <a href="login0.php?corpus=ricerca"><br><br>
					Effettua un'altra ricerca
					</a>
	<?php
	}
?>

