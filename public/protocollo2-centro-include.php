<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$from= $_GET['from'];
	$add = false;
	$my_anagrafica= new Anagrafica();//crea un nuovo oggetto anagrafica
	
	/*if (isset($_session['dbname'])) { 
		$dbname=$_session['dbname']; 
	}*/
	
	if (isset($_GET['idanagrafica'])) { 
		$idanagrafica=$_GET['idanagrafica']; 
	}
	
	if($from == "errore") {
		$errore = true;
	}
	else {
		$errore = false;
	}
	
	//se la pagina da cui si proviene è crea nuovo protocollo
	if ($from == 'crea') {  
				$my_file = new File(); //crea un nuovo oggetto 'file'
				$my_lettera = new Lettera(); //crea un nuovo oggetto
				$my_lettera->idtemporaneo=$_SESSION['loginid'].'-'.time();//crea un id temporaneo per la lettera unendo id utente
											// e timestamp
				$idlettera=$my_lettera->idtemporaneo;
				$doc = false;

	
	}
	
	else {	//se non si proviene da 'crea', si deserializzano gli oggetti già creati
		$my_lettera=unserialize($_SESSION['my_lettera']);
		if (isset($_SESSION['my_file'])) {
			$my_file=unserialize($_SESSION['my_file']); //deserializza l'oggetto solo se è presente in sessione
		}
		else {
			$my_file = new File();
		}
		$idlettera=$my_lettera->idtemporaneo;
		$doc = false;
		if (count($my_lettera->arrayallegati)> 0) {
			foreach ($my_lettera->arrayallegati as $elencochiavi => $elencoallegati ) {
				if( ($my_file->estensioneFile($elencoallegati) == 'doc') || ($my_file->estensioneFile($elencoallegati) == 'docx') || ($my_file->estensioneFile($elencoallegati) == 'odt')  ) {
					$doc = true;
				}
			}
		}
		
	}

	if ($from == 'aggiungi') {
			
		if ($my_lettera->controllaEsistenzaMittente($idlettera, $my_lettera->arraymittenti)==false) {
			$my_lettera->arraymittenti[$idanagrafica]=$my_anagrafica->getName($idanagrafica);
		}
		else { 
			echo 'Mittente o Destinatario già inserito'; 
		}
		$add = true;
			/*$my_log -> publscrivilog( $_SESSION['loginname'], 
						'AGGIUNTO MITTENTE PROTOCOLLO '
						.$idlettera , 
						'OK' , 
						'ID MITTENTE AGGIUNTO '
						. $idanagrafica, 
						$_SESSION['historylog']);*/
	}

	if ($from == 'elimina-mittente') {
	
		unset($my_lettera->arraymittenti[$idanagrafica]);
		
		/*$elimina=mysql_query("delete from joinletteremittenti$annoprotocollo where idanagrafica='$idanagrafica' and idlettera='$idlettera'");
	
		$my_log -> publscrivilog( $_SESSION['loginname'], 
					'ELIMINATO MITTENTE PROTOCOLLO '
					.$idlettera , 
					'OK' , 
					'ID MITTENTE ELIMINATO '
					.$idanagrafica, 
					$_SESSION['historylog']);*/
	}
	
	if ($from == 'urlpdf') {  
		/*$idlettera=$_GET['idlettera'];*/
		
	}
	
	if ($from == 'eliminaallegato') {  
		$nome = $_GET['nome'];
		unset($my_lettera->arrayallegati[$nome]);
		unlink("lettere$annoprotocollo/temp/" . $nome);
		$doc = false;
		if (count($my_lettera->arrayallegati)> 0) {
			foreach ($my_lettera->arrayallegati as $elencochiavi => $elencoallegati ) {
				if( ($my_file->estensioneFile($elencoallegati) == 'doc') || ($my_file->estensioneFile($elencoallegati) == 'docx') || ($my_file->estensioneFile($elencoallegati) == 'odt')  ) {
					$doc = true;
				}
			}
		}
		/*
		$idlettera=$_GET['idlettera'];
		$anno = $_GET['anno'];
		$delete = $my_file->cancellaAllegato($idlettera, $anno, $nome);
				if (!$delete) {
					echo "Si è verificato un problema con la cancellazione di un allegato.";
				}
		$deletequery=mysql_query("DELETE FROM joinlettereallegati WHERE idlettera=$idlettera AND annoprotocollo=$annoprotocollo AND pathfile='$nome'");
		$my_log -> publscrivilog( $_SESSION['loginname'], 'ELIMINATO ALLEGATO PROTOCOLLO '.$idlettera , 'OK' , 'ALLEGATO ELIMINATO '. $nome, $_SESSION['historylog']);
		*/
	}

?>

<!-- Modal -->
	<form action="?corpus=inserimento.rapido.anagrafica&idlettera=<?php echo $idlettera; ?>" method="POST" name="modale">
		<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Inserimento rapido in anagrafica</h4>
					</div>
	      
					<div class="modal-body">
						<div class="form-group">
							<label>Tipologia:</label>
							<div class="row">
								<div class="col-sm-5">
									<select class="form-control input-sm" name="anagraficatipologia" onChange="changeSelect()">
									<OPTION value="persona"> Persona Fisica</OPTION>
									<OPTION value="carica"> Carica Elettiva o Incarico</OPTION>
									<OPTION Value="ente"> Ente</OPTION>
									<OPTION Value="fornitore"> Fornitore</OPTION>
									</select>
								</div>
							</div>
							<br>
							<label id="lblcognome">Cognome:</label>
							<label id="lblden" style="display: none;">Denominazione:</label>
							<div class="row">
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" name="cognome" required>
								</div>
							</div>
							<br>
							<label id="lblnome">Nome:</label>
							<div class="row">
								<div class="col-sm-8">
									<input id="txtnome" type="text" class="form-control input-sm" name="nome" required>
								</div>
							</div>
						</div>
					</div>
			
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Chiudi</button>
						<button type="submit" class="btn btn-success"><i class="fa fa-arrow-down"></i> Salva ed associa al protocollo</button>
					</div>
				</div>
			</div>
		</div>
	</form>
<!--End Modal-->

<div class="<?php if($errore) { echo "panel panel-danger";} else { echo "panel panel-default";} ?>">
	
		<div class="panel-heading">
			<h3 class="panel-title">
				<i class="fa fa-warning"></i> Il numero di protocollo verrà assegnato dopo aver concluso l'inserimento dei dati. 
				<i class="fa fa-info-circle"></i> Identificativo Provvisorio Protocollo: <strong><?php echo $my_lettera->idtemporaneo;?></strong>
				<?php if($errore) { 
					echo " - <b><i class=\"fa fa-warning\"></i> ATTENZIONE:</b> Bisogna inserire almeno un mittente o un destinatario.";
				} ?>
			</h3>
		</div>
		
		<div class="panel-body">
			
			<?php
			if( isset($_GET['insert']) && $_GET['insert'] == "error") {
				?>
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-danger"><b><i class="fa fa-warning"></i> Attenzione:</b> c'è stato un errore nell'associare la nuova anagrafica.</div>
					</div>
				</div>
				<?php
			}
			?>
		
			<?php
			if( isset($_GET['upfile']) && $_GET['upfile'] == "error") {
				?>
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-danger"><b><i class="fa fa-warning"></i> Attenzione:</b>
												 c'e' stato un errore nel caricamento
												  del file sul server: controlla 
												  la dimensione massima, riprova in seguito 
												  o contatta l'amministratore del server.
						</div>
					</div>
				</div>
				<?php
			}
			
			if($doc) {
				?>
				<div class="alert alert-info"><b><i class="fa fa-warning"></i> ATTENZIONE:</b> hai allegato un file <b>modificabile</b>. E' consigliato allegare file in PDF.</div>
				<?php
			}
			
			 if( isset($_GET['upfile']) && $_GET['upfile'] == "success") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-success"><i class="fa fa-check"></i> File allegato <b>correttamente!</b></div>
				</div>
			</div>
			<?php
			}
			?>
			
		<div class="row">
			<div class="col-sm-6">
				<h3><b><small><i class="fa fa-square-o"></i></small> Primo Step: <small>allegati <i class="fa fa-folder-open-o"></i> e mittenti/destinatari <i class="fa fa-group"></i> </b></small></h3>
				<hr>
					<div class="form-group"> 
						<!--form caricamento allegati-->
						<form id="uploadForm" role="form" enctype="multipart/form-data" action="login0.php?corpus=prot-modifica-file" method="POST">
							<div class="row">
								<div class="col-sm-11">
									<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $_SESSION['protocollomaxfilesize'];?>" />			
									<label for="exampleInputFile"> <i class="fa fa-upload"></i> Carica allegati:</label>
									<input required id="uploadedfile" name="uploadedfile[]" type="file" multiple="multiple" class="filestyle" data-buttonBefore="true" data-placeholder="nessun file selezionato.">
									<br>
									<button id="btn" onclick="uploadFile(); showbar();" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Caricamento in corso..." type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-paperclip"></span> Allega File </button>
									<br><br><progress id="progressBar" value="0" max="100" style="width:100%; height:25px; display:none;"></progress>
									<h3 id="status"></h3>
									<p id="loaded_n_total"></p>
								</div>
							</div>
						</form>
					</div>
					
					<?php
					if (count($my_lettera->arrayallegati)> 0) {
						?>
						<i class="fa fa-folder-o"></i> <b>File associati:</b>
						<table class="table table-condensed">
						<?php
						foreach ($my_lettera->arrayallegati as $elencochiavi => $elencoallegati ) {
							?>
							<tr>
								<td>
									<?php echo $my_file->getIcon($my_file->estensioneFile($elencochiavi)); ?>
								</td>
								<td style="vertical-align: middle">
									<?php echo $elencochiavi.' '; ?>
								</td>
								<td>
									<a class="fancybox btn btn-info" data-fancybox-type="iframe" href="<?php echo 'lettere'.$annoprotocollo.'/temp/'.$elencochiavi;?>"><i class="fa fa-file-o fa-fw"></i></a>
									<a class="btn btn-danger" href="login0.php?corpus=protocollo2&from=eliminaallegato&nome=<?php echo $elencochiavi;?>"><i class="fa fa-trash fa-fw"></i></a>
								</td>
							</tr>	
							<?php
						}
						?>
						</table>
						<?php
					}
					else {
						echo "Nessun file associato.";
					}
					?>
					
					<div class="row">
						<div class ="col-sm-12" id="content" style="display: none;">
							<br>
							<i class="fa fa-spinner fa-spin"></i><b> Caricamento allegato in corso...</b>
							<br><img src="images/progress.gif">
						</div>
					</div>
					
					<hr>
					<?php
					
					if($errore) { echo "<div class=\"alert alert-danger\">"; }
					$my_lettera->publcercamittente($idlettera,''); //richiamo del metodo
					if($errore) { echo "</div>"; }

					if (count($my_lettera->arraymittenti)> 0) {
						echo "<br><b><i class=\"fa fa-users\"></i> Mittenti/Destinatari attuali: </b>";
						?>
						<table class="table table-condensed">
							<?php
							foreach ($my_lettera->arraymittenti as $elencochiavi => $elencomittenti ) {
								?>
								<tr>
									<td style="vertical-align: middle" width="12%">
										<img src="<?php echo $my_anagrafica->getFoto($elencochiavi); ?>" class="img-circle img-responsive">
									</td>
									<td style="vertical-align: middle">
										<?php echo stripslashes($elencomittenti).' '; ?>
									</td>
									<td style="vertical-align: middle">
										<a href="anagrafica-mini.php?id=<?php echo $elencochiavi ?>" class="fancybox btn btn-info" data-fancybox-type="iframe">
											<i class="fa fa-info fa-fw"></i>
										</a>
										<a class="btn btn-danger" href="login0.php?corpus=protocollo2&from=elimina-mittente&idanagrafica=<?php echo $elencochiavi;?>"><i class="fa fa-trash fa-fw"></i></a>
									</td>
								</tr>
							<?php
							}
						?>	
						</table>
						<?php
					}
					else {
						echo 'Nessun mittente/destinatario associato.<br>';
					}
					echo '<br>';
					?>
				</div>

				<div class="col-sm-6">
					<h3><b><small><i class="fa fa-square-o"></i></small> Secondo Step: <small>dettagli della lettera <i class="fa fa-file-text-o"></i></b></small></h3>
					<hr>
					<form name="modulo" method="post" >
					
						<div class="form-group">
							<label> <span class="glyphicon glyphicon-sort"></span> Spedita/Ricevuta</label>
							<div class="row">
								<div class="col-sm-11">
									<select class="form-control" size="1" cols=4 type="text" name="spedita-ricevuta" />
										<option value="ricevuta" <?php if( ($errore || $add) && isset($_SESSION['spedita-ricevuta']) && $_SESSION['spedita-ricevuta'] == "ricevuta") {echo "selected";} ?>> Ricevuta</option>
										<option value="spedita" <?php if( ($errore || $add) && isset($_SESSION['spedita-ricevuta']) && $_SESSION['spedita-ricevuta'] == "spedita") {echo "selected";} ?>> Spedita</option>
									</select>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label> <span class="glyphicon glyphicon-asterisk"></span> Oggetto della lettera:</label>
							<div class="row">
								<div class="col-sm-11">
									<input required type="text" class="form-control" name="oggetto" <?php if( ($errore || $add) && isset($_SESSION['oggetto']) ) { echo "value=\"".$_SESSION['oggetto']."\"";} ?> >
								</div>
							</div>
						</div>
					
						<div class="form-group">
							<label> <span class="glyphicon glyphicon-calendar"></span> Data della lettera:</label>
							<div class="row">
								<div class="col-sm-11">
									<input type="text" class="form-control datepickerProt" name="data" <?php if( ($errore || $add) && isset($_SESSION['data']) ) { echo "value=\"".$_SESSION['data']."\"";} else { echo 'value='.date("d/m/Y"); } ?> >
								</div>
							</div>
						</div>

						<div class="form-group">
							<label> <span class="glyphicon glyphicon-briefcase"></span> Mezzo di trasmissione:</label>
							<div class="row">
								<div class="col-sm-11">
									<select class="form-control" size=1 cols=4 NAME="posizione">
										<option selected value=""></option>
										<option value="posta ordinaria" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "posta ordinaria") {echo "selected";} ?>> posta ordinaria</option>
										<option value="raccomandata"<?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "raccomandata") {echo "selected";} ?>> raccomandata</option>
										<option Value="telegramma" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "telegramma") {echo "selected";} ?>> telegramma</option>
										<option value="fax" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "fax") {echo "selected";} ?>> fax</option>
										<option value="email" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "email") {echo "selected";} ?>> email</option>
										<option value="consegna a mano" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "consegna a mano") {echo "selected";} ?>> consegna a mano</option>
										<option value="PEC" <?php if( ($errore || $add) && isset($_SESSION['posizione']) && $_SESSION['posizione'] == "PEC") {echo "selected";} ?>> PEC</option>
									</select>
								</div>
							</div>
						</div>
					
						<div class="form-group">
							<div class="row">
								<div class="col-sm-11">
									<label> <i class="fa fa-archive"></i> Titolazione:</label>
									<?php
										$risultati=mysql_query("select distinct * from titolario");
									?>
									<select class="form-control" size=1 cols=4 NAME="riferimento">
										<option value="">nessuna titolazione
										<?php
										while ($risultati2=mysql_fetch_array($risultati)) {
											$risultati2 = array_map("stripslashes",$risultati2);
											if( ($errore || $add) && isset($_SESSION['riferimento']) && $_SESSION['riferimento'] == $risultati2['codice'] ) {
												echo '<option selected value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
											}
											else {
												echo '<option value="' . $risultati2['codice'] . '">' . $risultati2['codice'] . ' - ' . $risultati2['descrizione'];
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>
					
						<div class="form-group">
							<div class="row">
								<div class="col-sm-11">
									<label> <i class="fa fa-tag"></i> Pratica:</label>
									<?php
										$risultati=mysql_query("select distinct * from pratiche");
									?>
									<select class="form-control" size=1 cols=4 NAME="pratica">
										<option value="">nessuna pratica
										<?php
										while ($risultati2=mysql_fetch_array($risultati)) {
											$risultati2 = array_map("stripslashes",$risultati2);
											if( ($errore || $add) && isset($_SESSION['pratica']) && $_SESSION['pratica'] == $risultati2['id'] ) {
												echo '<option selected value="' . $risultati2['id'] . '">' . $risultati2['descrizione'];
											}
											else {
												echo '<option value="' . $risultati2['id'] . '">' .  $risultati2['descrizione'];
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>
					
						<div class="form-group">
							<label> <span class="glyphicon glyphicon-comment"></span> Note:</label>
							<div class="row">
								<div class="col-sm-11">
									<input type="text" class="form-control" name="note" <?php if( ($errore || $add) && isset($_SESSION['note'])) { echo "value=\"".$_SESSION['note']."\"";} ?>>
								</div>
							</div>
						</div>
				
						<button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Registrazione in corso..." type="button" class="btn btn-success btn-lg" onClick="Controllo()"><span class="glyphicon glyphicon-plus-sign"></span> Registra Lettera</button>
					</form>
				</div>
		</div>
	</div>
</div>

<?php
$_SESSION['my_lettera']=serialize($my_lettera);//serializzazione per passaggio dati alla sessione
?>

<script>
	$("#buttonl").click(function() {
		var $btn = $(this);
		var oggetto = document.modulo.oggetto.value;
		if ((oggetto == "") || (oggetto == "undefined")) {
			return false;
		}
		else {
			$btn.button('loading');
		}
	});
	
	$("#buttonload").click(function() {
		var $btn = $(this);
		 if(document.getElementById("uploadedfile").value != '') {
			$btn.button('loading');
		}
	});
</script>

<script language="javascript">

 <!--
function showbar() {
	if(document.getElementById("uploadedfile").value != '') {
		document.getElementById("progressBar").style.display="block";
	}
}

 function changeSelect() {
	var type = document.modale.anagraficatipologia.options[document.modale.anagraficatipologia.selectedIndex].value;
	if (type == "persona") {
		document.getElementById("lblcognome").style.display="table";
		document.getElementById("lblden").style.display="none";
		document.getElementById("txtnome").style.display="table";
		document.getElementById("txtnome").required = true;
		document.getElementById("lblnome").style.display="table";
	}
	if (type == "carica") {
		document.getElementById("lblcognome").style.display="none";
		document.getElementById("lblnome").style.display="none";
		document.getElementById("lblden").style.display="table";	
		document.getElementById("txtnome").style.display="none";
		document.getElementById("txtnome").required = false;
	}
	if (type == "ente") {
		document.getElementById("lblcognome").style.display="none";
		document.getElementById("lblnome").style.display="none";
		document.getElementById("lblden").style.display="table";
		document.getElementById("txtnome").style.display="none";
		document.getElementById("txtnome").required = false;
	}
	if (type == "fornitore") {
		document.getElementById("lblcognome").style.display="none";
		document.getElementById("lblnome").style.display="none";
		document.getElementById("lblden").style.display="table";
		document.getElementById("txtnome").style.display="none";
		document.getElementById("txtnome").required = false;
	}
 }
  function loading() 

  {
	 if(document.getElementById("exampleInputFile").value != '') {
		document.getElementById("content").style.display="table";
	}		
  }

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
           document.modulo.action = "login0.php?corpus=protocollo3";
           document.modulo.submit();
      }
  }
 //-->
</script> 