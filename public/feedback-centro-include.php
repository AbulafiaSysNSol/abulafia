<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-envelope-o"></i> Invia Feedback</b></h3>
	</div>
	
	<div class="panel-body">
		
		<i class="fa fa-smile-o"></i> La tua opinione per noi � <b>importante!</b><br>
		<small>Mandaci i tuoi suggerimenti o le possibili migliorie. Tutte le proposte saranno vagliate ed eventualmente implementate.</small>
		<br><br>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<form action="login0.php?corpus=feedback2" method="POST" enctype="multipart/form-data">
						Feedback:<br>
						<textarea required id="feed" class="form-control" rows="6" name="feedback"></textarea>
						<br>
						<button id="buttonl" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Invio email in corso..." class="btn btn-success" type="submit">Invia <i class="fa fa-mail-forward"></i></button>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	$("#buttonl").click(function() {
		var $btn = $(this);
		var feed = document.getElementById("feed").value;
		if ((feed == "") || (feed == "undefined")) {
			return;
		}
		else {
			$btn.button('loading');
		}
	});
</script>

