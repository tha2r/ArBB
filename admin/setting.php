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
#    admin Control panel setting File started
#
/*
        File name       -> setting.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'setting_main,setting_edit,setting_edit_sub,setting_edit_main';

$phrasearray=array('admincp');

require('global.php');

build_nav_location($lang['edit_settings'],"setting.php?sid=$sid");
if(empty($arbb->input['action']))
{
$settingselect='';
$query=$DB->query("select * from "._PREFIX_."settinggroup");
while($sel = $DB->fetch_array($query))
{
   $settingselect.="<option value=\"$sel[sgid]\">$sel[title]</option>\n";
}
$TP->WebTemp('setting_main');
}
elseif($arbb->input['action']=='edit')
{

$settings    = '';
$subsettings = '';
$sg          = array();
$sgg         = array();

$sgid=checkval("".$arbb->input['sgid']);

$query=$DB->query("select * from "._PREFIX_."settinggroup order by disporder ASC");
while($sel = $DB->fetch_array($query))
{
      if($sel['sgid']==$sgid)
      {
       $selected=' selected';

      }
      else
      {
       $selected='';
      }
   $settingselect.="<option value=\"$sel[sgid]\"$selected>$sel[title]</option>\n";

$sgg[$sel['sgid']]=$sel;
}

if($sgid > 0)
{
 $where="where sgid='$sgid'";
}
else
{
 $where='';
}

$query=$DB->query("select * from "._PREFIX_."setting $where order by disporder ASC");
while($set=$DB->fetch_array($query))
{
$sg[$set['sgid']][$set['sid']]=$set;
}
$show['all']=0;
if($sgid > 0)
{
$show['all']=1;
   $cat=$sgg[$sgid];
if(is_array($sg[$sgid]))
{
 while(list($id,$sub)=each($sg[$sgid]))
 {
    $sub['input']=build_input($sub['name'],$sub['optionscode'],$sub['value'],$$sub['name']);
  $subsettings.=$TP->GetTemp('setting_edit_sub');
 }
}

   $settings=$TP->gettemp('setting_edit_main');
}
else
{
 while(list($id,$cat)=each($sgg))
 {
$subsettings='';
if(is_array($sg[$id]))
{
 while(list($subid,$sub)=each($sg[$id]))
 {
    $sub['input']=build_input($sub['name'],$sub['optionscode'],$sub['value'],$$sub['name']);
    $subsettings.=$TP->GetTemp('setting_edit_sub');
 }
}
  $settings.=$TP->GetTemp('setting_edit_main');

  $subsettings='';
 }
}
   $TP->webtemp('setting_edit');
}
elseif($arbb->input['action']=='do_edit')
{

if(is_array($arbb->input['setting']))
{
  foreach($arbb->input['setting'] as $key => $val)
  {
   $val = $DB->escape_string($val);
   if($key == 'defaultlang')
   {
    $DB->query("update "._PREFIX_."language set type='default' where languageid='".$val."'");
    $DB->query("update "._PREFIX_."language set type='non' where languageid != '".$val."'");
   }
   if($key == 'defaultstyle')
   {
    $DB->query("update "._PREFIX_."styles set type='default' where styleid = '".$val."'");
    $DB->query("update "._PREFIX_."styles set type='none' where styleid != '".$val."'");
   }
   $DB->query("update "._PREFIX_."setting set value='$val' where name='$key'");
  }
}
  redirect($lang['setting_updated'],"setting.php?sid=$sgid");


}
$titleetc=$lang['edit_settings'].' - ';

print_page();
?>