<?php 

require_once('../db-connessione-include.php');

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
		global $connessione;
		$tabella = 'lettere'.$annoricercaprotocollo;
		$joinletteremittenti = 'joinletteremittenti'.$annoricercaprotocollo;
		$joinlettereinserimento ='joinlettereinserimento'.$annoricercaprotocollo;
		$risultati = $connessione->query("SELECT DISTINCT * FROM $tabella WHERE ($tabella.idlettera ='$idlettera')");
		$this->arraylettera = $risultati->fetch();
		$this->arraylettera = array_map('stripslashes', $this->arraylettera);
		$letteramittenti = $connessione->query("SELECT * FROM $joinletteremittenti, anagrafica WHERE $joinletteremittenti.idlettera='$idlettera' AND $joinletteremittenti.idanagrafica=anagrafica.idanagrafica ");
		$risultati3 = $connessione->query("SELECT * FROM $joinlettereinserimento, anagrafica WHERE idlettera='$idlettera' AND $joinlettereinserimento.idinser=anagrafica.idanagrafica");
		$arrayinserimento = $risultati3->fetch();
		$risultati4 = $connessione->query("SELECT * FROM $joinlettereinserimento, anagrafica WHERE idlettera='$idlettera' AND $joinlettereinserimento.idmod=anagrafica.idanagrafica");
		$arraymodifica = $risultati4->fetch();
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
		global $connessione;
		$this->leggilettera ($id, $anno); 
		$arraymitt = array();
		while ($mitt = $this->arrayletteramittenti->fetch()) {
			array_push($arraymitt, $mitt);
		}
		return $arraymitt;
	}
	
	public function getIns( $id, $anno) {
		$this->leggilettera ($id, $anno); 
		return $this->arrayinserimento1;
	}
	
	public function getLastMod( $id, $anno) {
		$this->leggilettera ($id, $anno); 
		return $this->arraymodifica1;
	}
	
	public function getDescPratica ($idpratica) {
		global $connessione;
		$desc = $connessione->query("SELECT DISTINCT * FROM pratiche WHERE id='$idpratica'");
		$descrizione = $desc->fetch();
		return stripslashes($descrizione[1]);
	}
	
	public function getPratiche() {
		global $connessione;
		$query = $connessione->query("SELECT id FROM pratiche");
		$pratiche = array();
		while ($prat = $query->fetch()) {
			array_push($pratiche, $prat);
		}
		array_map('stripslashes', $pratiche);
		return $pratiche;
	}
	
	public function getDescPosizione ($codice) {
		global $connessione;
		$pos = $connessione->query("SELECT DISTINCT * FROM titolario WHERE codice='$codice'");
		$posizione = $pos->fetch();
		return stripslashes($posizione[2]);
	}
	
	public function getPosizioni() {
		global $connessione;
		$query = $connessione->query("SELECT codice FROM titolario");
		$posizioni = array();
		while ($pos = $query->fetch()) {
			array_push($posizioni, $pos);
		}
		array_map('stripslashes', $posizioni);
		return $posizioni;
	}
	
	public function getMailSend($id, $anno) {
		global $connessione;
		$arraysend = array();
		$email = $connessione->query("SELECT * FROM mailsend, anagrafica WHERE mailsend.idlettera = '$id' AND mailsend.annolettera = '$anno' AND mailsend.user = anagrafica.idanagrafica");
		while ($send = $email->fetch()) {
			array_push($arraysend, $send);
		}
		return $arraysend;
	}

	public function contaMittenti($id, $anno) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(joinletteremittenti$anno.idanagrafica) FROM joinletteremittenti$anno WHERE joinletteremittenti$anno.idlettera = '$id'");
		$num = $query->fetch();
		return $num[0];
	}
	
	public function contaAllegati($id, $anno) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(*) FROM joinlettereallegati WHERE idlettera = '$id' AND annoprotocollo='$anno'");
		$num = $query->fetch();
		return $num[0];
	}
	
	public function getAttributi() {
		global $connessione;
		$query = $connessione->query("SELECT attributo FROM attributi");
		$attributi = array();
		while ($attr = $query->fetch()) {
			array_push($attributi, $attr);
		}
		return $attributi;
	}

	public function publdisplaylettera ($idlettera, $annoricercaprotocollo) { //<man>Stampa i dettagli di una lettera, passando come parametri id e anno di registrazione</man>
		global $connessione;
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
					echo $download;
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
				echo stripslashes($this->arraylettera1['oggetto']);
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
		$risultati = $connessione->query("SELECT DISTINCT * FROM pratiche WHERE id='$idpratica'");
		$risultati2 = $risultati->fetch();
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
					 echo stripslashes($this->arraylettera1['note']);
				?>
			</strong> 
		<?php
		}
		?>
		<br><br>
		Mittenti/Destinatari: 
		<b>
			<?php
				while ($row2 = $this->arrayletteramittenti->fetch()) {
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
				<small>per una ricerca esatta utilizzare cognome*nome;</small>
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
					<div class="col-xs-11">
						<input placeholder="digita il COGNOME o la RAGIONE SOCIALE" type="text" name="valore" class="form-control" onkeyup="showResult(this.value,'<?php echo $tipologia;?>',<?php echo $idlettera;?>)">
						<div id="livesearch"></div> <!-- spazio riservato ai risultati live della ricerca -->
					</div>
				</div>
			</div>
		</form>
		<?php 
	}//fine metodo

	public function publinseriscimittente ($idlettera, $idanagrafica, $annoprotocollo) { //<man>Inserisce in ajax i risultati della ricerca in anagrafica per  il mittente/destinatario di una lettera, passando l'id della lettera, l'id dell'anagrafica e l'anno di registrazione</man>
		global $connessione;
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT into joinletteremittenti$annoprotocollo values(:idlettera, :idanagrafica)"); 
			$query->bindParam(':idlettera', $idlettera);
			$query->bindParam(':idanagrafica', $idanagrafica);
			$query->execute();
			$connessione->commit();
			$q = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q = false;
		}
	}//fine metodo
	

	public function cercaAllegati ($idlettera, $annoprotocollo) {//<man>ricerca i path dei file allegati alla lettera passata come parametro</man>	 
		global $connessione;
		$this->urlfile=array();
		$this->patharray = $connessione->query("SELECT DISTINCT * 
					FROM
					joinlettereallegati 
					WHERE
					idlettera=$idlettera
					AND
					annoprotocollo=$annoprotocollo
					");
		while ($this->patharray2 = $this->patharray->fetch()) {
			array_push($this->urlfile, $this->patharray2);
		}
		return $this->urlfile;
	}//fine metodo
	
	public function ultimeLettere($numerolettere, $anno) {
		global $connessione;
		$res = array();
		$query = $connessione->query("SELECT idlettera, dataregistrazione, oggetto, speditaricevuta FROM lettere$anno WHERE datalettera != '0000-00-00' ORDER BY idlettera desc LIMIT $numerolettere ");
		while ($risultati  = $query->fetch()) {
			$risultati = array_map('stripslashes', $risultati);
			array_push ($res, $risultati);
		}
		return $res;
	}
	
	public function ultimoId($anno) {
		global $connessione;
		$query = $connessione->query("SELECT idlettera FROM lettere$anno ORDER BY idlettera desc LIMIT 1");
		$risultati = $query->fetch();
		return $risultati[0];
	}

	public function isSpedita($id, $anno) {
		global $connessione;
		$query = $connessione->query("SELECT speditaricevuta FROM lettere$anno WHERE idlettera='$id' ");
		$risultati = $query->fetch();
		if($risultati[0] == 'spedita') {
			return true;
		}
		else {
			return false;
		}
	}

	public function destinatariOk($id) {
		global $connessione;
		$query = $connessione->query("SELECT COUNT(id) FROM comp_destinatari WHERE idlettera='$id' ");
		$risultati = $query->fetch();
		if($risultati[0] > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function duplicaLettera($id) {
		global $connessione;
		$idins = $_SESSION['loginid'];
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO comp_lettera (protocollo, anno, data, oggetto, testo, allegati, vista, firmata, idins, ufficio) SELECT 0, 0, data, oggetto, testo, allegati, 0, 0, :idins, ufficio FROM comp_lettera WHERE id = :id"); 
			$query->bindParam(':idins', $idins);
			$query->bindParam(':id', $id);
			$query->execute();
			$idlettera = $connessione->lastInsertId();
			$connessione->commit();
			$q1 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q1 = false;
		}
		
		try {
   			$connessione->beginTransaction();
			$query = $connessione->prepare("INSERT INTO comp_destinatari (idlettera, idanagrafica, conoscenza, attributo, riga1, riga2) SELECT :idlettera, idanagrafica, conoscenza, attributo, riga1, riga2 FROM comp_destinatari WHERE idlettera = :id"); 
			$query->bindParam(':idlettera', $idlettera);
			$query->bindParam(':id', $id);
			$query->execute();
			$connessione->commit();
			$q2 = true;
		}	 
		catch (PDOException $errorePDO) { 
    		echo "Errore: " . $errorePDO->getMessage();
    		$connessione->rollBack();
    		$q2 = false;
		}
		if($q1 && $q2) {
			return true;
		}
		else {
			return false;
		}
	}

	public function getUffici() {
		global $connessione;
		$query = $connessione->query("SELECT id FROM uffici");
		$uffici = array();
		while ($uff = $query->fetch()) {
			array_push($uffici, $uff);
		}
		return $uffici;
	}

	public function getDescUfficio ($idufficio) {
		global $connessione;
		$desc = $connessione->query("SELECT DISTINCT * FROM uffici WHERE id='$idufficio'");
		$descrizione = $desc->fetch();
		return stripslashes($descrizione[1]);
	}
	
	public function controllaEsistenzaMittente($idmittente, $arraymittenti) {
		global $connessione;
		return array_key_exists ($idmittente,$arraymittenti);
	}

}//chiusura della classe

?>