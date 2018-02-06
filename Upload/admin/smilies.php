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
#    Admin Smilies manager File Started
#
/*
        File name       -> smilies.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'smilies_manage,
                 smilies_add,
                 smilies_edit,
                 smilies_delete,
                 smilies_add_multi';

$phrasearray=array('admincp');

require('global.php');
build_nav_location($lang['adminmenu_smiliesmanager'],"smilies.php?sid=$sid");
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';
if(
   ($arbb->input['do']=='add')
              OR
   ($arbb->input['do']=='do_add')
  )
{

$titleetc=$lang['adminmenu_addsmilies'].' - ';

     if($arbb->input['do']=='add')
     {

      $random=random_string(3);
      $TP->WebTemp('smilies_add');

     }
     else
     {

     $smilie=array('path'     => $DB->escape_string($arbb->input['path']),
                   'title'    => $DB->escape_string($arbb->input['title']),
                   'text'     => $DB->escape_string($arbb->input['text']),
                   'cat'      => '1');


          $query = $DB->query("select * from "._PREFIX_."smilies where path='$smilie[path]'");
          if($DB->num_rows($query)>0)
          {
            error_message($lang['smilie_already_exists']);
          }

          if(!is_file('../'.$smilie['path'])||!file_exists('../'.$smilie['path']))
          {
            error_message($lang['smilie_file_not_exists']);
          }

          $DB->insert($smilie,'smilies');
          redirect($lang['smilie_added'],"smilies.php?sid=$sid&");

     }

}
elseif($arbb->input['do']=='add_multi')
{
$path=$bbcode->clearhtml(addslashes($DB->escape_string($arbb->input['path'])));
$cat=checkval($arbb->input['catid']);
$smilies='';
$arrayed=array();
$checkvalues=array();

$diropen = opendir('../'.$path);
while($f = readdir($diropen))
{
 if(is_file('../'.$path.'/'.$f))
 {
  $size=getimagesize('../'.$path.'/'.$f);
  if(ereg('image',$size['mime']))
  {
  $arrayed[$f]='dd';
  $checkvalues[]=$path.'/'.$f;
  }
 }
}

$check="'".implode("','",$checkvalues)."'";

$query=$DB->query("select * from "._PREFIX_."smilies where path in($check)");
while($av=$DB->fetch_array($query))
{
  $npath=str_replace($path,'',$av['path']);
  $npath=str_replace('/','',$npath);
  unset($arrayed[$npath]);

}
if(is_array($arrayed))
{
foreach($arrayed as $f => $v)
{

  $ex=explode('.',$f);
  $title=str_replace('_',' ',$ex[0]);
  $pathh=$path.'/'.$f;
  $pathh=str_replace('//','/',$pathh);

    $smilies.="
        <tr class=\"thead\">
<input type=\"hidden\" name=\"files[$f][path]\" value=\"$pathh\">
          <td class=\"td1\" vAlign=\"top\" width=\"40%\">$f<br><img src=\"../$path/$f\"></td>
          <td class=\"td1\" vAlign=\"top\" width=\"60%\"><input type=\"text\" name=\"files[$f][title]\" size=\"25\" value=\"$title\"></td>
          <td class=\"td1\" vAlign=\"top\" width=\"60%\"><input type=\"text\" name=\"files[$f][text]\" size=\"25\" value=\":$title:\"></td>
          <td class=\"td1\" vAlign=\"top\" width=\"40%\"><input type=checkbox name=\"files[$f][checked]\" onclick=\"form.elements.allbox.checked=false;\"></td>
        </tr> ";
}
}
if($smilies == '')
{
 error_message($lang['no_smilies_exists']);
}

$TP->webtemp('smilies_add_multi');
}
elseif($arbb->input['do']=='do_add_multi')
{
$arrayed=array();

while(list($image,$sm) = each($arbb->input['files']))
{
 if(is_file('../'.$sm['path']) AND file_exists('../'.$sm['path']))
 {
   if($sm['checked']=="on")
   {
    $arrayed[]=$sm;
   }
 }
}

if(count($arrayed)<1)
{
 error_message($lang['no_smilies_selected']);
}

foreach($arrayed as $key => $val)
{

  $smilie=array('path'   => $val['path'],
                'title'  => $val['title'],
                'text'   => $val['text'],
                'cat'    => '1');
  $DB->insert($smilie,'smilies');
}



redirect($lang['smilie_added'],"smilies.php?sid=$sid");

}
elseif($arbb->input['do']=='manage')
{
$page=($arbb->input['page'])?$arbb->input['page']:1;
$perpage=($arbb->input['perpage'])?$arbb->input['perpage']:20;
$al[title]=$cat[title];
 $query=$DB->query('select sid from '._PREFIX_.'smilies');
 $pages=ceil($DB->num_rows($query)/$perpage);

   $end=$perpage*$page;
   $start=$end-$perpage;

$query=$DB->query("select * from "._PREFIX_."smilies limit $start,$end");
$i=0;
while($sm = $DB->fetch_array($query))
{
 $i++;
  $ii=($i>2)?$i-2:$i;
  $smilies.= "<td width=\"20%\" align=\"center\" class=\"td$ii\" valign=\"bottom\">$sm[title]<br><br>
  <img src=\"../$sm[path]\"><br><br><a href=\"smilies.php?do=edit&smid=$sm[sid]\">[$lang[edit]]</a>

  <a href=\"smilies.php?do=delete&smid=$sm[sid]\">[$lang[delete]]</a></td>";
           if($i==4)
           {
            $smilies.='</tr><tr>';
            $i=0;
           }
}
 $pagenav='';
if($pages != 1)
{
for($i=1;$i<=$pages;$i++)
{
$sel=($i==$page)?' selected':'';
 $pagenav.="\n<option value=\"$i\"$sel>$lang[page] $i $lang[of] $pages </option>";
}
}

$TP->webtemp('smilies_manage');

}
elseif(
       ($arbb->input['do']=='edit')
               or
       ($arbb->input['do']=='delete')
      )
{
 $sm=$DB->query_now("select * from "._PREFIX_."smilies where sid=".checkval($arbb->input['smid'])."");
 if(!$sm)
 {
  header("location:smilies.php?sid=$sid");
 }

 $TP->webtemp('smilies_'.$arbb->input['do'].'');
}
elseif(
       ($arbb->input['do']=='do_edit')
               or
       ($arbb->input['do']=='do_delete')
      )
{
 $sm=$DB->query_now("select * from "._PREFIX_."smilies where sid=".checkval($arbb->input['smid'])."");
 if(!$sm)
 {
  header("location:smilies.php?sid=$sid");
 }
if($arbb->input['do']=='do_delete')
{
 $DB->query("DELETE from "._PREFIX_."smilies where sid='$sm[sid]'");
 $phrase=$lang['smilie_deleted'];
}
else
{
$array=array('title' => $arbb->input['title'],
             'text'  => $arbb->input['text']);

 $DB->update($array,'smilies'," sid='$sm[sid]'");
 $phrase=$lang['smilie_edited'];
}
redirect($phrase,"smilies.php?sid=$sid");

}
if(!$titleetc)
{
    $titleetc=$lang['adminmenu_smiliesmanager'].' - ';
}
print_page();
?>