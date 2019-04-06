<body onload="setFocus()">
<?php
	$_SESSION['block'] = false;
	$level = $_SESSION['auth'];
	$my_log -> publscrivilog( $_SESSION['loginname'], 'GO TO RICERCA' , 'OK' , $_SESSION['ip'], $_SESSION['logfile'], 'protocollo');
	$lett = new Lettera();
?>

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><span class="glyphicon glyphicon-search"></span> Ricerca PROTOCOLLO</strong></h3>
	</div>
		
	<div class="panel-body">
		<div class="form-group">
				
			<form name="search" method="post">
					
				<div class="row">
					<div class="col-sm-6">
						<h4><i class="fa fa-pencil"></i> Inserisci il valore da cercare:</h4>
						<small>ricerca il valore presente nell'oggetto.</small><br><br>
						<input class="form-control input-sm" placeholder="lasciare vuoto per una ricerca di tutte le parole..." type="text" name="cercato" onkeydown="if(event.keyCode==13) autorized(<?php echo $level ?>)" onfocus="formInUse = true;"/>
						<input type="hidden" name="tabella" value="lettere">
					</div>
				</div>

				<br>

				<div class="row">
					<div class="col-sm-12">
						<h4><i class="fa fa-filter"></i> Filtri aggiuntivi:</h4><br>
					</div>
							
					<div class="col-sm-4">	
						<div id="prot" class="col-sm-12">
							<label><i class="fa fa-book"></i> Anno Protocollo:</label>
							<SELECT class="form-control input-sm" name="annoricercaprotocollo" >
								<?php
									$esistenzatabella1 = $connessione->query("SHOW TABLES LIKE 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
									$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
									$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
									while ($esistenzatabella11 = $esistenzatabella1->fetch()) {
										if ('lettere'.$my_calendario->anno== $esistenzatabella11[0]) { 
											$selected='selected'; 
										}
										else { 
											$selected ='';
										}
										$annoprotocollo= explode("lettere", $esistenzatabella11[0]);
										?>
										<OPTION value="<?php echo $annoprotocollo[1] ;?>" onclick="document.search.cercato.focus()" <?php echo $selected ;?>> <?php echo $annoprotocollo[1].' ' ;?></OPTION>
										<?php
									}
								?>
							</SELECT>
						</div>
							
						<div class="col-sm-12">
							<br><label><i class="fa fa-sort-alpha-asc"></i> Elenca in ordine:</label>
							<SELECT class="form-control input-sm" NAME="group1">
								<OPTION value="alfabetico" onclick="document.search.cercato.focus()"> Alfabetico</OPTION>
								<OPTION value="cronologico" onclick="document.search.cercato.focus()"> Cronologico</OPTION>
								<OPTION value="cron-inverso" onclick="document.search.cercato.focus()" selected> Cronologico Inverso</OPTION>
							</SELECT>
						</div>
						<br>
					</div>
						
					<div class="col-sm-4">
						<div id="prot1" class="col-sm-12">
							<label><i class="fa fa-exchange"></i> Spedita/Ricevuta:</label>
							<SELECT class="form-control input-sm" NAME="speditaricevuta">
								<OPTION value="" onclick="document.search.cercato.focus()">tutte</OPTION>
								<OPTION value="sped" onclick="document.search.cercato.focus()">spedite</OPTION>
								<OPTION value="ric" onclick="document.search.cercato.focus()">ricevute</OPTION>
							</SELECT>
							
							<br>
							<label><i class="fa fa-archive"></i> Posizioni:</label>
							<SELECT class="form-control input-sm" NAME="posizione">
								<OPTION value="" onclick="document.search.cercato.focus()">tutte</OPTION>
								<?php
									$posizioni = $lett->getPosizioni();
									foreach($posizioni as $pos) {
										echo '<option value ='.$pos[0].'>' . $pos[0] . ' - ' . $lett->getDescPosizione($pos[0]) . '</option>';
									}
								?>
							</SELECT>
						</div>
						<br>
					</div>
						
					<div class="col-sm-4">
						<div id="prot2" class="col-sm-12">
							<label><i class="fa fa-calendar"></i> Registrati dal - al:</label>
							<div class="row">
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm datepickerProt" name="data1" placeholder="dal...">
								</div>
								<div class="col-sm-6">
									<input type="text" class="form-control input-sm datepickerProt" name="data2" placeholder="al...">							
								</div>
							</div>
							<br>
								
							<label><i class="fa fa-tags"></i> Pratiche:</label>
							<SELECT class="form-control input-sm" NAME="pratica">
								<OPTION value="" onclick="document.search.cercato.focus()">tutte</OPTION>
								<?php
									$pratiche = $lett->getPratiche();
									foreach($pratiche as $prat) {
										echo '<option value='.$prat[0].'>' . $lett->getDescPratica($prat[0]) . '</option>';
									}
								?>
							</SELECT>
						</div>
					</div>

				</div>
				<br><br>
				<div class="row">
					<div class="col-sm-3">
						<button  id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Ricerca in corso..." class="btn btn-success btn-lg btn-block" type="button" onClick="autorized(<?php echo $level ?>)"><span class="glyphicon glyphicon-search"></span> Cerca Protocollo</button>
					</div>
				</div>
			</form>	
		</div>			
	</div>
</div>        

<script>
	$("#buttonl").click(function() {
		var $btn = $(this);
		$btn.button('loading');
	});
</script>

<script type="text/javascript" language="javascript">
function autorized(livello) {
           document.search.action = "login0.php?corpus=risultati&iniziorisultati=0&currentpage=1";
           document.search.submit();
  }
var formInUse = false;
function setFocus() {
	if(!formInUse) {
		document.search.cercato.focus();
	}
}
</script>
</body>
