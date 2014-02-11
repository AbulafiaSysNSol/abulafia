<div id="footer">
	<center>
		<table border="0">
		<tr>
			<td align="center" valign="middle">
				<?php echo $_SESSION['nomeapplicativo'];?> versione <?php echo $_SESSION['version']?>. Per usare questo codice, inviateci una email all'indirizzo <?php echo $_SESSION['email'];?>.
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">
				<span xmlns:dc="http://purl.org/dc/elements/1.1/" property="dc:title">
				Abulafia </span> by <span xmlns:cc="http://creativecommons.org/ns#" property="cc:attributionName">Alfio Musmarra, Biagio Saitta and Alfio Costanzo</span> is licensed under a:  
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle">
				<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/it/" target="_blank">
				<img alt="Creative Commons Attribuzione - Non commerciale - Condividi allo stesso modo 2.5 Italia License" style="border-width:0" src="http://creativecommons.org/images/public/somerights20.png" /></a>
			</td>
		</tr>
		</table>
	</center>
		</div>

	</div>

</div>

</body>
</html>

<?php
mysql_close ($verificaconnessione);
?>

