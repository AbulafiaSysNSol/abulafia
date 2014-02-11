<div id="primarycontent">
<div class="post">

				<div class="header">

					<h3>Log delle ultime 15 email:</h3>	

				</div>

				<div class="content">

					

					<p><?php 


						
						$my_log -> publleggilog('0', '15', ' ', $_SESSION['maillog']);//legge dal log delle email inviate
						
						
						?></p>
						
							<h2><a href="download.php?lud=mail.log&est=log">Scarica il log delle mail</a></h2>



			</div>	</div>  </div>
