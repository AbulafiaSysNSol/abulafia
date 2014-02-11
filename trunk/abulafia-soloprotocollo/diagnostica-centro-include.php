<?php
//controllo dell'autorizzazione necessaria alla gestione degli utenti di abulafia
if ($_SESSION['auth'] < 11) { echo 'Non hai l\'autorizzazione necessaria per utilizzare questa funzione. Se ritieni di averne diritto, contatta l\'amministratore di sistema'; exit ();}
?>
	<div id="primarycontent">
		
				<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Ricerca anomalie in ANAGRAFICA:</u></h3>
				
				</div>
				<div class="content">
					<p>
<ul class="linklist">
<li class="first"><a href="login0.php?corpus=anagrafica-cerca-anomalie&filtro=cognomenome">"Cognome + Nome" duplicato</a></li>
<li><a href="login0.php?corpus=anagrafica-cerca-anomalie&filtro=inmolteplicigruppi">Pionieri contemporaneamente in piu' gruppi</a></li>
</ul>


</p></div></div>
					

			
			<!-- post end -->

		</div>
