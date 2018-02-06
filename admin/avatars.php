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
#    Admin Avatars manager File Started
#
/*
        File name       -> avatars.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'avatars_cat_bit,
                 avatars_cats,
                 avatars_album,
                 avatars_add_cat,
                 avatars_edit,
                 avatars_add,
                 avatars_delete,
                 avatars_add_multi,
                 avatars_cat_delete';

$phrasearray=array('admincp','usercp');

require('global.php');
build_nav_location($lang['adminmenu_avatarsmanager'],'avatars.php?sid=$sid');
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';
$do=$arbb->input['do'];
if($arbb->input['do']=='manage')
{
$titleetc=$lang['adminmenu_avatarsmanager'].' - ';
$cats='';
$c=array();
  $query=$DB->query("select * from "._PREFIX_."avatar");
  while($av = $DB->fetch_array($query))
  {
    $c[$av['catid']]++;
  }

  $query=$DB->query("select * from "._PREFIX_."imagecat where type=3");
  while($cat = $DB->fetch_array($query))
  {
    $cat['avatars']=0+$c[$cat['catid']];
    $cats.=$TP->GetTemp('avatars_cat_bit');
  }

  $TP->WebTemp('avatars_cats');

}
elseif($arbb->input['do']=='addcat')
{
$cat=array();
 $titleetc=$lang['add_new_cat'].' - ';
 $phrase=$lang['add_new_cat'];
 $show['add']=1;
 $TP->WebTemp('avatars_add_cat');
}
elseif($arbb->input['do']=='do_addcat')
{
 $titleetc=$lang['add_new_cat'].' - ';
$title=$arbb->input['title'];
$DB->query("insert into "._PREFIX_."imagecat (`title`,`type`,`default`) VALUES ('$title','3','0')");
redirect($lang['cat_added'],"avatars.php?sid=$sid");
}
elseif(($arbb->input['do']=="edit_album")OR($arbb->input['do']=="delete_album")OR($arbb->input['do']=="do_delete_album"))
{
$cat=$DB->query_now("select * from ". _PREFIX_ ."imagecat where type='3' and catid='".checkval($arbb->input['catid'])."'");
if(!$cat)
{
 header("location:avatars.php?sid=$sid");
}
 if($arbb->input['do']=='edit_album')
 {
   $show['add']=false;
   $phrase=$lang['edit'];
   $TP->WebTemp('avatars_add_cat');
 }
 else
 {
         if($cat['default']==1)
         {
          error_message($lang['cant_delete_default_cat']);
         }
    if($arbb->input['do']=='do_delete_album')
    {
      $query=$DB->query("select * from "._PREFIX_."avatar where catid='$cat[catid]'");
      while($av=$DB->fetch_array($query))
      {
       if(!eregi('http',$av['path']))
       {
        @unlink('../'.$av['path']);
       }
      }

      $DB->query("DELETE FROM ". _PREFIX_ ."avatar where catid='$cat[catid]'");
      $DB->query("DELETE FROM ". _PREFIX_ ."imagecat where catid='$cat[catid]'");
      redirect($lang['cat_deleted'],"avatars.php?sid=$sid");
    }
    else
    {
      $TP->WebTemp('avatars_cat_delete');
    }
 }
}
elseif($arbb->input['do']=='do_edit_album')
{
$title=$arbb->input['title'];
$catid=$arbb->input['catid'];
if(!$title OR !checkval($catid))
{
    header("location:avatars.php?sid=$sid");
}

$DB->query("update "._PREFIX_."imagecat set title='$title' where catid='$catid'");

redirect($lang['cat_updated'],"avatars.php?sid=$sid");
}
elseif($arbb->input['do']=='album')
{
$cat=$DB->query_now("select * from ". _PREFIX_ ."imagecat where type='3' and catid='".checkval($arbb->input['catid'])."'");
if(!$cat)
{
 header("location:avatars.php?sid=$sid");
}
$page=($arbb->input['page'])?$arbb->input['page']:1;
$perpage=($arbb->input['perpage'])?$arbb->input['perpage']:20;
$al[title]=$cat[title];
eval("\$lang[current_avatars_in_album]=\"".$lang[current_avatars_in_album]."\";");
 $query=$DB->query("select avid from "._PREFIX_."avatar where catid='$cat[catid]'");
 $pages=ceil($DB->num_rows($query)/$perpage);

   $end=$perpage*$page;
   $start=$end-$perpage;

 $query=$DB->query("select * from "._PREFIX_."avatar where catid='$cat[catid]' order by displayorder limit $start,$perpage");
 $i=0;
 while($av=$DB->fetch_array($query))
 {
 $i++;
  $avatarbits.= "<td width=\"20%\" align=\"center\" class=\"tdf\" valign=\"bottom\">$av[title]<br><br>
  <img src=\"../$av[path]\"><br><br><a href=\"avatars.php?do=editav&avid=$av[avid]\">[$lang[edit]]</a> <a href=\"avatars.php?do=deleteav&avid=$av[avid]\">[$lang[delete]]</a>
  <br><input type=text size=\"5\" name=\"disporder[$av[avid]]\" value=\"$av[displayorder]\"></td>";
           if($i==4)
           {
            $avatarbits.='</tr><tr>';
            $i=0;
           }
 }
 $pagenav="";
if($pages != 1)
{
for($i=1;$i<=$pages;$i++)
{
$sel=($i==$page)?' selected':'';
 $pagenav.="\n<option value=\"$i\"$sel>$lang[page] $i $lang[of] $pages </option>";
}
}
 $TP->WebTemp('avatars_album');


}
elseif($arbb->input['do']=='savedisporder')
{
$disporder=$arbb->input['disporder'];
$catid=$arbb->input['catid'];
$page=$arbb->input['page'];



if(is_array($disporder))
{
 foreach($disporder as $key => $val)
 {
  $key = checkval($key);
  $val = checkval($val);

  $DB->query("update "._PREFIX_."avatar set displayorder='$val' where avid='$key'");
 }
}
redirect($lang['display_order_updated'],"avatars.php?do=album&page=$page&catid=$catid");


}
elseif(
        ($arbb->input['do']=='deleteav')
                       OR
       ($arbb->input['do']=='do_deleteav')
      )
{
  $avid=$arbb->input['avid'];

  $av=$DB->query_now("select * from "._PREFIX_."avatar where avid='$avid'");

  if(!$av)
  {
   header("location:avatars.php?sid=$sid");
  }

  if($arbb->input['do']=='deleteav')
  {
   $TP->WebTemp('avatars_delete');
  }
  else
  {
       if(!eregi('http',$av['path']))
       {
        @unlink('../'.$av['path']);
       }

      $DB->query("DELETE FROM ". _PREFIX_ ."avatar where path='$av[path]'");

      redirect($lang['avatar_deleted'],"avatars.php?sid=$sid&do=album&catid=$av[catid]");
  }
}
elseif($arbb->input['do']=='add')
{
$titleetc=$lang['adminmenu_addavatar'].' - ';
$catoptions="";
$query=$DB->query("select * from ". _PREFIX_ ."imagecat where type='3'");
while($cat = $DB->fetch_array($query))
{
$sel=($cat['catid']==$arbb->input['catid'])?" selected":"";
 $catoptions.="<option value=\"$cat[catid]\"$sel>$cat[title]</option>";
}
$TP->WebTemp('avatars_add');
}
elseif($arbb->input['do']=='do_add')
{

$path=$bbcode->clearhtml(addslashes($DB->escape_string($arbb->input['path'])));
$title=$bbcode->clearhtml($arbb->input['title']);
$displayorder=checkval($arbb->input['displayorder']);
$cat=checkval($arbb->input['catid']);

$avatar=array('path'         => $path,
              'title'        => $title,
              'displayorder' => $displayorder,
              'catid'        => $cat);


$query = $DB->query("select * from "._PREFIX_."avatar where path='$path' and catid='$cat'");

if($DB->num_rows($query)>0)
{
 error_message($lang['avatar_in_db']);
}

if(!is_file('../'.$path)||!file_exists('../'.$path))
{
 error_message($lang['avatar_file_not_exists']);
}

$DB->insert($avatar,'avatar');
redirect($lang['avatar_added'],"avatars.php?sid=$sid&do=album&catid=$cat");
}
elseif($arbb->input['do']=='add_multi')
{
$path=$bbcode->clearhtml(addslashes($DB->escape_string($arbb->input['path'])));
$cat=checkval($arbb->input['catid']);
$avatarbits='';
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

$query=$DB->query("select * from "._PREFIX_."avatar where path in($check)");
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

    $avatarbits.="
        <tr class=\"thead\">
<input type=\"hidden\" name=\"files[$f][path]\" value=\"$pathh\">
          <td class=\"td1\" vAlign=\"top\" width=\"40%\">$f<br><img src=\"../$path/$f\"></td>
          <td class=\"td1\" vAlign=\"top\" width=\"60%\"><input type=\"text\" name=\"files[$f][title]\" size=\"32\" value=\"$title\"></td>
          <td class=\"td1\" vAlign=\"top\" width=\"40%\"><input type=checkbox name=\"files[$f][checked]\" onclick=\"form.elements.allbox.checked=false;\"></td>
        </tr> ";
}
}
if($avatarbits == '')
{
 error_message($lang['no_avatars_exists']);
}

$TP->webtemp('avatars_add_multi');
}
elseif($arbb->input['do']=='do_add_multi')
{
$arrayed=array();
$catid=$arbb->input['cat'];
while(list($image,$av) = each($arbb->input['files']))
{
 if(is_file('../'.$av['path']) AND file_exists('../'.$av['path']))
 {
   if($av['checked']=='on')
   {
    $arrayed[]=$av;
   }
 }
}

if(count($arrayed)<1)
{
 error_message($lang['no_avatars_selected']);
}

foreach($arrayed as $key => $val)
{

  $avatar=array('path'   => $val['path'],
                'title'  => $val['title'],
                'catid'  => $catid);
  $DB->insert($avatar,"avatar");
}



redirect($lang['avatar_added'],"avatars.php?sid=$sid&do=album&catid=$catid");

}
elseif($arbb->input['do']=='editav')
{
    $avid=$arbb->input['avid'];
    $catoptions="";
    $av=$DB->query_now("select * from "._PREFIX_."avatar where avid='".$DB->escape_string($avid)."'");
    if(!$av)
    {
     header("location:$HTTP_SERVER_VARS[HTTP_REFERER]");
    }

$query=$DB->query("select * from ". _PREFIX_ ."imagecat where type='3'");
while($cat = $DB->fetch_array($query))
{
$sel=($cat['catid']==$av['catid'])?" selected":"";
 $catoptions.="<option value=\"$cat[catid]\"$sel>$cat[title]</option>";
}
    $TP->WebTemp('avatars_edit');
}
elseif($arbb->input['do']=='do_editav')
{

$array=array('title' => $DB->escape_string($arbb->input['title']),
             'catid' => checkval($arbb->input['catid']));

$DB->update($array,'avatar',"avid='".checkval($arbb->input['avid'])."'");
redirect($lang['avatar_edited'],"avatars.php?do=album&catid=$array[catid]");
}


if(!$titleetc)
{
    $titleetc=$lang['adminmenu_avatarsmanager'].' - ';
}
print_page();
?>