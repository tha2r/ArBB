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
#    Admin Plugins / Hacks manager File Started
#
/*
        File name       -> plugins.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'plugins_manager,plugins_add,plugins_downup,plugins_manager_bit,plugins_edit,plugins_place,plugins_delete';

$phrasearray=array('admincp');

require('global.php');
build_nav_location($lang['adminmenu_plugins'],"plugins.php?sid=$sid");
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';
$ins=array();
$upda=array();
if($arbb->input['do']=='manage')
{
$query = $DB->query("select * from "._PREFIX_."plugin");
$plugins="";
while($plugin=$DB->fetch_array($query))
{
$i++;
  $checked=($plugin['active']==1)?'checked':'';
  $plugins.=$TP->GetTemp('plugins_manager_bit');
  ($i==2)?$i=0:$i=$i;
}

$TP->webtemp('plugins_manager');
}
elseif($arbb->input['do']=='update')
{
$active=$arbb->input['active'];
   if(is_array($active))
   {
     foreach($active as $key => $val)
     {
      $DB->query("update "._PREFIX_."plugin set active='$val' where pid='$key'");
     }
   }
redirect($lang['plugins_updated'],"plugins.php?sid=$sid");

}
elseif($arbb->input['do']=='edit')
{
$query = $DB->query("select * from "._PREFIX_."plugin where pid='".checkval($arbb->input['pid'])."'");;
   while($plugin=$DB->fetch_array($query))
   {
$addition="<option value=\"$plugin[place]\">$plugin[place]</option>";
      $placeoptions=$TP->GetTemp('plugins_place');
    $titleetc=$lang['edit'].' : '.$plugin['title'].' - '.$lang['adminmenu_plugins'].' - ';
     $checkedyes=($plugin['active']==1)?'checked':'';
     $checkedno=($plugin['active']==0)?'checked':'';
    $TP->webtemp('plugins_edit');
   }
}
elseif($arbb->input['do']=="delete")
{
$query = $DB->query("select * from "._PREFIX_."plugin where pid='".checkval($arbb->input['pid'])."'");;
   while($plugin=$DB->fetch_array($query))
   {
    $titleetc=$lang['delete'].' : '.$plugin['title'].' - '.$lang['adminmenu_plugins'].' - ';
    $TP->webtemp('plugins_delete');
   }
}
elseif($arbb->input['do']=='do_delete')
{
$DB->query("delete from "._PREFIX_."plugin where pid='".checkval($arbb->input['pid'])."'");
 redirect($lang['plugin_deleted'],"plugins.php?sid=$sid");
}
elseif($arbb->input['do']=='add')
{

$addition = '<option value="'.$arbb->input['place'].'">'.$arbb->input['place'].'</option>';

      $placeoptions=$TP->GetTemp('plugins_place');

$TP->Webtemp('plugins_add');

}
elseif($arbb->input['do']=='do_add')
{

$arrayed=array('place','title','phpcode','active');
foreach($arrayed as $key => $val)
{
 $ins[$val]=$arbb->input[$val];
}
        $DB->insert($ins,'plugin');
redirect($lang['plugin_inserted'],"plugins.php?sid=$sid");

}
elseif($arbb->input['do']=='do_edit')
{

$arrayed=array('place','title','phpcode','active');
foreach($arrayed as $key => $val)
{
 $upda[$val]=$arbb->input[$val];
}
   $DB->update($upda,'plugin',"pid='".$arbb->input['pid']."'");
redirect($lang['plugin_updated'],"plugins.php?sid=$sid");

}
elseif($arbb->input['do']=='downup')
{
 $TP->WebTemp('plugins_downup');
}
elseif($arbb->input['do']=='download')
{
$filename=($arbb->input['filename'])?$arbb->input['filename']:'arbb-plugins.xml';
header('Content-disposition: attachment; filename='.$filename.'');
 $plugins=array();
include '../includes/class_xml.php';
$xml = new arbb_xml_writer;

$qu=$DB->query('select * from '._PREFIX_.'plugin');
$xml->send_headers('application/octet-stream',$lang['charset']);

while($plugin=$DB->fetch_array($qu))
{
$plugins[]=$plugin;
}
$xml->add_tag('plugins',array());
foreach($plugins as $key => $val)
{
$arr=array('title' => $val['title'],
           'place' => $val['place'],
           'active' => $val['active']);
$xml->add_tag('plugin',$arr);

 $xml->add_data('phpcode',$val['phpcode'],array(),true);
$xml->close_tag('plugin');
}

$xml->close_tag('plugins');
        header('Content-length: '.strlen($xml->data).'');
        header('Pragma: no-cache');
        header('Expires: 0');
$xml->print_data();
}
elseif($arbb->input['do']=='upload')
{
require_once('../includes/class_xml.php');
$xml = new arbb_xml;
$file=$_FILES['file'];
      if(is_array($file))
      {
       $dir=$file['tmp_name'];
      }
      else
      {
       $dir=$arbb->input['filedir'];
      }
if(!file_exists($dir))
{
 error_message($lang['error_file_not_valid']);
}

$xml->xml('',$dir);
$pn = $xml->parse();

   foreach($pn as $key => $plugins)
   {

      if(is_array($plugins[0]))
      {
        foreach($plugins as $key => $val)
        {
          $DB->insert($val,'plugin');
        }
      }
      else
      {
         $DB->insert($plugins,'plugin');
      }
   }

redirect($lang['plugins_imported'],"plugins.php?sid=$sid");
}


if(!$titleetc)
{
    $titleetc=$lang['adminmenu_plugins'].' - ';
}
print_page();
?>