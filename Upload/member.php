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
#    member tools File started
#
/*
        File name       -> member.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/
$templatelist='member_view_profile,member_sendmail,member_view_profile_threadbit';

$phrasearray = array('profile','memberlist','forum','register','contactus');

require('global.php');

if(empty($arbb->input['action']))
{
 $arbb->input['action']='profile';
 if(empty($arbb->input['userid']))
 {
 $arbb->input['userid']=$arbb->input['u'];

 }
}
$local['whereurl']='member.php?action='.$bbcode->clearhtml($arbb->input['action']).'&';

if($arbb->input['find']=='lastposter')
{
$forum=checkval($arbb->input['f']);

$fo=$DB->query_now("select lastposterid from forum where forumid='$forum'");

$arbb->input['action']='profile';
$arbb->input['userid']=$fo['lastposterid'];

}

if($arbb->input['action']=='profile')
{

$uid=checkval($arbb->input['userid']);
 $query=$DB->query("select u.*,a.path as avatarpath,a.title as avatartitle,ug.usertitle as ugusertitle,ug.opentag,ug.closetag,ug.title as groupname
                    From "._PREFIX_."users u
                    LEFT JOIN "._PREFIX_."avatar a on(a.avid=u.avatarid)
                    LEFT JOIN ". _PREFIX_ ."usergroup ug on (ug.usergroupid=u.usergroupid)
                    where u.userid='$uid'");

 while($user = $DB->fetch_array($query))
 {
 foreach($user as $key => $val)
 {
 if(!eregi('tag',$key)&&!(eregi('signatu',$val)))
 {
  $user[$key]=$bbcode->clearhtml($val);

  }
 }
     $local['wheretitle']=$lang['user_profile'].' - '.$user['username'];

     $local['whereurl'].="userid=$user[userid]";
$threads=$DB->query_now("select count(*) as threads from "._PREFIX_."thread where postuserid='$user[userid]'");
                  if($user['customtitle']==1)
                  {
                      $user['usertitle']=$user['usertitle'];
                  }
                  else
                  {
                      $user['usertitle']=$user['ugusertitle'];
                  }
                    $user['usertitle']=($user['usertitle'])?$user['usertitle']:$user['ugusertitle'];
                  if(!$user['usertitle'])
                  {
                   $user['usertitle']=build_title($user['posts']);
                  }

eval("\$lang['send_user_email']=\"".$lang['send_user_email']."\";");
eval("\$lang['send_user_pm']=\"".$lang['send_user_pm']."\";");
$user['threads']    = $threads['threads'];
$user['posts']      = $user['posts'];
$user['name']       = $user['username'];
$user['username']   = $user['opentag'].$user['username'].$user['closetag'];
$user['join_date']  = mydate($user['joindate'],'date');
$user['last_activity'] = mydate($user['lastactivity'],'last');
$user['homepage']   = ($user['homepage'])?$bbcode->clearhtml($user['homepage']):'&nbsp;';
$user['signature']  = ($user['signature'])?$bbcode->build($user['signature']):'&nbsp;';
$threads='';

$threads_q       = $DB->query("select t.*,p.post,i.title as icontitle,i.iconpath,i.iconid from "._PREFIX_."thread t
                               LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
                               LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                               where postuserid='$user[userid]'
                               order by threadid desc limit 5");
while($thread=$DB->fetch_array($threads_q))
{


                      $thread=$bbcode->clearhtml($thread);
                      $thread['post']=substr($bbcode->clearbbcode(str_replace('<br>',"\n",$thread['post'])),0,350);
                          $thread['lastposttime']=mydate($thread['lastpost'],'last');
                          $thread['statusimg'] = threadstatusimg($thread);
                          $posticon='';
                          if($thread['iconid']>0)
                          {
                          $posticon="<img src=\"$thread[iconpath]\" alt=\"$thread[icontitle]\">";
                          }
 $threads.=$TP->GetTemp('member_view_profile_threadbit');
}
$lang['search_for_x_posts']=str_replace('{1}',$user['name'],$lang['search_for_x_posts']);
$lang['search_for_x_threads']=str_replace('{1}',$user['name'],$lang['search_for_x_threads']);

$post=$DB->query_now('select * from '._PREFIX_.'post where userid=\''.$user['userid'].'\' order by postid desc limit 0,1');
$post=$bbcode->clearhtml($post);
$post['time']=mydate($post['dateline'],'last');
 $TP->webtemp('member_view_profile');
 }
}
elseif($arbb->input['action']=='activate')
{
    $userid = checkval($arbb->input['userid']);
    $code   = $bbcode->clearhtml($arbb->input['code']);
    $do     = $bbcode->clearhtml($arbb->input['do']);
    $error  = 1;

    $qu = $DB->query("select v.*,u.email,u.username from "._PREFIX_."verification v LEFT JOIN "._PREFIX_."users u on (u.userid=v.userid) where v.userid='$userid' and v.code='$code'");
    while($v = $DB->fetch_array($qu))
    {
      $error=0;
       if(strlen($v['addition']>0))
       {
        $do='password';
       }

      $DB->query("update "._PREFIX_."$v[query]");

      if($do=='email'||$do=='password')
      {
            if($do=='password')
            {
             eval("\$message = \"".$lang['message_verification_complete_password']."\";");
             sendmail($v['email'], $lang['password_change_information'], $message,$options['webmasteremail'], $options['sitetitle']);
            }
       redirect($lang['verification_complete_$do'],$options['forumhome'].'.php');
      }
      else
      {
       redirect($lang['verification_complete'],$options['forumhome'].'.php');
      }

    }

    if($error==1)
    {
     error_message($lang['verification_failed']);
    }

}
elseif($arbb->input['action']=='sendemail')
{
$local['wheretitle']=$lang['send_email'];
$uid=checkval($arbb->input['uid']);
$local['whereurl'].=($uid)?"uid=$uid":'';

if($uid>0)
{
$u=$DB->query_now("select username from "._PREFIX_."users where userid='$uid'");

$username=$u['username'];
}
else
{
 $username='';
}


$TP->webtemp('member_sendmail');

}
elseif($arbb->input['action']=='do_sendemail')
{
$local['wheretitle']=$lang['send_email'];

$to            = $bbcode->clearhtml($arbb->input['to']);
$message       = $bbcode->clearhtml($arbb->input['message']);
$title         = $bbcode->clearhtml($arbb->input['title']);
$show['error'] = 0;

$u = $DB->query_now("select email from "._PREFIX_."users where username='$to'");
$recepient = $u['email'];

if(empty($to)||empty($message)||empty($title)||empty($recepient))
{
$show['errors'] = 1;
$error_messages = '';
$errors         = array();
$username       = $to;

       if(empty($to)||empty($recepient))
       {
                 $errors[]=$lang['recepient_error'];
       }
       if(empty($message))
       {
                 $errors[]=$lang['fill_message_field'];
       }
       if(empty($title))
       {
                 $errors[]=$lang['fill_subject_filed'];
       }
   $error_messages=implode('<br><li>',$errors);
   $TP->webtemp('member_sendmail');

}
else
{

 $name  = $bbcode->clearhtml($local['username'])." @ $options[sitetitle]";;
 $email = $bbcode->clearhtml($local['email']);

     $send = sendmail($recepient, $title, $message,$email, $name);
     if(!$send)
     {
      error_message($lang['error_sending_message']);
     }
     else
     {
       $url = $options['forumhome'].'.php';
       $redirect_message = $lang['message_sent_succefully'];

         redirect($redirect_message,$url);
     }
}

}
     $titleetc=($titleetc)?$titleetc:$local['wheretitle'].' - ';

     build_nav_location($local['wheretitle'],$local['whereurl'],'add',1);
   print_page();
?>