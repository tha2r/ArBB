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
#    Language manager File started
#
/*
        File name       -> lang.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'lang_phrases_main,
                 lang_phrase_search_result,
                 lang_phrase_search,
                 lang_addphrase,
                 lang_phrase_edit,
                 lang_manage,
                 lang_edit,
                 lang_phrase_manager,
                 lang_phrase_manager_phrasebit,
                 lang_manage_langbit,
                 lang_delete,
                 lang_downup';

$phrasearray=array('admincp');

require('global.php');
if(empty($arbb->input['do']))
{
$arbb->input['do']='lang';
}
$arbb->input['langid']=trim(checkval($arbb->input['langid']));

build_nav_location($lang['adminmenu_langmanager'],"lang.php?sid=$sid");
$langid=$arbb->input['langid'];
$select=array();
$select[$arbb->input['do']]='selected';
$languages = '';

if($arbb->input['do']=='lang')
{
$query = $DB->query('select * from '._PREFIX_.'language');
  $i=0;
 while($lng=$DB->fetch_array($query))
 {
  $i++;
  $show['disabled']=($lng['type']=='default')?1:0;
  $languages.=$TP->gettemp('lang_manage_langbit');
  if($i==2){$i=0;}
 }

$TP->webtemp('lang_manage');
}
elseif($arbb->input['do']=='set_default')
{
$DB->query("update "._PREFIX_."language set type='default' where languageid='$langid'");
$DB->query("update "._PREFIX_."language set type='non' where languageid != '$langid'");
$DB->query("update "._PREFIX_."setting set value='$langid' where name='defaultlang'");

redirect($lang['default_language_setted'],"lang.php?sid=$sid");
}
elseif(($arbb->input['do']=='lang_delete')||($arbb->input['do'] == 'do_lang_delete'))
{

$langid=$arbb->input['langid'];
$query=$DB->query("select * from "._PREFIX_."language where languageid='".$langid."'");

       while($lng=$DB->fetch_array($query))
       {
         if($lng['type'] != 'default')
         {
           if($arbb->input['do']=='lang_delete')
           {
             $TP->webtemp('lang_delete');
           }
           else
           {
             $del = $DB->query("delete from "._PREFIX_."language where languageid='".$lng['languageid']."'");
             if($del == true)
             {
              $DB->query("delete from "._PREFIX_."phrase where languageid='".$lng['languageid']."'");
             }
             redirect($lang['lang_deleted'],"lang.php?sid=$sid");
           }
         }
         else
         {
          error_message($lang['could_not_delete_default_lang']);
         }
       }
}
elseif($arbb->input['do']=='lang_edit')
{

$query=$DB->query("select * from "._PREFIX_."language where languageid='$langid'");
       while($lng=$DB->fetch_array($query))
       {
        $CHECKED=array($lng['userselect'] => 'CHECKED',
                       $lng['textdirection'] => 'CHECKED');
        $TP->webtemp('lang_edit');
       }

}
elseif($arbb->input['do']=='do_lang_edit')
{
$upda='';
  foreach($arbb->input['lang'] as $key => $val)
  {
    $comma=($upda)?',':'';
    $upda=$upda.$comma."$key='$val'";
  }

  $DB->query("update "._PREFIX_."language set $upda where languageid='$langid'");

  redirect($lang['language_updated'],"lang.php?sid=$sid");
}
elseif($arbb->input['do']=='phrases')
{
 $titleetc=$lang['phrase_manager'].' - ';
$selectoptions='';
$query=$DB->query('select * from '._PREFIX_.'language');
       while($lng=$DB->fetch_array($query))
       {
        $selectoptions.="<option value=\"$lng[languageid]\">$lng[title]</option>\n";
       }
 $TP->webtemp('lang_phrases_main');
}
elseif($arbb->input['do']=='lang_phrases')
{
$link="lang.php?do=lang_phrases&langid=$langid";
build_nav_location($lang['phrase_manager'],"$link&sid=$sid");
 $titleetc=$lang['phrase_manager'].' - ';
$phrasetype=($arbb->input['phrasetype'])?$arbb->input['phrasetype']:'global';
$perpage=($arbb->input['perpage'])?$arbb->input['perpage']:'15';
$page=($arbb->input['page'])?$arbb->input['page']:'1';

$pages    = '';
$phrases  = '';

$num=$DB->num_rows($DB->query("select * from "._PREFIX_."phrase where phrasetype='$phrasetype' and languageid='$langid'"));
$ptquery=$DB->query('select * from '._PREFIX_.'phrasetype');
$pagenum=ceil($num/$perpage);
if($page>$pagenum)
{
 $page=$pagenum;
}
for($i=1;$i<=$pagenum;$i++)
{
$sel=($i==$page)?' selected':'';
$pages.="<option value=\"$i\"$sel>$lang[page]($i/$pagenum)</option>";
}
$end=$page*$perpage;
$start=$end-$perpage;
$limit=$start.','.$perpage;


while($pt=$DB->fetch_array($ptquery))
{
$sel=($pt['name']==$phrasetype)?' selected':'';
$phrasetypes.="<option value=\"$pt[name]\"$sel>$pt[title]</option>";
}
$query=$DB->query("select * from "._PREFIX_."phrase where phrasetype='$phrasetype' and languageid='$langid' limit $limit");
while($phrase=$DB->fetch_array($query))
{
 $phrases.=$TP->gettemp('lang_phrase_manager_phrasebit');
}
 $TP->webtemp('lang_phrase_manager');
}
elseif($arbb->input['do']=='edit_phrase')
{
$phrasetypeoptions='';
$phrase=checkval($arbb->input['phrase']);
$query=$DB->query("select * from "._PREFIX_."phrase where pid='$phrase'");
while($phrase = $DB->fetch_array($query))
{
$ptquery=$DB->query("select * from "._PREFIX_."phrasetype");
while($pt=$DB->fetch_array($ptquery))
{
$sel=($pt['name']==$phrase['phrasetype'])?' selected':'';
$phrasetypeoptions.="<option value=\"$pt[name]\"$sel>$pt[title]</option>";
}
        $langid=$phrase['languageid'];
        $TP->webtemp("lang_phrase_edit");
}
}
elseif($arbb->input['do']=='do_edit_phrase')
{
$upda="";
$phrase=checkval($arbb->input['phrasepid']);
$ph=$arbb->input['phrase'];
 foreach($arbb->input['phrase'] as $key => $val)
 {
  $comma=($upda)?',':'';
  $upda.=$comma."$key='$val'";
 }
 $phrasetype=$ph['phrasetype'];
 $DB->query("update "._PREFIX_."phrase set $upda where pid='$phrase'");
 redirect($lang['phrase_updated'],"lang.php?langid=$langid&do=lang_phrases&phrasetype=$phrasetype");
}
elseif(($arbb->input['do']=='add')||($arbb->input['do']=='do_add'))
{
$phrasetype=$arbb->input['phrasetype'];

   if($arbb->input['do']=='add')
   {

      $ptquery=$DB->query("select * from "._PREFIX_."phrasetype");
      while($pt=$DB->fetch_array($ptquery))
      {
      $sel=($pt['name']==$phrasetype)?' selected':'';
      $phrasetypeoptions.="<option value=\"$pt[name]\"$sel>$pt[title]</option>";
      }

   $TP->webtemp('lang_addphrase');
   }
   else
   {
   $text=$DB->escape_string($arbb->input['text']);
   $varname=$bbcode->clearhtml($arbb->input['varname']);
   $phrasetype=$bbcode->clearhtml($arbb->input['phrasetype']);
   $queryfirs=$DB->query("insert into "._PREFIX_."phrase (varname,languageid,text,phrasetype,username,dateline,version) Values ('$varname','$langid','$text','$phrasetype','$local[username]','".time()."','".IN_ARBB."')");

 redirect($lang['phrase_added'],"lang.php?langid=$langid&do=lang_phrases&phrasetype=$phrasetype");
   }
}
elseif(($arbb->input['do']=='search')||($arbb->input['do']=='do_search'))
{
 $titleetc=$lang['search'].' - '.$lang['phrase_manager'].' - ';
  if($arbb->input['do']=='search')
  {
     $TP->WebTemp('lang_phrase_search');
  }
  else
  {
      $varname=$arbb->input['varname'];
      $text=$arbb->input['text'];
      $phrases='';
      $show['extra']=1;
      $query=$DB->query("select * from "._PREFIX_."phrase where varname like '%$varname%' and text like '%$text%' and languageid='$langid'");
      while($phrase=$DB->fetch_array($query))
      {
         $phrases.=$TP->GetTemp('lang_phrase_manager_phrasebit');
      }
      $num=$DB->num_rows($query);
      $TP->WebTemp('lang_phrase_search_result');
  }

}
elseif($arbb->input['do']=='downup')
{
 $titleetc=$lang['adminmenu_langdownup'].' - ';
$langselect='';
$query=$DB->query("select * from "._PREFIX_."language");
while($lng=$DB->fetch_array($query))
{
$sel=($langid==$lng['languageid'])?' selected':'';
 $langselect.="<option value=\"$lng[languageid]\"$sel>$lng[title]</option>";
}
$TP->webtemp('lang_downup');

}
elseif($arbb->input['do']=='download')
{
$filename=($arbb->input['filename'])?$arbb->input['filename']:'arbb-language.xml';
header('Content-disposition: attachment; filename='.$filename.'');

include '../includes/class_xml.php';
$xml = new arbb_xml_writer;

$qu=$DB->query("select * from "._PREFIX_."phrasetype");
$ar=$DB->query("select * from "._PREFIX_."phrase where languageid='$langid'");
$lng=$DB->query_now("select * from "._PREFIX_."language where languageid='$langid'");
if(!$lng)
{
 error_message($lang['no_language_selected']);
}
$xml->send_headers('application/octet-stream',$lng['charset']);

while($ph=$DB->fetch_array($ar))
{
$phrase[$ph['phrasetype']][$ph['varname']]=$ph;

}
$xml->add_tag('language',array('title' => $lng['title'],
                               'version' => IN_ARBB,
                               'textdirection' => $lng['textdirection'],
                               'charset ' => $lng['charset']));
while($pt=$DB->fetch_array($qu))
{
if(is_array($phrase[$pt['name']]))
{
$xml->add_tag('phrasetype',array('name' => $pt['name'],
                                 'title' => $pt['title']));

foreach($phrase[$pt['name']] as $key => $val)
{
$arr=array('varname' => $val['varname'],
           'username' => $val['username'],
           'date' => $val['dateline'],
           'version' => $val['version']);
 $xml->add_data('phrase',$val['text'],$arr,true);
}
$xml->close_tag('phrasetype');
}
}
$xml->close_tag('language');
        header('Content-length: '.strlen($xml->data).'');
        header('Pragma: no-cache');
        header('Expires: 0');
$xml->print_data();

}
elseif($arbb->input['do']=='upload')
{

include '../includes/class_xml.php';
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

$lng = $xml->parse();
if((!is_array($lng))||(!isset($lng['charset']))||(!isset($lng['textdirection'])))
{
 error_message($lang['error_file_not_valid']);
}

if(strlen($arbb->input['langtitle'])>0)
{
 $lng['title']=$arbb->input['langtitle'];
}
$ins = $DB->query("insert into "._PREFIX_."language (title,textdirection,charset,userselect) values ('$lng[title]','$lng[textdirection]','$lng[charset]','1')");
$langid=$DB->insert_id();

foreach($lng['phrasetype'] as $ky => $vl)
{
$phrasetype=$vl['name'];
if(is_array($vl['phrase'][0]))
{
 foreach($vl['phrase'] as $key => $val)
 {

  foreach($val as $k => $v)
  {
   $val[$k]=addslashes($v);
  }
  $DB->query("insert into "._PREFIX_."phrase (languageid,varname,phrasetype,text,username,dateline,version) values ('$langid','$val[varname]','$phrasetype','$val[value]','$val[username]','$val[date]','$val[version]')");
 }
}
else
{
  $phrase=$vl['phrase'];
  foreach($phrase as $k => $v)
  {
   $phrase[$k]=addslashes($v);
  }
  $DB->query("insert into "._PREFIX_."phrase (languageid,varname,phrasetype,text,username,dateline,version) values ('$langid','$phrase[varname]','$phrasetype','$phrase[value]','$phrase[username]','$phrase[date]','$phrase[version]')");
}
}
redirect($lang['language_successfully_imported'],"lang.php?sid=$sid");
}

if(!$titleetc)
{
 $titleetc=$lang['adminmenu_langmanager'].' - ';
}
        print_page();
?>