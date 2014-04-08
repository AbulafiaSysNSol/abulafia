<?php 
class Lettera
	{
	private $mittentidestinatari='';
	private $speditaricevuta='';
	private $urlpdf='';
	private $oggetto='';
	private $datalettera='';
	private $posizione='';
	private $riferimento='';
	private $note='';
	private $loginname='';
	private $annoricercaprotocollo='';
	private $arraylettera;

	private function leggilettera ($idlettera, $annoricercaprotocollo)//<man>legge i dati dettagliati di una lettera in protocollo, indicandone id e anno di registrazione</man>
		{
		$tabella= 'lettere'.$annoricercaprotocollo;
		$joinletteremittenti= 'joinletteremittenti'.$annoricercaprotocollo;
		$joinlettereinserimento='joinlettereinserimento'.$annoricercaprotocollo;
		$risultati=mysql_query("select distinct * from $tabella where ($tabella.idlettera='$idlettera') ");
		echo mysql_error();
		$arraylettera = mysql_fetch_array($risultati);
		$letteramittenti=mysql_query("select * from $joinletteremittenti, anagrafica where $joinletteremittenti.idlettera='$idlettera' and $joinletteremittenti.idanagrafica=anagrafica.idanagrafica ");
		$risultati3=mysql_query("select * from $joinlettereinserimento, anagrafica where idlettera='$idlettera' and $joinlettereinserimento.idinser=anagrafica.idanagrafica");
		echo mysql_error();
		$arrayinserimento = mysql_fetch_array($risultati3);

		$risultati4=mysql_query("select * from $joinlettereinserimento, anagrafica where idlettera='$idlettera' and $joinlettereinserimento.idmod=anagrafica.idanagrafica");
echo mysql_error();
		$arraymodifica = mysql_fetch_array($risultati4);
		

		$this->arraylettera1 = $arraylettera;
		$this->arrayletteramittenti = $letteramittenti;
		$this->arrayinserimento1 = $arrayinserimento;
		$this->arraymodifica1 = $arraymodifica;
		}




		function publdisplaylettera ($idlettera, $annoricercaprotocollo)//<man>Stampa i dettagli di una lettera, passando come parametri id e anno di registrazione</man>
			{

			$this -> leggilettera ($idlettera, $annoricercaprotocollo); 
        ?>
			
        Protocollo numero: <strong><?php 
        echo $this->arraylettera1['idlettera'];
        ?></strong>
      
        <br>File associato: <b>
        <?php
        $my_file = new File (); 		
			$download = $my_file->downloadlink($this->arraylettera1['urlpdf'], $this->arraylettera1['idlettera'], $annoricercaprotocollo,'30'); //richiamo del metodo "downloadlink" dell'oggetto file
	echo stripslashes($download);
	?></b>
	
			<br>Spedita/Ricevuta: <strong><?php 
							echo $this->arraylettera1['speditaricevuta'];
							?></strong>

			<br>Oggetto: <strong> <?php 
						echo $this->arraylettera1['oggetto'];
						?></strong>

			
			<br>Data della lettera: <strong><?php 
					$datalettera = $this->arraylettera1['datalettera'];
					list($anno, $mese, $giorno) = explode("-", $datalettera);
					echo $giorno.'/'. $mese.'/'.$anno; 
				?></strong>
			
			<br>Mezzo di trasmissione: <strong><?php 
					echo $this->arraylettera1['posizione'];
					?></strong> 
          
        	<br>Fascicolazione: <strong><?php 
					echo $this->arraylettera1['riferimento'];
			?></strong>

			<br>Note: <strong><?php 
					echo $this->arraylettera1['note'];
			?></strong> <br>

			<br>Mittenti/Destinatari: <b><?php
			while ($row2 = mysql_fetch_array($this->arrayletteramittenti)) 
			{
			?><a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $row2['idanagrafica'];?>"><?
			if($row2['nome']) {
			  $nome = $row2['cognome'] . ' ' . $row2['nome'] .';';
			}
		      else {
			  $nome = $row2['cognome'] . ';';
			}
			echo $nome . ' ';?></a><?php
			}
			?>
			<br>

			
			</B><br>Utente che ha effettuato l'inserimento: <b>


		<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=
		<?php echo $this->arrayinserimento1['idanagrafica'];?>"> 
		<?php echo $this->arrayinserimento1['nome'] . '  ' . $this->arrayinserimento1['cognome'] ;?></a><br> </b>


			
			

				Data di registrazione: <strong><?php 
					$dataregistrazione = $this->arraylettera1['dataregistrazione'];
					list($annor, $meser, $giornor) = explode("-", $dataregistrazione);
					echo $giornor.'/'.$meser.'/'.$annor  ; 
				?>
			</strong> 



			<?php if ($this->arrayinserimento1['idmod'] != 0) { ?>
			<br><br>Ultima modifica effettuata da: <b><?php
			$idmod= $this->arrayinserimento1['idmod'];
			$datamod = $this->arrayinserimento1['datamod'];
			list($annoultimamod, $meseultimamod, $giornoultimamod) = explode("-", $datamod);?>

		

			<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=
				<?php echo $this->arraymodifica1['idanagrafica'];?>"> 
				<?php echo $this->arraymodifica1['nome'] . '  ' . $this->arraymodifica1['cognome'] ;?></a><br> </b>
			
			Data dell'ultima modifica: <strong><?php 
					echo $giornoultimamod.'/'.$meseultimamod.'/'.$annoultimamod  ; 
							}//chiusura if
				?></b></strong><?
			 

			 } //chiusura della funzione



	private function cercamittente ($idlettera, $tipologia)
		{
		?>
			<script type="text/javascript" src="livesearch-cerca-mittente.js"></script>
			<script language="javascript"> var id=0; </script>

			<form>
      <div class="form-group">
				<label>Ricerca mittente o destinatario:</label>
				<div class="row">
					<div class="col-xs-4">
              <input placeholder="digita il cognome o la ragione sociale" type="text" class="form-control" id="txt1" onkeyup="showResult(this.value,'<?php echo $tipologia;?>',<?php echo $idlettera;?>)" >
              <div id="livesearch"></div>
					</div>
				</div>
			</div>
			</form>

		<?php 
		}//fine metodo





	function publcercamittente ($idlettera, $tipologia) //<man>Elenca in ajax i risultati della ricerca in anagrafica per cercare il mittente/destinatario di una lettera, passando l'id della lettera e filtrando per tipologia</man>
		{
		$this->cercamittente($idlettera, $tipologia);
		}//fine metodo




	private function inseriscimittente ($idlettera, $idanagrafica, $annoprotocollo)
		{
		$inserisci=mysql_query("insert into joinletteremittenti$annoprotocollo values('$idlettera', '$idanagrafica')");
	
		}//fine metodo



	function publinseriscimittente ($idlettera, $idanagrafica, $annoprotocollo)//<man>Inserisce in ajax i risultati della ricerca in anagrafica per  il mittente/destinatario di una lettera, passando l'id della lettera, l'id dell'anagrafica e l'anno di registrazione</man>
		{
		$this->inseriscimittente($idlettera, $idanagrafica, $annoprotocollo);
		}//fine metodo





	}	//chiusura della classe
?>



