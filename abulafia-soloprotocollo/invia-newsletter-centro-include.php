<?php
	$idlettera= $_GET['id']; //acquisizione dell'id della lettera da inviare tramite newsletter
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Invio Protocollo come allegato</strong></h3>
	</div>
	
	<div class="panel-body">
		<form action="login0.php?corpus=invia-newsletter2&id=<?php echo $idlettera;?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="mittente" value="<?php $_SESSION['mittente'] ?>">
			<i> N.B. - Indirizzi multipli vanno separati da virgole.
			<br> 
			Ad esempio:<b> tizio@example.it,caio@example.it</b></i>
			
			<br><br>
			<div class="row">
				<div class="col-xs-5">
					<div class="form-group">
						<label>Destinatari:</label>
						<input required class="form-control" type="text" name="destinatario" placeholder="inserisci i destinatari separandoli con una virgola...">
					</div>
					
					<div class="form-group">
						<label>Oggetto:</label>
						<input class="form-control" type="text" name="oggetto" placeholder="inserisci un oggetto...">
					</div>
					
					<div class="form-group">
						<label>Messaggio:</label>
						<textarea class="form-control" rows="5" name="messaggio" placeholder="aggiungi un messaggio..."></textarea>
					</div>
					
					<div class="form-group">
						<input type="checkbox" name="intestazione" value="intestazione" checked="checked"> Intestazione Standard<br />
					</div>
					
					<div class="form-group">
						<input type="checkbox" name="firma" value="firma" checked="checked"> Firma Standard
					</div>
				</div>
			</div>
			<small>(Per utilizzare una intestazione ed una firma personalizzata deselezionare le caselle)</small>
			<br><br><button type="submit" class="btn btn-success"><i class="fa fa-share"></i> Invia</button>
		</form>
	</div>
</div>