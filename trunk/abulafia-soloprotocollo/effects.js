
var panelclick = 0;
var panelbig = 0;
var panelboxbig = 0;

var panelsmall = 0;
var panelboxsmall = 0;
var boxheightquery = 0;


function panel() {

if (panelclick == 0) {
panel3();
document.getElementById("panel_holder").value = "1";
store_form_panel();
document.getElementById("_open").style.display = 'none'; 
document.getElementById("_closed").style.display = 'block'; 
}

if (panelclick == 1) {
panel4();
document.getElementById("panel_holder").value = "2";
store_form_panel();
document.getElementById("_open").style.display = 'block'; 
document.getElementById("_closed").style.display = 'none'; 
}

}



function panel3() {


if (panelboxbig >= panelholder) {
document.getElementById("_panel").style.height = panelholder +'px';
panelclick = 1;
panelboxbig = 0;
panelbig = 0;
}
else {
window.setTimeout('increasepanelbox()',50);
}
}


function increasepanelbox() {
document.getElementById("_panel").style.height = panelboxbig +'px';
panel3();
panelboxbig = panelboxbig + 20;
}


function panel4() {

if (document.getElementById("_panel").offsetHeight > 1)
{
window.setTimeout('decreasepanelbox()',50);
}

}

function decreasepanelbox() {

panelheightquery = document.getElementById("_panel").offsetHeight;
panelheightquery = panelheightquery*1;

document.getElementById("_panel").style.height = panelheightquery - 20 +'px';


if (document.getElementById("_panel").offsetHeight < 20) {
document.getElementById("_panel").style.height = '0px';
panelclick = 0;
}


panel4();
}


var _right_column_height = 0;
var _main_column_height = 0;

var _right_column_inner_height = 0;
var _main_column_inner_height = 0;

function _set_body_height() {
	if (document.getElementById("_right_column")) {
		if (document.getElementById("_content_area")) {
		
		if ((_right_column_inner_height != document.getElementById("_right_column_inner").offsetHeight) || (_main_column_inner_height != document.getElementById("_content_area_inner").offsetHeight)){
				document.getElementById("_content_area").style.height = "auto";
				document.getElementById("_right_column").style.height = "auto";
				_right_column_height = document.getElementById("_right_column").offsetHeight;
				_main_column_height = document.getElementById("_content_area").offsetHeight;
			
				if (_right_column_height > _main_column_height) {
					document.getElementById("_content_area").style.height = _right_column_height + "px";
				}
				
				if (_right_column_height < _main_column_height) {
					document.getElementById("_right_column").style.height = _main_column_height + "px";
				}
				
				_right_column_height = document.getElementById("_right_column").offsetHeight;
				_main_column_height = document.getElementById("_content_area").offsetHeight;
				
				_right_column_inner_height = document.getElementById("_right_column_inner").offsetHeight;
				_main_column_inner_height = document.getElementById("_content_area_inner").offsetHeight;
			}
			
		}
	}
}


var _body_Interval = 0;
_body_Interval = window.setInterval("_set_body_height()",200);
