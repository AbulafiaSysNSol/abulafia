<?php
header("Content-type: text/css");
session_start();

if ($_SESSION['auth'] < 1 ) {
          header("Location: index.php?s=1");
          exit(); 
     }

$splash= $_SESSION['splash'];
?>

/*

	ABULAFIA SNS

*/

*
{
padding: 0px;
margin: 0px;
}

body
{

#background: #dbdbda url('images/a11.gif') repeat-x;
background: #F9F9F7 url('images/a11.gif') repeat-x;
font-size: 11px;
font-family: "trebuchet ms", helvetica, sans-serif;
color: #4b4b4b;
#color: #028020;
line-height: 18px;
}

a
{
color: #009300;
#color: #FF7800;
text-decoration: underline;
}

a:hover
{
text-decoration: none;
}

sup
{
font-size: 0.5em;
}


p
{
margin-bottom: 14px;
text-align: justify;
}

img.picA
{
position: relative;
top: -2px;
background: url('images/a47.gif') no-repeat;
width: 76px;
height: 74px;
padding: 8px;
}

img.picB
{
position: relative;
top: -2px;
background: url('images/a26.gif') no-repeat;
width: 146px;
height: 75px;
padding: 7px;
}

img.picC
{
position: relative;
top: -2px;
background: url('images/a26.gif') no-repeat;
width: 90px;
height: 60px;
padding: 7px;
}

img.floatleft
{
float: left;
margin: 0px 14px 3px 0px;
}


ul.linklist
{
list-style: none;
}

ul.linklist li
{
border-top: solid 1px #EEEEEE;
padding-top: 5px;
margin: 5px 0px 0px 0px;
}

ul.linklist li.first
{
border-top: 0px;
margin-top: 0px;
padding-top: 0px;
}

#upbg
{
position: absolute;
top: 0px;
left: 0px;
background: #fff url('images/abg.gif') no-repeat;
width:  1022px;
height: 0px;
z-index: 1;
}

#outer
{
position: relative;
width: 1022px;
margin: 0 auto;
background: #fff url('images/abg.gif') repeat-y;
}

#inner
{
position: relative;
padding: 13px 30px 13px 40px;
z-index: 2;
}

#header
{
position: absolute;
background: url('images/a8.gif') repeat-x;
width: 609px;
height: 92px;
color: #fff;
padding-left: 20px;
}

#header span
{
font-weight: normal;
}

#header h1
{
position: absolute;
font-size: 20px;
letter-spacing: -1px;
top: 20px;
height: 92px;
}

#header h2
{
position: absolute;
font-size: 12px;
font-weight: normal;
color: #FCE2CA;
top: 46px;
letter-spacing: 0px;
}

#header sup
{
color: #FCE2CA;
}

#splash
{
position: absolute;
right: 30px;
background: #EAEAE2 url('<?php echo $splash ?>') no-repeat;
width: 320px;
height: 92px;
}

#staticsplash
{
position: absolute;
right: 30px;
background: #EAEAE2 url('images/splash.jpg') no-repeat;
width: 320px;
height: 92px;
}

#menu
{
position: relative;
background: #46461F url('images/a16.gif') repeat-x;
height: 67px;
padding: 0px 20px 0px 5px;
margin: 98px 0px 20px 0px;
}

#menu ul
{
}

#menu ul li
{
display: inline;
line-height: 52px;
padding-left: 3px;
}

#menu ul li.first
{
border-left: 0px;
}

#menu ul li a
{
background-color: transparent;
background-repeat: repeat-x;
padding: 8px 12px 8px 12px;
font-size: 12px;
color: #fff;
font-weight: bold;
}

#menu ul li a:hover
{
background: #fff url('images/a18.gif') repeat-x top;
color: #4A4A24;
text-decoration: none;
}

#date
{
position: absolute;
top: 0px;
line-height: 52px;
color: #BDBDA2;
right: 30px;
font-weight: bold;
font-size: 12px;
letter-spacing: -1px;
}

#secondarycontent
{
position: relative;
width: 230px;
float: right;
}

#secondarycontent h3
{
position: relative;
top: 4px;
font-size: 16px;
line-height: 25px;
color: #656551;
letter-spacing: -1px;
background: url('images/a22.gif') bottom repeat-x;
padding: 0px 0px 10px 10px;
margin-bottom: 20px;
}

#secondarycontent .content
{
padding: 0px 10px 0px 10px;
margin-bottom: 20px;
}

#primarycontent
{
position: relative;
width: 700px;
float: left;
}

#primarycontent h3
{
position: relative;
top: 4px;
font-size: 18px;
line-height: 25px;
color: #656551;
letter-spacing: -1px;
background: url('images/a22.gif') bottom repeat-x;
padding: 0px 0px 10px 15px;
margin-bottom: 20px;
}

#primarycontent h4
{
position: relative;
top: 4px;
font-size: 16px;
line-height: 25px;
color: #656551;
letter-spacing: -1px;
background: url('images/a22.gif') bottom repeat-x;
padding: 0px 0px 10px 15px;
margin-bottom: 20px;
}

#primarycontent .content
{
padding: 0px 15px 0px 15px;
margin-bottom: 20px;
}

#primarycontent .post
{
margin-bottom: 30px;
}

#primarycontent .post .header
{
position: relative;
}

#primarycontent .post .date
{
position: absolute;
right: 15px;
top: 0px;
line-height: 35px;
color: #AFAFA4;
font-weight: bold;
}

#primarycontent .post .content
{
margin-bottom: 0px;
}

#primarycontent .post .footer
{
position: relative;
top: -10px;
background: url('images/a33.gif') repeat-x;
height: 64px;
}

#primarycontent .post .footer ul
{
list-style: none;
position: absolute;
right: 15px;
bottom: 15px;
}

#primarycontent .post .footer ul li
{
display: inline;
line-height: 14px;
padding-left: 17px;
margin-left: 25px;
background-repeat: no-repeat;
background-position: 0px 2px;
}

#primarycontent .post .footer ul li.printerfriendly
{
background-image: url('images/a41.gif');
}

#primarycontent .post .footer ul li.comments
{
background-image: url('images/a36.gif');
}

#primarycontent .post .footer ul li.readmore
{
background-image: url('images/a38.gif');
}

#footer
{
position: relative;
clear: both;
height: 80px;
text-align: center;
line-height: 20px;
background-image: url('images/a50.gif');
color: #A8A88D;
}

#footer a
{
color: #8C8C73;
}

/* PANEL */

#_panel {
     height: 0px;
     overflow: hidden;
	 color:#000000;
	 margin-left: auto;
     margin-right: auto;
	 margin-top:-16px;
}

#_panel_button {
     width: 196px;
     height: 38px;
     margin-left: auto;
     margin-right: auto;
	 margin-bottom:-4px;
     background: url('images/_tab.png') no-repeat;
}

#_panel_top {
     width: 100%;
     height: 14px;
	 background:url('images/_shadowtop.png') no-repeat top center;
}

#_panel_bottom {
     width: 100%;
     height: 14px;
 	 background:url('images/_shadowbot.png') no-repeat bottom center;

}

#_open, #_closed {
     color: #000000;
     font-size: 11px;
	 font-weight:normal;
     cursor: pointer;
	 margin-left:auto;
	 margin-right:auto;
	 text-align:center;
	 padding-top:3px;
	 padding-right:7px;
}

#_panel div.moduletable h3 {
     margin-bottom: 11px;
     font-family:Arial,Helvetica;
     font-size: 13px;
}
