/**
 *  Arbb 1.0.0 (beta 1)
 *  All Copyrights are saved Arabian bulletin board team
 *  Copyright © 2009 ArBB Team
 *  ArBB Is Free Bulletin Board and not for sale
**/
//#
//#    pm_popup java script File started
//#


var ie = document.all;
var nn6 = document.getElementById &&! document.all;

var isdrag = false;
var x, y;
var dobj;

function movemouse( e ) {
  if( isdrag ) {
    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
    return false;
  }
}

function selectmouse( e ) {
  var fobj       = nn6 ? e.target : event.srcElement;
  var topelement = nn6 ? "HTML" : "BODY";

  while (fobj.tagName != topelement && fobj.className != "dragme") {
    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
  }

  if (fobj.className=="dragme") {
    isdrag = true;
    dobj = document.getElementById("styled_popup");
    tx = parseInt(dobj.style.left+0);
    ty = parseInt(dobj.style.top+0);
    x = nn6 ? e.clientX : event.clientX;
    y = nn6 ? e.clientY : event.clientY;
    document.onmousemove=movemouse;
    return false;
  }
}

function styledPopupClose() {
  document.getElementById("styled_popup").style.display = "none";
}

document.onmousedown=selectmouse;
document.onmouseup=new Function("isdrag=false")