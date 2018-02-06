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
#    Admin User Titles manager File Started
#
/*
        File name       -> usertitles.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'usertitles_add,
                 usertitles_manage,
                 usertitles_edit,
                 usertitles_delete,
                 usertitles_manage_title';

$phrasearray=array('admincp');

require('global.php');
build_nav_location($lang['adminmenu_usertitles'],'usertitles.php?sid=$sid');
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';

if(($arbb->input['do']=='add') OR ($arbb->input['do']=='do_add'))
{

$titleetc=$lang['adminmenu_addusertitle'].' - ';
 if($arbb->input['do']=='add')
 {
    $TP->WebTemp('usertitles_add');
 }
 else
 {
    $array=array('title'    => $arbb->input['title'],
                 'minposts' => $arbb->input['minposts']);

    $DB->multible_insert($array,'usertitle');
    redirect($lang['usertitle_added'],"usertitles.php?do=manage&sid=$sid");
 }
}
elseif($arbb->input['do'] == "manage")
{
$titles="";
$titleetc=$lang['adminmenu_usertitlemanage']." - ";
$query=$DB->query("select * from "._PREFIX_."usertitle order by minposts ASC");
while($ut = $DB->fetch_array($query))
{
 $titles .= $TP->GetTemp("usertitles_manage_title");
}
 $TP->WebTemp("usertitles_manage");
}
elseif(($arbb->input['do']=="delete") OR ($arbb->input['do']=="edit"))
{
$ut=$DB->query_now("select * from "._PREFIX_."usertitle where usertitleid='".checkval($arbb->input['tid'])."'");
if(!$ut)
{
 header("location:usertitles.php?sid=$sid");
}
$titleetc=$lang[$arbb->input['do']]." : ".$ut['title']." - ";
$TP->WebTemp("usertitles_".$arbb->input['do']);


}
elseif(($arbb->input['do']=="do_edit") OR ($arbb->input['do']=="do_delete"))
{
$ut=$DB->query_now("select * from "._PREFIX_."usertitle where usertitleid='".checkval($arbb->input['tid'])."'");
if(!$ut)
{
 header("location:usertitles.php?sid=$sid");
}
if($arbb->input['do']=="do_delete")
{
  $DB->query("Delete from "._PREFIX_."usertitle where usertitleid='$ut[usertitleid]'");
 redirect($lang['usertitle_deleted'],"usertitles.php?sid=$sid");
}
else
{
$array=array("title"    => $arbb->input['title'],
             "minposts" => $arbb->input['minposts']);

$DB->update($array,"usertitle","usertitleid='$ut[usertitleid]'");
 redirect($lang['usertitle_edited'],"usertitles.php?sid=$sid");
}

}
if(!$titleetc)
{
    $titleetc=$lang['adminmenu_usertitles']." - ";
}
print_page();
?>