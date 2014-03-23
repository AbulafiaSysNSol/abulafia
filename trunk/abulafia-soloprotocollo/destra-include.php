<?php
$loginurlfoto =$_SESSION['loginurlfoto']; //acquisisce l'url della foto dell'utente che ha fatto login
?>
<div id="secondarycontent">

			<!-- secondary content start -->
		
			<h3>User Info</h3>
			<div class="content">
				<?php if (!$loginurlfoto)
				{ ?>
				<img src="foto/<?php echo $loginurlfoto;?>" height="100" alt="" /><!-- foto dell'utente che ha fatto login -->
				<?php } ?>
				<p><strong>Username =</strong> <?php echo $_SESSION['loginname'];?><br><strong>Auth level =</strong> <?php echo $_SESSION['auth'];?><br><strong>User ID =</strong> <?php echo $_SESSION['loginid'];?></p>
			</div>
			
			<h3>Opzioni Utente</h3>
			<div class="content">
				<ul class="linklist">
					<li class="first"><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>">Cambia la tua password</a></li>
					<li><a href="login0.php?corpus=segnala-bug">Segnala un errore</a></li>
					<li><a href="login0.php?corpus=gestione-utenti">Gestione degli Utenti</a></li>
					<li><a href="login0.php?corpus=settings">Settings</a></li>
					<li><a href="login0.php?corpus=advancedsettings">Advanced Settings</a></li>
<?php if ($_SESSION['auth'] > 44) {?><li><a href="download.php?lud=access.log&est=log">Scarica il log degli accessi</a></li><!--passa i parametri a download.php (nome file->lud ed estensione->est) per scaricare il log degli accessi--><?php } ?>
<?php if ($_SESSION['auth'] > 44) {?><li><a href="login0.php?corpus=log-mail">Visualizza il log delle mail</a></li><?php } ?>
					<li><a href="logout.php">Logout</a></li>				
				</ul>
			</div>

			<!-- secondary content end -->

		</div>
