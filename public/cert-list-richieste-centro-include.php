<div class="panel panel-default">
	
	<div class="panel-heading">
		<h3 class="panel-title"><strong><i class="fa fa-medkit"></i> Richieste di Emissione Certificato:</strong></h3>
	</div>

	<div class="panel-body">
		
		<?php
			$a = new Ambulatorio();
			if ($a->countRichieste() == 0) {
			?>
				<center><div class="alert alert-info"><i class="fa fa-check"></i> Nessuna richiesta di certificato presente nel sistema.</div></center>
			<?php
			}
			else {
			?>
			
			<table class="table table-bordered">
			
			<tr style="vertical-align: middle">
				<td><b>Richiesto da</b></td>
				<td><b>Assistito</b></td>
				<td><b>Data e Ora Visita</b></td>
				<td><b>Tipologia</b></td>
				<td align="center"><b>Opzioni</b></td>
			</tr>
				
				<?php
				$amb = new Ambulatorio();
				$anag = new Anagrafica();
				$c = new Calendario();
				$richieste = $amb->getRichieste();
				foreach ($richieste as $val) {
					echo '<tr>';
					echo '<td>' . ucwords($anag->getNome($val['richiedente'])) . ' ' . ucwords($anag->getCognome($val['richiedente'])) . '</td>';
					echo '<td>' . ucwords($anag->getNomeAssistito($val['paziente'])) . '</td>';
					echo '<td>' . $c->dataSlash($val['data']) . ' ' . $c->oraOM($val['ora']) . '</td>';
					echo '<td>' . ucwords($val['tipo']) . '</td>';
					?> 
						<td align="center">
							<a class="btn btn-xs btn-success" href="login0.php?corpus=cert-genera-certificato&idanagrafica=<?php echo $val['paziente']; ?>&idvisita=<?php echo $val['visita']; ?>&from=richiesta&richiesta=<?php echo $val[0]; ?>" data-toggle="modal">Genera Certificato</a>
						</td>
					<?php
					echo '</tr>'; 
				}
				?>
			</table>
			<?php
		}
		?>
	</div>
</div>
	