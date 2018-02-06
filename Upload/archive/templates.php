<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/
#
#    Archive Templates functions file started
#
/*
        File name       -> templates.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> functions
*/

        function print_archive()
        {
        GLOBAL $lang,$options,$base_url,$nav;
        GLOBAL $fullversionurl,$fullversiontitle,$titleetc;
        build_nav_location('','','build');
        print ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"$lang[dir]\" xml:lang=\"en\" lang=\"en\">
<head>
<title>$titleetc$options[sitetitle]</title>
<meta http-equiv=\"content-type\" content=\"text/html; charset=$lang[charset]\" />
<meta name=\"robots\" content=\"index,follow\" />
<link type=\"text/css\" rel=\"stylesheet\" rev=\"stylesheet\" href=\"style.css\" media=\"screen\" />
</head>
<body>
<div id=\"container\">
<div class=\"navigation\">$nav[location]</div>
<br>
<div id=\"fullversion\">
<strong>$lang[full_version] : </strong> <a href=\"$fullversionurl\">$fullversiontitle</a>
</div>
</br>
<div id=\"content\">
$options[webcontent]
</div>
</div>
<div align=\"center\">
        <div class=\"smallfont\" align=\"center\">
        $lang[powered_by]
        </div>
        <div class=\"smallfont\" align=\"center\">
        $options[copyright_text]
        </div>
</div>
</body>
</html>");

        }

        function archive_table($forums_list,$phrase)
        {
        GLOBAL $lang;
                return "
                <div class=\"listing forumlist\">
                <div class=\"header\">$phrase</div>
                $forums_list
                </div>
                </div>";
        }

        function subbit($url,$text)
        {

        return "
        <ol>
        <li>
        <a href=\"$url\">$text</a>
        </li>
        </ol>
        ";

        }

        function mainbit($subbits,$url,$text)
        {

        return "<div class=\"forums\">
        <ul>
        <li>
        <strong>
        <a href=\"$url\">$text</a>
        </strong>
        <ol>
        $subbits
        </ol>
        </li>
        </ul>";

        }

        function print_post($post)
        {
        GLOBAL $lang;

        return "<table class=\"listing forumlist\" width=\"100%\" align=center>
        <tr>
        <td class=\"header\">
                <div style=\"float:$lang[right]\">$post[date]</div>
                <a href=\"../member.php?userid=$post[userid]\">$post[username]</a> - ($post[usertitle])</td></tr>
                <tr><td>
                $post[post]
                </td></tr></table>";

        }
?>