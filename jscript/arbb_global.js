/**
 *  Arbb 1.0.0 (beta 1)
 *  All Copyrights are saved Arabian bulletin board team
 *  Copyright © 2009 ArBB Team
 *  ArBB Is Free Bulletin Board and not for sale
**/
//#
//#    ArBB_global java script File started
//#
/*
        File name       -> ArBB_global.js
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Java Script Functions
*/

function openwindow(url,window_width, window_height,window_id)
{
         // Toolbar setting

        setting="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes";

        // if is set window width
        if(window_width)
        {
                // window width setting
                setting = setting+",width="+window_width;
        }

        // if is set window heigh
        if(window_height)
        {
                // window heigh setting
                setting = setting+",height="+window_height;
        }

        // now open the window with our setting :)
        window.open(url,window_id,setting);
}

        function checkAll(formName)
        {
                for(var i=0;i<formName.elements.length;i++)
                {
                        var element = formName.elements[i];
                        if((element.name != "allbox") && (element.type == "checkbox"))
                        {
                                element.checked = formName.allbox.checked;
                        }
                }
        }

        function expandcollapse(group)
        {
          var subnavdiv = document.getElementById('table_'+group);
          var subnavbtn = document.getElementById('button_'+group);

          if(subnavdiv.style.display=='none')
          {
           subnavdiv.style.display='';
           subnavbtn.src='images/buttons/collapse.gif';
           }
           else
           {
            subnavdiv.style.display='none';
            subnavbtn.src='images/buttons/expand.gif';
           }
        }

        function pofile_div(divid)
        {
          var signature = document.getElementById('signature');
          var threads = document.getElementById('threads');
          var statistics = document.getElementById('statistics');
          var userinfo = document.getElementById('userinfo');
          var divdiv = document.getElementById(divid);

           signature.style.display='none';
           threads.style.display='none';
           statistics.style.display='none';
           userinfo.style.display='none';

           divdiv.style.display='';

        }

function styledPopupClose() {
  document.getElementById("styled_popup").style.display = "none";
}