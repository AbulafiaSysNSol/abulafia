<body onload="setFocus()">
<?php
$_SESSION['annoricercaprotocollo']= '';

$level = $_SESSION['auth'];
?>
	<div id="primarycontent">

		<!-- primary content start -->

			<div class="post">

				<div class="header">

					<h3><u>Ricerca nel Database</u></h3>

				</div>

					<div class="content">

					<p>
                    
                    	<form name="search" method="post">

<p><b>Ricerca avanzata</b> <br>
  
  <!--</label> -->
  
  <label> Inserisci il valore da cercare<br>
     <input type="text" name="cercato" onkeydown="if(event.keyCode==13) autorized(<?php echo $level ?>)" onfocus="formInUse = true;"/>
  </label>
  
  <input type="button" value="CERCA" onClick="autorized(<?php echo $level ?>)" />
<br />
<div id="content" style="display: none; border: solid; border-width:1px; padding:5px">
RICERCA COGNOME+NOME:<br /> &Eacute; possibile effettuare una ricerca esatta per cognome e nome (esempio Saitta+Biagio)
</div>

<label>
	<br>Ricerca in:<br> 

		<SELECT style="width:120px" size=1 cols=4 NAME="tabella" onChange="Change()">
			<OPTION selected value="lettere" onclick="document.search.cercato.focus()"> PROTOCOLLO&nbsp;
			<OPTION value="anagrafica" onclick="document.search.cercato.focus()"> ANAGRAFICA&nbsp;
		</SELECT>
</label>

<br><br>

Elenca in ordine:<br>
<input type="radio" onfocus="document.search.cercato.focus()" name="group1" value="alfabetico"> Alfabetico<br>
<input type="radio" onfocus="document.search.cercato.focus()" name="group1" value="cronologico"> Cronologico<br>
<input type="radio" onfocus="document.search.cercato.focus()" name="group1" value="cron-inverso" checked> Cronologico inverso<br>

<br>

Anno di riferimento: 

<br>


<SELECT style="width:100px" size=1 cols=4 NAME="annoricercaprotocollo" >
<?php
	$esistenzatabella1=mysql_query("show tables like 'lettere%'"); //ricerca delle tabelle "lettere" esistenti
	$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
	$my_calendario-> publadesso(); //acquisizione dell'anno attuale per indicare l'anno selezionato di default
	while ($esistenzatabella11 = mysql_fetch_array($esistenzatabella1, MYSQL_NUM))
	{
	if ('lettere'.$my_calendario->anno== $esistenzatabella11[0]) { $selected='selected'; }
	else { $selected ='';}
	$annoprotocollo= explode("lettere", $esistenzatabella11[0]);
	?><OPTION value="<?php echo $annoprotocollo[1] ;?>" onclick="document.search.cercato.focus()" <?php echo $selected ;?>> <?php echo $annoprotocollo[1].' ' ;?>
	<?
	}
	?>

</select>

<br><br>

Filtro per tipologia: <br>

<?php 
	if ($_SESSION['auth'] > 10) {?>
		<SELECT style="width:150px" size=1 cols=4 NAME="anagraficatipologia"  disabled>
			<OPTION value="anagrafica.tipologia" onclick="document.search.cercato.focus()" selected> Nessun filtro
			<OPTION value="persona" onclick="document.search.cercato.focus()"> Persone fisiche
			<OPTION value="carica" onclick="document.search.cercato.focus()"> Carica o Incarico
			<OPTION value="gruppo" onclick="document.search.cercato.focus()"> Gruppo Pionieri
			<OPTION value="ente" onclick="document.search.cercato.focus()"> Ente
		</select>
<?php } 

else { ?>	
	<SELECT style="width:150px" size=1 cols=4 NAME="anagraficatipologia"  disabled>
		<OPTION value="persona" selected> Persone fisiche
	</select>
<?php } ?>	

<br>
<br>
						</form>
					</p>

					</div>	

					<div class="footer">
					</div>

				</div>

				<!-- post end -->
		</div>
        

<script language="javascript">

 <!--

  function autorized(livello) 

  {

	var scelta = document.search.tabella.value;

	if ((livello <= 40) && (scelta == 'lettere'))

	{

		alert("Non hai i privilegi per ricercare nel 'PROTOCOLLO'");

		document.search.tabella.focus();

		return false;

	}

	else 

	{

           document.search.action = "login0.php?corpus=risultati&iniziorisultati=0&currentpage=1";

           document.search.submit();

      }

  }
  
  function Change() 

  {

	var type = document.search.tabella.options[document.search.tabella.selectedIndex].value;

	if (type == "lettere") 

	{

	  document.getElementById("content").style.display="none";
	  document.search.annoricercaprotocollo.disabled = false;
	  document.search.anagraficatipologia.disabled = true;

	}

	if (type == "anagrafica") 

	{

	  document.getElementById("content").style.display="table";
	  document.search.anagraficatipologia.disabled = false;
	  document.search.annoricercaprotocollo.disabled = true;

	}
	
  }

 //-->

</script> 
<script type="text/javascript">

var formInUse = false;

function setFocus()
{
if(!formInUse) {
  document.search.cercato.focus();
}
}

</script>
</body>
