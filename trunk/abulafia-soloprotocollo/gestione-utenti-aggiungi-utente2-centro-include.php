<?php 
$id=$_GET['id'];
$nome=$_GET['nome'];
$cognome=$_GET['cognome'];
?>
<div id="primarycontent">
<div class="post">
				<div class="header">
					<h3><u>Inserisci nuovo utente:</u></h3>
				
				</div>
				<div class="content">
					<p>

<?php
$nomenuovoutente= $nome.'.'.$cognome;
$passwordnuovoutente= md5($nomenuovoutente);
$nuovoutente=mysql_query("insert into users values('$id',0,'$nomenuovoutente', '$passwordnuovoutente')");



?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=gestione-utenti"; else window.location="login0.php?corpus=gestione-utenti"
</SCRIPT>

</p></div>
					

		</div>
			
			<!-- post end -->

</div>
