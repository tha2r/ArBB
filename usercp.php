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
#    User Control Panel File started
#
/*
        File name       -> usercp.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='usercp                                       ,
               usercp_main                                  ,
               usercp_edit_options                          ,
               usercp_edit_profile                          ,
               usercp_edit_signature                        ,
               register_birthday                            ,
               usercp_edit_password                         ,
               usercp_list_threads                          ,
               usercp_list_threads_threadbit                ,
               usercp_list_subscriptions_subscriptionbit    ,
               usercp_list_attachments                      ,
               usercp_list_subscriptions                    ,
               usercp_list_attachments_attach               ,
               usercp_avatars_album                         ,
               usercp_edit_avatar                           ,
               usercp_edit_email';

$phrasearray=array('profile'      ,
                   'usercp'       ,
                   'forum' ,
                   'memberlist'   ,
                   'register');

require('global.php');
Include 'includes/functions_usercp.php';

$plugins->cache('usercp_start,usercp_complete');

($evalp = $plugins->load('usercp_start'))?eval($evalp):'';

if(($localgroup['canuseusercp']==0)||($local['userid']<1))
{
  error_permission();
}



  $show['pm']   = $localgroup['canusepm'];
  $styleoptions = '';
  $avatarbits   = '';
  $avatars      = array();
  $daysel       = array();
  $msel         = array();
  $year         = '';
  $albums       = '';

  $local['whereurl']   = 'usercp.php?action='.$arbb->input['action'];
  $local['wheretitle'] = $lang['control_panel'];

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
 if($localgroup['avatarmaxsize']==0)
 {

    $show['avatarlink']=0;
 }
 else
 {

     $show['avatarlink']=1;
 }

  $show['editsignature']=1;

if(empty($arbb->input['action']))
{

   $arbb->input['action'] = 'main';
}

if($arbb->input['action']=='editavatar' || $arbb->input['action']=='avatars_album' || $arbb->input['action']=='main')
{

if($arbb->input['action']=='avatars_album')
{
 $sql = "where catid='".$arbb->input['albumid']."' order by displayorder";
}
else
{
 $sql="";
}

$query = $DB->query("select * from ". _PREFIX_ ."avatar $sql");

         while($av = $DB->fetch_array($query))
         {

         $i++;
          $avatars["$av[path]"] = $av['avid'];

           $avatarbits.= "<td width=\"20%\" align=\"center\">
           <img src=\"$av[path]\"><br>
           <input type=\"radio\" name=\"avatarid\" value=\"".$av['avid']."\"";

             if($av['avid'] == $local['avatarid'])
             {
               $avatarbit="<img src=\"$av[path]\">";
               $avatarbits.=' checked';
                $local['avatarpath']=$av['path'];
             }

           $avatarbits.='>'.$av['title'].'</option></td> ';

           if($i==4)
           {
            $avatarbits.='</tr><tr>';
            $i=0;
           }
         }
if($arbb->input['action'] != 'main')
{
   $avalqu=$DB->query("select * from "._PREFIX_."imagecat where type='3'");
   while($al=$DB->fetch_array($avalqu))
   {

      if($al['catid']==$arbb->input['albumid'])
      {
         eval("\$lang[current_avatars_in_album]=\"".$lang['current_avatars_in_album']."\";");
      }

    $albums.="<option value=\"$al[catid]\">$al[title]</option>";
   }

}

}


if(eregi('do_',$arbb->input['action']))
{

     build_nav_location($local['wheretitle'],$local['whereurl'],'add');
}

if($arbb->input['action']=='main')
{

$local['wheretitle']=$lang['main'];
$titleetc=$local['wheretitle'].' => ';

$threads=$DB->query_now("select count(*) as threads from "._PREFIX_."thread where postuserid='$local[userid]'");

$local['threads']    = $threads['threads'];
$local['posts']      = $local['posts'] - $local['threads'];
$local['username']   = $localgroup['opentag'].$local['username'].$localgroup['closetag'];
$local['join_date']  = mydate($local['joindate'],'date');

$cpcontents=$TP->GetTemp('usercp_main');

}
elseif($arbb->input['action']=='editsignature')
{

 $local['wheretitle']=$lang['edit_signature'];
 $titleetc=$local['wheretitle'].' => ';

 $local['b_signature'] = $bbcode->build($local['signature']);
 $local['signature']   = $bbcode->clearhtml(stripslashes($local['signature']));



 $cpcontents=$TP->GetTemp('usercp_edit_signature');
}
elseif($arbb->input['action']=='editpassword')
{

 $local['wheretitle']=$lang['edit_password'];
 $titleetc=$local['wheretitle'].' => ';

 $cpcontents=$TP->GetTemp('usercp_edit_password');
}
elseif($arbb->input['action']=='editemail')
{

  $local['wheretitle']=$lang['edit_email'];
  $titleetc=$local['wheretitle'].' => ';

  $cpcontents=$TP->GetTemp('usercp_edit_email');

}
elseif($arbb->input['action']=='editprofile')
{
     $birthday=array();

          if(strlen($local['birthday']) > 0)
          {
              $birthday = explode('-',$local['birthday']);

              $year                 = $birthday[2];
              $daysel[$birthday[0]] = 'selected';
              $msel[$birthday[1]]   = 'selected';

          }
          else
          {
              $year='';
              $daysel[0]='selected';
              $msel[0]='selected';
          }

  $birthdaybit = $TP->GetTemp('register_birthday');

 $local['wheretitle'] = $lang['edit_profile'];
 $titleetc            = $local['wheretitle'].' => ';

 $cpcontents=$TP->GetTemp('usercp_edit_profile');

}
elseif($arbb->input['action']=='editavatar')
{

 $local['wheretitle'] = $lang['edit_avatar'];
 $titleetc            = $local['wheretitle'].' => ';
 $cpcontents=$TP->GetTemp('usercp_edit_avatar');

}
elseif($arbb->input['action']=='editoptions')
{
 $local['wheretitle'] = $lang['edit_options'];
 $titleetc            = $local['wheretitle'].' => ';

$sel=array('autosubscribe' => array('yes' => '','no' => ''),
           'showbbcode' => array('yes' => '','no' => ''),
           'showsignature' => array('yes' => '','no' => ''),
           'showbirthday' => array('yes' => '','no' => ''),
           'pmpopup' => array('yes' => '','no' => ''));

foreach($sel as $key => $val)
{

 if($local[$key] == 1)
 {
  $sel[$key.'yes']='checked';
  $sel[$key.'no']='';
 }
 else
 {
  $sel[$key.'yes'] = '';
  $sel[$key.'no']  = 'checked';
 }

}

$stq=$DB->query("select * from "._PREFIX_."styles");

while($sty=$DB->fetch_array($stq))
{

  $styleoptions .= "<option value=\"$sty[styleid]\"";

  if($local['styleid']==$sty['styleid'])
  {
   $styleoptions .= 'selected';
  }

  $styleoptions .= ">$sty[title]</option>";
}

  $cpcontents=$TP->GetTemp('usercp_edit_options');

}
elseif($arbb->input['action']=='listthreads'||$arbb->input['action']=='listsubscriptions')
{

 $page                = (checkval($arbb->input['page']))?$arbb->input['page']:1;
 $perpage             = (checkval($arbb->input['pp']))?$arbb->input['pp']:15;

           $end=$perpage*$page;
           $start=$end-$perpage;

if($arbb->input['action']=='listthreads')
{
 $local['wheretitle'] = $lang['your_threads'];
$mainquery = "select t.*,p.post,i.title as icontitle,i.iconpath from "._PREFIX_."thread t
              LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
              LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
              where t.postuserid='$local[userid]'
              order by lastpost DESC limit $start,$perpage";
$totalquery = "select * from "._PREFIX_."thread where postuserid='$local[userid]'";
$subtemp  = 'usercp_list_threads_threadbit';
$maintemp = 'usercp_list_threads';
}
else
{

 $local['wheretitle'] = $lang['your_subscriptions'];


$mainquery = "select ts.*,t.*,p.post,i.title as icontitle,i.iconpath from "._PREFIX_."threadsubscribe ts
          LEFT JOIN ". _PREFIX_ ."thread t on (t.threadid=ts.threadid)
          LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
          LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
          where t.postuserid='$local[userid]'
          order by lastpost DESC limit $start,$perpage";
$totalquery="select * from "._PREFIX_."threadsubscribe where userid='$local[userid]'";

$subtemp  = 'usercp_list_subscriptions_subscriptionbit';
$maintemp = 'usercp_list_subscriptions';
}
 $titleetc            = $local['wheretitle'].' => ';


$total=$DB->num_rows($DB->query($totalquery));
        $pages_table = next_page($arbb->input['action'],$total,$perpage);


           $threadsbit='';

$query=$DB->query($mainquery);
$i=0;
while($thread=$DB->fetch_array($query))
{
$i++;
                          if($thread['open']==0)
                          {
                           $thread['statusimg']='thread_lock';
                          }

                          if($thread['lastpost']>$newthread)
                          {
                          $thread['statusimg']='thread_new';

                          if(($thread['replycount']>15)||($thread['views']>150))
                          {

                          $thread['statusimg']='thread_hot';

                          }

                          }
                          else
                          {

                          $thread['statusimg']='thread_old';

                          }
                          if($thread['iconid']>0)
                          {
                          $posticon="<img src=\"$thread[iconpath]\" alt=\"$thread[icontitle]\">";
                          }
                          else
                          {
                           $posticon='&nbsp;';
                          }
                          $thread['lastposttime']=mydate($thread['lastpost'],'last');
                          $thread['title']=$bbcode->clearhtml($thread['title']);
                            $thread['post']=str_replace("<br>","",substr($bbcode->clearhtml($thread['post']),0,350));
                            $thread['post']=$bbcode->clearbbcode($thread['post']);
    $threadsbit.=$TP->GetTemp($subtemp);
}
  $cpcontents=$TP->GetTemp($maintemp);

}
elseif($arbb->input['action']=='listattach')
{
 $local['wheretitle'] = $lang['attachment_manager'];
 $titleetc            = $local['wheretitle'].' => ';
 $page=(checkval($arbb->input['page']))?$arbb->input['page']:1;
 $perpage=15;
 $atdown=0;
 $atquota=0;
 $attachmentsbit = "";
 $totalq = $query=$DB->query("select atid from "._PREFIX_."attachment where userid='$local[userid]'");
 $atnum  = $DB->num_rows($totalq);
 $pages_table=next_page('listattach',$atnum,$page);
           $end=$perpage*$page;
           $start=$end-$perpage;

           $limit = "$start,$perpage";
 $query=$DB->query("select a.*,t.title as posttitle,p.threadid,p.postid from "._PREFIX_."attachment a LEFT JOIN "._PREFIX_."post p on (p.postid=a.postid) LEFT JOIN "._PREFIX_."thread t on (t.threadid=p.threadid)  where a.userid='$local[userid]' order by atid desc limit $limit");


while($at=$DB->fetch_array($query))
{
$atdown=$atdown+$at['counter'];
$atsize=$atsize+$at['filesize'];
$at['title']=$bbcode->clearhtml($at['filename']);
$at['date']=mydate($at['dateline'],'last');
 $attachmentsbit.=$TP->GetTemp('usercp_list_attachments_attach');

}

if($localgroup['attachlimit'] != 0)
{
 $atq=ceil($atsize/$localgroup['attachlimit']);
}
else
{
 $atq=$lang['unlimited'];
}


$atsize=ceil($atsize/1024);
if($atsize > 1024)
{
$atsize=ceil($atsize/1024);
$BB='MB';
}
else
{
$BB='KB';
}
if($atsize > 1024)
{
$atsize=ceil($atsize/1024);
$BB='GB';
}

$atsize="$atsize $BB. ($atq)";


$atquota=($localgroup['attachlimit'])?$localgroup['attachlimit']:$lang['unlimited'];

 $cpcontents=$TP->GetTemp('usercp_list_attachments');

}
elseif($arbb->input['action']=='upload_avatar')
{

$avatar=$_FILES['avatar'];
if(!is_array($avatar))
{
     error_message($lang['error_avatar_upload_failed']);
}

if(!eregi('image',$avatar['type']))
{
     error_message($lang['error_avatar_upload_failed']);
}

if($avatar['size']>$localgroup['avatarmaxsize'])
{
 error_message($lang['error_avatar_upload_size']);
}

include 'includes/class_upload.php';

$up = new arbb_upload;

$up->upload_path='images/avatars/';

$upload = $up->upload_avatar($avatar);

        if(!$upload)
        {
             error_message($lang['error_avatar_upload_failed']);
        }
        else
        {
           $DB->query("update "._PREFIX_."users set avatarid='$upload' where userid='$local[userid]'");
            redirect($lang['avatar_uploaded'],'usercp.php?action=main');
        }

}
elseif($arbb->input['action']=='avatars_album')
{
  $cpcontents=$TP->GetTemp('usercp_avatars_album');
}
elseif($arbb->input['action']=='do_editsignature')
{

 $local['wheretitle'] = $lang['edit_signature'];
 $titleetc            = $local['wheretitle'].' => ';

 $signature = addslashes(stripslashes($arbb->input['signature']));
 $sql = $DB->query("update "._PREFIX_."users set signature='".$signature."' where userid='$local[userid]'");

       if(!$sql)
       {

        error_message($lang['signature_not_updated']);
       }
       else
       {

        redirect($lang['signature_updated'],'usercp.php?action=editsignature');
       }

}
elseif($arbb->input['action']=='do_editpassword')
{

 if($local['password']==md5(addslashes($bbcode->clearhtml($arbb->input['old_password']))))
 {
     if((strlen($arbb->input['new_password'])<5)||(strlen($arbb->input['new_password'])>25))
     {
           error_message($lang['password_to_long_small']);
     }
     else
     {

             if($arbb->input['new_password'] == $arbb->input['new_password2'])
             {
                $upda=$DB->query("update "._PREFIX_."users set password='".md5(addslashes($bbcode->clearhtml($arbb->input['new_password'])))."' where userid='$local[userid]'");

                if(!$upda)
                {

                   error_message($lang['password_not_updated']);
                }
                else
                {

                    newcookie('password',md5(addslashes($bbcode->clearhtml($arbb->input['new_password']))));
                   redirect($lang['password_updated'],'usercp.php?action=main');
                }
             }
             else
             {

                 error_message($lang['password_not_match']);
             }

     }
 }
 else
 {

     error_message($lang['password_not_the_same']);
 }

}
elseif($arbb->input['action']=='do_editemail')
{

   $emex = $DB->query("select userid from "._PREFIX_."users where email='".addslashes($bbcode->clearhtml($arbb->input['email']))."'");

   if($DB->Num_rows($emex)>0)
   {

       error_message($lang['email_already_used']);
   }
   else
   {

     if(!checkmail($arbb->input['new_email']))
     {

           error_message($lang['not_valid_email']);
     }
     else
     {

          $local['new_email']=$bbcode->clearhtml($arbb->input['new_email']);
          $randomcode = random_string(10);
          $dateline=TIMENOW;

          eval("\$lang['message_email_change'] = \"".$lang['message_email_change']."\";");

          $ins = $DB->query("insert into "._PREFIX_."verification (userid,code,query,dateline) values ('$local[userid]','$randomcode','users set email=\'$local[new_email]\' where userid=\'$local[userid]\'','$dateline')");

          if(!$ins)
          {
              error_message($lang['email_not_updated']);
          }
          else
          {

          $send = sendmail($local['new_email'], $lang['email_change_verification'], $lang['message_email_change'],$options['webmasteremail'], $options['sitetitle']);
           redirect($lang['email_updated'],'usercp.php?action=main');
          }

     }
  }
}
elseif($arbb->input['action']=='do_editprofile')
{
 $update='';

$birthday=checkval($arbb->input['day'])
          .'-'.checkval($arbb->input['month'])
          .'-'.checkval($arbb->input['year']);
$arrayed = array('homepage',
                 'icq'     ,
                 'aim'     ,
                 'yahoo'   ,
                 'msn');

   foreach($arrayed as $key => $val)
   {
    $update.=$val."='".addslashes($bbcode->clearhtml($arbb->input[$val]))."',";
   }

   $update.="birthday = '$birthday'";

     $upda=$DB->query("update "._PREFIX_."users set $update where userid='$local[userid]'");

      if(!$upda)
      {
            error_message($lang['profile_not_updated']);
      }
      else
      {
            redirect($lang['profile_updated'],'usercp.php?action=main');
      }


}
elseif($arbb->input['action']=='do_editavatar')
{
$arbb->input['avatarid']=checkval($arbb->input['avatarid']);


     $upda=$DB->query("update "._PREFIX_."users set avatarid = '".addslashes($bbcode->clearhtml($arbb->input['avatarid']))."' where userid='$local[userid]'");

      if(!$upda)
      {
            error_message($lang['avatar_not_updated']);
      }
      else
      {
            redirect($lang['avatar_updated'],'usercp.php?action=main');
      }


}
elseif($arbb->input['action']=='do_editoptions')
{

$arrayed=array('styleid'        ,
               'autosubscribe'  ,
               'showbbcode'     ,
               'showsignature'  ,
               'showbirthday'   ,
               'pmpopup'         );

$update=array();

        foreach($arrayed as $key => $val)
        {

        $update[]="$val = '".addslashes(checkval($arbb->input[$val]))."'";

        }

$update=implode(',',$update);

        $upda = $DB->query("update "._PREFIX_."users set $update where userid='$local[userid]'");

                if(!$upda)
                {
                    error_message($lang['options_not_updated']);
                }
                else
                {
                    redirect($lang['options_updated'],'usercp.php?action=main');
                }

}
elseif($arbb->input['action']=='delete_subscriptions')
{
 $id=$arbb->input['id'];

 $ids=implode(',',$id);

      $query = $DB->query("delete from "._PREFIX_."threadsubscribe where stid in($ids) and userid='$local[userid]'");


      if(!$query)
      {
              error_message($lang['threads_subscriptions_not_deleted']);
      }
      else
      {
              redirect($lang['threads_subscriptions_deleted'],'usercp.php?action=listsubscriptions');

      }

}
elseif($arbb->input['action']=='do_del_attachment')
{

$attachments=$arbb->input['attachments'];
              $deletedattach="";

             foreach($attachments as $key => $id)
             {
              $deletedattach.=','.$id;
             }

             $query = $DB->query("select a.*,p.postid,p.threadid from "._PREFIX_."attachment a LEFT JOIN "._PREFIX_."post p on (p.postid=a.postid) where atid in (0$deletedattach) and a.userid='$local[userid]'");
             while($at=$DB->fetch_array($query))
             {

                   $DB->query("update "._PREFIX_."post set attach=attach-1 where postid='$at[postid]'");
                   $DB->query("update "._PREFIX_."thread set attach=attach-1 where threadid='$at[threadid]'");
             }

            $del=$DB->query("delete from "._PREFIX_."attachment where atid in(0$deletedattach) and userid='$local[userid]'");

            if(!$del)
            {
              error_message($lang['attachments_not_deleted']);
            }
            else
            {
               redirect($lang['attachments_deleted'],'usercp.php?action=listattach');
            }

}




if($arbb->input['action'] != 'main')
{

     build_nav_location($lang['control_panel'],'usercp.php','add');
     build_nav_location($local['wheretitle'],$local['whereurl'],'add',1);

}
else
{

     build_nav_location($lang['control_panel']." - ".$local['wheretitle'],$local['whereurl'],'add',1);

        }

   $TP->WebTemp('usercp');

($evalp = $plugins->load('usercp_complete'))?eval($evalp):'';

   update_online();

   print_page();


?>