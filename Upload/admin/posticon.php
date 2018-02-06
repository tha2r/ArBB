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
#    Admin Post Icons Manager File Started
#
/*
        File name       -> posticon.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'posticon_manage,posticon_add,posticon_delete';

$phrasearray=array('admincp');

require('global.php');
build_nav_location($lang['adminmenu_posticons'],"posticon.php?sid=$sid");
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';

if($arbb->input['do']=='manage')
{
$query=$DB->query("select * from "._PREFIX_."icon");
$posticons='';
   $i=0;
   while($ic = $DB->fetch_array($query))
   {
    $i++;
    $st=$i;
    if($st > 2)
    {
     $st=$st-2;
    }
    $posticons.= "<td width=\"20%\" align=\"center\" class=\"td$st\" valign=\"bottom\">$ic[title]<br><br>
    <img src=\"../$ic[iconpath]\"><br><a href=\"posticon.php?do=delete&id=$ic[iconid]\">[$lang[delete]]</a></td>";
           if($i==4)
           {
            $posticons.='</tr><tr>';
            $i=0;
           }
   }

$TP->WebTemp('posticon_manage');

}
elseif($arbb->input['do']=='add')
{
  $titleetc=$lang['adminmenu_addposticon'].' - ';
$random=random_string(3);

 $TP->WebTemp('posticon_add');
}
elseif($arbb->input['do']=='do_add')
{

$path=$bbcode->clearhtml(addslashes($DB->escape_string($arbb->input['path'])));
$title=$bbcode->clearhtml($arbb->input['title']);

$posticon=array('iconpath' => $path,
                'title'    => $title,
                'cat'      => '2');

$query = $DB->query("select * from "._PREFIX_."icon where iconpath='$path'");

if($DB->num_rows($query)>0)
{
 error_message($lang['icon_in_db']);
}

if(!is_file('../'.$path)||!file_exists('../'.$path))
{
 error_message($lang['icon_file_not_exists']);
}

$DB->insert($posticon,'icon');
redirect($lang['posticon_added'],"posticon.php?sid=$sid&");
}
if(
   ($arbb->input['do']=='delete')
           OR
   ($arbb->input['do']=='do_delete')
  )
{
$ic=$DB->query_now("select * from "._PREFIX_."icon where iconid='".$DB->escape_string($arbb->input['id'])."'");
if(!$ic)
{
     header("location:$HTTP_SERVER_VARS[HTTP_REFERER]");
}
$titleetc=$lang['delete'].' : '.$ic['title'].' - ';
if($arbb->input['do']=='delete')
{
$TP->WebTemp('posticon_delete');
}
else
{
 $del = $DB->query("delete from "._PREFIX_."icon where iconid='".$DB->escape_string($arbb->input['id'])."'");
 if($del)
 {
  @unlink('../'.$ic['iconpath']);
 }

 redirect($lang['posticon_deleted'],"posticon.php?sid=$sid&");

}

}


if(!$titleetc)
{
    $titleetc=$lang['adminmenu_posticons'].' - ';
}
print_page();
?>