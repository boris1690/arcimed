/*
var ns4 = (document.layers)? true:false
var ie4 = (document.all)? true:false
//var ff2 = (document.all)? true:false

// Show/Hide functions for non-pointer layer/objects
function show(id) {
	if (ns4) document.layers[id].visibility = "show"
	else if (ie4) document.all[id].style.visibility = "visible"
}

function hide(id) {
	if (ns4) document.layers[id].visibility = "hide"
	else if (ie4) document.all[id].style.visibility = "hidden"
}
//ocultar
function ocultar()
{
javascript:hide('catalog')
}
*/

function show(id) {
	//document.all[id].style.visibility = "visible"
	document.getElementById(id).style.visibility = "visible";
}

function hide(id) {
	//document.all[id].style.visibility = "hidden"
	document.getElementById(id).style.visibility = "hidden";
}