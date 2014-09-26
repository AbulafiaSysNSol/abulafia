<?php
	$idlettera= $_GET['id']; //acquisizione dell'id della lettera da inviare tramite newsletter
	$anno = $_GET['anno'];
	$lettera = new Lettera();
	$oggetto = $lettera->getDettagli($idlettera, $anno);
	$ogg = $oggetto['oggetto'];
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-share-square-o"></i> Invio Protocollo come Allegato via Email</strong></h3>
	</div>
	
	<div class="panel-body">
		<form name="sendmail" action="login0.php?corpus=invia-newsletter2&id=<?php echo $idlettera;?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="mittente" value="<?php $_SESSION['mittente'] ?>">
			<i>
			N.B. - Indirizzi multipli vanno separati da virgole, <ins>senza lasciare spazi.</ins>
			<br> 
			Ad esempio:<b> tizio@example.it,caio@example.it</b>
			</i>
			
			<br><br>
			<div class="row">
				<div class="col-xs-5">
					<div class="form-group">
						<h4><i class="fa fa-users"></i> Destinatari:</h4>
						<input id="email" required class="form-control" type="text" name="destinatario" placeholder="inserisci i destinatari separandoli con una virgola...">
					</div>
					
					<div class="form-group">
						<h4><i class="fa fa-certificate"></i> Oggetto:</h4>
						<input required id="ogg" value="<?php echo $ogg; ?>" class="form-control" type="text" name="oggetto" placeholder="inserisci un oggetto...">
					</div>
					
					<div class="form-group">
						<h4><i class="fa fa-file-text-o"></i> Messaggio:</h4>
						<textarea id="editorMail" class="form-control" rows="7" name="messaggio" placeholder="aggiungi un messaggio...">Si trasmette nota pari ad oggetto.<br><br>Cordiali Saluti.</textarea>
					</div>
					
					<div class="form-group">
						<input type="checkbox" name="intestazione" value="intestazione" checked="checked"> Intestazione Standard<br />
					</div>
					
					<div class="form-group">
						<input type="checkbox" name="firma" value="firma" checked="checked"> Firma Standard
					</div>
				</div>
				
				<div class="col-xs-7">
					<center>
					<script type="text/javascript" src="livesearch-email.js"></script>
					<h3><i class="fa fa-search"></i> <i class="fa fa-envelope-o"></i> Cerca indirizzo nell'anagrafica:</h3>
					</center>
					<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
					<input class="form-control input-sm" type="text" placeholder="inserisci nome, cognome o indirizzo email..." onkeyup="showResult(this.value)">
					<div id="livesearch"></div>
					</div>
					</div>
				</div>
			</div>
			<small>(Per utilizzare una intestazione ed una firma personalizzata deselezionare le caselle)</small>
			<br><br><button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Invio email in corso..." type="submit" class="btn btn-success"><i class="fa fa-share"></i> Invia</button>
		</form>
	</div>
</div>

<script>
	$("#buttonl").click(function() {
		var $btn = $(this);
		var oggetto = document.getElementById("ogg").value;
		var dest = document.getElementById("email").value;
		var mess = document.getElementById("editorMail").value;
		if ((oggetto == "") || (oggetto == "undefined") || (dest == "") || (dest == "undefined")) {
			return;
		}
		else {
			$btn.button('loading');
		}
	});
</script>

<script type="text/javascript">
  function changeEmail(valore) { 
	email = document.getElementById("email").value;
	if(email != "") {
		document.getElementById("email").value = email + ',' + valore;
	}
	else {
		document.getElementById("email").value = valore;
	}
  }
</script>