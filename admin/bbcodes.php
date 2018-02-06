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
#    Admin BBCodes manager File Started
#
/*
        File name       -> bbcodes.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'bbcodes_add,
                 bbcodes_manage,
                 bbcodes_edit,
                 bbcodes_delete,
                 bbcodes_manage_bit';

$phrasearray=array('admincp');

require('global.php');
build_nav_location($lang['adminmenu_bbcodes'],'avatars.php?sid=$sid');
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';

if($arbb->input['do']=='add')
{
$titleetc=$lang['adminmenu_addbbcode'].' - ';
 $TP->WebTemp('bbcodes_add');
}
elseif($arbb->input['do']=='do_add')
{
$titleetc=$lang['adminmenu_addbbcode'].' - ';
  $array=array('tag','replacement','example','explanation','parms','image');
  $ins=array();

  foreach($array as $val)
  {
   $ins[$val]=addslashes($arbb->input[$val]);
  }

  $DB->insert($ins,'bbcode');
  redirect($lang['bbcode_added'],"bbcodes.php?sid=$sid");
}
elseif($arbb->input['do']=='manage')
{
  $query=$DB->query("select * from "._PREFIX_."bbcode");
  while($bb = $DB->fetch_array($query))
  {
   $bbcodes .= $TP->GetTemp('bbcodes_manage_bit');
  }

$TP->WebTemp('bbcodes_manage');
}
elseif(
        ($arbb->input['do']=='delete')
                      OR
         ($arbb->input['do']=='edit')
      )
{
$sel=array();
 $id=checkval($arbb->input['id']);
 $bb = $DB->query_now("select * from "._PREFIX_."bbcode where bid='$id'");
 if(!$bb)
 {
   header("location:bbcodes.php?sid=$sid");
 }
 $titleetc=$lang[$arbb->input['do']].": $bb[tag]".' - ';

 $sel["$bb[parms]"]='selected';
 $TP->WebTemp('bbcodes_'.$arbb->input['do'].'');

}
elseif($arbb->input['do']=='do_delete')
{
 $id=checkval($arbb->input['id']);
 $bb = $DB->query_now("select * from "._PREFIX_."bbcode where bid='$id'");
 if(!$bb)
 {
   header("location:bbcodes.php?sid=$sid");
 }

 $query=$DB->query('delete from '._PREFIX_."bbcode where bid='$bb[bid]'");

 redirect(sprintf($lang['bbcode_deleted'],$bb['tag']),"bbcodes.php?sid=$sid&");
}
elseif($arbb->input['do']=='do_edit')
{
$ins = array();
$bid=checkval($arbb->input['id']);
 $arrayed=array('tag','example','replacement','image','parms','explanation');
 foreach($arrayed as $key => $val)
 {
  $ins[$val] = $arbb->input[$val];
 }

$DB->update($ins,'bbcode',"bid='$bid'");
redirect($lang['bbcode_updated'],"bbcodes.php?sid=$sid");

}

if(!$titleetc)
{
    $titleetc=$lang['adminmenu_bbcodes'].' - ';
}
print_page();
?>