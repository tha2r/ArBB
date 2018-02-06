<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/

#Requiring Neded Files
Require_once("global.php");

if(empty($arbb->input[Action])){

$dbquery=$DB->query("select * from phrasetype order by title desc");
$dbrwo=$DB->num_rows($dbquery);
while($row=$DB->fetch_array($dbquery))
{
        extract ($row);
        if($name == "admincp")
        {
         $sel="selected";
        }
        else
        {
         $sel="";
        }
$styleoptions.="\n<option $sel value='$name'>$title</option>
";
}
Echo "<html dir=rtl><form action=\"$php_self?Action=Add\" method=post>"
        ."<br>«·⁄‰Ê«‰&nbsp;&nbsp;&nbsp;&nbsp; : <input type=text name=\"PhraseName\">
        <br>
        „ﬂ«‰    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : <select name=\"Phrasetype\">$styleoptions</select>
        <br>    «·„Õ ÊÏ&nbsp;&nbsp;  :
        <textarea name=\"Phrase\"></textarea><br>
         <input type=submit>";
}
else
{
        $PhraseName=$arbb->input[PhraseName];
        $Phrasetype=$arbb->input[Phrasetype];
        $Phrase=$arbb->input[Phrase];
$queryfirs=$DB->query("insert into phrase (varname,languageid,text,phrasetype,username,dateline,version) Values ('$PhraseName','1','$Phrase','$Phrasetype','Thaer','".time()."','".IN_ARBB."')");
Echo "GoBack <a href=$PHP_SELF>GoBack</a>";
}
?>