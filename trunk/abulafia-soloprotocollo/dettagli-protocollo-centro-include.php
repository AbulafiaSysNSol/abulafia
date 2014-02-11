<?php
$my_lettera = new Lettera(); //crea un nuovo oggetto 'lettera'
//$_SESSION['my_lettera']= serialize($my_lettera); //serializzazione per passaggio alle variabili di sessione (se l'oggetto non viene riutilizzato è inutile serializzare?)
?>


	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Dettagli Protocollo:</u></h3>
				
				</div>
				<div class="content">
					<p>


<div class="content">
<p>
	<?php 
		$my_lettera -> publdisplaylettera ($_GET['id'], $_SESSION['annoricercaprotocollo']); //richiamo del metodo "mostra" dell'oggetto Lettera
	?> 


</p>


</div>

</p></div>
					
		
		</div>
			
			<!-- post end -->


<div id="primarycontent">
		
			<!-- secondary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Opzioni:</u></h3>
				
				</div>
				<div class="content">
					<p>



</p>


</div>
<div class="content">
				<ul class="linklist">

<li class="first"><a href="login0.php?corpus=modifica-protocollo&from=risultati&id=<?php echo $_GET['id'];?>"><br>Modifica questo Protocollo</a></li>
<li><a href="login0.php?corpus=invia-newsletter&id=<?php echo $_GET['id'];?>">Invia tramite mailing list</a></li>					
<li><a href="login0.php?corpus=protocollo">Nuovo inserimento PROTOCOLLO</a></li>
</ul>
			</div>
<br><br>


</p></div>
					
			
<div class="footer">

					
				</div>
		</div>

</div>
