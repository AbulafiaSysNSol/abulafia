<?php

$id = $_GET['id'];
$risultati_per_pagina = $_POST['risultatiperpagina'];
$splash = $_POST['splash'];
$color1 = $_POST['color1'];
$color2 = $_POST['color2'];
$annoprotocollo=$_SESSION['annoprotocollo'];
$altro='';
$fototargetpath=$_SESSION['fototargetpath'];
$larghezzatabellarisultati= $_SESSION['larghezzatabellarisultati'];
$protocollomaxfilesize=$_SESSION['protocollomaxfilesize'];
$fotomaxfilesize = $_SESSION['fotomaxfilesize'];
$nomeapplicativo= $_SESSION['nomeapplicativo'];
$email= $_SESSION['email'];
$version= $_SESSION['version'];
$host= $_SESSION['host'];
$paginaprincipale=$_SESSION['paginaprincipale'];
$titolopagina= $_SESSION['titolopagina'];
$keywords= $_SESSION['keywords'] ;
$description= $_SESSION['description'];
$headercescription= $_SESSION['headerdescription'];

//controllo esistenza profilo delle preferenze in defaultsettings
$esistenzacolonnadefaultsettings= mysql_query("select count(*) from defaultsettings where idanagrafica='$id'");

$res_esistenzacolonnadefaultsettings = mysql_fetch_row($esistenzacolonnadefaultsettings);//fine controllo

if ($res_esistenzacolonnadefaultsettings[0] == 0) { 
$inserimento=mysql_query("insert into defaultsettings values('$id', '$risultati_per_pagina', '$annoprotocollo', '$altro','$fototargetpath', '$splash', '$color2', '$color1',  '$larghezzatabellarisultati', '$protocollomaxfilesize', '$fotomaxfilesize', '$nomeapplicativo', '$email' , '$version', '$host', '$paginaprincipale', '$titolopagina', '$keywords', '$description', '$headercescription')");
if (!$inserimento) {echo 'Impossibile compiere l\'azione richiesta'; echo mysql_error(); exit();}

}


$update=mysql_query("update defaultsettings set risultatiperpagina='$risultati_per_pagina' , splash='$splash' , primocoloretabellarisultati='$color1' , secondocoloretabellarisultati='$color2' where idanagrafica='$id'");
if (!$update) {
?>
<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=settings&update=error"; else window.location="login0.php?corpus=settings&update=error"
</SCRIPT>
<?php
}

else 
{
	$_SESSION['risultatiperpagina'] = $risultati_per_pagina;
	$_SESSION['splash'] = $splash;
	$_SESSION['primocoloretabellarisultati'] = $color1;
	$_SESSION['secondocoloretabellarisultati'] = $color2;
}

?>

<SCRIPT LANGUAGE="Javascript">
browser= navigator.appName;
if (browser == "Netscape")
window.location="login0.php?corpus=settings&update=success"; else window.location="login0.php?corpus=settings&update=success"
</SCRIPT>
