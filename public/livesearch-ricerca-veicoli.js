var xmlhttp;

function showResult(str, num) {

    xmlhttp=GetXmlHttpObject()

    if (xmlhttp==null) {
        alert ("Your browser does not support XML HTTP Request");
        return null;
    }

    var url="livesearch-ricerca-veicoli.php";
    url=url+"?q="+str+"&num="+num;

    xmlhttp.onreadystatechange=stateChanged ;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}

function stateChanged() {
    if (xmlhttp.readyState==4) {
        document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
        document.getElementById("livesearch").style.border="0px solid #A5ACB2";
        document.getElementById("livesearch").style.width="100%";
    }
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
