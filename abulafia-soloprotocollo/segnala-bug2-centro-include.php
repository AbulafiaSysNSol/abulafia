<?php
$annoprotocollo = $_SESSION['annoprotocollo'];
$loginid= $_SESSION['loginid'];
$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");
?>
	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3><u>Invio segnalazione errore:</u></h3>
				
				</div>
				<div class="content">
					<p>



<?php 

//passaggio delle variabili dalla pagina del form
$destinatario = $_SESSION['email'];
$mittente = $_SESSION['loginname'];
$oggetto = 'Segnalazione bug in '.$_SESSION['nomeapplicativo'];
$messaggio = 'Pagina: '.$_POST['pagina-errore'].' -- Errore: '.$_POST['messaggio'];

$mess=$messaggio;

/*Nella variabile $mess va inserito tutto il codice html che comporrà il corpo dell'email che si vuole inviare. Come nell'esempio si possono utilizzare anche i fogli di stile.*/

$e=$destinatario; /*Inserire l'indirizzo email a cui si vuole spedire l'email*/
$ogg=$oggetto; /*Inserire l'oggetto dell'email da spedire*/
//$mittente="miaemail@email.com"; /*Inserire l'indirizzo email che verrà visulaizzato come mittente dell'email*/
$reply="regionale@pionierisicilia.com"; /*Inserire l'indirizzo email a cui verranno inviate le risposte all'email inviata*/


//$allegato = mysql_query("select distinct * from lettere$annoprotocollo where idlettera='$idlettera';");
//$allegato = mysql_fetch_array($allegato);
//$urlpdf= $allegato['urlpdf'];
//$estenzione=explode( ".", $urlpdf);
//$elementiurlpdf=count($estenzione);
//if ($elementiurlpdf > 1) {
//$estenzione2 = $elementiurlpdf-1;
//$est3 = $estenzione[$estenzione2];}
//else { $estenzione2 = 0; $estenzione ='';}
//$titolo='allegato-prot-'.$idlettera.'.'.$est3; /*Inserire il nome che si vuole dare all'allegato*/
//$f='lettere$annoprotocollo/'.$allegato['urlpdf']; /*Inserire l'indirizzo del file che si vuole inviare come allegato*/


//$filetype="application/octet-stream"; /*Inserire il formato MIME del file da allegare*/



/*Non modificare nulla al di sotto di questa linea*/

$intestazioni = "From: $mittente\nReply-To: $reply\nX-Mailer: Sismail Web Email Interface\nMIME-version: 1.0\nContent-type: multipart/mixed;\n boundary=\"Message-Boundary\"\nContent-transfer-encoding: 7BIT\nX-attachments: $titolo";

$body_top = "--Message-Boundary\n";
$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
$body_top .= "Content-transfer-encoding: 7BIT\n";
$body_top .= "Content-description: Mail message body\n\n";

$msg_body = $body_top . $mess;

//$filez = fopen($f, "r");
//$contents = fread($filez, filesize($f));
//$encoded_attach = chunk_split(base64_encode($contents));
//fclose($filez);

//$msg_body .= "\n\n--Message-Boundary\n";
//$msg_body .= "Content-type: $filetype; name=\"$titolo\"\n";
//$msg_body .= "Content-Transfer-Encoding: BASE64\n";
//$msg_body .= "Content-disposition: attachment; filename=\"$titolo\"\n\n";
//$msg_body .= "$encoded_attach\n";
//$msg_body .= "--Message-Boundary--\n";

if(!(@mail($e,$ogg,$msg_body, $intestazioni))){
print "<H5>Invio della email fallito.</H5>";
	$esito= 'FAILED';
	} 
else { print"<H5>Invio eseguito con successo.</H5>";
	$esito= 'SUCCESSFUL';
	} 


$my_log -> publscrivilog($_SESSION['loginname'],'bug report' , $esito ,'Pagina: '.$_POST['pagina-errore'], $_SESSION['maillog']);


echo 'Pagina: '.$_POST['pagina-errore'].' <br>Errore: '.$_POST['messaggio'];?>

</strong> 
</b>
</p>


</div>

</p></div>
					
		
	
			
			<!-- post end -->


		</div>
