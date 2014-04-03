<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
$my_file = new File(); //crea un nuovo oggetto 'file'
$my_lettera = new Lettera(); //crea un nuovo oggetto
$from= $_GET['from'];
$dbname=$_session['dbname'];
$idanagrafica=$_GET['idanagrafica'];
//se la pagina da cui si proviene è "crea nuovo protocollo" 
if ($from == 'crea') {  
$lastrec= mysql_query("SELECT * FROM lettere$annoprotocollo ORDER BY idlettera desc LIMIT 1");
while ($lastrec2 = mysql_fetch_array($lastrec)) {
$lastrec3=$lastrec2['idlettera'];
$lasttopic=$lastrec2['oggetto'];
}
$lastjoinletteremittenti=mysql_query("SELECT count(*) FROM joinletteremittenti$annoprotocollo where idlettera='$lastrec3'");
$lastjoinletteremittenti = mysql_fetch_array($lastjoinletteremittenti);

        
if (($lastjoinletteremittenti[0] < 1) or (!$lasttopic)) { //controlla che sia stato attribuito un oggetto e un mittente all'ultimo protocollo. In caso non sia stato fatto, lo cancella e lo riutilizza, in quanto ritenuto un protocollo non correttamente registrato e probabile frutto di errore.
$cancella=mysql_query("DELETE FROM lettere$annoprotocollo WHERE idlettera='$lastrec3' limit 1 ");
$resetta=mysql_query("ALTER TABLE lettere$annoprotocollo AUTO_INCREMENT = $lastrec3 ");
$cancella2=mysql_query("DELETE from joinletteremittenti$annoprotocollo where idlettera='$lastrec3' limit 1");
$cancella3=mysql_query("DELETE from joinlettereinserimento$annoprotocollo where idlettera='$lastrec3' limit 1");
}
$dataregistrazione = strftime("%Y-%m-%d");
$crea=mysql_query("insert into lettere$annoprotocollo values('','','','$dataregistrazione','','','','','')");
$ultimoid=mysql_insert_id();
$insertid=$ultimoid;
//$inseriscimittentestandard=mysql_query("insert into joinletteremittenti values('$ultimoid',1)"); eliminata perché inutile dopo modifica del 22-10-2009: l'inserimento del mittente anonimo avviene di default in pagina protocollo3- se non è stato selezionato nessun mittente
$loginid=$_SESSION['loginid'];
$tracciautenteinserimento=mysql_query("insert into joinlettereinserimento$annoprotocollo values('$ultimoid', '$loginid','','')");
if ($insertid > 0) { $idlettera = $insertid;}
}



if ($from =='aggiungi') 
	{
	$idlettera=$_GET['idlettera'];
	$my_lettera -> publinseriscimittente ($idlettera, $idanagrafica, $annoprotocollo); //richiamo del metodo
	}


if ($from == 'elimina-mittente') { 
$idlettera=$_GET['idlettera'];
$elimina=mysql_query("delete from joinletteremittenti$annoprotocollo where idanagrafica='$idanagrafica' and idlettera='$idlettera'");

$urlpdf = $_GET['urlpdf'];
}
if ($from == 'urlpdf') {  
$urlpdf = $_GET['urlpdf'];
$idlettera=$_GET['idlettera'];
}


?>

<div class="panel panel-default">
	
		<div class="panel-heading">
		<h3 class="panel-title"><strong>Protocollo numero: <?php echo $idlettera;?></strong></h3>
		</div>
		<div class="panel-body">
		
			<?php
			 if($_GET['upfile'] == "error") {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-danger">C'e' stato un errore nel caricamento del file sul server: controlla la dimensione massima, riprova in seguito o contatta l'amministratore del server.</div>
				</div>
			</div>
			<?php
			}
			?>
			
			<?php
			 if($_GET['upfile'] == "success") {
			?>
			<div class="row">
				<div class="col-xs-12">
					<div class="alert alert-success">File allegato correttamente!</div>
				</div>
			</div>
			<?php
			}
			?>
			
			<div class="form-group">
			<form role="form" enctype="multipart/form-data" action="login0.php?corpus=prot-modifica-file&idlettera=<?php echo $idlettera;?>" method="POST">
			<table>
			<tr>
			<td>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />			
			<label for="exampleInputFile">Carica allegato</label>
			<input name="uploadedfile" type="file" id="exampleInputFile">
			</td>
			<td>
			<button type="submit" class="btn btn-default" onClick="Change()">Allega</button>
			</td>
			</tr>
			</table>
			</form>
			
			<?php
			$cercadocumento= mysql_query("select distinct * from lettere$annoprotocollo where idlettera='$idlettera'");
			$urlpdf1= mysql_fetch_array($cercadocumento);
			$urlpdf=$urlpdf1['urlpdf'];
			$my_file -> publdownloadlink ($urlpdf, $idlettera, $annoprotocollo); //richiamo del metodo "downloadlink" dell'oggetto file
			?>
			<div class="row">
			<div class ="col-xs-5" id="content" style="display: none;">
			<br>
			<b>Caricamento in corso...</b>
			<img src="images/progress.gif">
			</div>
			</div>
			
			<br>
			
			<?php
				$my_lettera -> publcercamittente ($idlettera,''); //richiamo del metodo
			?>
			
			<?php
			$risultati=mysql_query("select anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, joinletteremittenti$annoprotocollo.idlettera, joinletteremittenti$annoprotocollo.idanagrafica from anagrafica, joinletteremittenti$annoprotocollo where anagrafica.idanagrafica = joinletteremittenti$annoprotocollo.idanagrafica and joinletteremittenti$annoprotocollo.idlettera='$idlettera'");
			if ($row = mysql_fetch_array($risultati)) {
			echo '<b>Mittenti/Destinatari:<br></b>';
			$risultati2=mysql_query("select anagrafica.idanagrafica, anagrafica.cognome, anagrafica.nome, joinletteremittenti$annoprotocollo.idlettera, joinletteremittenti$annoprotocollo.idanagrafica from anagrafica, joinletteremittenti$annoprotocollo where anagrafica.idanagrafica = joinletteremittenti$annoprotocollo.idanagrafica and joinletteremittenti$annoprotocollo.idlettera='$idlettera'");
			while ($row2 = mysql_fetch_array($risultati2)) {
			echo $row2['cognome'] . '  -  ' . $row2['nome'] ;?> <a href="login0.php?corpus=protocollo2&from=elimina-mittente&idlettera=<?php echo $idlettera;?>&idanagrafica=<?php echo $row2['idanagrafica'];?>&urlpdf=<?php echo $urlpdf;?>">elimina</a><br><?php
			}
			echo '<br>';
			}
			?>

			<form name="modulo" method="post" >
			
			<div class="form-group">
				<label>Spedita/Ricevuta</label>
				<div class="row">
					<div class="col-xs-2">
						<select class="form-control" size="1" cols=4 type="text" name="spedita-ricevuta" />
						<OPTION value="ricevuta"> Ricevuta
						<OPTION value="spedita"> Spedita
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Oggetto della lettera:</label>
				<div class="row">
					<div class="col-xs-5">
						<input type="text" class="form-control" name="oggetto">
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Data della lettera:</label>
				<div class="row">
					<div class="col-xs-2">
						<input type="text" class="form-control datepicker" name="data">
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Mezzo di trasmissione:</label>
				<div class="row">
					<div class="col-xs-2">
						<select class="form-control" size=1 cols=4 NAME="posizione">
						<OPTION selected value="">
						<OPTION value="posta ordinaria"> posta ordinaria
						<OPTION value="raccomandata"> raccomandata
						<OPTION Value="telegramma"> telegramma
						<OPTION value="fax"> fax
						<OPTION value="email"> email
						<OPTION value="consegna a mano"> consegna a mano
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
				<div class="col-xs-3">
				<label>Titolazione:</label>
				<?php
				$risultati=mysql_query("select distinct * from titolario");
				?>
				<select class="form-control" size=1 cols=4 NAME="riferimento">
				<option value="">nessuna titolazione
				<?php
				while ($risultati2=mysql_fetch_array($risultati))
				{
					echo '<option value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
				}
				echo '</select>';
				?>
				</div>
				</div>
			</div>
			
			<div class="form-group">
				<label>Note:</label>
				<div class="row">
					<div class="col-xs-5">
						<input type="text" class="form-control" name="note">
					</div>
				</div>
			</div>
			
			<button type="button" class="btn btn-default" onClick="Controllo()">Registra</button>

			</form>

		</div>
	</div>	
</div>

<script language="javascript">

 <!--
  function Change() 

  {
	  document.getElementById("content").style.display="table";	
  }

 //-->

</script> 

<script language="javascript">
 <!--
  function Controllo() 
  {
	//acquisisco il valore delle variabili
	var oggetto = document.modulo.oggetto.value;

    
	//controllo coerenza dati
	
	if ((oggetto == "") || (oggetto == "undefined")) 
	{
           alert("Il campo OGGETTO e' obbligatorio");
           document.modulo.oggetto.focus();
           return false;
      }
	
	//mando i dati alla pagina
	else 
	{
           document.modulo.action = "login0.php?corpus=protocollo3&urlpdf=<?php echo $urlpdf;?>&idlettera=<?php echo $idlettera;?>";
           document.modulo.submit();
      }
  }
 //-->
</script> 
