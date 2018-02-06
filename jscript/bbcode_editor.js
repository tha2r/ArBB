
var clientPC        = navigator.userAgent.toLowerCase(); // Get client info
var is_gecko        = ((clientPC.indexOf('gecko')!=-1) && (clientPC.indexOf('spoofer')==-1)
                                                                && (clientPC.indexOf('khtml') == -1) && (clientPC.indexOf('netscape/7.0')==-1));
var is_safari = ((clientPC.indexOf('AppleWebKit')!=-1) && (clientPC.indexOf('spoofer')==-1));
var is_khtml = (navigator.vendor == 'KDE' || ( document.childNodes && !document.all && !navigator.taintEnabled ));
if (clientPC.indexOf('opera')!=-1) {
        var is_opera = true;
        var is_opera_preseven = (window.opera && !document.childNodes);
        var is_opera_seven = (window.opera && document.childNodes);
}

/**
 * apply tagOpen/tagClose to selection in textarea, use sampleText instead
 * of selection if there is none copied and adapted from phpBB
 *
 * @author phpBB development team
 * @author MediaWiki development team
 * @author Andreas Gohr <andi@splitbrain.org>
 * @author Jim Raynor <jim_raynor@web.de>
 */
function insert_tags(tagOpen, tagClose) {
        var txtarea = document.getElementById('message');
        var sampleText = '';
        // IE
        if(document.selection        && !is_gecko) {
                var theSelection = document.selection.createRange().text;
                var replaced = true;
                if(!theSelection){
                        replaced = false;
                        theSelection=sampleText;
                }
                txtarea.focus();

                // This has change
                text = theSelection;
                if(theSelection.charAt(theSelection.length - 1) == " "){// exclude ending space char, if any
                        theSelection = theSelection.substring(0, theSelection.length - 1);
                        r = document.selection.createRange();
                        r.text = tagOpen + theSelection + tagClose + " ";
                } else {
                        r = document.selection.createRange();
                        r.text = tagOpen + theSelection + tagClose;
                }
                if(!replaced){
                        r.moveStart('character',-text.length-tagClose.length);
                        r.moveEnd('character',-tagClose.length);
                }
                r.select();
        // Mozilla
        } else if(txtarea.selectionStart || txtarea.selectionStart == '0') {
                var replaced = false;
                var startPos = txtarea.selectionStart;
                var endPos         = txtarea.selectionEnd;
                if(endPos - startPos) replaced = true;
                var scrollTop=txtarea.scrollTop;
                var myText = (txtarea.value).substring(startPos, endPos);
                if(!myText) { myText=sampleText;}
                if(myText.charAt(myText.length - 1) == " "){ // exclude ending space char, if any
                        subst = tagOpen + myText.substring(0, (myText.length - 1)) + tagClose + " ";
                } else {
                        subst = tagOpen + myText + tagClose;
                }
                txtarea.value = txtarea.value.substring(0, startPos) + subst + txtarea.value.substring(endPos, txtarea.value.length);
                txtarea.focus();

                //set new selection
                if(replaced){
                        var cPos=startPos+(tagOpen.length+myText.length+tagClose.length);
                        txtarea.selectionStart=cPos;
                        txtarea.selectionEnd=cPos;
                }else{
                        txtarea.selectionStart=startPos+tagOpen.length;
                        txtarea.selectionEnd=startPos+tagOpen.length+myText.length;
                }
                txtarea.scrollTop=scrollTop;
        // All others
        } else {
                var copy_alertText=alertText;
                var re1=new RegExp("\\$1","g");
                var re2=new RegExp("\\$2","g");
                copy_alertText=copy_alertText.replace(re1,sampleText);
                copy_alertText=copy_alertText.replace(re2,tagOpen+sampleText+tagClose);
                var text;
                if (sampleText) {
                        text=prompt(copy_alertText);
                } else {
                        text="";
                }
                if(!text) { text=sampleText;}
                text=tagOpen+text+tagClose;
                //append to the end
                txtarea.value += "\n"+text;

                // in Safari this causes scrolling
                if(!is_safari) {
                        txtarea.focus();
                }

        }
        // reposition cursor if possible
        if (txtarea.createTextRange) txtarea.caretPos = document.selection.createRange().duplicate();
}

function insert_smiley(code) {

        insert_tags(' '+code+' ', '');

}

function one_tag(code) {

        insert_tags('['+code+']', '[/'+code+']');

}

function promot_tag(code) {

if(code=='2')
{
var link = prompt("Enter The Link for the image .. Example Http://www.ar-bb.com/logo.gif", "Your Image Location")
var reply = '';
var tag  = 'img';
}
else
{
 if(code == '1')
 {
var text1 = "Your Text";
var text2 = "Enter the URL .. Example Http://www.ar-bb.com";
var tag   = "url";
 }
 else
 {
  if(code == '3')
  {
  var text1 = "Your Text";
  var text2 = "Your Email Address";
  var tag   = "email";
  }
 }
var reply = prompt(text1, "your text here")
var link = prompt(text2, "http://link.location")
}
 if(code == '2' && link != 'Your Image Location')
 {
  insert_tags('['+tag+']'+link+'', '[/'+tag+']');
 }
 else
 {

if(link != '' && reply != '' && link != 'http://link.location')
{
        insert_tags('['+tag+'='+reply+']'+link+'', '[/'+tag+']');
}
else
{

  alert('Error .. You must enter values');
 }
}

}

function two_tags(code,value) {

        insert_tags('['+code+'='+value+']', '[/'+code+']');

}

