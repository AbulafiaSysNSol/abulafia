<?php
$idlettera= $_GET['id']; //acquisizione dell'id della lettera da inviare tramite newsletter
?>

<div id="primarycontent">
	<div class="post">
		<div class="header"><h3><u>Invio mailing list:</u></h3></div>
			<div class="content">
				<p>

<form action="login0.php?corpus=invia-newsletter2&id=<?php echo $idlettera;?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="mittente" value="<?php $_SESSION['mittente'] ?>">
<table border="0">
<tr>
  <td><br><i>N.B. - Indirizzi multipli vanno separati da virgole.<br> Ad esempio:<b> tizio@pionierisicilia.com,caio@pionierisicilia.com</b></i></td><td></td></tr>
  <tr>
<td><b>Destinatari:</b></td></tr>
  <tr><td><input type="text" size ="52" name="destinatario" value="" /></td>
</tr>
<tr>
  <td><b>Oggetto:</b></td></tr><tr>
  <td><input type="text" name="oggetto" value="" size ="52"/></td>
</tr>
<tr>
  <td><b>Messaggio:</b></td></tr><tr>
  <td><textarea cols="50" rows="15" name="messaggio"></textarea></td>
  </tr>
  
<tr>
  <td style="padding:3px">
    <input type="checkbox" name="intestazione" value="intestazione" checked="checked"> Intestazione Standard<br />
	<input type="checkbox" name="firma" value="firma" checked="checked"> Firma Standard<br />
<font size="-2">(Per utilizzare una intestazione ed una firma personalizzata deselezionare le caselle)</font>
  </td>
</tr>
  
<tr>
  <td colspan="2" align="right"><input type="submit" value="Invia" /></td>
</tr>
</table>
</form>

	</strong> 
</b>

			</div>
		</p>
	</div>
</div>