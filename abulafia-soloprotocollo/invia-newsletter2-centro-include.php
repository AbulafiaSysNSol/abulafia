<?php
session_start(); 
$idlettera= $_GET['id'];
$annoricercaprotocollo=$_SESSION['annoricercaprotocollo'];
$tabella= 'lettere'.$annoricercaprotocollo;
$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");
?>

<div id="primarycontent">
	<div class="post">
		<div class="header"><h3><u>Invio mailing list:</u></h3></div>
		<div class="content">
			<p>
                    
<?php 

$setting=mysql_query("select * from mailsettings");
$setting2=mysql_fetch_array($setting);

$intestazione = $_POST['intestazione'];
$firma = $_POST['firma'];

if ($intestazione != 'intestazione') {
	$headermail = '';
}
else {
	$headermail = $setting2['headermail'].'<br><br><br>';	
}

if ($firma != 'firma') {
	$footermail = '';
}
else {
	$footermail = '<br><br><br>'.$setting2['footermail'];	
}

$mittente = $setting2['mittente'];

//passaggio delle variabili dalla pagina del form
$destinatario = $_POST['destinatario'];
$oggetto = stripslashes($_POST['oggetto']);
$messaggio = stripslashes($_POST['messaggio']);

$mess="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">
<HTML><HEAD>
<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
<STYLE>
H5 {text-align: justify; text-decoration: none; color: #333333; font-size: 12px; font-family: Arial}
A:link, A:visited, A:hover { color: #FFcc00 }

</STYLE>
</HEAD>
<BODY bgColor=#ffffff link=#333333 alink=#333333 vlink=#333333>
<DIV><h5>".$headermail." ".$messaggio." ".$footermail."</h5>
</BODY></HTML>
";

/*Nella variabile $mess va inserito tutto il codice html che comporrà il corpo dell'email che si vuole inviare. Come nell'esempio si possono utilizzare anche i fogli di stile.*/

$e=$destinatario; /*Inserire l'indirizzo email a cui si vuole spedire l'email*/
$ogg=$oggetto; /*Inserire l'oggetto dell'email da spedire*/

$reply = $mittente; /*Inserire l'indirizzo email a cui verranno inviate le risposte all'email inviata*/


$allegato = mysql_query("select distinct * from $tabella where idlettera='$idlettera';");
$allegato = mysql_fetch_array($allegato);
$urlpdf= $allegato['urlpdf'];
$estenzione=explode( ".", $urlpdf);
$elementiurlpdf=count($estenzione);
if ($elementiurlpdf > 1) {
$estenzione2 = $elementiurlpdf-1;
$est3 = $estenzione[$estenzione2];}
else { $estenzione2 = 0; $estenzione ='';}
$titolo='allegato-prot-'.$idlettera.'.'.$est3; /*Inserire il nome che si vuole dare all'allegato*/
$f='lettere'.$annoricercaprotocollo.'/'.$allegato['urlpdf']; /*Inserire l'indirizzo del file che si vuole inviare come allegato*/


$filetype="application/octet-stream"; /*Inserire il formato MIME del file da allegare*/



/*Non modificare nulla al di sotto di questa linea*/

$intestazioni = "From: $mittente\nReply-To: $reply\nX-Mailer: Sismail Web Email Interface\nMIME-version: 1.0\nContent-type: multipart/mixed;\n boundary=\"Message-Boundary\"\nContent-transfer-encoding: 7BIT\nX-attachments: $titolo";

$body_top = "--Message-Boundary\n";
$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
$body_top .= "Content-transfer-encoding: 7BIT\n";
$body_top .= "Content-description: Mail message body\n\n";

$msg_body = $body_top . $mess;

$filez = fopen($f, "r");
$contents = fread($filez, filesize($f));
$encoded_attach = chunk_split(base64_encode($contents));
fclose($filez);

$msg_body .= "\n\n--Message-Boundary\n";
$msg_body .= "Content-type: $filetype; name=\"$titolo\"\n";
$msg_body .= "Content-Transfer-Encoding: BASE64\n";
$msg_body .= "Content-disposition: attachment; filename=\"$titolo\"\n\n";
$msg_body .= "$encoded_attach\n";
$msg_body .= "--Message-Boundary--\n";


//SALVATAGGIO LOG MAIL


if(!(@mail($e,$ogg,$msg_body, $intestazioni)))
{
	print "<H5>Invio della email fallito.</H5>";
	
	$esito= 'FAILED';
} 
else 
{ 
	print"<H5>Invio eseguito con successo.</H5>";
	
	$esito= 'SUCCESSFUL';
} 


$my_log -> publscrivilog($_SESSION['loginname'],'mail' , $esito , 'oggetto '.$ogg.' - prot '.$idlettera.' - destinatari:'.$e, $_SESSION['maillog']);

?>

	</strong> 
</b>
				
			</div>
		</p>
	</div>
</div>
