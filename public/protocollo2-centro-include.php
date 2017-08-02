<style>

#progress-bar {
	background-color: #c0c0c0;
	height:30px;
	color: #FFFFFF;
	width:0%;
	-webkit-transition: width .3s;
	-moz-transition: width .3s;
	transition: width .3s;
}

#progress-div {
	border:#808080 1px solid;
	padding: 0px 0px;
	margin:30px 0px;
	border-radius:4px;
	text-align:center;
	display:none;	
}

#targetLayer {
	width:100%;
	text-align:center;
	display:none;
}

</style>

<?php

$annoprotocollo = $_SESSION['annoprotocollo'];
$from= $_GET['from'];
$add = false;
$my_anagrafica= new Anagrafica();//crea un nuovo oggetto anagrafica
		
if (isset($_GET['idanagrafica'])) { 
	$idanagrafica=$_GET['idanagrafica']; 
}
	
if($from == "errore") {
	$errore = true;
} else {
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
} else {	//se non si proviene da 'crea', si deserializzano gli oggetti già creati
	$my_lettera=unserialize($_SESSION['my_lettera']);
	
	if (isset($_SESSION['my_file'])) {
		$my_file=unserialize($_SESSION['my_file']); 
		//deserializza l'oggetto solo se è presente in sessione
	} else {
		$my_file = new File();
	}

	$idlettera=$my_lettera->idtemporaneo;
	$doc = false;

	if (count($my_lettera->arrayallegati)> 0) {
		foreach ($my_lettera->arrayallegati as $elencochiavi => $elencoallegati ) {
			if( ($my_file->estensioneFile($elencoallegati) == 'doc') 
				|| ($my_file->estensioneFile($elencoallegati) == 'docx') 
				|| ($my_file->estensioneFile($elencoallegati) == 'odt')  ) {
				$doc = true;
				}
		}
	}
		
}

if ($from == 'aggiungi') {
	if ($my_lettera->controllaEsistenzaMittente($idlettera, $my_lettera->arraymittenti)==false) {
		$my_lettera->arraymittenti[$idanagrafica]=$my_anagrafica->getName($idanagrafica, $verificaconnessione);
	} else { 
		echo 'Mittente o Destinatario già inserito'; 
	}

	$add = true;		
}

if ($from == 'elimina-mittente') {
	unset($my_lettera->arraymittenti[$idanagrafica]);
}
	
if ($from == 'eliminaallegato') {  
	$nome = $_GET['nome'];
	unset($my_lettera->arrayallegati[$nome]);
	unlink("lettere$annoprotocollo/temp/" . $nome);
	$doc = false;

	if (count($my_lettera->arrayallegati)> 0) {
		foreach ($my_lettera->arrayallegati as $elencochiavi => $elencoallegati ) {
			
			if( ($my_file->estensioneFile($elencoallegati) == 'doc') 
				|| ($my_file->estensioneFile($elencoallegati) == 'docx') 
				|| ($my_file->estensioneFile($elencoallegati) == 'odt')  ) {
				$doc = true;
			}
		}
	}
		
}

?>

<!-- Modal -->
<form action="?corpus=inserimento.rapido.anagrafica&idlettera=<?php echo $idlettera; ?>" method="POST" name="modale">
	<div class="modal fade" id="myModal" tabindex="-1" role="form" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">
						<span class="glyphicon glyphicon-user"></span> 
						Inserimento rapido in anagrafica
					</h4>
				</div>
	      
				<div class="modal-body">
					<div class="form-group">
						<label>Tipologia:</label>
						<div class="row">
							<div class="col-sm-5">
								<select class="form-control input-sm" 	
									name="anagraficatipologia" 
									onChange="changeSelect()">
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
								<input type="text" 
									class="form-control input-sm" 
									name="cognome" required>
							</div>
						</div>
						<br>
						<label id="lblnome">Nome:</label>
						<div class="row">
							<div class="col-sm-8">
								<input id="txtnome" 
									type="text" 
									class="form-control input-sm" 
									name="nome" required>
							</div>
						</div>
					</div>
				</div>
			
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times"></i> Chiudi
					</button>
					
					<button type="submit" 
						class="btn btn-success">
						<i class="fa fa-arrow-down"></i> Salva ed associa al protocollo
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<!--End of Modal-->

<div class=" 
	<?php 
		if($errore) { 
			echo "panel panel-danger";
		} else { 
			echo "panel panel-default";
		} 
	?>
">
	
<div class="panel-heading">
	<h3 class="panel-title">
		<i class="fa fa-warning"></i> 
		Il numero di protocollo verrà assegnato dopo aver concluso l'inserimento dei dati. 
		<i class="fa fa-info-circle"></i> 
		Identificativo Provvisorio Protocollo: 
		<strong>
		<?php 
			echo $my_lettera->idtemporaneo;
		?>
		</strong>
		<?php 
			if($errore) { 
				echo " - <b><i class=\"fa fa-warning\"></i> 
					ATTENZIONE:</b> Bisogna inserire almeno un mittente o un destinatario.";
			} 
		?>
	</h3>
</div>
		
<div class="panel-body">
	<?php
		if( isset($_GET['insert']) && $_GET['insert'] == "error") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger">
						<b><i class="fa fa-warning"></i> 
						Attenzione:
						</b> c'è stato un errore nell'associare la nuova anagrafica.
					</div>
				</div>
			</div>
			<?php
		}
	
		if( isset($_GET['upfile']) && $_GET['upfile'] == "error") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-danger">
						<b><i class="fa fa-warning"></i> Attenzione:</b>
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
			<div class="alert alert-info">
				<b><i class="fa fa-warning"></i> ATTENZIONE:</b> 
				hai allegato un file <b>modificabile</b>. 
				E' consigliato allegare file in PDF.
			</div>
			<?php
		}
			
		if( isset($_GET['upfile']) && $_GET['upfile'] == "success") {
			?>
			<div class="row">
				<div class="col-sm-12">
					<div class="alert alert-success">
						<i class="fa fa-check"></i> 
						File allegato 
						<b>correttamente!</b>
					</div>
				</div>
			</div>
			<?php
		}

		?>	
		<div class="row">
			<div class="col-sm-6">
				<h3><b><small>
					<i class="fa fa-square-o"></i>
					</small> Primo Step: 
					<small>allegati <i class="fa fa-folder-open-o"></i> 
					e mittenti/destinatari 
					<i class="fa fa-group"></i> </b></small>
				</h3>
				<hr>
					<div class="form-group"> 
						<!--form caricamento allegati-->
						<form id="uploadForm" 
							role="form" 
							enctype="multipart/form-data" 
							action="login0.php?corpus=prot-modifica-file" 
							method="POST">
							
							<div class="row">
								<div class="col-sm-11">
									<input type="hidden" 
										name="MAX_FILE_SIZE" 
										value="<?php 
												echo $_SESSION['protocollomaxfilesize'];?>" />			
									<label for="exampleInputFile"> 
									<i class="fa fa-upload"></i> Carica allegati:
									</label>

									<input required id="uploadedfile" 
										name="uploadedfile[]" 
										type="file" 
										multiple="multiple" 
										class="filestyle" 
										data-buttonBefore="true" 
										data-placeholder="nessun file selezionato."
									>

									<br>

									<button id="buttonload" 
										onclick="showbar();" 
										data-loading-text="<i class='fa fa-spinner fa-spin'></i> Caricamento in corso..." 
										type="submit" 
										class="btn btn-primary">
										<span class="glyphicon glyphicon-paperclip">
										</span> 
										Allega File 
									</button>

									<div id="progress-div">
										<div id="progress-bar"></div>
									</div>

									<div id="targetLayer"></div>
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
									<?php 
										echo $my_file->getIcon($my_file->estensioneFile($elencochiavi)); 
									?>
									</td>

									<td style="vertical-align: middle">
									<?php echo $elencochiavi.' '; ?>
									</td>
							
									<td>
									<a class="fancybox btn btn-info" 
										data-fancybox-type="iframe" 
										href="<?php echo 'lettere'.$annoprotocollo.'/temp/'.$elencochiavi;?>">
										<i class="fa fa-file-o fa-fw"></i>
									</a>

									<a class="btn btn-danger" 
										href="login0.php?
											corpus=protocollo2
											&from=eliminaallegato
											&nome=<?php echo $elencochiavi;?>">
										<i class="fa fa-trash fa-fw"></i>
									</a>
									</td>
								</tr>	
								<?php
							}
							?>
							</table>
							<?php
						} else {
							echo "Nessun file associato.";
						}
							?>
					
					<div class="row">
						<div class ="col-sm-12" id="content" style="display: none;">
							
						<br>
							
						<i class="fa fa-spinner fa-spin"></i>
						<b> Caricamento allegato in corso...</b>
						<br>
						<img src="images/progress.gif">
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
										<img src="<?php echo $my_anagrafica->getFoto($elencochiavi, $verificaconnessione); ?>" class="img-circle img-responsive">
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
		document.getElementById("progress-div").style.display="block";
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

<script>
/* jquery.form.min.js */
(function(e){"use strict";if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(typeof jQuery!="undefined"?jQuery:window.Zepto)}})(function(e){"use strict";function r(t){var n=t.data;if(!t.isDefaultPrevented()){t.preventDefault();e(t.target).ajaxSubmit(n)}}function i(t){var n=t.target;var r=e(n);if(!r.is("[type=submit],[type=image]")){var i=r.closest("[type=submit]");if(i.length===0){return}n=i[0]}var s=this;s.clk=n;if(n.type=="image"){if(t.offsetX!==undefined){s.clk_x=t.offsetX;s.clk_y=t.offsetY}else if(typeof e.fn.offset=="function"){var o=r.offset();s.clk_x=t.pageX-o.left;s.clk_y=t.pageY-o.top}else{s.clk_x=t.pageX-n.offsetLeft;s.clk_y=t.pageY-n.offsetTop}}setTimeout(function(){s.clk=s.clk_x=s.clk_y=null},100)}function s(){if(!e.fn.ajaxSubmit.debug){return}var t="[jquery.form] "+Array.prototype.join.call(arguments,"");if(window.console&&window.console.log){window.console.log(t)}else if(window.opera&&window.opera.postError){window.opera.postError(t)}}var t={};t.fileapi=e("<input type='file'/>").get(0).files!==undefined;t.formdata=window.FormData!==undefined;var n=!!e.fn.prop;e.fn.attr2=function(){if(!n){return this.attr.apply(this,arguments)}var e=this.prop.apply(this,arguments);if(e&&e.jquery||typeof e==="string"){return e}return this.attr.apply(this,arguments)};e.fn.ajaxSubmit=function(r){function k(t){var n=e.param(t,r.traditional).split("&");var i=n.length;var s=[];var o,u;for(o=0;o<i;o++){n[o]=n[o].replace(/\+/g," ");u=n[o].split("=");s.push([decodeURIComponent(u[0]),decodeURIComponent(u[1])])}return s}function L(t){var n=new FormData;for(var s=0;s<t.length;s++){n.append(t[s].name,t[s].value)}if(r.extraData){var o=k(r.extraData);for(s=0;s<o.length;s++){if(o[s]){n.append(o[s][0],o[s][1])}}}r.data=null;var u=e.extend(true,{},e.ajaxSettings,r,{contentType:false,processData:false,cache:false,type:i||"POST"});if(r.uploadProgress){u.xhr=function(){var t=e.ajaxSettings.xhr();if(t.upload){t.upload.addEventListener("progress",function(e){var t=0;var n=e.loaded||e.position;var i=e.total;if(e.lengthComputable){t=Math.ceil(n/i*100)}r.uploadProgress(e,n,i,t)},false)}return t}}u.data=null;var a=u.beforeSend;u.beforeSend=function(e,t){if(r.formData){t.data=r.formData}else{t.data=n}if(a){a.call(this,e,t)}};return e.ajax(u)}function A(t){function T(e){var t=null;try{if(e.contentWindow){t=e.contentWindow.document}}catch(n){s("cannot get iframe.contentWindow document: "+n)}if(t){return t}try{t=e.contentDocument?e.contentDocument:e.document}catch(n){s("cannot get iframe.contentDocument: "+n);t=e.document}return t}function k(){function f(){try{var e=T(v).readyState;s("state = "+e);if(e&&e.toLowerCase()=="uninitialized"){setTimeout(f,50)}}catch(t){s("Server abort: ",t," (",t.name,")");_(x);if(w){clearTimeout(w)}w=undefined}}var t=a.attr2("target"),n=a.attr2("action"),r="multipart/form-data",u=a.attr("enctype")||a.attr("encoding")||r;o.setAttribute("target",p);if(!i||/post/i.test(i)){o.setAttribute("method","POST")}if(n!=l.url){o.setAttribute("action",l.url)}if(!l.skipEncodingOverride&&(!i||/post/i.test(i))){a.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"})}if(l.timeout){w=setTimeout(function(){b=true;_(S)},l.timeout)}var c=[];try{if(l.extraData){for(var h in l.extraData){if(l.extraData.hasOwnProperty(h)){if(e.isPlainObject(l.extraData[h])&&l.extraData[h].hasOwnProperty("name")&&l.extraData[h].hasOwnProperty("value")){c.push(e('<input type="hidden" name="'+l.extraData[h].name+'">').val(l.extraData[h].value).appendTo(o)[0])}else{c.push(e('<input type="hidden" name="'+h+'">').val(l.extraData[h]).appendTo(o)[0])}}}}if(!l.iframeTarget){d.appendTo("body")}if(v.attachEvent){v.attachEvent("onload",_)}else{v.addEventListener("load",_,false)}setTimeout(f,15);try{o.submit()}catch(m){var g=document.createElement("form").submit;g.apply(o)}}finally{o.setAttribute("action",n);o.setAttribute("enctype",u);if(t){o.setAttribute("target",t)}else{a.removeAttr("target")}e(c).remove()}}function _(t){if(m.aborted||M){return}A=T(v);if(!A){s("cannot access response document");t=x}if(t===S&&m){m.abort("timeout");E.reject(m,"timeout");return}else if(t==x&&m){m.abort("server abort");E.reject(m,"error","server abort");return}if(!A||A.location.href==l.iframeSrc){if(!b){return}}if(v.detachEvent){v.detachEvent("onload",_)}else{v.removeEventListener("load",_,false)}var n="success",r;try{if(b){throw"timeout"}var i=l.dataType=="xml"||A.XMLDocument||e.isXMLDoc(A);s("isXml="+i);if(!i&&window.opera&&(A.body===null||!A.body.innerHTML)){if(--O){s("requeing onLoad callback, DOM not available");setTimeout(_,250);return}}var o=A.body?A.body:A.documentElement;m.responseText=o?o.innerHTML:null;m.responseXML=A.XMLDocument?A.XMLDocument:A;if(i){l.dataType="xml"}m.getResponseHeader=function(e){var t={"content-type":l.dataType};return t[e.toLowerCase()]};if(o){m.status=Number(o.getAttribute("status"))||m.status;m.statusText=o.getAttribute("statusText")||m.statusText}var u=(l.dataType||"").toLowerCase();var a=/(json|script|text)/.test(u);if(a||l.textarea){var f=A.getElementsByTagName("textarea")[0];if(f){m.responseText=f.value;m.status=Number(f.getAttribute("status"))||m.status;m.statusText=f.getAttribute("statusText")||m.statusText}else if(a){var c=A.getElementsByTagName("pre")[0];var p=A.getElementsByTagName("body")[0];if(c){m.responseText=c.textContent?c.textContent:c.innerText}else if(p){m.responseText=p.textContent?p.textContent:p.innerText}}}else if(u=="xml"&&!m.responseXML&&m.responseText){m.responseXML=D(m.responseText)}try{L=H(m,u,l)}catch(g){n="parsererror";m.error=r=g||n}}catch(g){s("error caught: ",g);n="error";m.error=r=g||n}if(m.aborted){s("upload aborted");n=null}if(m.status){n=m.status>=200&&m.status<300||m.status===304?"success":"error"}if(n==="success"){if(l.success){l.success.call(l.context,L,"success",m)}E.resolve(m.responseText,"success",m);if(h){e.event.trigger("ajaxSuccess",[m,l])}}else if(n){if(r===undefined){r=m.statusText}if(l.error){l.error.call(l.context,m,n,r)}E.reject(m,"error",r);if(h){e.event.trigger("ajaxError",[m,l,r])}}if(h){e.event.trigger("ajaxComplete",[m,l])}if(h&&!--e.active){e.event.trigger("ajaxStop")}if(l.complete){l.complete.call(l.context,m,n)}M=true;if(l.timeout){clearTimeout(w)}setTimeout(function(){if(!l.iframeTarget){d.remove()}else{d.attr("src",l.iframeSrc)}m.responseXML=null},100)}var o=a[0],u,f,l,h,p,d,v,m,g,y,b,w;var E=e.Deferred();E.abort=function(e){m.abort(e)};if(t){for(f=0;f<c.length;f++){u=e(c[f]);if(n){u.prop("disabled",false)}else{u.removeAttr("disabled")}}}l=e.extend(true,{},e.ajaxSettings,r);l.context=l.context||l;p="jqFormIO"+(new Date).getTime();if(l.iframeTarget){d=e(l.iframeTarget);y=d.attr2("name");if(!y){d.attr2("name",p)}else{p=y}}else{d=e('<iframe name="'+p+'" src="'+l.iframeSrc+'" />');d.css({position:"absolute",top:"-1000px",left:"-1000px"})}v=d[0];m={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(t){var n=t==="timeout"?"timeout":"aborted";s("aborting upload... "+n);this.aborted=1;try{if(v.contentWindow.document.execCommand){v.contentWindow.document.execCommand("Stop")}}catch(r){}d.attr("src",l.iframeSrc);m.error=n;if(l.error){l.error.call(l.context,m,n,t)}if(h){e.event.trigger("ajaxError",[m,l,n])}if(l.complete){l.complete.call(l.context,m,n)}}};h=l.global;if(h&&0===e.active++){e.event.trigger("ajaxStart")}if(h){e.event.trigger("ajaxSend",[m,l])}if(l.beforeSend&&l.beforeSend.call(l.context,m,l)===false){if(l.global){e.active--}E.reject();return E}if(m.aborted){E.reject();return E}g=o.clk;if(g){y=g.name;if(y&&!g.disabled){l.extraData=l.extraData||{};l.extraData[y]=g.value;if(g.type=="image"){l.extraData[y+".x"]=o.clk_x;l.extraData[y+".y"]=o.clk_y}}}var S=1;var x=2;var N=e("meta[name=csrf-token]").attr("content");var C=e("meta[name=csrf-param]").attr("content");if(C&&N){l.extraData=l.extraData||{};l.extraData[C]=N}if(l.forceSync){k()}else{setTimeout(k,10)}var L,A,O=50,M;var D=e.parseXML||function(e,t){if(window.ActiveXObject){t=new ActiveXObject("Microsoft.XMLDOM");t.async="false";t.loadXML(e)}else{t=(new DOMParser).parseFromString(e,"text/xml")}return t&&t.documentElement&&t.documentElement.nodeName!="parsererror"?t:null};var P=e.parseJSON||function(e){return window["eval"]("("+e+")")};var H=function(t,n,r){var i=t.getResponseHeader("content-type")||"",s=n==="xml"||!n&&i.indexOf("xml")>=0,o=s?t.responseXML:t.responseText;if(s&&o.documentElement.nodeName==="parsererror"){if(e.error){e.error("parsererror")}}if(r&&r.dataFilter){o=r.dataFilter(o,n)}if(typeof o==="string"){if(n==="json"||!n&&i.indexOf("json")>=0){o=P(o)}else if(n==="script"||!n&&i.indexOf("javascript")>=0){e.globalEval(o)}}return o};return E}if(!this.length){s("ajaxSubmit: skipping submit process - no element selected");return this}var i,o,u,a=this;if(typeof r=="function"){r={success:r}}else if(r===undefined){r={}}i=r.type||this.attr2("method");o=r.url||this.attr2("action");u=typeof o==="string"?e.trim(o):"";u=u||window.location.href||"";if(u){u=(u.match(/^([^#]+)/)||[])[1]}r=e.extend(true,{url:u,success:e.ajaxSettings.success,type:i||e.ajaxSettings.type,iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},r);var f={};this.trigger("form-pre-serialize",[this,r,f]);if(f.veto){s("ajaxSubmit: submit vetoed via form-pre-serialize trigger");return this}if(r.beforeSerialize&&r.beforeSerialize(this,r)===false){s("ajaxSubmit: submit aborted via beforeSerialize callback");return this}var l=r.traditional;if(l===undefined){l=e.ajaxSettings.traditional}var c=[];var h,p=this.formToArray(r.semantic,c);if(r.data){r.extraData=r.data;h=e.param(r.data,l)}if(r.beforeSubmit&&r.beforeSubmit(p,this,r)===false){s("ajaxSubmit: submit aborted via beforeSubmit callback");return this}this.trigger("form-submit-validate",[p,this,r,f]);if(f.veto){s("ajaxSubmit: submit vetoed via form-submit-validate trigger");return this}var d=e.param(p,l);if(h){d=d?d+"&"+h:h}if(r.type.toUpperCase()=="GET"){r.url+=(r.url.indexOf("?")>=0?"&":"?")+d;r.data=null}else{r.data=d}var v=[];if(r.resetForm){v.push(function(){a.resetForm()})}if(r.clearForm){v.push(function(){a.clearForm(r.includeHidden)})}if(!r.dataType&&r.target){var m=r.success||function(){};v.push(function(t){var n=r.replaceTarget?"replaceWith":"html";e(r.target)[n](t).each(m,arguments)})}else if(r.success){v.push(r.success)}r.success=function(e,t,n){var i=r.context||this;for(var s=0,o=v.length;s<o;s++){v[s].apply(i,[e,t,n||a,a])}};if(r.error){var g=r.error;r.error=function(e,t,n){var i=r.context||this;g.apply(i,[e,t,n,a])}}if(r.complete){var y=r.complete;r.complete=function(e,t){var n=r.context||this;y.apply(n,[e,t,a])}}var b=e("input[type=file]:enabled",this).filter(function(){return e(this).val()!==""});var w=b.length>0;var E="multipart/form-data";var S=a.attr("enctype")==E||a.attr("encoding")==E;var x=t.fileapi&&t.formdata;s("fileAPI :"+x);var T=(w||S)&&!x;var N;if(r.iframe!==false&&(r.iframe||T)){if(r.closeKeepAlive){e.get(r.closeKeepAlive,function(){N=A(p)})}else{N=A(p)}}else if((w||S)&&x){N=L(p)}else{N=e.ajax(r)}a.removeData("jqxhr").data("jqxhr",N);for(var C=0;C<c.length;C++){c[C]=null}this.trigger("form-submit-notify",[this,r]);return this};e.fn.ajaxForm=function(t){t=t||{};t.delegation=t.delegation&&e.isFunction(e.fn.on);if(!t.delegation&&this.length===0){var n={s:this.selector,c:this.context};if(!e.isReady&&n.s){s("DOM not ready, queuing ajaxForm");e(function(){e(n.s,n.c).ajaxForm(t)});return this}s("terminating; zero elements found by selector"+(e.isReady?"":" (DOM not ready)"));return this}if(t.delegation){e(document).off("submit.form-plugin",this.selector,r).off("click.form-plugin",this.selector,i).on("submit.form-plugin",this.selector,t,r).on("click.form-plugin",this.selector,t,i);return this}return this.ajaxFormUnbind().bind("submit.form-plugin",t,r).bind("click.form-plugin",t,i)};e.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")};e.fn.formToArray=function(n,r){var i=[];if(this.length===0){return i}var s=this[0];var o=this.attr("id");var u=n?s.getElementsByTagName("*"):s.elements;var a;if(u&&!/MSIE [678]/.test(navigator.userAgent)){u=e(u).get()}if(o){a=e(':input[form="'+o+'"]').get();if(a.length){u=(u||[]).concat(a)}}if(!u||!u.length){return i}var f,l,c,h,p,d,v;for(f=0,d=u.length;f<d;f++){p=u[f];c=p.name;if(!c||p.disabled){continue}if(n&&s.clk&&p.type=="image"){if(s.clk==p){i.push({name:c,value:e(p).val(),type:p.type});i.push({name:c+".x",value:s.clk_x},{name:c+".y",value:s.clk_y})}continue}h=e.fieldValue(p,true);if(h&&h.constructor==Array){if(r){r.push(p)}for(l=0,v=h.length;l<v;l++){i.push({name:c,value:h[l]})}}else if(t.fileapi&&p.type=="file"){if(r){r.push(p)}var m=p.files;if(m.length){for(l=0;l<m.length;l++){i.push({name:c,value:m[l],type:p.type})}}else{i.push({name:c,value:"",type:p.type})}}else if(h!==null&&typeof h!="undefined"){if(r){r.push(p)}i.push({name:c,value:h,type:p.type,required:p.required})}}if(!n&&s.clk){var g=e(s.clk),y=g[0];c=y.name;if(c&&!y.disabled&&y.type=="image"){i.push({name:c,value:g.val()});i.push({name:c+".x",value:s.clk_x},{name:c+".y",value:s.clk_y})}}return i};e.fn.formSerialize=function(t){return e.param(this.formToArray(t))};e.fn.fieldSerialize=function(t){var n=[];this.each(function(){var r=this.name;if(!r){return}var i=e.fieldValue(this,t);if(i&&i.constructor==Array){for(var s=0,o=i.length;s<o;s++){n.push({name:r,value:i[s]})}}else if(i!==null&&typeof i!="undefined"){n.push({name:this.name,value:i})}});return e.param(n)};e.fn.fieldValue=function(t){for(var n=[],r=0,i=this.length;r<i;r++){var s=this[r];var o=e.fieldValue(s,t);if(o===null||typeof o=="undefined"||o.constructor==Array&&!o.length){continue}if(o.constructor==Array){e.merge(n,o)}else{n.push(o)}}return n};e.fieldValue=function(t,n){var r=t.name,i=t.type,s=t.tagName.toLowerCase();if(n===undefined){n=true}if(n&&(!r||t.disabled||i=="reset"||i=="button"||(i=="checkbox"||i=="radio")&&!t.checked||(i=="submit"||i=="image")&&t.form&&t.form.clk!=t||s=="select"&&t.selectedIndex==-1)){return null}if(s=="select"){var o=t.selectedIndex;if(o<0){return null}var u=[],a=t.options;var f=i=="select-one";var l=f?o+1:a.length;for(var c=f?o:0;c<l;c++){var h=a[c];if(h.selected){var p=h.value;if(!p){p=h.attributes&&h.attributes.value&&!h.attributes.value.specified?h.text:h.value}if(f){return p}u.push(p)}}return u}return e(t).val()};e.fn.clearForm=function(t){return this.each(function(){e("input,select,textarea",this).clearFields(t)})};e.fn.clearFields=e.fn.clearInputs=function(t){var n=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var r=this.type,i=this.tagName.toLowerCase();if(n.test(r)||i=="textarea"){this.value=""}else if(r=="checkbox"||r=="radio"){this.checked=false}else if(i=="select"){this.selectedIndex=-1}else if(r=="file"){if(/MSIE/.test(navigator.userAgent)){e(this).replaceWith(e(this).clone(true))}else{e(this).val("")}}else if(t){if(t===true&&/hidden/.test(r)||typeof t=="string"&&e(this).is(t)){this.value=""}}})};e.fn.resetForm=function(){return this.each(function(){if(typeof this.reset=="function"||typeof this.reset=="object"&&!this.reset.nodeType){this.reset()}})};e.fn.enable=function(e){if(e===undefined){e=true}return this.each(function(){this.disabled=!e})};e.fn.selected=function(t){if(t===undefined){t=true}return this.each(function(){var n=this.type;if(n=="checkbox"||n=="radio"){this.checked=t}else if(this.tagName.toLowerCase()=="option"){var r=e(this).parent("select");if(t&&r[0]&&r[0].type=="select-one"){r.find("option").selected(false)}this.selected=t}})};e.fn.ajaxSubmit.debug=false})
</script>

<script type="text/javascript">
$(document).ready(function() { 
	 $('#uploadForm').submit(function(e) {	
		if($('#uploadedfile').val()) {
			e.preventDefault();
			$(this).ajaxSubmit({ 
				target: '#targetLayer', 
				beforeSubmit: function() {
				  $("#progress-bar").width('0%');
				},
				uploadProgress: function (event, position, total, percentComplete){	
					$("#progress-bar").width(percentComplete + '%');
					$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
				},
				resetForm: true
			}); 
			return false; 
		}
	});
}); 
</script>
