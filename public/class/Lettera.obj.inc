<?php 
class Lettera {
	private $mittentidestinatari='';
	private $speditaricevuta='';
	private $oggetto='';
	private $datalettera='';
	private $posizione='';
	private $riferimento='';
	private $note='';
	private $loginname='';
	private $annoricercaprotocollo='';
	private $arraylettera=array();
	private $urlfile=array();
	private $arraylettera1=array();
	private $arrayletteramittenti=array();
	private $arrayinserimento1=array();
	private $arraymodifica1=array();
	public  $idtemporaneo;
	public  $arraymittenti=array();
	public  $arrayallegati=array();

	private function leggilettera ($idlettera, $annoricercaprotocollo) { //<man>legge i dati dettagliati di una lettera in protocollo, indicandone id e anno di registrazione</man>
		
		$tabella= 'lettere'.$annoricercaprotocollo;
		$joinletteremittenti= 'joinletteremittenti'.$annoricercaprotocollo;
		$joinlettereinserimento='joinlettereinserimento'.$annoricercaprotocollo;
		$risultati=mysql_query("select distinct * from $tabella where ($tabella.idlettera='$idlettera') ");
		echo mysql_error();
		$this->arraylettera = mysql_fetch_array($risultati);
		$this->arraylettera = array_map('stripslashes', $this->arraylettera);
		$letteramittenti=mysql_query("select * from $joinletteremittenti, anagrafica where $joinletteremittenti.idlettera='$idlettera' and $joinletteremittenti.idanagrafica=anagrafica.idanagrafica ");
		$risultati3=mysql_query("select * from $joinlettereinserimento, anagrafica where idlettera='$idlettera' and $joinlettereinserimento.idinser=anagrafica.idanagrafica");
		echo mysql_error();
		$arrayinserimento = mysql_fetch_array($risultati3);
		$risultati4=mysql_query("select * from $joinlettereinserimento, anagrafica where idlettera='$idlettera' and $joinlettereinserimento.idmod=anagrafica.idanagrafica");
		echo mysql_error();
		$arraymodifica = mysql_fetch_array($risultati4);
		$this->arraylettera1 = $this->arraylettera;
		$this->arrayletteramittenti = $letteramittenti;
		$this->arrayinserimento1 = $arrayinserimento;
		$this->arraymodifica1 = $arraymodifica;
	}
	
	public function getDettagli( $id, $anno) {
		$this -> leggilettera ($id, $anno); 
		return $this->arraylettera1;
	}
	
	public function getMittenti( $id, $anno) {
		$this -> leggilettera ($id, $anno); 
		$arraymitt = array();
		while ($mitt = mysql_fetch_array($this->arrayletteramittenti)) {
			array_push($arraymitt, $mitt);
		}
		return $arraymitt;
	}
	
	public function getIns( $id, $anno) {
		$this -> leggilettera ($id, $anno); 
		return $this->arrayinserimento1;
	}
	
	public function getLastMod( $id, $anno) {
		$this -> leggilettera ($id, $anno); 
		return $this->arraymodifica1;
	}
	
	public function getDescPratica ($idpratica) {
		$desc=mysql_query("select distinct * from pratiche WHERE id='$idpratica'");
		$descrizione=mysql_fetch_row($desc);
		return stripslashes($descrizione[1]);
	}
	
	public function getPratiche() {
		$query = mysql_query("SELECT id FROM pratiche");
		$pratiche = array();
		while ($prat = mysql_fetch_array($query)) {
			array_push($pratiche, $prat);
		}
		return $pratiche;
	}
	
	public function getDescPosizione ($codice) {
		$pos=mysql_query("select distinct * from titolario WHERE codice='$codice'");
		$posizione=mysql_fetch_row($pos);
		return stripslashes($posizione[2]);
	}
	
	public function getPosizioni() {
		$query = mysql_query("SELECT codice FROM titolario");
		$posizioni = array();
		while ($pos = mysql_fetch_array($query)) {
			array_push($posizioni, $pos);
		}
		return $posizioni;
	}
	
	public function getMailSend($id, $anno) {
		$arraysend = array();
		$email=mysql_query("select * from mailsend, anagrafica WHERE mailsend.idlettera = '$id' AND mailsend.annolettera = '$anno' AND mailsend.user = anagrafica.idanagrafica");
		while ($send = mysql_fetch_array($email)) {
			array_push($arraysend, $send);
		}
		return $arraysend;
	}

	public function contaMittenti($id, $anno) {
		$query=mysql_query("SELECT COUNT(joinletteremittenti$anno.idanagrafica) FROM joinletteremittenti$anno WHERE joinletteremittenti$anno.idlettera = '$id'");
		$num = mysql_fetch_row($query);
		return $num[0];
	}
	
	public function contaAllegati($id, $anno) {
		$query=mysql_query("SELECT COUNT(*) FROM joinlettereallegati WHERE idlettera = '$id' AND annoprotocollo='$anno'");
		$num = mysql_fetch_row($query);
		return $num[0];
	}
	
	public function getAttributi() {
		$query = mysql_query("SELECT attributo FROM attributi");
		$attributi = array();
		while ($attr = mysql_fetch_array($query)) {
			array_push($attributi, $attr);
		}
		return $attributi;
	}

	public function publdisplaylettera ($idlettera, $annoricercaprotocollo) { //<man>Stampa i dettagli di una lettera, passando come parametri id e anno di registrazione</man>
		$this -> leggilettera ($idlettera, $annoricercaprotocollo); 
		?>
		
		Protocollo numero: 
		<strong>
			<?php 
				echo $this->arraylettera1['idlettera'];
			?>
		</strong>
      
		<br>
		File associati: <b>
		<?php
			$my_file = new File(); 		
			
			$urlfile= $this->cercaAllegati($this->arraylettera1['idlettera'], $annoricercaprotocollo);
			if ($urlfile) {
				foreach ($urlfile as $valore) {
					$download = $my_file->downloadlink($valore[2], $this->arraylettera1['idlettera'], $annoricercaprotocollo, '30'); //richiamo del metodo "downloadlink" dell'oggetto file
					echo $download.";    ";
				}
			}
			else {
				echo "Nessun file associato.";
			}
		?>
		</b>
	
		<br>
		Spedita/Ricevuta: 
		<strong>
			<?php 
				echo $this->arraylettera1['speditaricevuta'];
			?>
		</strong>

		<br>
		Oggetto: 
		<strong>
			<?php 
				echo $this->arraylettera1['oggetto'];
			?>
		</strong>
		
		<br>
		Data della lettera: 
		<strong>
			<?php 
				$datalettera = $this->arraylettera1['datalettera'];
				list($anno, $mese, $giorno) = explode("-", $datalettera);
				echo $giorno.'/'. $mese.'/'.$anno; 
			?>
		</strong>
			
		<?php if($this->arraylettera1['posizione']) { ?>
			<br>
			Mezzo di trasmissione: 
			<strong>
				<?php 
					echo $this->arraylettera1['posizione'];
				?>
			</strong> 
		<?php
		}
		
		if($this->arraylettera1['riferimento']) {
		?>
			<br>
			Posizione: 
			<strong>
				<?php 
					echo $this->arraylettera1['riferimento'];
				?>
			</strong>
		<?php
		}
		
		$idpratica = $this->arraylettera1['pratica'];
		$risultati=mysql_query("select distinct * from pratiche WHERE id='$idpratica'");
		$risultati2=mysql_fetch_row($risultati);
		if($risultati2[1]) {
		?>
			<br>
			Pratica: 
			<strong>
				<?php
					
					echo stripslashes($risultati2[1]); 
				?>
			</strong>
		<?php
		}
		
		if($this->arraylettera1['note']) {
		?>
			<br>
			Note: 
			<strong>
				<?php 
					 echo $this->arraylettera1['note'];
				?>
			</strong> 
		<?php
		}
		?>
		<br><br>
		Mittenti/Destinatari: 
		<b>
			<?php
				while ($row2 = mysql_fetch_array($this->arrayletteramittenti)) {
					$row2 = array_map('stripslashes', $row2);
					?>
					<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=<?php echo $row2['idanagrafica'];?>">
						<?php
							if($row2['nome']) {
								$nome = $row2['cognome'] . ' ' . $row2['nome'] .';';
							}
							else {
								$nome = $row2['cognome'] . ';';
							}
							echo $nome . ' ';?>
					</a>
					<?php
				}
			?>
		</b>
		
		<br><br>
		Utente che ha effettuato l'inserimento: 
		<b>
			<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=
					<?php echo $this->arrayinserimento1['idanagrafica'];?>"> 
					<?php echo $this->arrayinserimento1['nome'] . '  ' . $this->arrayinserimento1['cognome'] ;?>
			</a>
		</b>		
		
		<br> 
		Data di registrazione: 
		<strong>
			<?php 
				$dataregistrazione = $this->arraylettera1['dataregistrazione'];
				list($annor, $meser, $giornor) = explode("-", $dataregistrazione);
				echo $giornor.'/'.$meser.'/'.$annor  ; 
			?>
		</strong> 
		
		<?php 
		if ($this->arrayinserimento1['idmod'] != 0) { 
			?>
			<br><br>
			Ultima modifica effettuata da: 
			<strong>
				<?php
				$idmod= $this->arrayinserimento1['idmod'];
				$datamod = $this->arrayinserimento1['datamod'];
				list($annoultimamod, $meseultimamod, $giornoultimamod) = explode("-", $datamod);?>
				<a href="login0.php?corpus=dettagli-anagrafica&from=risultati&tabella=anagrafica&id=
						<?php echo $this->arraymodifica1['idanagrafica'];?>"> 
						<?php echo $this->arraymodifica1['nome'] . '  ' . $this->arraymodifica1['cognome'] ;?>
				</a>
			</strong>
			<br>
		
			Data dell'ultima modifica: 
			<strong>
				<?php 
					echo $giornoultimamod.'/'.$meseultimamod.'/'.$annoultimamod;
				?>
			</strong>
			<?php	
		}//chiusura if		 
	} //chiusura della funzione

	public function publcercamittente ($idlettera, $tipologia) { //<man>Elenca in ajax i risultati della ricerca in anagrafica per cercare il mittente/destinatario di una lettera, passando l'id della lettera e filtrando per tipologia</man>
		?>
		<script type="text/javascript" src="livesearch-cerca-mittente.js"></script>
		<form name="cercato" onSubmit="return false">
			<div class="form-group">
				<label> <span class="glyphicon glyphicon-search"></span> Ricerca mittente o destinatario:</label>
				<div class="row">
					<div class="col-xs-11">
						<input placeholder="digita il COGNOME o la RAGIONE SOCIALE" type="text" name="valore" class="form-control" onkeyup="showResult(this.value,'<?php echo $tipologia;?>',<?php echo $idlettera;?>)">
						<div id="livesearch"></div> <!-- spazio riservato ai risultati live della ricerca -->
					</div>
				</div>
			</div>
		</form>
		<?php 
	}//fine metodo
	
	public function modificaMittente ($idlettera, $tipologia) { //<man>Elenca in ajax i risultati della ricerca in anagrafica per cercare il mittente/destinatario di una lettera, passando l'id della lettera e filtrando per tipologia</man>
		?>
		<script type="text/javascript" src="livesearch-modifica-mittente.js"></script>
		<form name="cercato" onSubmit="return false">
			<div class="form-group">
				<label><span class="glyphicon glyphicon-search"></span> Ricerca mittente o destinatario:</label>
				<div class="row">
					<div class="col-xs-5">
						<input placeholder="digita il COGNOME o la RAGIONE SOCIALE" type="text" name="valore" class="form-control" onkeyup="showResult(this.value,'<?php echo $tipologia;?>',<?php echo $idlettera;?>)">
						<div id="livesearch"></div> <!-- spazio riservato ai risultati live della ricerca -->
					</div>
				</div>
			</div>
		</form>
		<?php 
	}//fine metodo

	public function publinseriscimittente ($idlettera, $idanagrafica, $annoprotocollo) { //<man>Inserisce in ajax i risultati della ricerca in anagrafica per  il mittente/destinatario di una lettera, passando l'id della lettera, l'id dell'anagrafica e l'anno di registrazione</man>
		$inserisci=mysql_query("insert into joinletteremittenti$annoprotocollo values('$idlettera', '$idanagrafica')");
	}//fine metodo
	

	public function cercaAllegati ($idlettera, $annoprotocollo) {//<man>ricerca i path dei file allegati alla lettera passata come parametro</man>	 
		$this->urlfile=array();
		$this->patharray = mysql_query("select 
					distinct * 
					from 
					joinlettereallegati 
					where
					idlettera=$idlettera
					and
					annoprotocollo=$annoprotocollo
					");
		while ($this->patharray2=mysql_fetch_row($this->patharray)) {
			array_push($this->urlfile, $this->patharray2);
		}
		return $this->urlfile;
	}//fine metodo
	
	public function ultimeLettere($numerolettere, $anno) {
		$res = array();
		$query = mysql_query("SELECT idlettera, dataregistrazione, oggetto, speditaricevuta FROM lettere$anno WHERE datalettera != '0000-00-00' ORDER BY idlettera desc LIMIT $numerolettere ");
		while ($risultati  = mysql_fetch_array($query)) {
			$risultati = array_map('stripslashes', $risultati);
			array_push ($res, $risultati);
		}
		return $res;
	}
	
	public function ultimoId($anno) {
		$query = mysql_query("SELECT idlettera FROM lettere$anno ORDER BY idlettera desc LIMIT 1");
		$risultati = mysql_fetch_row($query);
		return $risultati[0];
	}
	
	public function controllaEsistenzaMittente($idmittente, $arraymittenti) {
		return array_key_exists ($idmittente,$arraymittenti);
	}
	

}//chiusura della classe

?>



