<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-cog"></i> Impostazioni utente</b></h3>
	</div>
		
	<div class="panel-body">
			
		<?php
		 if( isset($_GET['update']) && $_GET['update'] == "error") {
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <b>Attenzione:</b> c'e' stato un errore nella modifica delle impostazioni, riprova in seguito o contatta l'amministratore del server.</div>
			</div>
		</div>
		<?php
		}
		?>
			
		<?php
		 if( isset($_GET['update']) && $_GET['update'] == "success") {
		?>
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Impostazioni utente modificate con <b>successo!</b></div>
			</div>
		</div>
		<?php
		}
		?>

		<div class="form-group">
			<form name="modifica" method="post" >
				<div class="row">
					<div class="col-sm-4">
						<h4><i class="fa fa-tint"></i> Primo Colore Risultati
						<br><small> Primo colore di sfondo nei risultati.</small></h4>
						<table border="0" style="border-collapse:separate; border-spacing:5px 10px;">
							<tr height="50">
								<?php if($_SESSION['primocoloretabellarisultati'] == "#FFFFCC") { ?>
								<td><input type="radio" name="color1" value="#FFFFCC" checked="checked"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#FFFFCC"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } ?>
						
								<?php if($_SESSION['primocoloretabellarisultati'] == "#d8e2f8") { ?>
								<td><input type="radio" name="color1" value="#d8e2f8" checked="checked"></td><td width="100" bgcolor="#d8e2f8"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#d8e2f8"></td><td width="100" bgcolor="#d8e2f8"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#dbf9d6") { ?>
								<td><input type="radio" name="color1" value="#dbf9d6" checked="checked"></td><td width="100" bgcolor="#dbf9d6"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#dbf9d6"></td><td width="100" bgcolor="#dbf9d6"></td>
								<?php } ?>
						
							</tr>
							<tr height="50">
								<?php if($_SESSION['primocoloretabellarisultati'] == "#fde6c8") { ?>
								<td><input type="radio" name="color1" value="#fde6c8" checked="checked"></td><td width="100" bgcolor="#fde6c8"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#fde6c8"></td><td width="100" bgcolor="#fde6c8"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#DEFEB4") { ?>
								<td><input type="radio" name="color1" value="#DEFEB4" checked="checked"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#DEFEB4"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#fbe0f4") { ?>
								<td><input type="radio" name="color1" value="#fbe0f4" checked="checked"></td><td width="100" bgcolor="#fbe0f4"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#fbe0f4"></td><td width="100" bgcolor="#fbe0f4"></td>
								<?php } ?>
							</tr>
							<tr height="50">
								<?php if($_SESSION['primocoloretabellarisultati'] == "#efeeee") { ?>
								<td><input type="radio" name="color1" value="#efeeee" checked="checked"></td><td width="100" bgcolor="#efeeee"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#efeeee"></td><td width="100" bgcolor="#efeeee"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#d9d8d8") { ?>
								<td><input type="radio" name="color1" value="#d9d8d8" checked="checked"></td><td width="100" bgcolor="#d9d8d8"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#d9d8d8"></td><td width="100" bgcolor="#d9d8d8"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#ffffff") { ?>
								<td><input type="radio" name="color1" value="#ffffff" checked="checked"></td><td width="100" bgcolor="#ffffff"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#ffffff"></td><td width="100" bgcolor="#ffffff"></td>
								<?php } ?>
							</tr>
						</table>
					</div>
					<div class="col-sm-4">
						<h4><i class="fa fa-tint"></i> Secondo Colore Risultati
						<br><small> Secondo colore di sfondo nei risultati.</small></h4>
						<table border="0" style="border-collapse:separate; border-spacing:5px 10px;">
							<tr height="50" valign="middle">
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#FFFFCC") { ?>
								<td><input type="radio" name="color2" value="#FFFFCC" checked="checked"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#FFFFCC"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#d8e2f8") { ?>
								<td><input type="radio" name="color2" value="#d8e2f8" checked="checked"></td><td width="100" bgcolor="#d8e2f8"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#d8e2f8"></td><td width="100" bgcolor="#d8e2f8"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#dbf9d6") { ?>
								<td><input type="radio" name="color2" value="#dbf9d6" checked="checked"></td><td width="100" bgcolor="#dbf9d6"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#dbf9d6"></td><td width="100" bgcolor="#dbf9d6"></td>
								<?php } ?>
								
							</tr>
							<tr height="50" valign="middle">
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#fde6c8") { ?>
								<td><input type="radio" name="color2" value="#fde6c8" checked="checked"></td><td width="100" bgcolor="#fde6c8"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#fde6c8"></td><td width="100" bgcolor="#fde6c8"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#DEFEB4") { ?>
								<td><input type="radio" name="color2" value="#DEFEB4" checked="checked"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#DEFEB4"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#fbe0f4") { ?>
								<td><input type="radio" name="color2" value="#fbe0f4" checked="checked"></td><td width="100" bgcolor="#fbe0f4"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#fbe0f4"></td><td width="100" bgcolor="#fbe0f4"></td>
								<?php } ?>
								
							</tr>
							<tr height="50" valign="middle">
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#efeeee") { ?>
								<td><input type="radio" name="color2" value="#efeeee" checked="checked"></td><td width="100" bgcolor="#efeeee"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#efeeee"></td><td width="100" bgcolor="#efeeee"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#d9d8d8") { ?>
								<td><input type="radio" name="color2" value="#d9d8d8" checked="checked"></td><td width="100" bgcolor="#d9d8d8"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#d9d8d8"></td><td width="100" bgcolor="#d9d8d8"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#ffffff") { ?>
								<td><input type="radio" name="color2" value="#ffffff" checked="checked"></td><td width="100" bgcolor="#ffffff"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#ffffff"></td><td width="100" bgcolor="#ffffff"></td>
								<?php } ?>
								
							</tr>
						</table>			
					</div>
				
					<div class="col-sm-4">
						<h4><i class="fa fa-list-ol"></i> Numero di Risultati per Pagina
						<br><small> N. di record visualizzati nella ricerca.</small></h4>
						<input class="form-control" size="3" type="text" name="risultatiperpagina" value="<?php echo $_SESSION['risultatiperpagina'];?>"/>
						
						<?php if($_SESSION['auth'] >= 95) { ?>
							<br>
							<h4>
								<i class="fa fa-exclamation-circle"></i> Attiva/Disattiva Notifiche Protocollo
								<br><small> Notifiche via email.</small>
							</h4>
							<div class="row">
							<div class="col-md-11 col-md-offset-1">
							<ul>
								<li>
									Inserimento nuovo protocollo: <br>
									<input type="radio" name="ins" value="1" <?php if($_SESSION['notificains']) echo 'checked'; ?>> attiva
									&nbsp &nbsp &nbsp &nbsp
									<input type="radio" name="ins" value="0" <?php if(!$_SESSION['notificains']) echo 'checked'; ?>> disattiva
								</li>
								<br>
								<li>
									Modifica protocollo:<br>
									<input type="radio" name="mod" value="1" <?php if($_SESSION['notificamod']) echo 'checked'; ?>> attiva
									&nbsp &nbsp &nbsp &nbsp
									<input type="radio" name="mod" value="0" <?php if(!$_SESSION['notificamod']) echo 'checked'; ?>> disattiva
								</li>
							</ul>
							</div>
							</div>
						<?php } ?>
					</div>
				
				</div>
				<br>
				<center><button class="btn btn-success btn-lg" onClick="Controllo()"><i class="fa fa-save"></i> SALVA IMPOSTAZIONI</button></center>
			</form>
		</div>
	</div>
</div>


<script language="javascript">
 <!--
  function Controllo() 
  {
	//acquisisco il valore delle variabili
	
	var risultatiperpagina = document.modifica.risultatiperpagina.value;
	
	var colore1 = document.modifica.color1;
	for(var i=0; i<colore1.length; i++) 
	{
		if(colore1[i].checked) 
		{
			var colors1 = colore1[i].value;
			break;
		}
	}
	
	var colore2 = document.modifica.color2;
	for(var i=0; i<colore2.length; i++) 
	{
		if(colore2[i].checked) 
		{
			var colors2 = colore2[i].value;
			break;
		}
	}

	if ((risultatiperpagina == "") || (risultatiperpagina == "undefined")) 
	{
           alert("Il campo Risultati per Pagina è obbligatorio");
           document.modifica.risultatiperpagina.focus();
           return false;
      }

	else if ((risultatiperpagina < 3) || (risultatiperpagina > 100)) 
	{
           alert("Il campo Risultati per Pagina deve essere compreso fra 3 e 100");
           document.modifica.risultatiperpagina.focus();
           return false;
        }
	else if (isNaN(risultatiperpagina))
	{
           alert("Il campo Risultati per Pagina deve essere un numero");
           document.modifica.risultatiperpagina.focus();
           return false;
        }
	
	//mando i dati alla pagina
	else 
	{	
		if(colors1 != colors2)
		{
			document.modifica.action = "login0.php?corpus=settings2&id=<?php echo $_SESSION['loginid'];?>";
			document.modifica.submit();
		}
		else
		{
			if(confirm('Attenzione hai scelto due colori uguali, la leggibilità dei risultati potrebbe essere poco chiara.\nContinuare?'))
			{
				document.modifica.action = "login0.php?corpus=settings2&id=<?php echo $_SESSION['loginid'];?>";
				document.modifica.submit();
			}
			else
			{
				return false;
			}
		}
      }
  }
 //-->
</script> 
