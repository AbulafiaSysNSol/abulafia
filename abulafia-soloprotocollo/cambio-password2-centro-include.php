<?php 
$loginid=$_SESSION['loginid'];
$vecchiapassword=$_POST['vecchiapassword'];
$nuovapassword1=$_POST['nuovapassword1'];
$nuovapassword2=$_POST['nuovapassword2'];
$errorecambiopassword= 0;
$controllodb = mysql_query("select distinct * from users where idanagrafica='$loginid'");
$controllodb2 = mysql_fetch_array($controllodb);
$nuovapassword3 =MD5($nuovapassword1);
?>
<div id="primarycontent">
<div class="post">
				<div class="header">
					<h3><u>Cambio della password:</u></h3>
				
				</div>
				<div class="content">
					<p>

<?php if ($nuovapassword1 != $nuovapassword2) { echo 'Errore: le due password nuove non coincidono<br><br>'; $errorecambiopassword= 1; }	

if (($nuovapassword1 =='') or ($nuovapassword2 =='') or ($vecchiapassword =='')) { echo 'Errore: nessun campo può essere lasciato vuoto<br><br>'; $errorecambiopassword= 1;}

if (strlen($nuovapassword1) < 6) { echo 'Errore: la password deve contenere almeno 6 caratteri<br><br>'; $errorecambiopassword= 1;}

if (md5($vecchiapassword) === $controllodb2['password']) {echo "La vecchia password e' corretta<br><br>";}
else {echo 'errore: la vecchia password non e\' corretta<br><br>'; $errorecambiopassword= 1;}


if ($errorecambiopassword > 0) {?><li class="first"><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>">Torna Indietro</a></li><?php } 

if ($errorecambiopassword == 0) { $inserimento=mysql_query("update users set users.password='$nuovapassword3' where users.idanagrafica='$loginid' limit 1");
echo mysql_error();?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=home"; else window.location="login0.php?corpus=home"
</SCRIPT>
<?php }
?>

</p></div>
					

		</div>
			
			<!-- post end -->

</div>
