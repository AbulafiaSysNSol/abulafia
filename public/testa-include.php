 <?php

	if ($_SESSION['auth']< 1 ) {
		echo 'Devi prima effettuare il login dalla<br>';
		?> <a href="../"><?php echo 'pagina principale'; $_SESSION['auth']= 0 ;  ?></a>
		<?php 
		exit(); 
	}
	
	include '../db-connessione-include.php'; //connessione al db-server
	include 'maledetti-apici-centro-include.php';

	function __autoload ($class_name) { //funzione predefinita che si occupa di caricare dinamicamente tutti gli oggetti esterni quando vengono richiamati
		require_once "class/" . $class_name.".obj.inc";
	}
	
	$my_calendario = unserialize ($_SESSION['my_calendario']); //deserializzazione dell'oggetto
	$my_anagrafica= unserialize($_SESSION['my_anagrafica']);//deserializzazione 
	$my_log= unserialize($_SESSION['my_log']);//deserializzazione 
	$my_registroprotocollo= unserialize($_SESSION['my_registroprotocollo']);//deserializzazione 
	$my_ricerca= unserialize($_SESSION['my_ricerca']);//deserializzazione 
	$my_manuale= unserialize($_SESSION['my_manuale']);//deserializzazione 
	$my_tabellahtml= unserialize($_SESSION['my_tabellahtml']);//deserializzazione 
	$my_database= unserialize($_SESSION['my_database']);//deserializzazione
	$my_lettera= unserialize($_SESSION['my_lettera']);//deserializzazione 
	$setting=mysql_query("select * from defaultsettings");
	$setting2=mysql_fetch_array($setting);

	$_SESSIONs['paginaprincipale'] = $setting2['paginaprincipale'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//IT" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>

 <script>
/* jquery.form.min.js */
(function(e){"use strict";if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(typeof jQuery!="undefined"?jQuery:window.Zepto)}})(function(e){"use strict";function r(t){var n=t.data;if(!t.isDefaultPrevented()){t.preventDefault();e(t.target).ajaxSubmit(n)}}function i(t){var n=t.target;var r=e(n);if(!r.is("[type=submit],[type=image]")){var i=r.closest("[type=submit]");if(i.length===0){return}n=i[0]}var s=this;s.clk=n;if(n.type=="image"){if(t.offsetX!==undefined){s.clk_x=t.offsetX;s.clk_y=t.offsetY}else if(typeof e.fn.offset=="function"){var o=r.offset();s.clk_x=t.pageX-o.left;s.clk_y=t.pageY-o.top}else{s.clk_x=t.pageX-n.offsetLeft;s.clk_y=t.pageY-n.offsetTop}}setTimeout(function(){s.clk=s.clk_x=s.clk_y=null},100)}function s(){if(!e.fn.ajaxSubmit.debug){return}var t="[jquery.form] "+Array.prototype.join.call(arguments,"");if(window.console&&window.console.log){window.console.log(t)}else if(window.opera&&window.opera.postError){window.opera.postError(t)}}var t={};t.fileapi=e("<input type='file'/>").get(0).files!==undefined;t.formdata=window.FormData!==undefined;var n=!!e.fn.prop;e.fn.attr2=function(){if(!n){return this.attr.apply(this,arguments)}var e=this.prop.apply(this,arguments);if(e&&e.jquery||typeof e==="string"){return e}return this.attr.apply(this,arguments)};e.fn.ajaxSubmit=function(r){function k(t){var n=e.param(t,r.traditional).split("&");var i=n.length;var s=[];var o,u;for(o=0;o<i;o++){n[o]=n[o].replace(/\+/g," ");u=n[o].split("=");s.push([decodeURIComponent(u[0]),decodeURIComponent(u[1])])}return s}function L(t){var n=new FormData;for(var s=0;s<t.length;s++){n.append(t[s].name,t[s].value)}if(r.extraData){var o=k(r.extraData);for(s=0;s<o.length;s++){if(o[s]){n.append(o[s][0],o[s][1])}}}r.data=null;var u=e.extend(true,{},e.ajaxSettings,r,{contentType:false,processData:false,cache:false,type:i||"POST"});if(r.uploadProgress){u.xhr=function(){var t=e.ajaxSettings.xhr();if(t.upload){t.upload.addEventListener("progress",function(e){var t=0;var n=e.loaded||e.position;var i=e.total;if(e.lengthComputable){t=Math.ceil(n/i*100)}r.uploadProgress(e,n,i,t)},false)}return t}}u.data=null;var a=u.beforeSend;u.beforeSend=function(e,t){if(r.formData){t.data=r.formData}else{t.data=n}if(a){a.call(this,e,t)}};return e.ajax(u)}function A(t){function T(e){var t=null;try{if(e.contentWindow){t=e.contentWindow.document}}catch(n){s("cannot get iframe.contentWindow document: "+n)}if(t){return t}try{t=e.contentDocument?e.contentDocument:e.document}catch(n){s("cannot get iframe.contentDocument: "+n);t=e.document}return t}function k(){function f(){try{var e=T(v).readyState;s("state = "+e);if(e&&e.toLowerCase()=="uninitialized"){setTimeout(f,50)}}catch(t){s("Server abort: ",t," (",t.name,")");_(x);if(w){clearTimeout(w)}w=undefined}}var t=a.attr2("target"),n=a.attr2("action"),r="multipart/form-data",u=a.attr("enctype")||a.attr("encoding")||r;o.setAttribute("target",p);if(!i||/post/i.test(i)){o.setAttribute("method","POST")}if(n!=l.url){o.setAttribute("action",l.url)}if(!l.skipEncodingOverride&&(!i||/post/i.test(i))){a.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"})}if(l.timeout){w=setTimeout(function(){b=true;_(S)},l.timeout)}var c=[];try{if(l.extraData){for(var h in l.extraData){if(l.extraData.hasOwnProperty(h)){if(e.isPlainObject(l.extraData[h])&&l.extraData[h].hasOwnProperty("name")&&l.extraData[h].hasOwnProperty("value")){c.push(e('<input type="hidden" name="'+l.extraData[h].name+'">').val(l.extraData[h].value).appendTo(o)[0])}else{c.push(e('<input type="hidden" name="'+h+'">').val(l.extraData[h]).appendTo(o)[0])}}}}if(!l.iframeTarget){d.appendTo("body")}if(v.attachEvent){v.attachEvent("onload",_)}else{v.addEventListener("load",_,false)}setTimeout(f,15);try{o.submit()}catch(m){var g=document.createElement("form").submit;g.apply(o)}}finally{o.setAttribute("action",n);o.setAttribute("enctype",u);if(t){o.setAttribute("target",t)}else{a.removeAttr("target")}e(c).remove()}}function _(t){if(m.aborted||M){return}A=T(v);if(!A){s("cannot access response document");t=x}if(t===S&&m){m.abort("timeout");E.reject(m,"timeout");return}else if(t==x&&m){m.abort("server abort");E.reject(m,"error","server abort");return}if(!A||A.location.href==l.iframeSrc){if(!b){return}}if(v.detachEvent){v.detachEvent("onload",_)}else{v.removeEventListener("load",_,false)}var n="success",r;try{if(b){throw"timeout"}var i=l.dataType=="xml"||A.XMLDocument||e.isXMLDoc(A);s("isXml="+i);if(!i&&window.opera&&(A.body===null||!A.body.innerHTML)){if(--O){s("requeing onLoad callback, DOM not available");setTimeout(_,250);return}}var o=A.body?A.body:A.documentElement;m.responseText=o?o.innerHTML:null;m.responseXML=A.XMLDocument?A.XMLDocument:A;if(i){l.dataType="xml"}m.getResponseHeader=function(e){var t={"content-type":l.dataType};return t[e.toLowerCase()]};if(o){m.status=Number(o.getAttribute("status"))||m.status;m.statusText=o.getAttribute("statusText")||m.statusText}var u=(l.dataType||"").toLowerCase();var a=/(json|script|text)/.test(u);if(a||l.textarea){var f=A.getElementsByTagName("textarea")[0];if(f){m.responseText=f.value;m.status=Number(f.getAttribute("status"))||m.status;m.statusText=f.getAttribute("statusText")||m.statusText}else if(a){var c=A.getElementsByTagName("pre")[0];var p=A.getElementsByTagName("body")[0];if(c){m.responseText=c.textContent?c.textContent:c.innerText}else if(p){m.responseText=p.textContent?p.textContent:p.innerText}}}else if(u=="xml"&&!m.responseXML&&m.responseText){m.responseXML=D(m.responseText)}try{L=H(m,u,l)}catch(g){n="parsererror";m.error=r=g||n}}catch(g){s("error caught: ",g);n="error";m.error=r=g||n}if(m.aborted){s("upload aborted");n=null}if(m.status){n=m.status>=200&&m.status<300||m.status===304?"success":"error"}if(n==="success"){if(l.success){l.success.call(l.context,L,"success",m)}E.resolve(m.responseText,"success",m);if(h){e.event.trigger("ajaxSuccess",[m,l])}}else if(n){if(r===undefined){r=m.statusText}if(l.error){l.error.call(l.context,m,n,r)}E.reject(m,"error",r);if(h){e.event.trigger("ajaxError",[m,l,r])}}if(h){e.event.trigger("ajaxComplete",[m,l])}if(h&&!--e.active){e.event.trigger("ajaxStop")}if(l.complete){l.complete.call(l.context,m,n)}M=true;if(l.timeout){clearTimeout(w)}setTimeout(function(){if(!l.iframeTarget){d.remove()}else{d.attr("src",l.iframeSrc)}m.responseXML=null},100)}var o=a[0],u,f,l,h,p,d,v,m,g,y,b,w;var E=e.Deferred();E.abort=function(e){m.abort(e)};if(t){for(f=0;f<c.length;f++){u=e(c[f]);if(n){u.prop("disabled",false)}else{u.removeAttr("disabled")}}}l=e.extend(true,{},e.ajaxSettings,r);l.context=l.context||l;p="jqFormIO"+(new Date).getTime();if(l.iframeTarget){d=e(l.iframeTarget);y=d.attr2("name");if(!y){d.attr2("name",p)}else{p=y}}else{d=e('<iframe name="'+p+'" src="'+l.iframeSrc+'" />');d.css({position:"absolute",top:"-1000px",left:"-1000px"})}v=d[0];m={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(t){var n=t==="timeout"?"timeout":"aborted";s("aborting upload... "+n);this.aborted=1;try{if(v.contentWindow.document.execCommand){v.contentWindow.document.execCommand("Stop")}}catch(r){}d.attr("src",l.iframeSrc);m.error=n;if(l.error){l.error.call(l.context,m,n,t)}if(h){e.event.trigger("ajaxError",[m,l,n])}if(l.complete){l.complete.call(l.context,m,n)}}};h=l.global;if(h&&0===e.active++){e.event.trigger("ajaxStart")}if(h){e.event.trigger("ajaxSend",[m,l])}if(l.beforeSend&&l.beforeSend.call(l.context,m,l)===false){if(l.global){e.active--}E.reject();return E}if(m.aborted){E.reject();return E}g=o.clk;if(g){y=g.name;if(y&&!g.disabled){l.extraData=l.extraData||{};l.extraData[y]=g.value;if(g.type=="image"){l.extraData[y+".x"]=o.clk_x;l.extraData[y+".y"]=o.clk_y}}}var S=1;var x=2;var N=e("meta[name=csrf-token]").attr("content");var C=e("meta[name=csrf-param]").attr("content");if(C&&N){l.extraData=l.extraData||{};l.extraData[C]=N}if(l.forceSync){k()}else{setTimeout(k,10)}var L,A,O=50,M;var D=e.parseXML||function(e,t){if(window.ActiveXObject){t=new ActiveXObject("Microsoft.XMLDOM");t.async="false";t.loadXML(e)}else{t=(new DOMParser).parseFromString(e,"text/xml")}return t&&t.documentElement&&t.documentElement.nodeName!="parsererror"?t:null};var P=e.parseJSON||function(e){return window["eval"]("("+e+")")};var H=function(t,n,r){var i=t.getResponseHeader("content-type")||"",s=n==="xml"||!n&&i.indexOf("xml")>=0,o=s?t.responseXML:t.responseText;if(s&&o.documentElement.nodeName==="parsererror"){if(e.error){e.error("parsererror")}}if(r&&r.dataFilter){o=r.dataFilter(o,n)}if(typeof o==="string"){if(n==="json"||!n&&i.indexOf("json")>=0){o=P(o)}else if(n==="script"||!n&&i.indexOf("javascript")>=0){e.globalEval(o)}}return o};return E}if(!this.length){s("ajaxSubmit: skipping submit process - no element selected");return this}var i,o,u,a=this;if(typeof r=="function"){r={success:r}}else if(r===undefined){r={}}i=r.type||this.attr2("method");o=r.url||this.attr2("action");u=typeof o==="string"?e.trim(o):"";u=u||window.location.href||"";if(u){u=(u.match(/^([^#]+)/)||[])[1]}r=e.extend(true,{url:u,success:e.ajaxSettings.success,type:i||e.ajaxSettings.type,iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},r);var f={};this.trigger("form-pre-serialize",[this,r,f]);if(f.veto){s("ajaxSubmit: submit vetoed via form-pre-serialize trigger");return this}if(r.beforeSerialize&&r.beforeSerialize(this,r)===false){s("ajaxSubmit: submit aborted via beforeSerialize callback");return this}var l=r.traditional;if(l===undefined){l=e.ajaxSettings.traditional}var c=[];var h,p=this.formToArray(r.semantic,c);if(r.data){r.extraData=r.data;h=e.param(r.data,l)}if(r.beforeSubmit&&r.beforeSubmit(p,this,r)===false){s("ajaxSubmit: submit aborted via beforeSubmit callback");return this}this.trigger("form-submit-validate",[p,this,r,f]);if(f.veto){s("ajaxSubmit: submit vetoed via form-submit-validate trigger");return this}var d=e.param(p,l);if(h){d=d?d+"&"+h:h}if(r.type.toUpperCase()=="GET"){r.url+=(r.url.indexOf("?")>=0?"&":"?")+d;r.data=null}else{r.data=d}var v=[];if(r.resetForm){v.push(function(){a.resetForm()})}if(r.clearForm){v.push(function(){a.clearForm(r.includeHidden)})}if(!r.dataType&&r.target){var m=r.success||function(){};v.push(function(t){var n=r.replaceTarget?"replaceWith":"html";e(r.target)[n](t).each(m,arguments)})}else if(r.success){v.push(r.success)}r.success=function(e,t,n){var i=r.context||this;for(var s=0,o=v.length;s<o;s++){v[s].apply(i,[e,t,n||a,a])}};if(r.error){var g=r.error;r.error=function(e,t,n){var i=r.context||this;g.apply(i,[e,t,n,a])}}if(r.complete){var y=r.complete;r.complete=function(e,t){var n=r.context||this;y.apply(n,[e,t,a])}}var b=e("input[type=file]:enabled",this).filter(function(){return e(this).val()!==""});var w=b.length>0;var E="multipart/form-data";var S=a.attr("enctype")==E||a.attr("encoding")==E;var x=t.fileapi&&t.formdata;s("fileAPI :"+x);var T=(w||S)&&!x;var N;if(r.iframe!==false&&(r.iframe||T)){if(r.closeKeepAlive){e.get(r.closeKeepAlive,function(){N=A(p)})}else{N=A(p)}}else if((w||S)&&x){N=L(p)}else{N=e.ajax(r)}a.removeData("jqxhr").data("jqxhr",N);for(var C=0;C<c.length;C++){c[C]=null}this.trigger("form-submit-notify",[this,r]);return this};e.fn.ajaxForm=function(t){t=t||{};t.delegation=t.delegation&&e.isFunction(e.fn.on);if(!t.delegation&&this.length===0){var n={s:this.selector,c:this.context};if(!e.isReady&&n.s){s("DOM not ready, queuing ajaxForm");e(function(){e(n.s,n.c).ajaxForm(t)});return this}s("terminating; zero elements found by selector"+(e.isReady?"":" (DOM not ready)"));return this}if(t.delegation){e(document).off("submit.form-plugin",this.selector,r).off("click.form-plugin",this.selector,i).on("submit.form-plugin",this.selector,t,r).on("click.form-plugin",this.selector,t,i);return this}return this.ajaxFormUnbind().bind("submit.form-plugin",t,r).bind("click.form-plugin",t,i)};e.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")};e.fn.formToArray=function(n,r){var i=[];if(this.length===0){return i}var s=this[0];var o=this.attr("id");var u=n?s.getElementsByTagName("*"):s.elements;var a;if(u&&!/MSIE [678]/.test(navigator.userAgent)){u=e(u).get()}if(o){a=e(':input[form="'+o+'"]').get();if(a.length){u=(u||[]).concat(a)}}if(!u||!u.length){return i}var f,l,c,h,p,d,v;for(f=0,d=u.length;f<d;f++){p=u[f];c=p.name;if(!c||p.disabled){continue}if(n&&s.clk&&p.type=="image"){if(s.clk==p){i.push({name:c,value:e(p).val(),type:p.type});i.push({name:c+".x",value:s.clk_x},{name:c+".y",value:s.clk_y})}continue}h=e.fieldValue(p,true);if(h&&h.constructor==Array){if(r){r.push(p)}for(l=0,v=h.length;l<v;l++){i.push({name:c,value:h[l]})}}else if(t.fileapi&&p.type=="file"){if(r){r.push(p)}var m=p.files;if(m.length){for(l=0;l<m.length;l++){i.push({name:c,value:m[l],type:p.type})}}else{i.push({name:c,value:"",type:p.type})}}else if(h!==null&&typeof h!="undefined"){if(r){r.push(p)}i.push({name:c,value:h,type:p.type,required:p.required})}}if(!n&&s.clk){var g=e(s.clk),y=g[0];c=y.name;if(c&&!y.disabled&&y.type=="image"){i.push({name:c,value:g.val()});i.push({name:c+".x",value:s.clk_x},{name:c+".y",value:s.clk_y})}}return i};e.fn.formSerialize=function(t){return e.param(this.formToArray(t))};e.fn.fieldSerialize=function(t){var n=[];this.each(function(){var r=this.name;if(!r){return}var i=e.fieldValue(this,t);if(i&&i.constructor==Array){for(var s=0,o=i.length;s<o;s++){n.push({name:r,value:i[s]})}}else if(i!==null&&typeof i!="undefined"){n.push({name:this.name,value:i})}});return e.param(n)};e.fn.fieldValue=function(t){for(var n=[],r=0,i=this.length;r<i;r++){var s=this[r];var o=e.fieldValue(s,t);if(o===null||typeof o=="undefined"||o.constructor==Array&&!o.length){continue}if(o.constructor==Array){e.merge(n,o)}else{n.push(o)}}return n};e.fieldValue=function(t,n){var r=t.name,i=t.type,s=t.tagName.toLowerCase();if(n===undefined){n=true}if(n&&(!r||t.disabled||i=="reset"||i=="button"||(i=="checkbox"||i=="radio")&&!t.checked||(i=="submit"||i=="image")&&t.form&&t.form.clk!=t||s=="select"&&t.selectedIndex==-1)){return null}if(s=="select"){var o=t.selectedIndex;if(o<0){return null}var u=[],a=t.options;var f=i=="select-one";var l=f?o+1:a.length;for(var c=f?o:0;c<l;c++){var h=a[c];if(h.selected){var p=h.value;if(!p){p=h.attributes&&h.attributes.value&&!h.attributes.value.specified?h.text:h.value}if(f){return p}u.push(p)}}return u}return e(t).val()};e.fn.clearForm=function(t){return this.each(function(){e("input,select,textarea",this).clearFields(t)})};e.fn.clearFields=e.fn.clearInputs=function(t){var n=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var r=this.type,i=this.tagName.toLowerCase();if(n.test(r)||i=="textarea"){this.value=""}else if(r=="checkbox"||r=="radio"){this.checked=false}else if(i=="select"){this.selectedIndex=-1}else if(r=="file"){if(/MSIE/.test(navigator.userAgent)){e(this).replaceWith(e(this).clone(true))}else{e(this).val("")}}else if(t){if(t===true&&/hidden/.test(r)||typeof t=="string"&&e(this).is(t)){this.value=""}}})};e.fn.resetForm=function(){return this.each(function(){if(typeof this.reset=="function"||typeof this.reset=="object"&&!this.reset.nodeType){this.reset()}})};e.fn.enable=function(e){if(e===undefined){e=true}return this.each(function(){this.disabled=!e})};e.fn.selected=function(t){if(t===undefined){t=true}return this.each(function(){var n=this.type;if(n=="checkbox"||n=="radio"){this.checked=t}else if(this.tagName.toLowerCase()=="option"){var r=e(this).parent("select");if(t&&r[0]&&r[0].type=="select-one"){r.find("option").selected(false)}this.selected=t}})};e.fn.ajaxSubmit.debug=false})
</script>

<script type="text/javascript">
$(document).ready(function() { 
	 $('#uploadForm').submit(function(e) {	
		if($('#uploadedfile').val()) {
			e.preventDefault();
			$(this).ajaxSubmit({ 
				target: '#targetLayer', 
				beforeSubmit: function() {
				  $("#progress-bar").width('0%');
				},
				uploadProgress: function (event, position, total, percentComplete){	
					$("#progress-bar").width(percentComplete + '%');
					$("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
				},
				resetForm: true
			}); 
			return false; 
		}
	});
}); 
</script> 

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5144136285411668",
    enable_page_level_ads: true
  });
</script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $_SESSION['nomeapplicativo'] . ' ' . $_SESSION['version'];?></title>
<meta name="keywords" content="abulafia, protocollo, informatico, volontari, croce rossa italiana, cri, segreteria" />
<meta name="description" content="Abulafia - Protocollo Informatico dei Volontari C.R.I." />
<meta name="author" content="Biagio Saitta & Alfio Musmarra" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="style.php"/>

  <!-- META -->
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <!-- META -->
  
  <!-- CSS -->
  <link href='https://fonts.googleapis.com/css?family=Telex' rel='stylesheet' type='text/css'>
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.10.4.custom.css"></link>
  <link href="css/grid.css" rel="stylesheet">
  <!-- CSS -->  
  
  <!-- JS -->
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/jquery-1.10.4.custom.js"></script>
  <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.10.4.custom.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-i18n.js"></script>
  <script type="text/javascript" src="lib/tinymce/tinymce.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-filestyle.min.js"> </script>
  <!-- JS -->

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editor",
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    nonbreaking_force_tab: true,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
    fontsize_formats: "6pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt 54pt 72pt",
    plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools'
    ],
    toolbar1: "bold underline italic strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect",
    toolbar2: "table | subscript superscript charmap | link image | paste | preview visualblocks visualchars code"
 });
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editorMail",
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
    plugins: [
		'paste'
    ],
    toolbar: "bold underline italic strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
 });
</script>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#editorOgg",
    statusbar : false,
    menubar: false,
    forced_root_block: false,
    paste_as_text: true,
    paste_auto_cleanup_on_paste : true,
     plugins: [
		'paste'
    ],
    toolbar: "bold underline italic strikethrough"
 });
</script>
  
  <script type="text/javascript">
	$(function(){
	     $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );
	     $('.datepicker').datepicker( { changeMonth: true, changeYear: true });
	     $('.datepickerAnag').datepicker( { changeMonth: true, changeYear: true, yearRange: "-100:+0" }); 
	     $('.datepickerProt').datepicker( { changeMonth: true, changeYear: true, maxDate: "today" });
	});
</script>
  
  <!-- Fancybox -->
	<script type="text/javascript" src="js/fancy/lib/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="js/fancy/source/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="js/fancy/source/jquery.fancybox.css?v=2.1.5" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/fancy/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<link rel="stylesheet" type="text/css" href="js/fancy/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="js/fancy/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="js/fancy/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<script type="text/javascript" src="js/fancy/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<!-- End Fancybox -->

<script type="text/javascript">
		$(function() {
			$('.fancybox').fancybox();
			
			$(".iframe").fancybox({
				type: 'iframe',
				'padding' : 10,  
				'autoDimensions' : false,
				'width' : 500,
				'height' : 'auto'
			});

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

		});
  </script>
  
  <style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>
  
</head>


<body>
  
	<?php
		$anag = new Anagrafica();
	?>

  <div class="container">
	 
	 <div class="page-header">
		<div class="row">
			<div class="col-sm-1">
				<center><img width="60" src="images/abulafia logo-scont.png"></center>
			</div>
			<div class="col-sm-7">
				<h2><?php echo $_SESSION['nomeapplicativo'] .' ' . $_SESSION['version'] . ' <br><small>'. $_SESSION['headerdescription'];?></small></h2> 
			</div>
			<div class="col-sm-4" align="center" valign="middle">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- AbuHeader -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:320px;height:100px"
				     data-ad-client="ca-pub-5144136285411668"
				     data-ad-slot="5521587909"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
	</div>
	
	<nav class="navbar navbar-default" role="navigation">
		
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<center>Menu
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></center>
				</button>
			</div>
		
			<div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li <?php if($_GET['corpus'] == 'home') { echo 'class="active"'; }?>><a href="login0.php?corpus=home"><i class="fa fa-home"></i> Home</a></li>
					
					<?php if($_SESSION['mod_anagrafica'] && $anag->isAnagrafica($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'anagrafica' OR $_GET['corpus']=='ricerca-anagrafica') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user fa-fw"></i> Anagrafica <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=anagrafica"><i class="fa fa-plus fa-fw"></i> Inserisci nuova anagrafica</a></li>
								<li><a href="login0.php?corpus=ricerca-anagrafica"><i class="fa fa-search fa-fw"></i></span> Ricerca in anagrafica</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_protocollo'] && $anag->isProtocollo($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'protocollo' OR $_GET['corpus']=='titolario' OR $_GET['corpus']=='titolario-modifica' OR $_GET['corpus']=='stampa-registro' OR $_GET['corpus'] == 'protocollo2') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book"></i> Protocollo <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=protocollo2&from=crea"><i class="fa fa-plus fa-fw"></i></span> Crea nuovo numero progressivo</a></li>
								<li><a href="login0.php?corpus=ricerca-protocollo"><i class="fa fa-search fa-fw"></i> Ricerca nel protocollo</a></li>
								<li><a href="login0.php?corpus=titolario"><i class="fa fa-list fa-fw"></i> Gestione titolario</a></li>
								<li><a href="login0.php?corpus=pratiche"><i class="fa fa-tags fa-fw"></i> Gestione pratiche</a></li>
								<li><a href="login0.php?corpus=stampa-registro"><i class="fa fa-file-pdf-o fa-fw"></i> Esporta registro in PDF</a></li>
							</ul>
						</li>
					<?php } ?>


					<?php
					if($_SESSION['mod_lettere'] && $anag->isLettere($_SESSION['loginid'])) {
						$user = $_SESSION['loginid'];
						if($anag->isAdmin($_SESSION['loginid'])) {
							$query = mysql_query("SELECT COUNT(*) FROM comp_lettera WHERE (vista = 1 OR vista = 2) AND firmata = 0");
						}
						else {
							$query = mysql_query("SELECT COUNT(*) FROM comp_lettera, joinpersoneuffici WHERE (vista = 1 OR vista = 2) AND firmata = 0 AND joinpersoneuffici.ufficio = comp_lettera.ufficio AND joinpersoneuffici.utente = $user");
						}
						$num = mysql_fetch_row($query);
						$prot = mysql_query("SELECT COUNT(*) FROM comp_lettera WHERE firmata = 1 AND protocollo = 0");
						$protocollare = mysql_fetch_row($prot);
						?>
						<li class="dropdown <?php if($_GET['corpus'] == 'lettera' OR $_GET['corpus']=='lettera2' OR $_GET['corpus']=='elenco-lettere' OR $_GET['corpus']=='elenco-lettere-firma') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?php 
									if($protocollare[0] > 0) {
										echo '<span class="badge alert-success"><i class="fa fa-exclamation"></i></span>';
									}
									else {
										echo '<i class="fa fa-file-text-o"></i>';
									}
								?>
								 Lettere
								<?php 
									if(($num[0] > 0) && ($_SESSION['auth']>=90)) {
										echo '<span class="badge alert-success">' . $num[0] . '</span>';
									}
								?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="login0.php?corpus=lettera"><i class="fa fa-pencil fa-fw"></i> Scrivi lettera</a></li>
								<li><a href="login0.php?corpus=attributi"><i class="fa fa-font fa-fw"></i> Gestione Attributi</a></li>
								<li><a href="login0.php?corpus=elenco-lettere"><i class="fa fa-wrench fa-fw"></i> Lettere in Lavorazione <?php if($protocollare[0] > 0) { echo '<span class="badge alert-success">'. $protocollare[0] .' da protocollare!</span>'; } ?></a></li>
								<li><a href="login0.php?corpus=archivio-lettere"><i class="fa fa-archive fa-fw"></i> Lettere Archiviate</a></li>
								<?php 
									if(($num[0] > 0) && ($_SESSION['auth']>=90)) {
										echo '<li class="divider"></li>';
										echo '<li><a href="login0.php?corpus=elenco-lettere-firma"><i class="fa fa-pencil fa-fw"></i> Lettere da Firmare <span class="badge alert-success">' . $num[0] . '</span></a></li>';
									}
								?>
							</ul>
						</li>
					<?php } ?>

					<?php if($_SESSION['mod_magazzino'] && $anag->isMagazzino($_SESSION['loginid'])) { ?>
						<li class="dropdown <?php if($_GET['corpus'] == 'farm-magazzino' OR $_GET['corpus']=='farmacia') { echo ' active'; }?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cubes"></i> Magazzino <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?corpus=magazzino-prodotti"><i class="fa fa-asterisk fa-fw"></i> Prodotti</a></li>
								<li><a href="?corpus=magazzino-servizi"><i class="fa fa-building-o fa-fw"></i> Servizi</a></li>
								<li><a href="?corpus=magazzino-depositi"><i class="fa fa-suitcase fa-fw"></i> Depositi</a></li>
								<li><a href="?corpus=magazzino-documenti"><i class="fa fa-file-text-o fa-fw"></i> Documenti di Magazzino</a></li>
								<li class="divider"></li>
								<li><a href="?corpus=magazzino-settori"><i class="fa fa-list-ul fa-fw"></i> Settori</a></li>
								<!--<li><a href="?corpus=magazzino-causali"><i class="fa fa-list-ul fa-fw"></i> Causali</a></li>
								<li><a href="#"><i class="fa fa-pencil-square-o"></i> Richieste</a></li>
								<li><a href="#"><i class="fa fa-truck"></i> Ordini</a></li> -->
							</ul>
						</li>
					<?php } ?>
					
				</ul>
		   
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Logged as <strong><?php echo $_SESSION['loginname'];?></strong> <b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">OPZIONI</li>
							<li><a href="login0.php?corpus=cambio-password&loginid=<?php echo $_SESSION['loginid']?>"><i class="fa fa-edit fa-fw"></i> Cambia Password</a></li>
							<li><a href="login0.php?corpus=segnala-bug"><i class="fa fa-warning fa-fw"></i> Segnala un Errore</a></li>
							<li><a href="login0.php?corpus=feedback"><i class="fa fa-thumbs-o-up fa-fw"></i> Invia Feedback</a></li>
							<li><a href="login0.php?corpus=settings"><i class="fa fa-cog fa-fw"></i> Impostazioni</a></li>
							<li><a href="login0.php?corpus=server-mail"><i class="fa fa-envelope-o fa-fw"></i> Impostazioni Server Mail</a></li>
							<li><a href="login0.php?corpus=statistiche"><i class="fa fa-bar-chart fa-fw"></i> Statistiche</a></li>
							<li><a href="http://wiki.abulafia.cricatania.it" target="_blank"><i class="fa fa-wikipedia-w fa-fw"></i> Wiki</a></li>
							<?php 
								if ($_SESSION['auth'] > 95) {
									?>
									<li class="divider"></li>
									<li role="presentation" class="dropdown-header">ADVANCED</li>
									<li><a href="login0.php?corpus=gestione-utenti"><i class="fa fa-users fa-fw"></i> Gestione degli Utenti</a></li>
									<li><a href="login0.php?corpus=advancedsettings"><i class="fa fa-cogs fa-fw"></i> Advanced Settings</a></li>
									<li><a href="login0.php?corpus=diagnostica"><i class="fa fa-wrench fa-fw"></i> Diagnostica</a></li>
									<li class="divider"></li>
									<li role="presentation" class="dropdown-header">LOG</li>
									<li><a href="login0.php?corpus=access-log"><i class="fa fa-key fa-fw"></i> Visualizza il log degli accessi</a></li>
									<li><a href="login0.php?corpus=log-mail"><i class="fa fa-envelope-o fa-fw"></i> Visualizza il log delle mail</a></li>
									<li><a href="login0.php?corpus=history"><i class="fa fa-clock-o fa-fw"></i> Visualizza il log delle azioni</a></li>
									<?php
								}
							?>
							<li class="divider"></li>
							<li><a href="logout.php"><i class="fa fa-power-off fa-fw"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div> 
		</div>
	</nav>
	
<?php
	if ($_GET['corpus'] != 'cambioanno') { 
		$my_registroprotocollo->publcontrolloanno (); //controllo della corrispondenza fra l'anno corrente e l'anno in uso dal db
	}
?>