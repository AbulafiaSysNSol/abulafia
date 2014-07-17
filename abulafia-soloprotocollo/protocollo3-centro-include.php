<?php
	$annoprotocollo = $_SESSION['annoprotocollo'];
	//inizio passaggio dati da pagina inserimento
	$loginid=$_SESSION['loginid'];
	$idlettera=$_GET['idlettera'];
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
	$conteggiomittenti=mysql_query("select count(*) from joinletteremittenti$annoprotocollo where idlettera='$idlettera'"); 
	$conteggiomittenti2 = mysql_fetch_row($conteggiomittenti);
	if ($conteggiomittenti2[0] < 1) { 
		$_SESSION['spedita-ricevuta'] = $_POST['spedita-ricevuta'];
		$_SESSION['oggetto'] = $_POST['oggetto'];
		$_SESSION['data'] = $_POST['data'];
		$_SESSION['posizione'] = $_POST['posizione'];
		$_SESSION['riferimento'] = $_POST['riferimento'];
		$_SESSION['pratica'] = $_POST['pratica'];
		$_SESSION['note'] = $_POST['note'];
		
		//RITORNO ALLA PAGINA DI REGISTRAZIONE  O DI MODIFICA SE NON E' STATO INSERITO NEMMENO UN MITTENTO O UN DESISTARIO
		if($from != "modifica") {
		?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=protocollo2&idlettera=<?php echo $idlettera;?>&from=errore"; else window.location="login0.php?corpus=protocollo2&idlettera=<?php echo $idlettera;?>&from=errore";
			</SCRIPT>
			<?php
			exit();
		}
		else {
			?>
			<SCRIPT LANGUAGE="Javascript">
			browser= navigator.appName;
			if (browser == "Netscape")
			window.location="login0.php?corpus=modifica-protocollo&from=errore&tabella=protocollo&id=<?php echo $idlettera;?>"; else window.location="login0.php?corpus=modifica-protocollo&from=errore&tabella=protocollo&id=<?php echo $idlettera;?>";
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
	$inserimento = mysql_query("UPDATE lettere$annoprotocollo set lettere$annoprotocollo.speditaricevuta ='$speditaricevuta', lettere$annoprotocollo.oggetto ='$oggetto', lettere$annoprotocollo.datalettera='$lettera_data', lettere$annoprotocollo.posizione='$posizione', lettere$annoprotocollo.riferimento='$riferimento', lettere$annoprotocollo.pratica='$pratica', lettere$annoprotocollo.note='$note', lettere$annoprotocollo.dataregistrazione='$dataregistrazione' WHERE lettere$annoprotocollo.idlettera='$idlettera'");
	echo  mysql_error();
	
	if ( (!$inserimento) && ($from == 'modifica') ) { 
		echo "Modifica non riuscita" ; 
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA MODIFICA LETTERA '. $idlettera , 'FAILED' , '' , $_SESSION['historylog']);
	}
	if ( (!$inserimento) && ($from != 'modifica') ) { 
		echo "Inserimento non riuscito" ; 
		$my_log -> publscrivilog( $_SESSION['loginname'], 'TENTATA REGISTRAZIONE LETTERA '. $idlettera , 'FAILED' , '' , $_SESSION['historylog']);
	}
	if ( ($inserimento) && ($from == 'modifica') ) { 
		$my_log -> publscrivilog( $_SESSION['loginname'], 'MODIFICATA LETTERA '. $idlettera , 'OK' , '' , $_SESSION['historylog']);
	}
	if ( ($inserimento) && ($from != 'modifica') ) { 
		$my_log -> publscrivilog( $_SESSION['loginname'], 'REGISTRATA LETTERA '. $idlettera , 'OK' , '' , $_SESSION['historylog']);
	}
	
	$ultimoid = mysql_insert_id();
	$modifica =mysql_query("update joinlettereinserimento$annoprotocollo set joinlettereinserimento$annoprotocollo.idmod='$loginid', joinlettereinserimento$annoprotocollo.datamod='$dataregistrazione2' where joinlettereinserimento$annoprotocollo.idlettera='$idlettera' limit 1");
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
				<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Protocollo registrato correttamente.</div>
				<?php
			}
			else {
				?>
				<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Protocollo modificato correttamente.</div>
				<?php
			}
			?>
		</div>
	</div>
	<b>Riepilogo:</b>
	<br><br>
	<?php 	
	$my_lettera = new Lettera(); //crea un nuovo oggetto 'lettera'
	$my_lettera -> publdisplaylettera ($_GET['idlettera'], $annoprotocollo); //richiamo del metodo "mostra" dell'oggetto Lettera
	?>
	
  </div>
  
  	<div class="panel-heading">
	<h3 class="panel-title"><strong>Opzioni:</strong></h3>
	</div>
	<div class="panel-body">
		<p><a href="login0.php?corpus=protocollo2&from=crea" onClick="return confirm('ATTENZIONE: OPERAZIONE NON REVERSIBILE\n\nCreare nuovo numero di protocollo?');"><i class="fa fa-plus-square"></i> Registrazione nuovo protocollo</a></p>
		<p><a href="login0.php?corpus=modifica-protocollo&from=risultati&id=<?php echo $idlettera;?>"> <span class="glyphicon glyphicon-edit"></span> Modifica questo protocollo</a></p>
		<p><a href="login0.php?corpus=invia-newsletter&id=<?php echo $idlettera;?>&anno=<?php echo $annoprotocollo;?>"> <span class="glyphicon glyphicon-envelope"></span> Invia tramite email</p>
		<a href="login0.php?corpus=aggiungi-inoltro&id=<?php echo $idlettera;?>&anno=<?php echo $annoprotocollo;?>"> <span class="glyphicon glyphicon-pencil"></span> Aggiungi inoltro email manuale</a>		
	</div>
  
</div>
