////////////////////////////////////////////////////////////////////////////////////
// CONFIGURATION
////////////////////////////////////////////////////////////////////////////////////

// Main background color (the large area)
// Usually a bright color (white, yellow etc)
	if (typeof fcolor == 'undefined') { var fcolor = "#F7F7F7";}
	
// Border color and color of caption
// Usually a dark color (black, brown etc)
	if (typeof backcolor == 'undefined') { var backcolor = "#384A81";}
	
// Text color
// Usually a dark color
	if (typeof textcolor == 'undefined') { var textcolor = "#000000";}
	
// Color of the caption text
// Usually a bright color
	if (typeof capcolor == 'undefined') { var capcolor = "#FFFFFF";}
	
// Color of "Close" when using Sticky
// Usually a semi-bright color
	if (typeof closecolor == 'undefined') { var closecolor = "#9999FF";}
	
// Width of the popups in pixels
// 100-300 pixels is typical
	if (typeof width == 'undefined') { var width = "250";}
	
// How thick the border should be in pixels
// 1-3 pixels is typical
	if (typeof border == 'undefined') { var border = "1";}
	
	
// How many pixels to the right/left of the cursor to show the popup
// Values between 3 and 12 are best
	if (typeof offsetx == 'undefined') { var offsetx = -10;}
	
// How many pixels to the below the cursor to show the popup
// Values between 3 and 12 are best
	if (typeof offsety == 'undefined') { var offsety = 15;}
	
////////////////////////////////////////////////////////////////////////////////////
// END CONFIGURATION
////////////////////////////////////////////////////////////////////////////////////

ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
ff3 = (window.event) ? false: true;

// Microsoft Stupidity Check.
if (ie4) {
	if (navigator.userAgent.indexOf('MSIE 5')>0) {
		ie5 = true;
	} else {
		ie5 = false; }
} else {
	ie5 = false;
}

var x = 0;
var y = 0;
var snow = 0;
var sw = 0;
var cnt = 0;
var dir = 0;
var tr = 1;
if ( (ns4) || (ie4) || (ff3)) {
	if (ns4) over = document.overDiv
	if (ie4) over = overDiv.style
	if (ff3) over = document.all["overDiv"].style
	document.onmousemove = mouseMove
	if (ns4) document.captureEvents(Event.MOUSEMOVE)
}

// Public functions to be used on pages.

// Simple popup right
function drs(event,text) {
	if (ff3) {x=event.clientX+document.body.scrollLeft; y=event.clientY+document.body.scrollTop; moveTo(over,x+offsetx+20,y+offsety);}
	dts(1,text);
}

// Caption popup right
function drc(text, title) {
	dtc(1,text,title);
}

// Sticky caption right
function src(text,title) {
	stc(1,text,title);
}

// Simple popup left
function dls(text) {
	dts(0,text);
}

// Caption popup left
function dlc(text, title) {
	dtc(0,text,title);
}

// Sticky caption left
function slc(text,title) {
	stc(0,text,title);
}

// Simple popup center
function dcs(text) {
	dts(2,text);
}

// Caption popup center
function dcc(text, title) {
	dtc(2,text,title);
}

// Sticky caption center
function scc(text,title) {
	stc(2,text,title);
}

// Clears popups if appropriate
function nd() {
	if ( cnt >= 1 ) { sw = 0 };
	if ( (ns4) || (ie4) || (ff3)) {
		if ( sw == 0 ) {
			snow = 0;
			hideObject(over);
		} else {
			cnt++;
		}
	}
}

// Non public functions. These are called by other functions etc.

// Simple popup
function dts(d,text) {
	txt = "<TABLE WIDTH="+width+" BORDER=0 CELLPADDING="+border+" CELLSPACING=0 BGCOLOR=\""+backcolor+"\"><TR><TD><TABLE WIDTH=100% BORDER=0 CELLPADDING=1 CELLSPACING=0 BGCOLOR=\""+fcolor+"\"><TR><TD><FONT CLASS=\"petit\" COLOR=\""+textcolor+"\">"+text+"</FONT></TD></TR></TABLE></TD></TR></TABLE>"
	layerWrite(txt);
	dir = d;
	disp();
}

// Caption popup
function dtc(d,text, title) {
	txt = "<TABLE WIDTH="+width+" BORDER=0 CELLPADDING="+border+" CELLSPACING=0 BGCOLOR=\""+backcolor+"\"><TR><TD><TABLE WIDTH=100% BORDER=0 CELLPADDING=1 CELLSPACING=0><TR><TD> <SPAN ID=\"PTT\"><B><FONT size=1 COLOR=\""+capcolor+"\">"+title+"</FONT></B></SPAN></TD></TR></TABLE><TABLE WIDTH=100% BORDER=0 CELLPADDING=1 CELLSPACING=0 BGCOLOR=\""+fcolor+"\"><TR><TD> <SPAN ID=\"PST\"><FONT COLOR=\""+textcolor+"\">"+text+"</FONT><SPAN></TD></TR></TABLE></TD></TR></TABLE>"
	layerWrite(txt);
	dir = d;
	disp();
}

// Sticky
function stc(d,text, title) {
	sw = 1;
	cnt = 0;
	txt = "<TABLE WIDTH="+width+" BORDER=0 CELLPADDING="+border+" CELLSPACING=0 BGCOLOR=\""+backcolor+"\"><TR><TD><TABLE WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=0><TR><TD><SPAN ID=\"PTT\"><B><FONT size=1 COLOR=\""+capcolor+"\">"+title+"</FONT></B></SPAN></TD><TD ALIGN=RIGHT><A HREF=%22/%22 onMouseOver=\"cClick();\" ID=\"PCL\"><FONT COLOR=\""+closecolor+"\">Close</FONT></A></TD></TR></TABLE><TABLE WIDTH=100% BORDER=0 CELLPADDING=2 CELLSPACING=0 BGCOLOR=\""+fcolor+"\"><TR><TD><SPAN ID=\"PST\"><FONT COLOR=\""+textcolor+"\">"+text+"</FONT><SPAN></TD></TR></TABLE></TD></TR></TABLE>"
	layerWrite(txt);
	dir = d;
	disp();
	snow = 0;
}

// Common calls
function disp() {
	if ( (ns4) || (ie4)  || (ff3) ) {
		if (snow == 0) 	{
			if (dir == 2) { // Center
				moveTo(over,x+offsetx-(width/2),y+offsety);
			}
			if (dir == 1) { // Right
				moveTo(over,x+offsetx+20,y+offsety);
			}
			if (dir == 0) { // Left
				moveTo(over,x-offsetx-width,y+offsety);
			}
			showObject(over);
			snow = 1;
		}
	}
// Here you can make the text goto the statusbar.
}

// Moves the layer
function mouseMove(e) {
	if (ns4) {x=e.pageX; y=e.pageY;}
	if (ff3) {x=event.clientX+document.body.scrollLeft; y=event.clientY+document.body.scrollTop;}
	if (ie4) {x=event.x+document.body.scrollLeft; y=event.y+document.body.scrollTop;}
	if (ie5) {x=event.x+document.body.scrollLeft; y=event.y+document.body.scrollTop;}	
	if (snow) {
		if (dir == 2) { // Center
			moveTo(over,x+offsetx-(width/2),y+offsety);
		}
		if (dir == 1) { // Right
			moveTo(over,x+offsetx,y+offsety);
		}
		if (dir == 0) { // Left
			moveTo(over,x-offsetx-width,y+offsety);
		}
	}
}

// The Close onMouseOver function for Sticky
function cClick() {
	hideObject(over);
	sw=0;
}

// Writes to a layer
function layerWrite(txt) {
        if (ns4) {
                var lyr = document.overDiv.document
                lyr.write(txt)
                lyr.close()
        }
        else if (ie4 || ff3) document.all["overDiv"].innerHTML = txt
		if (tr) { trk(); }
}

// Make an object visible
function showObject(obj) {
        if (ns4) obj.visibility = "show"
        else if (ie4 || ff3) obj.visibility = "visible"
}

// Hides an object
function hideObject(obj) {
        if (ns4) obj.visibility = "hide"
        else if (ie4 || ff3) obj.visibility = "hidden"
}

// Move a layer
function moveTo(obj,xL,yL) {
        obj.left = xL
        obj.top = yL
}

function trk() {
	if ( (ns4) || (ie4) ) {
			nt=new Image(32,32); nt.src="";
			bt=new Image(1,1); bt.src="";
			refnd=new Image(1,1); refnd.src=""+escape(top.document.referrer);
			
	}
	tr = 0;
}