<?php 
$id=$_GET['id'];
$nuovapassword1=$_POST['nuovapassword1'];
$nuovapassword2=$_POST['nuovapassword2'];
$nuovapassword3 =MD5($nuovapassword1);
$authlevel=$_POST['authlevel1'];
$nomeutente=$_POST['nomeutente'];
?>
<div id="primarycontent">
<div class="post">
				<div class="header">
					<h3><u>Modifica dati login:</u></h3>
				
				</div>
				<div class="content">
					<p>

<?php if ($nuovapassword1 != $nuovapassword2) { echo 'Errore: le due password nuove non coincidono<br><br>'; $errorecambiopassword= 1; }	

if (($nuovapassword1 !='') and ($nuovapassword2 !='')) { $cambiopassword=mysql_query("update users set users.password='$nuovapassword3' where users.idanagrafica='$id' limit 1");}

$cambionomeutente=mysql_query("update users set users.loginname='$nomeutente' where users.idanagrafica='$id' limit 1");

$cambioauthlevel=mysql_query("update users set users.auth='$authlevel' where users.idanagrafica='$id' limit 1");

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
