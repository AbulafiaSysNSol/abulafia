	<div id="primarycontent">
		
			<!-- primary content start -->
		
			<div class="post">
				<div class="header">
					<h3>Registro di protocollo: procedura di allineamento</h3>
	
				</div>
				<div class="content">
					
					<p><strong>
					<?php 
					$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
					$my_calendario-> publadesso();
					$directory= 'lettere'.$my_calendario->anno;
									
						if (is_dir($directory))  //controllo dell'esistenza ed eventuale creazione della directory dell'anno corrente
						{ 
							 echo "La directory ".$directory." era gia' presente<br>"; 
						}

						else 
						{
 							$creadir=mkdir($directory, 0777, true);
							if (!$creadir) { die ('Impossibile creare la directory '.$directory); }
							else { echo "Directory ".$directory." creata correttamente<br>";}
						}
						
						$tabella1='lettere'.$my_calendario->anno;
						$esistenzatabella1=mysql_query("show tables like '$tabella1'");
						$esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM);
						if ($esistenzatabella11[0]==$tabella1)
							{
							echo "La tabella ".$tabella1." era gia' presente<br>";
							}
						
						else 
							{ 
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
 							 `note` text collate utf8_roman_ci NOT NULL,
 							 PRIMARY KEY  (`idlettera`)
							) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci AUTO_INCREMENT=833 ;
							 "); 
							if ($creatabella) {echo 'Tabella '.$tabella1.' creata correttamente<br>'; 
									   $queryprimoprotocollo = mysql_query("ALTER TABLE $tabella1 AUTO_INCREMENT = 1");
									   if (!$queryprimoprotocollo) { echo 'Settaggio del primo numero del protocollo NON RIUSCITO<br>'; echo mysql_error(); exit();}		
			
									   else { echo 'Tabella '.$tabella1.' settata correttamente al numero 1<br>';}	
									   }
							else { die("Impossibile creare la tabella ".$tabella1); }
							 }
							
						$tabella2='joinletteremittenti'.$my_calendario->anno;
						$esistenzatabella2=mysql_query("show tables like '$tabella2'");
						$esistenzatabella21 = mysql_fetch_array($esistenzatabella2, MYSQL_NUM);
						if ($esistenzatabella21[0]==$tabella2)
							{
							echo "La tabella ".$tabella2." era gia' presente<br>";
							}
						else 
							{
							$creatabella2=mysql_query("
							CREATE TABLE IF NOT EXISTS `$tabella2` (
 							 `idlettera` text collate utf8_roman_ci NOT NULL,
 							 `idanagrafica` text collate utf8_roman_ci NOT NULL
							) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;
							");	
							if ($creatabella2) {echo 'Tabella '.$tabella2.' creata correttamente<br>'; }
							else { die("Impossibile creare la tabella ".$tabella2); }
							}
	
						$tabella3='joinlettereinserimento'.$my_calendario->anno;
						$esistenzatabella3=mysql_query("show tables like '$tabella3'");
						$esistenzatabella31 = mysql_fetch_array($esistenzatabella3, MYSQL_NUM);
						if ($esistenzatabella31[0]==$tabella3)
						
							{
							echo "La tabella ".$tabella3." era gia' presente<br>";
							}
						else 
							{
							$creatabella3=mysql_query("
							CREATE TABLE IF NOT EXISTS `$tabella3` (
 							 `idlettera` int(11) NOT NULL,
 							 `idinser` int(11) NOT NULL,
 							 `idmod` int(11) NOT NULL,
 							 `datamod` date NOT NULL
							) ENGINE=MyISAM DEFAULT CHARSET=latin1;
							");
							if ($creatabella3) {echo 'Tabella '.$tabella3.' creata correttamente<br><br><br>'; }
							else { die("Impossibile creare la tabella ".$tabella3); }
							
							}

						$aggiornaannodb=mysql_query("update defaultsettings set annoprotocollo='$my_calendario->anno'");
						if (!$aggiornaannodb) { die ("Impossibile aggiornare l'anno del registro protocollo virtuale");}
						$_SESSION['annoprotocollo'] = $my_calendario->anno;
				


					echo "Aggiornamento eseguito correttamente. <br>Adesso e' possibile riprendere l'uso dell'applicazione";
					?>
					</strong></p>


			</div>
					
			
		</div>
			
			<!-- primary content end -->
	


		</div>
