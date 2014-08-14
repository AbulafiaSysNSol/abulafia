<?php

	$my_lettera = unserialize($_SESSION['my_lettera']); //carica l'oggetto 'lettera'
	
	//CREAZIONE NUOVI OGGETTI
	$my_file = new File();
	$anagrafica = new Anagrafica();
	$calendario = new Calendario();
	
	//LIBRERIA PER L'INVIO DI EMAIL
	include('lib/phpmailer/PHPMailerAutoload.php');
	$date=strftime("%d/%m/%Y");
	$ora = date("g:i a");
	$datamail = $date . ' alle ' . $ora;

	//RECUPERO VARIABILE FROM DAL GET
	if(isset($_GET['from'])) { 
		$from = $_GET['from']; 
		$idlettera = $_GET['idlettera'];
	}
	else {
		$from='';
	}
	
	// CONTROLLO SE E' STATO INSERITO ALMENO UN MITTENTO O UN DESTINATARIO
	if (count($my_lettera->arraymittenti) < 1) { 
		$_SESSION['spedita-ricevuta'] = $_POST['spedita-ricevuta'];
		$_SESSION['oggetto'] = $_POST['oggetto'];
		$_SESSION['data'] = $_POST['data'];
		$_SESSION['posizione'] = $_POST['posizione'];
		$_SESSION['riferimento'] = $_POST['riferimento'];
		$_SESSION['pratica'] = $_POST['pratica'];
		$_SESSION['note'] = $_POST['note'];
		
		//RITORNO ALLA PAGINA DI REGISTRAZIONE  O DI MODIFICA SE NON E' STATO INSERITO NEMMENO UN MITTENTO O UN DESTISTARIO
		if($from != "modifica") {
		$_SESSION['my_lettera']=serialize ($my_lettera);
		?>
	
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&from=errore"; 
			else window.location="login0.php?corpus=protocollo2&from=errore";
			</SCRIPT>
			<?php
			exit();
		}
		else {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-protocollo
					&from=errore
					&tabella=protocollo
					&id=<?php echo $idlettera;?>"; 
			else window.location="login0.php?corpus=modifica-protocollo
						&from=errore
						&tabella=protocollo
						&id=<?php echo $idlettera;?>";
			</SCRIPT>
			<?php
			exit();
		}
	}
	// FINE CONTROLLO MITTENTI/DESTINATARI
	
	//VARIABILI DI SESSIONI
	$annoprotocollo = $_SESSION['annoprotocollo'];
	$loginid=$_SESSION['loginid'];
	
	//ACQUISISCO I DATI DAL FORM
	$speditaricevuta = $_POST['spedita-ricevuta'];
	$oggetto= $_POST['oggetto'];
	$datalettera = $calendario->dataDB($_POST['data']);
	$posizione = $_POST['posizione'];
	$riferimento = $_POST['riferimento'];
	$pratica = $_POST['pratica'];
	$note  = $_POST['note'];
	$dataregistrazione = strftime("%Y-%m-%d");
	$loginid = $_SESSION['loginid'];
	$auth = $_SESSION['auth'] ;
	//FINE ACQUISIZIONE DATI

	
	//INSERISCO I DATI NEL DATABASE SE IL FROM E' DIVERSO DA MODIFICA
	if($from != 'modifica') {
	
		//SCRIVO I DETTAGLI DELLA LETTERA NEL DB
		$inserimento = mysql_query("insert 
					into lettere$annoprotocollo
					values
					('', 
					'$oggetto',
					'$datalettera',
					'$dataregistrazione',
					'',
					'$speditaricevuta', 
					'$posizione', 
					'$riferimento', 
					'$pratica', 
					'$note')
					");
		
		$ultimoid = mysql_insert_id();
		
		//SCRIVO L'UTENTE CHE HA FATTO L'INSERIMENTO
		$utentemod =mysql_query("	INSERT INTO 
								joinlettereinserimento$annoprotocollo 
							VALUES ( 
								'$ultimoid',
								'$loginid',
								'$loginid',
								'$dataregistrazione'
							)
						");
		
		//SCRIVO I MITTENTI/DESTINATARI NEL DB
		foreach ($my_lettera->arraymittenti as $key => $value) { //inserisce i dati dei mittenti nel db
			$inserimento1= mysql_query("insert
						into joinletteremittenti$annoprotocollo
						values
						('$ultimoid',
						'$key'
						)");
			echo  mysql_error();
		}
		
		//SCRIVO GLI ALLEGATI NEL DB
		foreach ($my_lettera->arrayallegati as $key => $value) { //inserisce i dati degli allegati nel db e provvede a spostare i file dalla dir temp
			$inserimento2= mysql_query("insert
						into joinlettereallegati
						values
						(
						'$ultimoid',
						'$annoprotocollo',
						'$key')
						");
			echo  mysql_error();
			if (!is_dir("lettere$annoprotocollo/".$ultimoid)) { //se non esiste una directory con il l'id della lettera, 
									//la crea per ospitare gli allegati
									mkdir("lettere$annoprotocollo/".$ultimoid, 0777, true);
									}
			rename($value, "lettere$annoprotocollo".'/'.$ultimoid.'/'.$key);
		}
		
		//CREO IL QRCODE NELLA DIRECTORY LETTEREANNO/QRCODE
		include('lib/qrcode/qrlib.php');
		$id = $ultimoid;
		$anno = $annoprotocollo;
		
		if (!is_dir('lettere'.$anno.'/qrcode/')) {
			$creadir=mkdir('lettere'.$anno.'/qrcode/', 0777, true);
			if (!$creadir) die ("Impossibile creare la directory: qrcode/");
		}
		
		$pathqrcode = 'lettere'.$anno.'/qrcode/'.$id.$anno.'.png';
		$param = 'Protocollo n° '.$id.' del '.$dataregistrazione;
		$codeText = $param; 
		$debugLog = ob_get_contents(); 
		QRcode::png($codeText, $pathqrcode);
		
		//SE L'INSERIMENTO NON VA A BUON FINE SCRIVO NEL LOG L'ERRORE
		if ( (!$inserimento || !$inserimento1) ) { 
			echo "Inserimento non riuscito" ; 
			$my_log -> publscrivilog( 	$_SESSION['loginname'], 
								'TENTATA REGISTRAZIONE LETTERA '. $ultimoid, 
								'FAILED' , 
								'' , 
								$_SESSION['historylog']
							);
		}
		
		//SE L'INSERIMENTO VA A BUON FINE SCRIVO NEL LOG E SE SONO ATTIVE LE NOTIFICHE MANDO EMAIL
		else { 
			$indirizzi = $anagrafica->getNotificationsIns();
			if ($indirizzi) {
				//invio notifica
				$mail = new PHPMailer();
				$mail->From = 'no-reply@cricatania.it';
				$mail->FromName = 'Abulafia';
				$mail->isHTML(true);
				include "../mail-conf-include.php";
				foreach ($indirizzi as $email) {
					$mail->addAddress($email[0]);
				}
				$mail->Subject = 'Notifica registrazione nuova lettera in ' . $_SESSION['nomeapplicativo'];
				$mail->Body    = 'Con la presente si notifica l\'avvenuta registrazione della lettera n. <b>' . $idlettera . 
							'</b> avente come oggetto: <b>"'. $oggetto . '"</b>.<br>
							Inserimento effettuato da <b>' . $_SESSION['loginname'] 
							. '</b> il giorno ' . $datamail . '.<br><br>
							Messaggio automatico inviato da ' . $_SESSION['nomeapplicativo'] 
							.'.<br>Non rispondere a questa email.';
				$esito = $mail->send();
				//scrittura log mail
				$my_log -> publscrivilog($_SESSION['loginname'],
							'send notifications' , 
							$esito ,
							'notifica automatica - inserisci lettera', 
							$_SESSION['maillog']);
			}
			//scrittura history log		
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'REGISTRATA LETTERA '. $ultimoid , 
						'OK' , 
						'' , 
						$_SESSION['historylog']);
		}
	}
	
	if($from == 'modifica') {
	
		$idlettera = $_GET['idlettera'];
		$modifica = mysql_query("	UPDATE 
								lettere$annoprotocollo 
							SET 
								speditaricevuta = '$speditaricevuta', 
								oggetto = '$oggetto',
								datalettera = '$datalettera',
								posizione = '$posizione',
								riferimento = '$riferimento',
								pratica = '$pratica',
								note = '$note'
							WHERE 
								lettere$annoprotocollo.idlettera='$idlettera' 
							LIMIT 1
						");
		echo mysql_error();
		
		$date=strftime("%Y-%m-%d");
		//AGGIORNO L'UTENTE CHE HA FATTO LA MODIFICA
		$utentemod =mysql_query("	UPDATE 
								joinlettereinserimento$annoprotocollo 
							SET 
								joinlettereinserimento$annoprotocollo.idmod='$loginid', 
								joinlettereinserimento$annoprotocollo.datamod='$date' 
							WHERE 
								joinlettereinserimento$annoprotocollo.idlettera='$idlettera' 
							LIMIT 1
						");
	
		//SE LA MODIFICA NON E' ANDATA A BUON FINE SCRIVO L'ERRORE NEL LOG
		if (!$modifica) { 
			echo "Modifica non riuscita" ; 
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'TENTATA MODIFICA LETTERA '. $idlettera , 
						'FAILED' , 
						'' , 
						$_SESSION['historylog']);
		}
		
		//SE LA MODIFICA E' ANDATA A BUON FINE SCRIVO NEL LOG E SE LE NOTIFICHE SONO ATTIVE MANDO L'EMAIL
		else {
			$indirizzi = $anagrafica->getNotificationsMod();
			if ($indirizzi) {
				//invio notifica
				$mail = new PHPMailer();
				$mail->From = 'no-reply@cricatania.it';
				$mail->FromName = 'Abulafia';
				$mail->isHTML(true);
				include "../mail-conf-include.php";
				foreach ($indirizzi as $email) {
					$mail->addAddress($email[0]);
				}
				$mail->Subject = 'Notifica modifica lettera in ' . $_SESSION['nomeapplicativo'];
				$mail->Body    = 'Con la presente si notifica la modifica della lettera n. <b>' . $idlettera . 
							'</b> avente come oggetto: <b>"'. $oggetto . '"</b>.<br>
							Modifica effettuata da <b>' . $_SESSION['loginname'] 
							. '</b> il giorno ' . $datamail . '<br><br>
							Messaggio automatico inviato da ' . $_SESSION['nomeapplicativo'] 
							.'.<br>Non rispondere a questa email.';
				$esito = $mail->send();
				//scrittura log mail
				$my_log -> publscrivilog($_SESSION['loginname'],
							'send notifications' , 
							$esito ,'notifica automatica - modifica lettera', 
							$_SESSION['maillog']);
			}
			
			//scrittura history log
			$my_log -> publscrivilog( $_SESSION['loginname'], 
						'MODIFICATA LETTERA '. 
						$idlettera , 
						'OK' , 
						'' , 
						$_SESSION['historylog']);
			
			$ultimoid= $idlettera;
		}
	}
	
	//RESET VARIABILI DI SESSIONE 
	unset($_SESSION['spedita-ricevuta']);
	unset($_SESSION['oggetto']);
	unset($_SESSION['data']);
	unset($_SESSION['posizione']);
	unset($_SESSION['riferimento']);
	unset($_SESSION['pratica']);
	unset($_SESSION['note']);
?>


<div class="panel panel-default">
  <div class="panel-body">
   
	<div class="row">
		<div class="col-xs-12">
			<?php
			if($from != "modifica") {
				?>
				<div class="alert alert-success">
					<span class="glyphicon glyphicon-ok">
					</span> 
					Protocollo registrato <b>correttamente.</b>
				</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-success">
					<span class="glyphicon glyphicon-ok">
					</span> 
					Protocollo modificato <b>correttamente.</b>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-5">
			<h4><i class="fa fa-list"></i> Riepilogo:</h4>
			<?php 
				$my_lettera -> publdisplaylettera ($ultimoid, $annoprotocollo); //richiamo del metodo "mostra"
			?>
		</div>
		
		<div class="col-xs-5">
			<h4><i class="fa fa-cog"></i> Opzioni:</h4>
			<p>	<a href="login0.php?corpus=protocollo2
					&from=crea">
					<i class="fa fa-plus-square"></i> 
					Registrazione nuovo protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=modifica-protocollo
					&from=risultati
					&id=<?php echo $ultimoid;?>"> 
					<span class="glyphicon glyphicon-edit">
					</span> 
					Modifica questo protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=invia-newsletter
					&id=<?php echo $ultimoid;?>
					&anno=<?php echo $annoprotocollo;?>"> 
					<span class="glyphicon glyphicon-envelope">
					</span> 
					Invia tramite email
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=aggiungi-inoltro
				&id=<?php echo $ultimoid;?>
				&anno=<?php echo $annoprotocollo;?>"> 
				<span class="glyphicon glyphicon-pencil">
				</span> 
				Aggiungi inoltro email manuale
				</a>
			</p>	
			<a href="stampa-protocollo.php?id=<?php echo $ultimoid; ?>
				&anno=<?php echo $annoprotocollo; ?>"
				target="_blank">
				<i class="fa fa-print">
				</i> 
				Stampa ricevuta Protocollo
			</a>
		</div>
	</div>
  </div>
</div>
