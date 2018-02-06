<?php
/*======================================================================*\
|| #################################################################### ||
|| #                     Arbb 1.0.0 (beta 1)                          # ||
|| #       All Copyrights are saved Arabian bulletin board team       # ||
|| #                   Copyright © 2006 ArBB Team                     # ||
|| #           ArBB Is Free Bulletin Board and not for sale           # ||
|| #################################################################### ||
\*======================================================================*/
#
#    showpost File started
#
/*
        File name       -> showpost.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='showpost,showthread_attachmentbit';
$phrasearray=array('forumdisplay','showthread','showteam','profile','showpost');

require('global.php');

$plugins->cache('showpost_start,showpost_post,showpost_complete');

$post_page='';

$plugins->load('showpost_start');

          $pid=intval($arbb->input['pid']);
                   $posts_query=$DB->query("select p.*,u.usergroupid,u.joindate,u.posts,u.birthday,u.usertitle,u.avatarid,u.signature,u.location,u.ipaddress,u.username as musername,t.open,ug.opentag,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."post p
                                      LEFT JOIN "._PREFIX_."users u on (u.userid=p.userid)
                                      LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                      LEFT JOIN "._PREFIX_."thread t on(t.threadid=p.threadid)
                                      where p.postid='$pid' limit 1");

                           $i=$start;
                           $modquery=$DB->query("select userid from "._PREFIX_."moderator where forumid in('$thread[forumid]'$modsqladd)");
                           while($mod=$DB->fetch_array($modquery))
                           {

                                 if($local['userid']==$mod['userid'])
                                 {

                                 if($post['open']==1)
                                 {
                                 $show['replylink']=1;
                                 }

                                 $show['editlink']=1;
                                 }
                           }
                   while($post=$DB->fetch_array($posts_query))
                   {
                   $i++;
                   $post['posttime']     = mydate($post['dateline'],'last');
                   $post['threadpostid'] = $i;
                   $post['joindate']     = mydate($post['joindate'],'date');
                   $post['title']        = $bbcode->clearhtml($post['title']);

                   if($post['showsignature']>0)
                   {
                    $post['signature']   = $bbcode->build($post['signature']);
                   }
                   $pbday=explode("-",$post['birthday']);
                   $ptday=explode("-",mydate(TIMENOW,'date'));
                    $post['age']=$ptday[2]-$pbday[2];
                    if(($ptday[1]-$pbday[1]) < 0)
                    {
                    $post['age']--;
                    }
                                 if(($local['userid']==$post['userid'])&&($localgroup['caneditpost']==1))
                                 {
                                 $show['editlink']=1;
                                 }

                                 if(($localgroup['canpost']==1)&&($post['open']==1))
                                 {
                                     $show['replylink']=1;
                                 }
                   if($post['userid']>0)
                   {
                           $show['profile']=1;
                           }
                           else
                           {
                               $show['profile']=0;
                                   }

                             if($post['userid']>0)
                             {
                               if(empty($post['usertitle']))
                               {
                                $post['usertitle']=$post['gusertitle'];
                               }

                               if(empty($post['usertitle']))
                               {
                                  $post['usertitle']=build_title($post['posts']);

                               }

                             }
                             else
                             {
                                 $post['usertitle']=$lang['guest'];
                             }
                             if(get_user_status($post['userid'])>0)
                             {
                                 $statusbutton='online';
                                     }
                                     else
                                     {
                                         $statusbutton='offline';
                                             }
                   $post['user_status']=$lang[$statusbutton];
                   $post['onlinestatus']="<img src=\"$stylevar[dir]/status/user_$statusbutton.gif\" alt=\"$post[musername] $lang[$statusbutton]\">";

                   if($localgroup['canviewip'])
                   {
                    $post['user_ip']="<img src=\"$stylevar[dir]/status/user_ip.gif\" alt=\"$post[ipaddress]\">";
                   }

                   $post['post']=$bbcode->build($post['post'],$post['allowsmilie']);

                   $attach_query=$DB->query("select * from "._PREFIX_."attachment where postid='$post[postid]'");
                   while($at = $DB->fetch_array($attach_query))
                   {
                    
                     if($at['filesize']>1024)
                     {
                     $at['filesize']=ceil($at['filesize']/1024);
                          if($at['filesize']>1024)
                          {
                            $at['filesize']=ceil($at['filesize']/1024).'&nbsp;MB';
                          }
                          else
                          {
                            $at['filesize'].='&nbsp;KB';
                          }
                     }
                     else
                     {
                          $at['filesize'].='&nbsp;Byte';
                     }
                      $at['img']="<img src=\"images/attach/$at[filetype].gif\">";
                       $show['attachment']=1;
                       $post['attachments'].=$TP->GetTemp('showthread_attachmentbit');
                   }
                    $titleetc="$lang[viewing_post] : $post[title] -- ";
                           $local['whereurl']='showpost.php?pid='.$pid;
                           $local['wheretitle']=addslashes($post['title']);
                                 update_online();

                     $plugins->load('showpost_post');
                     $post_page.= $TP->GetTemp('showpost');
                   }
                   $plugins->load('showpost_complete');
print_page($post_page);
?>