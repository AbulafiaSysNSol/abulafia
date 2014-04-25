<body onload="setFocus()">
<?php
	$_SESSION['annoricercaprotocollo'] = '';
	$level = $_SESSION['auth'];
?>

<div class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><strong>Ricerca nel database</strong></h3>
		</div>
		
		<div class="panel-body">
			<div class="form-group">
				<form name="search" method="post">
					<label>Inserisci il valore da cercare:</label>
					<div class="row">
						<div class="col-xs-4">
							<input class="form-control input-sm" placeholder="lasciare vuoto per una ricerca senza filtri" type="text" name="cercato" onkeydown="if(event.keyCode==13) autorized(<?php echo $level ?>)" onfocus="formInUse = true;"/>
						</div>
						<div class="col-xs-2">
							<button class="btn btn-primary" type="button" onClick="autorized(<?php echo $level ?>)"><span class="glyphicon glyphicon-search"></span> Cerca</button>
						</div>
					</div>
					<br>
					<div id="content" style="display: none;" class="alert alert-info">
						<span class="glyphicon glyphicon-search"></span> <b> RICERCA COGNOME+NOME</b>: è possibile effettuare una ricerca esatta per cognome e nome (esempio <b>Saitta+Biagio</b>)
					</div>
					<label>Ricerca in:</label>
					<div class="row">
						<div class="col-xs-2">
							<SELECT class="form-control input-sm" name="tabella" onChange="Change()">
								<OPTION selected value="lettere" onclick="document.search.cercato.focus()"> PROTOCOLLO</OPTION>
								<OPTION value="anagrafica" onclick="document.search.cercato.focus()"> ANAGRAFICA</OPTION>
							</SELECT>
						</div>
					</div>
					<br>
					<label>Elenca in ordine:</label>
					<div class="row">
						<div class="col-xs-3">
							<input type="radio" onfocus="document.search.cercato.focus()" name="group1" value="alfabetico"> Alfabetico;<br>
							<input type="radio" onfocus="document.search.cercato.focus()" name="group1" value="cronologico"> Cronologico;<br>
							<input type="radio" onfocus="document.search.cercato.focus()" name="group1" value="cron-inverso" checked> Cronologico inverso;<br>
						</div>
					</div>	
					<br>
					<label>Anno di riferimento:</label>
					<div class="row">
						<div class="col-xs-2">
							<SELECT class="form-control input-sm" name="annoricercaprotocollo" >
							<?php
								$esistenzatabella1=mysql_query("show tables like 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
								$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
								$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
								while ($esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM))
								{
								if ('lettere'.$my_calendario->anno== $esistenzatabella11[0]) { $selected='selected'; }
								else { $selected ='';}
								$annoprotocollo= explode("lettere", $esistenzatabella11[0]);
							?>
							<OPTION value="<?php echo $annoprotocollo[1] ;?>" onclick="document.search.cercato.focus()" <?php echo $selected ;?>> <?php echo $annoprotocollo[1].' ' ;?></OPTION>
							<?php
							}
							?>
							</SELECT>
						</div>
					</div>
					<br>
					<label>Filtra per tipologia:</label>
					<div class="row">
						<div class="col-xs-2">
							<SELECT class="form-control input-sm" NAME="anagraficatipologia"  disabled>
								<OPTION value="anagrafica.tipologia" onclick="document.search.cercato.focus()" selected> Nessun filtro</OPTION>
								<OPTION value="persona" onclick="document.search.cercato.focus()"> Persone fisiche</OPTION>
								<OPTION value="carica" onclick="document.search.cercato.focus()"> Carica o Incarico</OPTION>
								<OPTION value="ente" onclick="document.search.cercato.focus()"> Ente</OPTION>
							</SELECT>
						</div>
					</div>
				</form>	
			</div>			
		</div>
</div>        

<script type="text/javascript" language="javascript">
function autorized(livello) {
	var scelta = document.search.tabella.value;
	if ((livello < 40) && (scelta == 'lettere')) {
		alert("Non hai i privilegi per ricercare nel 'PROTOCOLLO'");
		document.search.tabella.focus();
		return false;
	}
	else {
           document.search.action = "login0.php?corpus=risultati&iniziorisultati=0&currentpage=1";
           document.search.submit();
      }
  }
function Change() {
	var type = document.search.tabella.options[document.search.tabella.selectedIndex].value;
	if (type == "lettere") {
	  document.getElementById("content").style.display="none";
	  document.search.annoricercaprotocollo.disabled = false;
	  document.search.anagraficatipologia.disabled = true;
	}
	if (type == "anagrafica") {
	  document.getElementById("content").style.display="table";
	  document.search.anagraficatipologia.disabled = false;
	  document.search.annoricercaprotocollo.disabled = true;
	}
  }
var formInUse = false;
function setFocus() {
	if(!formInUse) {
		document.search.cercato.focus();
	}
}
</script>
</body>