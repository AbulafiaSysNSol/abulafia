<?php

$annoprotocollo = $_SESSION['annoprotocollo'];
$loginid= $_SESSION['loginid'];
$data=strftime("%d-%m-%Y /") . ' ' . date("g:i a");

//passaggio delle variabili dalla pagina del form
$destinatario = $_SESSION['email'];
$mittente = $_SESSION['loginname'];
$oggetto = 'Segnalazione bug in '.$_SESSION['nomeapplicativo'];
$messaggio = 'Pagina: '.$_POST['pagina-errore'].' -- Errore: '.$_POST['messaggio'];

$mess=$messaggio;

$e=$destinatario; /*Inserire l'indirizzo email a cui si vuole spedire l'email*/
$ogg=$oggetto; /*Inserire l'oggetto dell'email da spedire*/
$reply=$_SESSION['email']; /*Inserire l'indirizzo email a cui verranno inviate le risposte all'email inviata*/

/*Non modificare nulla al di sotto di questa linea*/

$intestazioni = "From: $mittente\nReply-To: $reply\nX-Mailer: Sismail Web Email Interface\nMIME-version: 1.0\nContent-type: multipart/mixed;\n boundary=\"Message-Boundary\"\nContent-transfer-encoding: 7BIT\nX-attachments: $titolo";

$body_top = "--Message-Boundary\n";
$body_top .= "Content-type: text/html; charset=iso-8859-1\n";
$body_top .= "Content-transfer-encoding: 7BIT\n";
$body_top .= "Content-description: Mail message body\n\n";

$msg_body = $body_top . $mess;

if(!(mail($e,$ogg,$msg_body, $intestazioni))){
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
