<?php
//$annoprotocollo = $_SESSION['annoprotocollo'];
$risultatiperpagina = $_SESSION['risultatiperpagina']; //acquisisce la variabile di sessione che stabilisce quanti risultati vengono mostrati in ogni pagina

$currentpage = $_GET['currentpage'];

// se non settate da una form di invio, le seguenti variabili prendono valore da GET o da SESSION

if (!isset($_POST['cercato'])) 
	{
	$_POST['cercato'] = $_GET['cercato'] ;
	} 
if (!isset($_POST['ordinerisultati'])) 
	{
	$_POST['ordinerisultati'] = "anagrafica" ;
	}
if (!isset($_POST['tabella'])) 
	{
	$_POST['tabella'] = $_GET['tabella'] ;
	}
if (!isset($_POST['annoricercaprotocollo'])) 
	{
	$_POST['annoricercaprotocollo'] = $_SESSION['annoricercaprotocollo'] ;
	}
if (!isset($_POST['anagraficatipologia'])) 
	{
	if (isset($_GET['anagraficatipologia']))
		{
		 $_POST['anagraficatipologia']= $_GET['anagraficatipologia'] ;
		 }
	}
$logindatagruppo2=$_SESSION['gruppo'];//setta l'id del gruppo cui appartiene l'utente che ha fatto login

if (isset($_POST['anagraficatipologia']))
	{
	$filtro = $_POST['anagraficatipologia'];
	}


$ordinerisultati = $_POST['ordinerisultati'];
$cercato = $_POST['cercato']; //parola chiave da ricercare

$nomecercato = NULL;

if ($cercato!='') 
	{
	if (substr_count(" ", $cercato) > 0)
		{
		list($cognomecercato, $nomecercato) = explode("+", $cercato);
		}
	}

$tabella = $_POST['tabella'];
$annoricercaprotocollo=$_POST['annoricercaprotocollo'];
$_SESSION['annoricercaprotocollo']= $annoricercaprotocollo;
$ordinerisultati= $_POST['group1']; //scelta fra i vari tipi di presentazione dei risultati: ordine cronologico, cronologico inverso ed alfabetico
//scelta fra ricerca in anagrafica e protocollo

//scelta 'anagrafica'
if ($tabella == 'anagrafica')
	{
	if ($ordinerisultati == 'alfabetico') 
		{ 
		$_SESSION['ordinerisultati'] = 'order by anagrafica.cognome, anagrafica.nome';
		}
	if ($ordinerisultati == 'cronologico') 
		{ 
		$_SESSION['ordinerisultati'] = 'order by anagrafica.idanagrafica';
		}
	if ($ordinerisultati == 'cron-inverso') 
		{ 
		$_SESSION['ordinerisultati'] = 'order by anagrafica.idanagrafica desc';
		}
	
//filtro per ispettori di gruppo: visualizza tra i risultati solo anagrafiche di persone fisiche del suo stesso gruppo
	if ($_SESSION['auth'] < 11) 
		{
		$filtroispettorigruppo = "and ( joinanagraficagruppo.idgruppo='$logindatagruppo2') 
				and (joinanagraficagruppo.idanagrafica=anagrafica.idanagrafica)"; 
				$joinanagraficagruppo= ', joinanagraficagruppo';
		}//setta un filtro che impedisce agli ispettori di gruppo, 
		//in base al loro livello di autorizzazione, di vedere anagrafiche che non siano appartenenti al loro stesso gruppo
	
	else 
		{
		$filtroispettorigruppo =''; $joinanagraficagruppo= '';
		}

	if ($filtro == 'anagrafica.tipologia')
		{
		if($nomecercato != NULL)
    			{ 
      			$count = mysql_query("SELECT COUNT(*) 
      						FROM anagrafica 
      						where (anagrafica.idanagrafica = '$cercato' 
      						or (anagrafica.cognome ='$cognomecercato' 
      						and anagrafica.nome='$nomecercato'))
      						"); //conteggio per divisione in pagine dei risultati
    			}
    			
   		 else
   			{
       			$count = mysql_query("SELECT COUNT(*) 
       						FROM anagrafica 
       						where (anagrafica.idanagrafica = '$cercato' 
       						or anagrafica.nome like '%$cercato%' 
       						or anagrafica.cognome like '%$cercato%')
       						"); //conteggio per divisione in pagine dei risultati
    			}
		}
	else
		{
		if($nomecercato != NULL)
    			{ 
      			$count = mysql_query("SELECT COUNT(*) 
      						FROM anagrafica $joinanagraficagruppo 
      						where ((anagrafica.idanagrafica = '$cercato' 
      						or (anagrafica.nome='$nomecercato' 
      						and anagrafica.cognome='$cognomecercato')) 
      						and (anagrafica.tipologia='$filtro') 
      						$filtroispettorigruppo )
      						");//conteggio per divisione in pagine dei risultati
    			}
    		else
    			{
       			$count = mysql_query("SELECT COUNT(*) 
       						FROM anagrafica $joinanagraficagruppo 
       						where ((anagrafica.idanagrafica = '$cercato' 
       						or anagrafica.nome like '%$cercato%' 
       						or anagrafica.cognome like '%$cercato%') 
       						and (anagrafica.tipologia='$filtro') 
       						$filtroispettorigruppo )
       						");//conteggio per divisione in pagine dei risultati
    			}
		}

	$res_count = mysql_fetch_row($count);//conteggio per divisione in pagine dei risultati

	$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati

	$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - 
							//la frazione arrotondata per eccesso

	$iniziorisultati = $_GET['iniziorisultati'];

	$contatorelinee = 1 ;// per divisione in due colori diversi in tabella

	$ordinerisultati=$_SESSION['ordinerisultati']; //acquisisce la scelta fra ordine alfabetico, 
						//cronologico o cronologico inverso nella presentazione dei risultati

	if($filtro == 'anagrafica.tipologia')  //se la ricerca in anagrafica è su 'nessun filtro'
		{
		if($nomecercato != NULL)
   			{ 
      			$risultati= mysql_query("select distinct * 
      						FROM anagrafica 
      						where (anagrafica.idanagrafica = '$cercato' 
      						or (anagrafica.nome='$nomecercato' 
      						and anagrafica.cognome='$cognomecercato')) 
      						$ordinerisultati 
      						limit $iniziorisultati , $risultatiperpagina 
      						");
    			}
    		else
    			{
       			$risultati= mysql_query("select distinct * 
       						FROM anagrafica 
       						where (anagrafica.idanagrafica = '$cercato' 
       						or anagrafica.nome like '%$cercato%' 
       						or anagrafica.cognome like '%$cercato%') 
       						$ordinerisultati 
       						limit $iniziorisultati , $risultatiperpagina 
       						");
    			}
		}
		
	else //se la ricerca in anagrafica è impostata con un qualche filtro per tipologia
		{
		if($nomecercato != NULL)
    			{ 
      			$risultati= mysql_query("select distinct * 
      						FROM anagrafica $joinanagraficagruppo 
      						where ((anagrafica.idanagrafica = '$cercato' 
      						or (anagrafica.nome='$nomecercato' 
      						and anagrafica.cognome='$cognomecercato')) 
      						and (anagrafica.tipologia='$filtro') 
      						$filtroispettorigruppo ) 
      						$ordinerisultati 
      						limit $iniziorisultati , $risultatiperpagina 
      						");
    			}
    		else
    			{
      			$risultati= mysql_query("select distinct * 
      				FROM anagrafica $joinanagraficagruppo 
      				where ((anagrafica.idanagrafica = '$cercato' 
      				or anagrafica.nome like '%$cercato%' 
      				or anagrafica.cognome like '%$cercato%') 
      				and (anagrafica.tipologia='$filtro') 
      				$filtroispettorigruppo ) 
      				$ordinerisultati 
      				limit $iniziorisultati , $risultatiperpagina 
      				");
    			}
		}

	$num_righe = mysql_num_rows($risultati);

	if  ($num_righe > 0 ) 
		{
		if ($cercato !='') 
			{
			if ($tot_records==1) 
				{
				echo "Numero di risultati trovati: <b>$tot_records</b>"; 
				} 
			else 
				{
				echo "Numero di risultati trovati: <b>$tot_records</b>";
				} 
			}
		else 
			{ 
			echo "Numero di risultati trovati: <b>$tot_records</b>";
			}
		?>
		<br><br>


		<table class="table table-bordered">

			<tr><b>
				<td align="center"><b>Id</td>
				<td align="center"><b>Tipo</td>
				<td align="center"><b>Cognome</td>
				<td align="center"><b>Nome</td>
				<td align="center"><b>Data di Nascita</td>
				<td align="center"><b>Comune</td>
				<td align="center"><b>Prov.</td>
				<td align="center"><b>Codice Fiscale</td>
				<td align="center"><b>Opzioni</td>
			</tr>

		<?php

		while ($row = mysql_fetch_array($risultati)) 
			{
			if ( $contatorelinee % 2 == 1 ) 
				{ 
				$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
				} //primo colore

			else 
				{ 
				$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
				} //secondo colore

			$contatorelinee = $contatorelinee + 1 ;




			?><tr bgcolor = <?php echo $colorelinee; ?> >
				<td><?php echo $row['idanagrafica'];?></td>
				<td align="center" valign="middle"><?php echo $row['tipologia'];?></td>
				<td align="center" valign="middle"><?php echo $row['cognome'];?></td>
				<td align="center" valign="middle"><?php echo $row['nome'] ; ?> </td>
				<td align="center" valign="middle"><?php $data = $row['nascitadata'] ;
									list($anno, $mese, $giorno) = explode("-", $data);
									$data2 = "$giorno-$mese-$anno";
									echo "$data2" ;?>
					</td>
				<td align="center" valign="middle"><?php echo $row['nascitacomune'];?></td>
				<td align="center" valign="middle"><?php echo $row['nascitaprovincia'];?></td>
				<td align="center" valign="middle"><?php echo $row['codicefiscale'];?></td>
				<td align="center" width="150">
					<div class="btn-group btn-group-sm">
					<a class="btn btn-info" href="login0.php?corpus=dettagli-anagrafica
									&from=risultati
									&tabella=anagrafica
									&id=<?php echo $row['idanagrafica'];?>">
									Dettagli
						</a>
					<a class="btn btn-warning" href="login0.php?corpus=modifica-anagrafica
									&from=risultati
									&tabella=anagrafica
									&id=<?php echo $row['idanagrafica'];?>">
									Modifica
						</a>
					</div>
					</td>
			</tr><?php

			}?>

		</table>
		
		<?php

		echo "<br>Pagina $currentpage di $tot_pages <br>";

//controllo per pagina avanti-indietro

		if(($filtro != 'persona') 
			and ($filtro != 'carica') 
			and ($filtro != 'ente')) 
			{
			$filtro = 'anagrafica.tipologia';
			}
		if ($iniziorisultati > 0) 
			{
			?> <a href="login0.php?corpus=risultati
				&iniziorisultati=<?php $paginaprecedente = $iniziorisultati - $risultatiperpagina ; 
						echo "$paginaprecedente" ;?>
				&cercato=<?php echo "$cercato" ;?>
				&tabella=<?php echo "$tabella" ;?>
				&currentpage=<?php $previouspage= $currentpage - 1 ; 
						echo "$previouspage" ;?>
				&anagraficatipologia=<?php echo "$filtro" ;?>">
				Pagina precedente 
				</a> &nbsp &nbsp <?php 
			} 

		if (($iniziorisultati + $risultatiperpagina) < $tot_records ) 
			{
			?> <a href="login0.php?corpus=risultati
				&iniziorisultati=<?php $paginasuccessiva = $iniziorisultati + $risultatiperpagina ; 
						echo "$paginasuccessiva" ;?>
				&cercato=<?php echo "$cercato" ;?>
				&tabella=<?php echo "$tabella" ;?>
				&currentpage=<?php $nextpage= $currentpage + 1 ; 
						echo "$nextpage" ;?>
				&anagraficatipologia=<?php echo "$filtro" ;?>">
				Pagina successiva
				</a><?php 
			}

//fine controllo pagine avanti-indietro

		echo '<br><br>';

		}

	else 
		{

		echo "Non ci sono risultati "; ?> 
		<a href="login0.php?corpus=ricerca"><br><br>Effettua un'altra ricerca
			</a><?php
		}

	}
//fine scelta tabella = anagrafica





//scelta tabella = lettere
$my_file = new File(); //crea un nuovo oggetto 'file'


$data = explode("/", $cercato);
if( isset($data[0]) && isset($data[1]) && isset($data[2])) { 
	$data = "$data[2]-$data[1]-$data[0]";
}

if (preg_match("/lettere/i", $tabella))
	{
	if ($tabella=='lettere') 
		{ 
		$tabella= $tabella.$annoricercaprotocollo;
		}
	$joinletteremittenti= 'joinletteremittenti'.$annoricercaprotocollo;

	if ($ordinerisultati == 'alfabetico') 
		{ 
		$_SESSION['ordinerisultati'] = 'order by anagrafica.cognome, anagrafica.nome';
		}
	if ($ordinerisultati == 'cronologico') 
		{ 
		$_SESSION['ordinerisultati'] = 'order by '.$tabella.'.idlettera';
		}
	if ($ordinerisultati == 'cron-inverso') 
		{ 
		$_SESSION['ordinerisultati'] = 'order by '.$tabella.'.idlettera desc';
		}

	$count = mysql_query("SELECT COUNT(*) 
				FROM $tabella , anagrafica , $joinletteremittenti 
				where ( $tabella.idlettera like '%$cercato%' 
					or $tabella.oggetto like '%$cercato%' 
					or $tabella.speditaricevuta like '%$cercato%' 
					or $tabella.note like '%$cercato%' 
					or $tabella.posizione like '%$cercato%' 
					or anagrafica.cognome like '%$cercato%' 
					or $tabella.datalettera like '$data') 
				and ($joinletteremittenti.idlettera = $tabella.idlettera 
					and $joinletteremittenti.idanagrafica = anagrafica.idanagrafica
				) ");//conteggio per divisione in pagine dei risultati

	$res_count = mysql_fetch_row($count);//conteggio per divisione in pagine dei risultati

	$tot_records = $res_count[0];//conteggio per divisione in pagine dei risultati

	$tot_pages = ceil($tot_records / $risultatiperpagina);//conteggio per divisione in pagine dei risultati - la frazione arrotondata per eccesso

	$iniziorisultati = $_GET['iniziorisultati'];

	$contatorelinee = 1 ;// per divisione in due colori diversi in tabella
	$ordinerisultati=$_SESSION['ordinerisultati'];

	$risultati = mysql_query("SELECT  distinct * 
				FROM $tabella
				where ( $tabella.idlettera like '%$cercato%' 
					or $tabella.oggetto like '%$cercato%' 
					or $tabella.speditaricevuta like '%$cercato%' 
					or $tabella.note like '%$cercato%' 
					or $tabella.posizione like '%$cercato%' 
					or $tabella.datalettera like '$data') 
				$ordinerisultati 
				limit $iniziorisultati , $risultatiperpagina
				");
	echo mysql_error();
	
	$num_righe = mysql_num_rows($risultati);

	if  ($num_righe > 0 )
		{
		if ($cercato !='') 
			{ 
			if ($tot_records==1) 
				{
				echo "Numero di risultati trovati: <b>$tot_records</b>"; 
				} 
			else 
				{
				echo "Numero di risultati trovati: <b>$tot_records</b>";
				} 
			}
		else 
			{ 
			echo "Numero di risultati trovati: <b>$tot_records</b>";
			}
			?>
			<br><br>
		<table class="table table-bordered" align="center">
			<tr align = "center"><strong>
				<td>N. Prot.</td>
				<td>Data Reg.</td>
				<td>Sped./Ric.</td>
				<td>Oggetto</td>
				<td>File</td>
				<td>Mitt./Dest.</td>
				<td>Opzioni</td>
			</strong>
			</tr>

			<?php
			
		$my_database->arrayfromquery($risultati); //uso oggetto database per impostare i risultati della query

		foreach ($my_database->resultarray as $key=>$value) //elenco i risultati dell'array
			{
			if ( $contatorelinee % 2 == 1 ) 
				{ 
				$colorelinee = $_SESSION['primocoloretabellarisultati'] ; 
				} //primo colore
			else 
				{ 
				$colorelinee = $_SESSION['secondocoloretabellarisultati'] ; 
				} //secondo colore

			$contatorelinee = $contatorelinee + 1 ;
			?><tr bgcolor = <?php echo "$colorelinee"; ?> >
				<td><?php echo $value[0] ;?></td>
				<td> <?php $my_calendario->publdataitaliana($value[3],'/'); echo $my_calendario->dataitaliana?></td>
				<td><?php echo $value[5] ;?></td>
				<td><?php echo $value[1] ;?></td>
				<td>
				<?php
				$download = $my_file -> downloadlink($value[4], $value[0], $annoricercaprotocollo, '30');
					if ($download != "Nessun file associato") {
						echo $download;
					}
					else {
						echo "Nessun file associato";
					}
				?>
				</td>

				<td><?php
					$mittenti= mysql_query("SELECT  distinct *
								from anagrafica, $joinletteremittenti
								where $joinletteremittenti.idlettera = $value[0]
								and anagrafica.idanagrafica=$joinletteremittenti.idanagrafica
								");
					while ($mittenti2=mysql_fetch_array($mittenti))
						{
						$mittenti3=$mittenti2['nome'].' '.$mittenti2['cognome'];	
						?><a href="login0.php?corpus=dettagli-anagrafica
						&from=risultati
						&tabella=anagrafica
						&id=<?php echo $mittenti2['idanagrafica'];?>
						">
						<?echo $mittenti3;?><br></a>
						<?php 
						}
						?>
				</td>
				<td align="center" width="150">
					<div class="btn-group btn-group-sm">
					<a class="btn btn-info" 
						href="login0.php?corpus=dettagli-protocollo
							&from=risultati&tabella=protocollo
							&id=<?php echo $value[0];?>
						">Dettagli
					</a>
					<a class="btn btn-warning" 
						href="login0.php?corpus=modifica-protocollo
							&from=risultati
							&tabella=anagrafica
							&id=<?php echo $value[0];?>
						">Modifica
					</a>
					</div>
					</td>
		
	   		</tr><?
			}
			?>

		</table>

		<?php

		echo "<br>Pagina $currentpage di $tot_pages <br>";

//controllo per pagina avanti-indietro

		if ($iniziorisultati > 0) 
			{
			?> <a href="login0.php?corpus=risultati
				&iniziorisultati=<?php $paginaprecedente = $iniziorisultati - $risultatiperpagina ; 
				echo "$paginaprecedente" ;?>
				&cercato=<?php echo "$cercato" ;?>
				&tabella=<?php echo "$tabella" ;?>
				&currentpage=<?php $previouspage= $currentpage - 1 ; 
				echo "$previouspage" ;?>">Pagina precedente </a> &nbsp &nbsp <?php 
			} 

		if (($iniziorisultati + $risultatiperpagina) < $tot_records ) 
			{
			?> <a href="login0.php?corpus=risultati&iniziorisultati=<?php $paginasuccessiva = $iniziorisultati + $risultatiperpagina ; 
									echo "$paginasuccessiva" ;?>
									&cercato=<?php echo "$cercato" ;?>
									&tabella=<?php echo "$tabella" ;?>
									&currentpage=<?php $nextpage= $currentpage + 1 ; 
									echo "$nextpage" ;?>">Pagina successiva </a>
			<?php 
			}

//fine controllo pagine avanti-indietro

echo '<br><br>';

			


		}
	else 
		{
		echo "Non ci sono risultati nelle tabelle $tabella e $joinletteremittenti"; ?> 
		<br><br><a href="login0.php?corpus=ricerca">Effettua un'altra ricerca</a><?php
		}
	}
?>
