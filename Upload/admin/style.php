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
#    Style manager File started
#
/*
        File name       -> style.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'style_manage,style_templates,style_templates_edit,style_templates_main,style_downup,style_edit,style_delete,style_cssaddition,style_all_form_end,style_commontemps,style_cssbit,style_manage_stylebit,style_stylevars,style_all_form';

$phrasearray=array('admincp');

require('global.php');
if(empty($arbb->input['do']))
{
$arbb->input['do']='manage';
}
build_nav_location($lang['adminmenu_stylemanager'],"style.php?sid=$sid");
$styleid=$arbb->input['styleid'];
switch($arbb->input['do'])
{
 case 'downup':
 case 'upload':
   $titleetc=$lang['adminmenu_styledownup'].' - ';
 break;
 case 'style_edit':
 case 'do_style_edit':
   $titleetc=$lang['style_edit_settings'].' - ';
 break;
 case 'style_delete':
 case 'do_style_delete':
   $titleetc=$lang['style_delete'].' - ';
 break;
 case 'style_css':
 case 'do_style_css':
   $titleetc=$lang['edit_css'].' - '.$lang['adminmenu_stylemanager'].' - ';
 break;
 case 'style_stylevars':
 case 'do_style_stylevars':
   $titleetc=$lang['edit_stylevars'].' - '.$lang['adminmenu_stylemanager'].' - ';
 break;
 default:
   $titleetc=$lang['adminmenu_stylemanager'].' - ';
 break;

}
$arbb->input['styleid']=trim(checkval($arbb->input['styleid']));

$select=array();
$select[$arbb->input['do']]='selected';
if($arbb->input['do'] == 'manage')
{
$query=$DB->query("select * from "._PREFIX_."styles");
 $stylebits = '';
 $i=0;
while($st=$DB->fetch_array($query))
{
$show['img']=($st['type']=="default")?1:0;
$i++;
 $stylebits.=$TP->GetTemp("style_manage_stylebit");
if($i==2){$i=0;}
}
 $TP->webtemp("style_manage");
}
elseif(($arbb->input['do'] == "style_all")||($arbb->input['do'] == "style_css")||($arbb->input['do'] == "style_stylevars"))
{
$do=$arbb->input['do'];

$styleoptions="";
$style=array();
$styleid=trim(checkval($arbb->input['styleid']));
$st=array();
$qu=$DB->query("select * from "._PREFIX_."styles");
while($s = $DB->fetch_array($qu))
{
$sel="";
 if($s['styleid']==$styleid)
 {
  $st=$s;
  $sel='selected';
  $style=$s;
 }

 $styleoptions.="<option value=\"$s[styleid]\" $sel>$s[title]</option>";
}
$TP->webtemp('style_all_form');

$template=array();
if($arbb->input['do']=='style_all')
{
$temp=$DB->query("select * from "._PREFIX_."templates where styleid='$styleid' and title in('header','headinclude','footer')");
while($t = $DB->fetch_array($temp))
{
 $template[$t[title]]=$bbcode->clearhtml($t[template]);
}
$TP->webtemp('style_commontemps');
}

if(($arbb->input['do']=='style_all')||($arbb->input['do']=='style_stylevars'))
{
$stylevar = unserialize($style['stylevar']);
foreach($stylevar as $key => $val)
{
 $stylevar[$key]=$bbcode->clearhtml($val);
}

$TP->webtemp('style_stylevars');
}
if(($arbb->input['do']=='style_all')||($arbb->input['do']=='style_css'))
{
$cssq=$DB->query("select * from "._PREFIX_."templates where styleid='$styleid' & templatetype='css'");
while($tmp = $DB->fetch_array($cssq))
{
 $css=unserialize($tmp['template']);

  foreach($css as $key => $val)
  {
     $css[$key]=stripslashes($val);
  }

 $TP->webtemp('style_cssbit');


}
 $TP->webtemp('style_cssaddition');
}
$TP->webtemp('style_all_form_end');

}
elseif(($arbb->input['do'] == 'do_style_all')||($arbb->input['do'] == 'do_style_css')||($arbb->input['do'] == 'do_style_stylevars'))
{

if($arbb->input['do'] == 'do_style_all')
{
 foreach($arbb->input['template'] as $key => $val)
 {
  $DB->query('update '._PREFIX_.'templates set template=\''.$val.'\' where title=\''.$key.' and styleid=\''.$arbb->input['styleid'].'\'');
 }
}

if(($arbb->input['do'] == 'do_style_all')||($arbb->input['do'] == 'do_style_css'))
{

    foreach($arbb->input['css'] as $key => $val)
    {
        foreach($val as $k => $v)
        {
         $val[$k]=stripslashes($v);
        }

     $template=serialize($val);
     $DB->query("update "._PREFIX_."templates set template='".$template."' where templatetype='css' and styleid='$styleid' and title='$key'");
    }

    $style = $arbb->input['style'];
    $cssaddition = $style['cssaddition'];
    $DB->query('update '._PREFIX_."styles set cssaddition='".$cssaddition."'");
}

if(($arbb->input['do'] == 'do_style_all')||($arbb->input['do'] == 'do_style_stylevars'))
{
foreach($arbb->input['stylevar'] as $key => $val)
{
 $arbb->input['stylevar'][$key]=stripslashes($val);
}
        $val = serialize($arbb->input['stylevar']);

        $DB->query("update "._PREFIX_."styles set stylevar='".addslashes($val)."' where styleid='".$arbb->input['styleid']."'");
}

redirect($lang['style_updated_successfully'],"style.php?sessid=$SID");
}
elseif($arbb->input['do']=='style_edit')
{
$do=$arbb->input['do'];
 $styleoptions    = "";
 $defstyleoptions = "";

$style=array();
$styleid=trim(checkval($arbb->input['styleid']));
$qu=$DB->query('select * from '._PREFIX_.'styles');
while($s = $DB->fetch_array($qu))
{
$sel='';
$sel2='';
 if($s['styleid']==$styleid)
 {
  $sel='selected';
  $style=$s;
 }
 if($s['type']=='default')
 {
  $sel2='selected';
 }


 $styleoptions.="<option value=\"$s[styleid]\" $sel>$s[title]</option>";
 $defstyleoptions.="<option value=\"$s[styleid]\" $sel2>$s[title]</option>";
}
$TP->webtemp('style_all_form');
$CHECKED=array($style['userselect'] => 'CHECKED');
$TP->webtemp('style_edit');
$TP->webtemp('style_all_form_end');
}
elseif($arbb->input['do']=='do_style_edit')
{
$upda='';
 foreach($arbb->input['style'] as $key => $val)
 {
  $comma=($upda)?',':'';
  $upda.=$comma."$key='$val'";
 }
 $DB->query('update '._PREFIX_."styles set $upda where styleid='".$arbb->input['styleid']."'");
 $DB->query('update '._PREFIX_."styles set type='default' where styleid = '".$arbb->input['defaultstyle']."'");
 $DB->query('update '._PREFIX_."styles set type='none' where styleid != '".$arbb->input['defaultstyle']."'");
 $DB->query('update '._PREFIX_."setting set value='".$arbb->input['defaultstyle']."' where name='defaultstyle'");
redirect($lang['style_updated_successfully'],"style.php?sessid=$SID");
}
elseif(($arbb->input['do']=='style_delete')||($arbb->input['do'] == 'do_style_delete'))
{
$styleid=$arbb->input['styleid'];
$query=$DB->query("select * from "._PREFIX_."styles where styleid='".$styleid."'");
       while($style=$DB->fetch_array($query))
       {
         if($style['type'] != "default")
         {
           if($arbb->input['do']=="style_delete")
           {
             $TP->webtemp("style_delete");
           }
           else
           {
             $del = $DB->query("delete from "._PREFIX_."styles where styleid='".$style['styleid']."'");
             if($del == true)
             {
              $DB->query("delete from "._PREFIX_."templates where styleid='".$style['styleid']."'");
             }
             redirect($lang['style_deleted'],"style.php?sid=$sid");
           }
         }
         else
         {
          error_message($lang['could_not_delete_default_style']);
         }
       }
}
elseif($arbb->input['do']=="downup")
{
$styleid=$arbb->input['styleid'];
$styleselect="";
$query=$DB->query("select * from "._PREFIX_."styles");
while($st=$DB->fetch_array($query))
{
$sel=($styleid==$st['styleid'])?" selected":"";
 $styleselect.="<option value=\"$st[styleid]\"$sel>$st[title]</option>";
}
$TP->webtemp("style_downup");
}
elseif($arbb->input['do']=="download")
{

$styleid=$arbb->input['styleid'];
$filename=($arbb->input['filename'])?$arbb->input['filename']:"arbb-language.xml";
header("Content-disposition: attachment; filename=".$filename."");

include "../includes/class_xml.php";
$xml = new arbb_xml_writer;


$st=$DB->query_now("select * from "._PREFIX_."styles where styleid='$styleid'");
if(!$st)
{
 error_message($lang['no_style_selected']);
}
$templates=$DB->query("select * from "._PREFIX_."templates where styleid='$st[styleid]'");
$template=array();
while($temp=$DB->fetch_array($templates))
{
 $template[$temp[templatetype]][$temp[title]]=$temp;
}

$xml->send_headers("unknown/unknown",$lang['charset']);
$xml->add_tag("style",array("title" => $st['title'],
                            "version" => "1.0.0",
                            "dir" => $st['dir']));

 $xml->add_data("stylevar",$st['stylevar'],array(),true);
 $xml->add_data("cssaddition",$st['cssaddition'],array(),true);
$xml->add_tag("cssbits");

foreach($template['css'] as $key => $val)
{
 $arr=array("title"    => $val['title'],
            "dateline" => $val['dateline'],
            "username" => $val['username'],
            "version"  => $val['version']);
 $xml->add_data("css",$val['template'],$arr,true);
}
$xml->close_tag("cssbits");

$xml->add_tag("templates");
foreach($template['template'] as $key => $val)
{
 $arr=array("title"    => $val['title'],
            "dateline" => $val['dateline'],
            "username" => $val['username'],
            "version"  => $val['version']);
 $xml->add_data("template",$val['template'],$arr,true);
}
$xml->close_tag("templates");

$xml->close_tag("style");
        header("Content-length: ".strlen($xml->data)."");
        header("Pragma: no-cache");
        header("Expires: 0");
$xml->print_data();
}
elseif($arbb->input['do']=="upload")
{
include "../includes/class_xml.php";
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

$st = $xml->parse();
if((!is_array($st))||(!isset($st['stylevar']))||(!isset($st['dir']))||(!isset($st['templates'])))
{
 error_message($lang['error_file_not_valid']);
}


if(strlen($arbb->input['styletitle'])>0)
{
 $st['title']=$arbb->input['styletitle'];
}
$ins = $DB->query("insert into "._PREFIX_."styles (title,stylevar,cssaddition,dir,userselect) values ('$st[title]','$st[stylevar]','$st[cssaddition]','$st[dir]','1')");
$styleid=$DB->insert_id();

foreach($st['cssbits']['css'] as $key => $val)
{
$DB->query("insert into "._PREFIX_."templates (styleid,title,template,templatetype,dateline,username,version) values('$styleid','$val[title]','$val[value]','css','$val[dateline]','$val[username]','$val[version]')");
}

foreach($st['templates']['template'] as $key => $val)
{
$DB->query("insert into "._PREFIX_."templates (styleid,title,template,templatetype,dateline,username,version) values('$styleid','$val[title]','$val[value]','css','$val[dateline]','$val[username]','$val[version]')");
}

redirect($lang['style_successfully_imported'],"style.php?sid=$sid");
}
elseif($arbb->input['do']=='templates')
{
   $titleetc=$lang['edit_templates'].' - ';
      $selectoptions='';
  if(isset($arbb->input['styleid']) and $arbb->input['styleid'] != '' and $arbb->input['styleid'] != 0)
  {
   if(empty($arbb->input['op']))
   {
      $query=$DB->query('select * from '._PREFIX_.'templates where styleid=\''.$arbb->input['styleid'].'\' and templatetype=\'template\'');

      while($tpl=$DB->fetch_array($query))
      {
        $exp=explode('_',$tpl['title']);
        $tpls=array('footer','header','headinclude','lostpassword','alert','redirection','error','navbar','forum_page');
        if(!in_array($tpl['title'],$tpls))
        {
         if($tpl['title']=='editpost')
         {
             $exp[0]='newpost';
         }
         elseif($tpl['title']=='post')
         {
             $exp[0]='thread';
         }
         elseif($tpl['title']=='forumpm')
         {
             $exp[0]='usercp';
         }
         $templates[$exp[0]][]=$tpl;
        }
        else
        {

         $templates['global'][]=$tpl;
        }

      }



        foreach($templates as $key => $val)
        {
        $keyy=strtoupper($key);
            $selectoptions.='<optgroup label="'.$keyy.'" style="color:red;font-weight:bold;">'.$keyy.'</optgroup>';

            foreach($val as $k => $tpl)
            {
              $selectoptions.='<option value=\''.$tpl['templateid'].'\'>'."&nbsp;&nbsp;&nbsp;&nbsp;".$tpl['title'].'</option>';
            }
            $selectoptions.='</optgroup>';

        }

        $TP->WebTemp('style_templates');
   }
   elseif($arbb->input['op']=='edit')
   {
            $qu=$DB->query('select * from '._PREFIX_.'templates  where styleid=\''.$arbb->input['styleid']."' and templateid='".checkval($arbb->input['tpid'])."'");
            while($tpl = $DB->fetch_array($qu))
            {
            $tpl['template']=htmlspecialchars($tpl['template']);
             $TP->WebTemp('style_templates_edit');
            }
   }
   elseif($arbb->input['op']=='do_edit')
   {
            $qu=$DB->query('select * from '._PREFIX_.'templates  where styleid=\''.$arbb->input['styleid']."' and templateid='".checkval($arbb->input['tpid'])."'");
            while($tpl = $DB->fetch_array($qu))
            {
             $DB->query('update '._PREFIX_.'templates set template=\''.$arbb->input['template'].'\' where templateid=\''.$tpl['templateid'].'\'');
            redirect($lang['template_edited'],"style.php?do=templates&styleid=$styleid");
            }
   }

  }
  else
  {

      $query=$DB->query('select * from '._PREFIX_.'styles');

      while($style=$DB->fetch_array($query))
      {
            $selectoptions.='<option value=\''.$style['styleid'].'\'>'.$style['title'].'</option>';
      }

      $TP->WebTemp('style_templates_main');
  }

}




print_page();
?>