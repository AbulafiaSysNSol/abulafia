<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><b><i class="fa fa-cog"></i> Impostazioni utente</b></h3>
	</div>
		
	<div class="panel-body">
			
		<?php
		 if( isset($_GET['update']) && $_GET['update'] == "error") {
		?>
		<div class="row">
			<div class="col-xs-12">
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
			<div class="col-xs-12">
				<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Impostazioni utente modificate con <b>successo!</b></div>
			</div>
		</div>
		<?php
		}
		?>

		<div class="form-group">
			<form name="modifica" method="post" >
				<div class="row">
					<div class="col-xs-4">
						<h4><i class="fa fa-image"></i> Logo
						<br><small> Logo visualizzato in alto a destra.</small></h4>
						<table border="0">
							<tr>
								<?php if($_SESSION['splash'] == "images/splash.jpg") { ?>
								<td><input type="radio" name="splash" value="images/splash.jpg" checked="checked"></td><td><img src="images/splash.jpg" width="85%"></td>
								<?php } else{ ?>
								<td><input type="radio" name="splash" value="images/splash.jpg"></td><td><img src="images/splash.jpg" width="85%"></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($_SESSION['splash'] == "images/splash1.jpg") { ?>
								<td><input type="radio" name="splash" value="images/splash1.jpg" checked="checked"></td><td><img src="images/splash1.jpg" width="85%"></td>
								<?php } else{ ?>
								<td><input type="radio" name="splash" value="images/splash1.jpg"></td><td><img src="images/splash1.jpg" width="85%"></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($_SESSION['splash'] == "images/splash2.jpg") { ?>
								<td><input type="radio" name="splash" value="images/splash2.jpg" checked="checked"></td><td><img src="images/splash2.jpg" width="85%"></td>
								<?php } else{ ?>
								<td><input type="radio" name="splash" value="images/splash2.jpg"></td><td><img src="images/splash2.jpg" width="85%"></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($_SESSION['splash'] == "images/splash3.jpg") { ?>
								<td><input type="radio" name="splash" value="images/splash3.jpg" checked="checked"></td><td><img src="images/splash3.jpg" width="85%"></td>
								<?php } else{ ?>
								<td><input type="radio" name="splash" value="images/splash3.jpg"></td><td><img src="images/splash3.jpg" width="85%"></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($_SESSION['splash'] == "images/splash4.jpg") { ?>
								<td><input type="radio" name="splash" value="images/splash4.jpg" checked="checked"></td><td><img src="images/splash4.jpg" width="85%"></td>
								<?php } else{ ?>
								<td><input type="radio" name="splash" value="images/splash4.jpg"></td><td><img src="images/splash4.jpg" width="85%"></td>
								<?php } ?>
							</tr>
							<tr>
								<?php if($_SESSION['splash'] == "images/splash5.jpg") { ?>
								<td><input type="radio" name="splash" value="images/splash5.jpg" checked="checked"></td><td><img src="images/splash5.jpg" width="85%"></td>
								<?php } else{ ?>
								<td><input type="radio" name="splash" value="images/splash5.jpg"></td><td><img src="images/splash5.jpg" width="85%"></td>
								<?php } ?>
							</tr>
						</table>
					</div>
			
					<div class="col-xs-4">
						<h4><i class="fa fa-tint"></i> Primo colore risultati
						<br><small> Primo colore di sfondo nei risultati.</small></h4>
						<table border="0" cellspacing="4">
							<tr height="30" valign="middle">
								<?php if($_SESSION['primocoloretabellarisultati'] == "#FFFFCC") { ?>
								<td><input type="radio" name="color1" value="#FFFFCC" checked="checked"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#FFFFCC"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } ?>
						
								<?php if($_SESSION['primocoloretabellarisultati'] == "#F4A460") { ?>
								<td><input type="radio" name="color1" value="#F4A460" checked="checked"></td><td width="100" bgcolor="#F4A460"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#F4A460"></td><td width="100" bgcolor="#F4A460"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#F0E68C") { ?>
								<td><input type="radio" name="color1" value="#F0E68C" checked="checked"></td><td width="100" bgcolor="#F0E68C"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#F0E68C"></td><td width="100" bgcolor="#F0E68C"></td>
								<?php } ?>
						
							</tr>
							<tr height="30" valign="middle">
								<?php if($_SESSION['primocoloretabellarisultati'] == "#B0E0E6") { ?>
								<td><input type="radio" name="color1" value="#B0E0E6" checked="checked"></td><td width="100" bgcolor="#B0E0E6"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#B0E0E6"></td><td width="100" bgcolor="#B0E0E6"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#DEFEB4") { ?>
								<td><input type="radio" name="color1" value="#DEFEB4" checked="checked"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#DEFEB4"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#FFC0CB") { ?>
								<td><input type="radio" name="color1" value="#FFC0CB" checked="checked"></td><td width="100" bgcolor="#FFC0CB"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#FFC0CB"></td><td width="100" bgcolor="#FFC0CB"></td>
								<?php } ?>
							</tr>
							<tr height="30" valign="middle">
								<?php if($_SESSION['primocoloretabellarisultati'] == "#9ACD32") { ?>
								<td><input type="radio" name="color1" value="#9ACD32" checked="checked"></td><td width="100" bgcolor="#9ACD32"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#9ACD32"></td><td width="100" bgcolor="#9ACD32"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#9999FF") { ?>
								<td><input type="radio" name="color1" value="#9999FF" checked="checked"></td><td width="100" bgcolor="#9999FF"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#9999FF"></td><td width="100" bgcolor="#9999FF"></td>
								<?php } ?>
								
								<?php if($_SESSION['primocoloretabellarisultati'] == "#DEB887") { ?>
								<td><input type="radio" name="color1" value="#DEB887" checked="checked"></td><td width="100" bgcolor="#DEB887"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color1" value="#DEB887"></td><td width="100" bgcolor="#DEB887"></td>
								<?php } ?>
							</tr>
						</table>
						<br>
						<h4><i class="fa fa-tint"></i> Secondo colore risultati
						<br><small> Secondo colore di sfondo nei risultati.</small></h4>
						<table border="0" cellspacing="4">
							<tr height="30" valign="middle">
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#FFFFCC") { ?>
								<td><input type="radio" name="color2" value="#FFFFCC" checked="checked"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#FFFFCC"></td><td width="100" bgcolor="#FFFFCC"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#F4A460") { ?>
								<td><input type="radio" name="color2" value="#F4A460" checked="checked"></td><td width="100" bgcolor="#F4A460"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#F4A460"></td><td width="100" bgcolor="#F4A460"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#F0E68C") { ?>
								<td><input type="radio" name="color2" value="#F0E68C" checked="checked"></td><td width="100" bgcolor="#F0E68C"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#F0E68C"></td><td width="100" bgcolor="#F0E68C"></td>
								<?php } ?>
								
							</tr>
							<tr height="30" valign="middle">
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#B0E0E6") { ?>
								<td><input type="radio" name="color2" value="#B0E0E6" checked="checked"></td><td width="100" bgcolor="#B0E0E6"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#B0E0E6"></td><td width="100" bgcolor="#B0E0E6"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#DEFEB4") { ?>
								<td><input type="radio" name="color2" value="#DEFEB4" checked="checked"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#DEFEB4"></td><td width="100" bgcolor="#DEFEB4"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#FFC0CB") { ?>
								<td><input type="radio" name="color2" value="#FFC0CB" checked="checked"></td><td width="100" bgcolor="#FFC0CB"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#FFC0CB"></td><td width="100" bgcolor="#FFC0CB"></td>
								<?php } ?>
								
							</tr>
							<tr height="30" valign="middle">
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#9ACD32") { ?>
								<td><input type="radio" name="color2" value="#9ACD32" checked="checked"></td><td width="100" bgcolor="#9ACD32"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#9ACD32"></td><td width="100" bgcolor="#9ACD32"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#9999FF") { ?>
								<td><input type="radio" name="color2" value="#9999FF" checked="checked"></td><td width="100" bgcolor="#9999FF"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#9999FF"></td><td width="100" bgcolor="#9999FF"></td>
								<?php } ?>
								
								<?php if($_SESSION['secondocoloretabellarisultati'] == "#DEB887") { ?>
								<td><input type="radio" name="color2" value="#DEB887" checked="checked"></td><td width="100" bgcolor="#DEB887"></td>
								<?php } else{ ?>
								<td><input type="radio" name="color2" value="#DEB887"></td><td width="100" bgcolor="#DEB887"></td>
								<?php } ?>
								
							</tr>
						</table>			
					</div>
				
					<div class="col-xs-4">
						<h4><i class="fa fa-list-ol"></i> Numero di risultati per pagina
						<br><small> N. di record visualizzati nella ricerca.</small></h4>
						<input class="form-control"size="3" type="text" name="risultatiperpagina"  value="<?php echo $_SESSION['risultatiperpagina'];?>"/>
						
						<?php if($_SESSION['auth'] > 98) { ?>
							<br>
							<h4>
								<i class="fa fa-exclamation-circle"></i> Attiva/Disattiva notifiche protocollo
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
				<button class="btn btn-primary" onClick="Controllo()"><span class="glyphicon glyphicon-edit"></span> MODIFICA</button>
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
