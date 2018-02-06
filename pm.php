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
#    Private messages File started
#
/*
        File name       -> pm.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='usercp                        ,
               usercp_pm_folder_message      ,
               usercp_pm_view                ,
               usercp_pm_new_message         ,
               usercp_pm_edit_folders_folder ,
               usercp_pm_edit_folders        ,
               usercp_pm_folder';

$phrasearray=array('profile'      ,
                   'usercp'       ,
                   'forum' ,
                   'memberlist'   ,
                   'register');

require('global.php');
include 'includes/functions_pm.php';

$plugins->cache('pm_start,pm_complete');

($evalp = $plugins->load('pm_start'))?eval($evalp):'';

if(($localgroup['canusepm']==0)||($local['userid']<1))
{
  error_permission();
}
$show['pm']=1;
if(empty($arbb->input['action']))
{
 $arbb->input['action']='folder';
}
$folders=array(1 => 'inbox',
               2 => 'sent_items');
$local_folders = explode('|',$local['folders']);
$i=0;
$pmfolders='';
while(isset($local_folders[$i]) and strlen($local_folders[$i])>0)
{
  $local_folders[$i]=str_replace('_',' ',$local_folders[$i]);
$p=$i+3;
$folders[$p]=$local_folders[$i];
$pmfolders.="<tr><td class=\"td1\"><a href=\"pm.php?folder=$p\">$local_folders[$i]</a></td></tr>";
$i++;
}
  $local['whereurl']   = 'pm.php?action='.$arbb->input['action'];
  $local['wheretitle'] = '';



if($arbb->input['action']=='folder')
{

$folder = checkval($arbb->input['folder']);

if(empty($folder))
{
 $folder=1;
}
 if($folders[$folder]=='inbox' || $folders[$folder]=='sent_items')
 {
  $foldername = $lang[$folders[$folder]];
 }
 else
 {
  $foldername ='';
 }
 $folderoptions='';
foreach($folders as $key => $val)
{
 if($key==1 or $key==2)
 {
  $val=$lang[$val];
 }
 $val=str_replace('_',' ',$val);
 $folderoptions.="<option value=\"$key\">$val</option>";
}


if(empty($foldername))
{
 if(!$folders[$folder])
 {
     error_message($lang['usercp_pm_folder_not_found']);
 }
 $foldername=str_replace('_',' ',$folders[$folder]);
}

$local['whereurl'].='&folder='.$folder;
$local['wheretitle']=$foldername;

eval("\$lang[messages_in_folder] = \"".$lang['messages_in_folder']."\";");

 $page                = (checkval($arbb->input['page']))?$arbb->input['page']:1;
 $perpage             = (checkval($arbb->input['pp']))?$arbb->input['pp']:15;

         $end=$page*$perpage;

         $start=$end-$perpage;

         $limit=$start.','.$perpage;


$total=$DB->num_rows($query=$DB->query("select pmid from "._PREFIX_."pm where folder='$folder' and userid='$local[userid]'"));
$query=$DB->query("select p.*,u.*,i.title as icontitle,i.iconpath,i.iconid from "._PREFIX_."pm p LEFT JOIN "._PREFIX_."users u on (u.userid=p.fuid) LEFT JOIN "._PREFIX_."icon i on(i.iconid=p.iconid) where p.folder='$folder' and p.userid='$local[userid]' order by pmid desc limit $limit");


$pages_table = next_page(checkval($arbb->input['folder']),$total,$perpage);


if($folder==2)
{
   $show['to'] = 1;
}

       while($pm = $DB->fetch_array($query))
       {
             $pm['date']=mydate($pm['dateline'],'date');
             if($pm['opened'] == 0)
             {
                $statusimage = 'new';
             }
             else
             {
                $statusimage = 'old';
             }

                   $pmstatus="<img src=\"$stylevar[dir]/status/pm_$statusimage.gif\" alt=\"".$lang[$statusimage."_message"]."\">";

                          if($pm['iconid']>0)
                          {
                          $pmicon="<img src=\"$pm[iconpath]\" alt=\"$pm[icontitle]\">";
                          }

           $messagesbit .= $TP->GetTemp('usercp_pm_folder_message');
       }

       $cpcontents = $TP->GetTemp('usercp_pm_folder');
}
elseif($arbb->input['action']=='send')
{

$local['wheretitle'].=$lang['new_pm'];
      if($local['showsignature']>0)
      {
       $checked['signature']='checked';
      }
      else
      {
       $checked['signature']='';
      }

   $query    = $DB->query("select * from "._PREFIX_."icon");
   $tabindex = 0;
   $i        = 0;
   $icons    = '';
   $pm       = array();

   while($icon=$DB->fetch_array($query))
   {
    $tabindex++;
    $i++;

    if($i>7)
    {
       $icons.='</tr><tr>
       <td width="12%">&nbsp;</td>
       ';
       $i=0;
            }

       $icons.="<td><input type=\"radio\" name=\"iconid\" value=\"$icon[iconid]\" id=\"iconid_$icon[iconid]\" tabindex=\"$tabindex\"></td>
<td width=\"12%\"><label for=\"iconid_$icon[iconid]\"><img src=\"$icon[iconpath]\" alt=\"$icon[title]\" id=\"icon_$icon[iconid]\"></label></td>\n";

           }
           $pmid=checkval($arbb->input['pmid']);
     if(($arbb->input['quote'] == 1)&&($pmid>0))
     {

         $pmq=$DB->query("select * from "._PREFIX_."pm where pmid='$pmid'");
         while($private=$DB->fetch_array($pmq))
         {

         $pm['title']     = $bbcode->clearhtml($private['title']);
         $pm['pmid']      = $private['pmid'];
         $pm['fusername'] = $bbcode->clearhtml($private['fusername']);
         $pm['pm']        = $bbcode->clearhtml($private['message']);

         }

     }
     $uid=checkval($arbb->input['uid']);
     if((!$pm['fusername']) && isset($uid))
     {

     $uu=$DB->query_now("select username from "._PREFIX_."users where userid='$uid'");
     $pm['fusername']=$bbcode->clearhtml($uu['username']);

     }
 $cpcontents = $TP->GetTemp('usercp_pm_new_message');
}
elseif($arbb->input['action']=='do_send')
{
            $title       = addslashes($arbb->input['title']);
            $message     = addslashes($arbb->input['message']);
            $poptions    = $arbb->input['poptions'];
            $iconid      = checkval($arbb->input['iconid']);
            $to          = $bbcode->clearhtml($arbb->input['to']);


if($poptions['disablesmilies']==1)
{
$poptions['allowsmilie']=0;
}
else
{
$poptions['allowsmilie']=1;
}
$poptions['showsignature']=checkval($poptions['signature']);

$error=1;
$query  = $DB->query("select * from "._PREFIX_."users where username='".addslashes($to)."'");
while($u= $DB->fetch_array($query))
{

 $toid=$u['userid'];
 $tousername=$bbcode->clearhtml($u['username']);
 $error=0;

}
if($error==1)
{
 error_message($lang['pm_error_not_send']);

}
else
{
 $insert = $DB->query("INSERT INTO `"._PREFIX_."pm` (`userid` , `fuid` , `tuid` , `fusername` , `tusername` , `opened` , `title` , `message` , `iconid` , `dateline` , `showsignature` , `allowsmilie` , `folder` )VALUES ('$toid', '$local[userid]', '$toid', '$local[username]', '$tousername', '0', '$title', '$message', '$iconid', '".TIMENOW."', '$poptions[showsignature]', '$poptions[allowsmilie]', '1')");
$query=$DB->query("UPDATE "._PREFIX_."users set pmtotal=pmtotal+1,pmunread=pmunread+1,pmpopup=1 where userid='$toid'");
 if(!$insert)
 {
  error_message($lang['pm_error_not_send']);
 }
 else
 {
 if($poptions['save_copy']==1)
 {
   $DB->query("INSERT INTO `"._PREFIX_."pm` (`userid` , `fuid` , `tuid` , `fusername` , `tusername` , `opened` , `title` , `message` , `iconid` , `dateline` , `showsignature` , `allowsmilie` , `folder` )VALUES ('$local[userid]', '$local[userid]', '$toid', '$local[username]', '$tousername', '1', '$title', '$message', '$iconid', '".TIMENOW."', '$poptions[showsignature]', '$poptions[allowsmilie]', '2')");
$query=$DB->query("UPDATE "._PREFIX_."users set pmtotal=pmtotal+1 where userid='$local[userid]'");
 }
   redirect($lang['pm_sent'],'pm.php');
 }

}

}
elseif($arbb->input['action']=='view')
{
$pmid=checkval($arbb->input['pmid']);
if(!$pmid || $pmid <1)
{
        error_message($lang['error_pm_not_exist']);
}
$error=1;
$pmq=$DB->query("select p.*,u.usergroupid,u.joindate,u.birthday,u.posts,u.usertitle,u.avatarid,u.signature,u.location,u.ipaddress,u.username as musername,ug.opentag,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."pm p
                                      LEFT JOIN "._PREFIX_."users u on (u.userid=p.userid)
                                      LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                      where p.userid='$local[userid]' and p.pmid='$pmid' limit 1");
while($pm=$DB->fetch_array($pmq))
{


$pm['pmtime']       = mydate($pm['dateline'],"last");
$pm['joindate']     = mydate($pm['joindate'],"date");
$pm['title']        = $bbcode->clearhtml($pm['title']);
$pm['message']      = $bbcode->build($pm['message']);
$pm['signature']    = $bbcode->build($pm['signature']);
$pm['fusername']    = $pm['opentag'].$pm['fusername'].$pm['closetag'];
$pbday=explode('-',$pm['birthday']);
$ptday=explode('-',mydate(TIMENOW,'date'));
$local['wheretitle']=$lang['view_pm'].' : '.$pm['title'];
$local['whereurl'].="&pmid=$pm[pmid]";
$pm['age']=$ptday[2]-$pbday[2];

if($localgroup['canviewip'])
{
$pm['user_ip']      = "<img src=\"$stylevar[dir]/status/user_ip.gif\" alt=\"$pm[ipaddress]\">";
}
          if($pm['fuid']>0)
          {
            if(empty($pm['usertitle']))
            {
             $pm['usertitle']=$pm['gusertitle'];
            }

            if(empty($pm['usertitle']))
            {
               $pm['usertitle']=build_title($pm['posts']);

            }

          }
          else
          {
              $pm['usertitle']=$lang['guest'];
          }

          if(get_user_status($pm['fuid'])>0)
          {
              $statusbutton='online';
          }
          else
          {
              $statusbutton='offline';
          }

$pm['user_status']=$lang[$statusbutton];
$pm['onlinestatus']="<img src=\"$stylevar[dir]/status/user_$statusbutton.gif\" alt=\"$pm[musername] $lang[$statusbutton]\">";

 $cpcontents = $TP->GetTemp('usercp_pm_view');
 $error=0;
 if($pm['opened']==0)
 {
 $DB->query("update "._PREFIX_."pm set opened=1 where pmid='$pmid'");
 $DB->query("update "._PREFIX_."users set pmunread=pmunread-1 where userid='$local[userid]'");
 }

 $fid=$pm['folder'];


 }
 if($error==1)
 {

 error_message($lang['error_pm_not_exist']);
 }
}
elseif($arbb->input['action']=='edit_folders')
{
$local_folders=array();
foreach($folders as $id => $name)
{

 if($name=='inbox' || $name='sent_items')
 {

  $name = $lang[$folders[$id]];
 }
 else
 {
  $name='';
 }

  if(empty($name))
  {
   $name=str_replace('_',' ',$folders[$folder]);
  }

 $local_folders[$id]=$name;

}

$qu = $DB->query("select folder from "._PREFIX_."pm where userid='$local[userid]'");
while($p = $DB->fetch_array($qu))
{
$fo='m'.$p['folder'];
 $local_folders[$fo]=$local_folders[$fo]+1;
}
$subfolders='';
         $local_folders[m1]=($local_folders[m1])?$local_folders[m1]:'0';
         $local_folders[m2]=($local_folders[m2])?$local_folders[m2]:'0';

foreach($folders as $id => $name)
{
        $fo         = 'm'.$id;
        $num        = ($local_folders[$fo])?$local_folders[$fo]:'0aaa';
         $num='sss';
        if($id > 2)
        {
                $subfolders.= $TP->GetTemp('usercp_pm_edit_folders_folder');
        }
}
$local['wheretitle']=$lang['edit_folders'];
$cpcontents = $TP->GetTemp('usercp_pm_edit_folders');
}
elseif($arbb->input['action']=='delete_folder')
{
$fid=checkval($arbb->input['fid']);
     if($fid > 2)
     {
          if(strlen($folders[$fid])<1)
          {
              error_message($lang['error_folder_couldnt_delete']);
          }

          $comma='';
          $editedfolders = '';

          foreach($local_folders as $id => $name)
          {
            $nid=$id+3;
           if($nid != $fid)
           {

            $editedfolders.=$comma.trim($name);
            $comma="|";
           }
          }

          $del=$DB->query("select pmid from "._PREFIX_."pm where userid='$local[userid]' and folder='$fid'");

          $upda=$DB->query("update "._PREFIX_."users set folders='$editedfolders' where userid='$local[userid]'");

          $num=$DB->num_rows($del);

          if(!$upda)
          {
              error_message($lang['pm_folder_not_deleted']);
          }
          else
          {
           $DB->query("update "._PREFIX_."pm set folder=folder-1 where userid='$local[userid]' and folder>$fid");
          $alert=$lang['pm_folder_deleted'];

            if($num > 0)
            {
               $alert.=$lang['pm_folders_deletd_note'];
               $DB->query("DELETE FROM "._PREFIX_."pm where userid='$local[userid]' and folder='$fid'");
            }
              redirect($alert,'pm.php?action=edit_folders');
          }

     }
     else
     {
         error_message($lang['error_folder_couldnt_delete']);
     }

}
elseif($arbb->input['action']=='do_editfolders')
{
 $newfolder=$arbb->input['newfolder'];
 $exfolders=$arbb->input['exfolders'];

 $editedfolders    = '';
 $comma            = '';
 if(is_array($exfolders))
 {
 foreach($exfolders as $id => $name)
 {
     $nid=$id-3;
     if(isset($local_folders[$nid]))
     {
     if(empty($exfolders[$id]))
     {
        $exfolders[$id]=$lang['no_name'];
     }
         $editedfolders.=$comma.$bbcode->clearhtml($exfolders[$id]);
         $comma='|';
     }

 }
 }

 if(strlen($editedfolders)<1)
 {
  $comma='';
 }

 foreach($newfolder as $id => $name)
 {
  if(strlen($name)>0)
  {
   $editedfolders.=$comma.$name;
  $comma='|';
  }
 }

 $editedfolders=$bbcode->clearhtml($DB->escape_string($editedfolders));

 $upda=$DB->query("update "._PREFIX_."users set folders='$editedfolders' where userid='$local[userid]'");

    if(!$upda)
    {
     error_messages($lang['pm_folders_not_updated']);
    }
    else
    {
        redirect($lang['pm_folders_update'],'pm.php?action=edit_folders');
    }
}
elseif($arbb->input['action']=='export')
{
 $query=$DB->query("select * from "._PREFIX_."pm where userid='$local[userid]' and folder<>2");
 $query2=$DB->query("select * from "._PREFIX_."pm where userid='$local[userid]' and folder='2'");

$local['username']=$bbcode->clearhtml($local['username']);
 $filename=$local['username'].'-'.$lang['messages'].'.txt';
        header('Content-disposition: filename='.$filename.'');
        header('Content-type: text/plain');
$local['time']=str_replace('&nbsp;',' ',mydate(TIMENOW,'date'));

 eval("\$ex=\"".$lang['pm_export_note']."\";");

 while($pm=$DB->fetch_array($query))
 {
 $pm['date']=str_replace('&nbsp;',' ',mydate($pm['dateline'],'last'));
 $pm['message']=$bbcode->clearhtml($pm['message']);
 $pm['title']=$bbcode->clearhtml($pm['title']);
 $pm['fusername']=$bbcode->clearhtml($pm['fusername']);

 $ex .= "

$lang[title] : $pm[title]
$lang[from]  : $pm[fusername]
$lang[date]  : $pm[date]
-----------------------------------------------------------------------
$pm[message]
-----------------------------------------------------------------------";
 }
 while($pm=$DB->fetch_array($query2))
 {
 $pm['date']=str_replace('&nbsp;',' ',mydate($pm['dateline'],'last'));
 $pm['message']=$bbcode->clearhtml($pm['message']);
 $pm['title']=$bbcode->clearhtml($pm['title']);
 $pm['fusername']=$bbcode->clearhtml($pm['fusername']);

 $ex .= "

$lang[title] : $pm[title]
$lang[usercp_pm_sent_to]  : $pm[fusername]
$lang[date]  : $pm[date]
-----------------------------------------------------------------------
$pm[message]
-----------------------------------------------------------------------";
 }

die($ex);

}
elseif($arbb->input['action']=='messages_edit')
{

$private=$arbb->input['private'];

if(is_array($private))
{
$private=implode(',',$private);
}
else
{
error_message($lang['no_messages_selected']);
}
$folder = checkval($arbb->input['folder']);
$cufid  = checkval($arbb->input['cufid']);


$foldername=$folders[$folder];


$pms="";
$query=$DB->query("select * from "._PREFIX_."pm where pmid in (".$bbcode->clearhtml(addslashes($private)).") and userid='$local[userid]'");
while($pm = $DB->fetch_array($query))
{
$comma=($pms)?',':'';
$pms.=$comma."$pm[pmid]";
}

$pms=($pms)?$pms:'0';
if($arbb->input['delete'])
{
$num=count(explode(",",$pms));

  $del = $DB->query("delete from "._PREFIX_."pm where pmid in ($pms)");
  if(!$del)
  {
     error_message($lang['selected_messages_not_deleted']);
  }
  else
  {

  $unread_q=$DB->query('select * from '._PREFIX_.'pm where opened=0 and tuid=\''.$local['userid'].'\'');
  $unread=$DB->num_rows($unread_q);
  $total_q=$DB->query('select * from '._PREFIX_.'pm where tuid=\''.$local['userid'].'\'');
  $total=$DB->num_rows($total_q);
  $DB->query('update '._PREFIX_.'users set pmtotal=\''.$total.'\',pmunread=\''.$unread.'\' where userid=\''.$local['userid'].'\'');
     redirect($lang['selected_messages_deleted'],"pm.php?action=folder&folder=$cufid");

  }
}
else  if($arbb->input['move'])
{
if(!$folder||!$foldername)
{
error_message($lang['error_pm_folder_not_found']);
}
  $upda = $DB->query("update "._PREFIX_."pm set folder='$folder' where pmid in ($pms)");
  if(!$upda)
  {
     error_message($lang['selected_messages_not_moved']);
  }
  else
  {
     redirect($lang['selected_messages_moved'],"pm.php?action=folder&folder=$cufid");
  }
}



}


     if($arbb->input['action']=='view')
     {
      build_nav_location($lang['private_messages'],"pm.php?folder=$fid",'add');
     }
     else
     {

          build_nav_location($lang['private_messages'],'pm.php','add');
     }
     build_nav_location($local['wheretitle'],$local['whereurl'],'add',1);
$titleetc=$lang['private_messages']." - ".$local['wheretitle'].' - ';

   $TP->WebTemp('usercp');

   ($evalp = $plugins->load('pm_complete'))?eval($evalp):'';

   update_online();

   print_page()

?>