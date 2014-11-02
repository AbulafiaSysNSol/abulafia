<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong>Procedura di allineamento registro di protocollo:</strong></h3>
	</div>
  
	<div class="panel-body">
		<?php 
			$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
			$my_calendario-> publadesso();
			$directory= 'lettere'.$my_calendario->anno;
			
			if (is_dir($directory)) {  //controllo dell'esistenza ed eventuale creazione della directory dell'anno corrente
				 echo '<i class="fa fa-info-circle"></i> La directory '.$directory.' era gia\' presente<br>'; 
			}
			else {
				$creadir=mkdir($directory, 0777, true);
				if (!$creadir) { 
					die ('<i class="fa fa-times"></i> Impossibile creare la directory '.$directory); 
				}
				else { 
					echo '<i class="fa fa-check"></i> Directory '.$directory.' creata correttamente<br>';
				}
			}
			
			$tabella1='lettere'.$my_calendario->anno;
			$esistenzatabella1=mysql_query("show tables like '$tabella1'");
			$esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM);
			if ($esistenzatabella11[0]==$tabella1) {
				echo '<i class="fa fa-info-circle"></i> La tabella '.$tabella1.' era gia\' presente<br>';
			}
			else { 
				$creatabella=mysql_query("
				CREATE TABLE IF NOT EXISTS `$tabella1` (
				`idlettera` int(11) NOT NULL auto_increment,
				`oggetto` text collate utf8_roman_ci NOT NULL,
				`datalettera` date NOT NULL,
				`dataregistrazione` date NOT NULL,
				`urlpdf` text collate utf8_roman_ci NOT NULL,
				`speditaricevuta` text collate utf8_roman_ci NOT NULL,
				`posizione` text collate utf8_roman_ci NOT NULL,
				`riferimento` text collate utf8_roman_ci NOT NULL,
				`pratica` int(11) NULL,
				`note` text collate utf8_roman_ci NOT NULL,
				 PRIMARY KEY  (`idlettera`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci AUTO_INCREMENT=833 ;
				 "); 
				if ($creatabella) {
					echo '<i class="fa fa-check"></i> Tabella '.$tabella1.' creata correttamente<br>'; 
					$queryprimoprotocollo = mysql_query("ALTER TABLE $tabella1 AUTO_INCREMENT = 1");
					if (!$queryprimoprotocollo) { 
						echo 'Settaggio del primo numero del protocollo NON RIUSCITO<br>'; 
						echo mysql_error(); 
						exit();
					}		
					else { 
						echo '<i class="fa fa-check"></i> Tabella '.$tabella1.' settata correttamente al numero 1<br>';
					}
				}	
				else { 
					die('<i class="fa fa-times"></i> Impossibile creare la tabella '.$tabella1); 
				}
			}
								
			$tabella2='joinletteremittenti'.$my_calendario->anno;
			$esistenzatabella2=mysql_query("show tables like '$tabella2'");
			$esistenzatabella21 = mysql_fetch_array($esistenzatabella2, MYSQL_NUM);
			if ($esistenzatabella21[0]==$tabella2) {
				echo '<i class="fa fa-info-circle"></i> La tabella '.$tabella2.' era gia\' presente<br>';
			}
			else {
				$creatabella2=mysql_query("
				CREATE TABLE IF NOT EXISTS `$tabella2` (
				`idlettera` text collate utf8_roman_ci NOT NULL,
				`idanagrafica` text collate utf8_roman_ci NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;
				");	
				if ($creatabella2) {
					echo '<i class="fa fa-check"></i> Tabella '.$tabella2.' creata correttamente<br>'; 
				}
				else { 
					die('<i class="fa fa-times"></i> Impossibile creare la tabella '.$tabella2); 
				}
			}
		
			$tabella3='joinlettereinserimento'.$my_calendario->anno;
			$esistenzatabella3=mysql_query("show tables like '$tabella3'");
			$esistenzatabella31 = mysql_fetch_array($esistenzatabella3, MYSQL_NUM);
			if ($esistenzatabella31[0]==$tabella3) {
				echo '<i class="fa fa-info-circle"></i> La tabella '.$tabella3.' era gia\' presente<br>';
			}
			else {
				$creatabella3=mysql_query("
				CREATE TABLE IF NOT EXISTS `$tabella3` (
				 `idlettera` int(11) NOT NULL,
				 `idinser` int(11) NOT NULL,
				 `idmod` int(11) NOT NULL,
				 `datamod` date NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				");
				if ($creatabella3) {
					echo '<i class="fa fa-check"></i> Tabella '.$tabella3.' creata correttamente<br>'; 
				}
				else { 
					die('<i class="fa fa-times"></i> Impossibile creare la tabella '.$tabella3); 
				}
			}

			$aggiornaannodb=mysql_query("update defaultsettings set annoprotocollo='$my_calendario->anno'");
			if (!$aggiornaannodb) { 
				die ('<i class="fa fa-times"></i> Impossibile aggiornare l\'anno del registro protocollo virtuale');
			}
			
			$_SESSION['annoprotocollo'] = $my_calendario->anno;
					
			echo '<br><b><i class="fa fa-check"></i> Aggiornamento eseguito correttamente.</b><br><br>Adesso e\' possibile riprendere l\'uso dell\'applicazione';
		?>
		
	</div>
</div>