var xmlhttp;

function changeAttr(idanagrafica,idlettera,attributo) {
	
	xmlhttp=GetXmlHttpObject()

	if (xmlhttp==null) {
		alert ("Your browser does not support XML HTTP Request");
		return null;
	}

	var url="livesearch-cambia-attributo.php";
	url=url+"?idanagrafica="+idanagrafica;
	url=url+"&idlettera="+idlettera;
	url=url+"&attributo="+attributo;
	
	xmlhttp.onreadystatechange=stateChanged ;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function GetXmlHttpObject() {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}

	if (window.ActiveXObject) {
		// code for IE6, IE5
	return new ActiveXObject("Microsoft.XMLHTTP");
	}

	return null;
}
