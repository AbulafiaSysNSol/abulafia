<?php

	$my_lettera = unserialize($_SESSION['my_lettera']); //carica l'oggetto 'lettera'
	$my_file = new File();
	$anagrafica = new Anagrafica();
	include('lib/phpmailer/PHPMailerAutoload.php');
	$date=strftime("%d/%m/%Y");
	$ora = date("g:i a");
	$datamail = $date . ' alle ' . $ora;
	
	$annoprotocollo = $_SESSION['annoprotocollo'];
	//inizio passaggio dati da pagina inserimento
	$loginid=$_SESSION['loginid'];

	if(isset($_GET['dataoriginalegiorno'])) { 
		$dataoriginalegiorno= $_GET['dataoriginalegiorno']; 
	}
	if(isset($_GET['dataoriginalemese'])) { 
		$dataoriginalemese = $_GET['dataoriginalemese']; 
	}
	if(isset($_GET['dataoriginaleanno'])) { 
		$dataoriginaleanno= $_GET['dataoriginaleanno']; 
	}
	if(isset($_GET['from'])) { 
		$from = $_GET['from']; 
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
			else window.location="login0.php?corpus=protocollo2&idlettera=<?php echo $idlettera;?>&from=errore";
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
	
	$speditaricevuta = $_POST['spedita-ricevuta'];
	$oggetto= $_POST['oggetto'];
	$data = $_POST['data'];
	$lettera_data_giorno = 0;
	$lettera_data_mese = 0;
	$lettera_data_anno = 0;
	$arraydata = explode("/", $data);
	if( isset($arraydata[0]) ) { 
		$lettera_data_giorno = $arraydata[0]; 
	}
	if( isset($arraydata[1]) ) { 
		$lettera_data_mese = $arraydata[1]; 
	}
	if( isset($arraydata[2]) ) { 
		$lettera_data_anno = $arraydata[2]; 
	}
	$posizione = $_POST['posizione'];
	$riferimento = $_POST['riferimento'];
	$pratica = $_POST['pratica'];
	$note  = $_POST['note'];
	$dataregistrazione = strftime("%Y-%m-%d");
	list($anno, $mese, $giorno) = explode("-", $dataregistrazione);
	$dataregistrazione2= $anno.'-'.$mese.'-'.$giorno;
	if (isset($from) && $from =='modifica') { 
		$dataregistrazione = $dataoriginaleanno.'-'.$dataoriginalemese.'-'.$dataoriginalegiorno; 
	}
	$lettera_data = $lettera_data_anno . '-' . $lettera_data_mese . '-' . $lettera_data_giorno   ;
	$loginid = $_SESSION['loginid'];
	$auth = $_SESSION['auth'] ;
	//fine passaggio dati

	//controllo esistenza
	$inserimento = mysql_query("insert
				into lettere$annoprotocollo
				values
				('', 
				'$oggetto',
				'$lettera_data',
				'$dataregistrazione',
				'',
				'$speditaricevuta', 
				'$posizione', 
				'$riferimento', 
				'$pratica', 
				'$note')
				");
	echo  mysql_error();
	
	$ultimoid = mysql_insert_id();
	foreach ($my_lettera->arraymittenti as $key => $value)
		{
		$inserimento= mysql_query("insert
					into joinletteremittenti$annoprotocollo
					values
					('$ultimoid',
					'$key'
					)");
		echo  mysql_error();echo $key;
		}
		
	foreach ($my_lettera->arrayallegati as $key => $value)
		{
		$inserimento= mysql_query("insert
					into joinlettereallegati
					values
					(
					'$ultimoid',
					'$annoprotocollo',
					'$key')
					");
		if (!is_dir("lettere$annoprotocollo/".$ultimoid)) { //se non esiste una directory con il l'id della lettera, 
								//la crea per ospitare gli allegati
								mkdir("lettere$annoprotocollo/".$ultimoid, 0777, true);
								}
		rename($value, "lettere$annoprotocollo".'/'.$ultimoid.'/'.$key);
		}
	
	if ( (!$inserimento) && ($from == 'modifica') ) { 
		echo "Modifica non riuscita" ; 
		$my_log -> publscrivilog( $_SESSION['loginname'], 
					'TENTATA MODIFICA LETTERA '. $idlettera , 
					'FAILED' , 
					'' , 
					$_SESSION['historylog']);
	}
	if ( (!$inserimento) && ($from != 'modifica') ) { 
		echo "Inserimento non riuscito" ; 
		$my_log -> publscrivilog( $_SESSION['loginname'], 
					'TENTATA REGISTRAZIONE LETTERA '. $ultimoid, 
					'FAILED' , 
					'' , 
					$_SESSION['historylog']);
	}
	if ( ($inserimento) && ($from == 'modifica') ) {
		
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
			//scrittura history log
		}
		
		$my_log -> publscrivilog( $_SESSION['loginname'], 
					'MODIFICATA LETTERA '. 
					$idlettera , 
					'OK' , 
					'' , 
					$_SESSION['historylog']);
	}
	if ( ($inserimento) && ($from != 'modifica') ) { 
		
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
		$my_log -> publscrivilog( $_SESSION['loginname'], 'REGISTRATA LETTERA '. $idlettera , 'OK' , '' , $_SESSION['historylog']);
	}
	
	$ultimoid = mysql_insert_id();
	$modifica =mysql_query("update 
				joinlettereinserimento$annoprotocollo 
				set 
				joinlettereinserimento$annoprotocollo.idmod='$loginid', 
				joinlettereinserimento$annoprotocollo.datamod='$dataregistrazione2' 
				where 
				joinlettereinserimento$annoprotocollo.idlettera='$idlettera' 
				limit 1");
	echo  mysql_error();
	
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
				$my_lettera -> publdisplaylettera ($_GET['idlettera'], $annoprotocollo); //richiamo del metodo "mostra"
			?>
		</div>
		
		<div class="col-xs-5">
			<h4><i class="fa fa-cog"></i> Opzioni:</h4>
			<p>	<a href="login0.php?corpus=protocollo2
					&from=crea" 
					onClick="return confirm('ATTENZIONE: OPERAZIONE NON REVERSIBILE\n\nCreare nuovo numero di protocollo?');">
					<i class="fa fa-plus-square"></i> 
					Registrazione nuovo protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=modifica-protocollo
					&from=risultati
					&id=<?php echo $idlettera;?>"> 
					<span class="glyphicon glyphicon-edit">
					</span> 
					Modifica questo protocollo
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=invia-newsletter
					&id=<?php echo $idlettera;?>
					&anno=<?php echo $annoprotocollo;?>"> 
					<span class="glyphicon glyphicon-envelope">
					</span> 
					Invia tramite email
				</a>
			</p>
			<p>
				<a href="login0.php?corpus=aggiungi-inoltro
				&id=<?php echo $idlettera;?>
				&anno=<?php echo $annoprotocollo;?>"> 
				<span class="glyphicon glyphicon-pencil">
				</span> 
				Aggiungi inoltro email manuale
				</a>
			</p>	
			<a href="stampa-protocollo.php?id=<?php echo $idlettera; ?>
				&anno=<?php echo $anno; ?>" 
				target="_blank">
				<i class="fa fa-print">
				</i> 
				Stampa ricevuta Protocollo
			</a>
		</div>
	</div>
  </div>
  </div>
