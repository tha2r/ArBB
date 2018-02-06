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
#    announcements manager File started
#
/*
        File name       -> announcement.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist='announcement_add,announcement_delete,announcement_edit,announcement_manager,announcement_manager_bit';

$phrasearray = array('admincp');

require('global.php');
if(empty($arbb->input['do']))
{
 $arbb->input['do']='manage';
}
build_nav_location($lang['adminmenu_announcement'],"announcement.php?sid=$sid");
if($arbb->input['do']=="add")
{
    $titleetc=$lang['adminmenu_addannouncement'].' - ';
$query=$DB->query("select * from "._PREFIX_."forum");
$msel=array();
$msel2=array();
$forumoptions="<option value=\"-1\" class=\"td2\"> ------- $lang[all_forums] ------ </option>";
$forums="";
while($f=$DB->fetch_array($query))
{
   $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
}

    $startyear=mydate('Y');
    $endyear=$startyear;
    $month=mydate('n'); ;
    $msel[$month]=' selected';
    $month2=$month+3;

        if($month2 > 12)
        {
           $month2=$month2-12;
           $endyear++;
        }

    $msel2[$month2]=' selected';

    $startday=mydate('d');
    $endday=$startday;
$forumid=$arbb->input['forumid'];
$forumid=($forumid)?$forumid:'-';
    while(list($disprder,$info) = each($forums[-1]))
    {

     foreach($info as $id => $f)
     {
       $sel=($f['forumid']==$forumid)?'selected':'';

       $forumoptions.="\n<option value=\"$f[forumid]\" class=\"td2\" $sel>$f[title]</option>\n";
       if(is_array($forums[$id]))
       {
               $sel='';
        $jumpforums='';
        $forumoptions.=forumjump_tree($forums,$id,"0",$forumid);
       }
     }
    }


 $TP->webtemp('announcement_add');
}
elseif(($arbb->input['do']=='do_add')||($arbb->input['do']=='do_edit'))
{
$title=$bbcode->clearhtml($arbb->input['title']);
$text = $DB->escape_string($arbb->input['text']);
$forumid=(checkval($arbb->input['forumid']))?$arbb->input['forumid']:'-1';
$startdate= mktime(0, 0, 0, $arbb->input['startmonth'], $arbb->input['startday'], $arbb->input['startyear']);
$enddate= mktime(0, 0, 0, $arbb->input['endmonth'], $arbb->input['endday'], $arbb->input['endyear']);
$aid=checkval($arbb->input['aid']);
    if($arbb->input['do']=="do_edit")
    {
       $DB->query("update "._PREFIX_."announcement set title='$title',announcement='$text',userid='".$local['userid']."',startdate='$startdate',enddate='$enddate',forumid='$forumid' where aid='$aid'");
        $phrase='announcement_edited';
    }
    else
    {
        $DB->query("insert into "._PREFIX_."announcement (title,userid,startdate,enddate,announcement,forumid,views) VALUES ('".$title."','".$local['userid']."','".$startdate."','".$enddate."','".$text."','".$forumid."','0')");
        $phrase='announcement_added';
    }
     redirect($lang[$phrase],"announcement.php?sid=$sid");
}
elseif($arbb->input['do']=='manage')
{
$fquery=$DB->query("select * from "._PREFIX_."forum");
$forums=array();
$forum=array();
while($f=$DB->fetch_array($fquery))
{
   $forums[$f[forumid]]=$f;
}
$query=$DB->query("select * from "._PREFIX_."announcement");
$i=0;
while($an=$DB->fetch_array($query))
{
$i++;
     $forum=$forums[$an[forumid]];
     $an['forum']=($forum['title'])?$bbcode->clearhtml($forum['title']):$lang['all_forums'];
     $an['title']=$bbcode->clearhtml($an['title']);
     $announcements.=$TP->GetTemp('announcement_manager_bit');
($i==2)?$i=0:$i=$i;
}
$TP->webtemp('announcement_manager');

}
elseif($arbb->input['do']=='edit')
{
    $titleetc=$lang['edit']." ".$lang['announcement']." - ";
$aid=checkval($arbb->input['aid']);
$query=$DB->query("select * from "._PREFIX_."announcement where aid='$aid'");
while($an=$DB->fetch_array($query))
{
$query=$DB->query("select * from "._PREFIX_."forum");
$msel=array();
$msel2=array();
$forumoptions="<option value=\"-1\" class=\"td2\"> ------- $lang[all_forums] ------ </option>";
$forums="";
while($f=$DB->fetch_array($query))
{
   $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
}
$forumid=$an['forumid'];
$forumid=($forumid)?$forumid:'-';
    while(list($disprder,$info) = each($forums[-1]))
    {

     foreach($info as $id => $f)
     {
       $sel=($f['forumid']==$forumid)?'selected':'';

       $forumoptions.="\n<option value=\"$f[forumid]\" class=\"td2\" $sel>$f[title]</option>\n";
       if(is_array($forums[$id]))
       {
               $sel='';
        $jumpforums='';
        $forumoptions.=forumjump_tree($forums,$id,"0",$forumid);
       }
     }
    }

    $sdate=mydate($an['startdate'],'date');
    $edate=mydate($an['enddate'],'date');

    $start = explode('-',$sdate);
    $end   = explode('-',$edate);
    $msel[$start[1]]='selected';
    $msel2[$end[1]]='selected';
    $startday=$start[0];
    $endday=$end[0];
    $startyear=$start[2];
    $endyear=$end[2];

$TP->webtemp('announcement_edit');
}

}
elseif($arbb->input['do']=='delete')
{

 $aid=$arbb->input['aid'];
 $query=$DB->query("select * from "._PREFIX_."announcement where aid='$aid'");
 while($an=$DB->fetch_array($query))
 {
       $TP->webtemp('announcement_delete');
 }

}
elseif($arbb->input['do']=='do_delete')
{

  $aid=$arbb->input['aid'];
  $DB->query("delete from "._PREFIX_."announcement where aid='$aid'");
  redirect($lang['announcement_deleted'],"announcement.php?sid=$sid");

}

  if(!$titleetc)
  {
    $titleetc=$lang['adminmenu_announcementmanage'].' - ';
  }
print_page();
?>