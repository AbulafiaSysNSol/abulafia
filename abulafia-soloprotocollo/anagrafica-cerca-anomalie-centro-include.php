<?php
	$filtro=$_GET['filtro'];
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			<b>
				<i class="fa fa-bug">
				</i> 
			Elenco delle presunte anomalie: <?php echo '('.$filtro.')';?>
			</b>
		</h3>
	</div>
  
	<div class="panel-body">
     
		<?php
		if ($filtro == 'cognomenome') {
			 
			?> <!--inizio scelta filtro ='cognomenome'-->
			
			<form 	role="form" 
				enctype="multipart/form-data"
				name="modulo"  
				method="POST">

			<table class="table table-bordered">
				<tr>
					<td><b>ID<br>(mantenere o riassociare)</td>
					<td><b>Cognome</td>
					<td><b>Nome</td>
					<td><b>Data di Nascita</td>
				</tr>

			<?php
				$risultati= mysql_query("select * 
							from anagrafica 
							order by anagrafica.cognome, anagrafica.nome");

				if (!$risultati) {
					echo 'Nessun risultato dalla query';
				}

				while ($row = mysql_fetch_array($risultati)) { //inizio ciclo while
					$cognome= $row['cognome'];
					$nome= $row['nome'];
					$id= $row['idanagrafica'];
					$datagrezza=$row['nascitadata'];
					$datadinascita= list($anno, $mese, $giorno) = explode("-", $datagrezza);
					$datadinascita2 = "$giorno-$mese-$anno";
					$verificaduplicati= mysql_query("select COUNT(*) 
									from anagrafica 
									where anagrafica.cognome='$cognome' 
									and 
									anagrafica.nome='$nome'");
					echo mysql_error();
					$res_count=mysql_fetch_row($verificaduplicati);
					
					if ($res_count[0] > 1) { //caso in cui il gruppo cognome+nome risulti duplicato
						?>
						<tr>								
							<td>
								<a href="login0.php?corpus=dettagli-anagrafica
									&from=risultati
									&tabella=anagrafica
									&id=<?php echo $id ;?>"><?php echo $id; ?>
								</a>
								<br>
								<input type="radio" name="group1" value="<?php echo $id; ?>"> M
								<br>
								<input type="radio" name="group2" value="<?php echo $id; ?>"> R
							</td>
							<td valign="middle"><?php echo $cognome; ?>
							</td>
							<td valign="middle"><?php echo $nome; ?>
							</td>
							<td  valign="middle"><?php echo $datadinascita2; ?>
							</td>
						</tr>
						<?php
					}
				}
			?>
			</table>
			<button class="btn btn-primary" 
				onClick="Controllo()">
				<span class="glyphicon glyphicon-check">
				</span> Fondi le anagrafiche selezionate
			</button>
			</form>
			<?php 
		} //fine scelta filtro ='cognomenome'-->
		?>
		<a href="login0.php?corpus=diagnostica"><b><i class="fa fa-arrow-left"></i> Indietro</b></a>
	</div>
</div>
<form name="testform" method="POST">
<input id="r" type="radio" name="group3" value="R"> R
<input id="e" type="radio" name="group3" value="e"> e
<button onClick="showBoxes(this.form)">TEST
</button>
</form>
<script language="javascript">
 <!--


	function showBoxes(frm){
   	var message = "Your chose:\n\n"


   	//For each radio button if it is checked get the value and break.
  	 for (var i = 0; i < frm.group3.length; i++){
     	 if (frm.group3[i].checked){
        	 message = message + "\n" + frm.group3[i].value
        	 break
     	 }
  	 }
  	 alert(message)
	 }
  
//-->
</script>
