	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Segnalazione errori:</u></h3>
				
				</div>
				<div class="content">
					<p>
<form action="login0.php?corpus=segnala-bug2&idanagrafica=<?php echo $_SESSION['loginid'];?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="mittente" value="webmaster@pionierisicilia.com">
<table border="0">

<tr>
  <td>Pagina in cui si e' riscontrato l'errore</td>
  <td><input type="text" name="pagina-errore" value="" /></td>
</tr>
<tr>
  <td>Descrizione dell'errore:</td>
  <td><textarea cols="23" rows="4" name="messaggio"></textarea></td>
  </tr>
<tr>
  <td colspan="2" align="right"><input type="submit" value="Invia" /></td>
</tr>
</table>
</form>

<b>Tutte le segnalazioni verranno vagliate. <br>Si verra' avvisati via e-mail quando l'errore sara' stato corretto.</b>


</p></div>
					
		</div>
			
			<!-- post end -->

</div>
