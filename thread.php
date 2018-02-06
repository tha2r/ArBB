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
#    thread File started
#
/*
        File name       -> thread.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

// Used Templates list ,,

$templatelist='thread               ,
               thread_postbit       ,
               thread_quickreply    ,
               poll_options_table       ,
               poll_optionbit           ,
               poll_results_table       ,
               thread_attachmentbit ,
               poll_result';

$phrasearray = array('poll','forum','thread','showteam','profile','editor');



require 'global.php';

$pluginlist = 'thread_start,thread_poll_start,thread_polloption,thread_results,thread_post_start'
             .',thread_postbit_create,thread_loggedinuser,thread_complete';
// Caching plugins for requiring in the right place ,,

$plugins->cache($pluginlist);

// Requring Functions File for show thread ,,
// These functions are only for Showthread.php

require_once 'includes/functions_thread.php';


($evalp = $plugins->load('thread_start'))?eval($evalp):'';


          $tid  = intval($arbb->input['tid']);
          $page = intval($arbb->input['page']);
          $pid  = checkval($arbb->input['pid']);
          ($page)?$page=$page:$page=1;

          // For user post options like show signature
          $poptionschecked=array();

$thread_query=$DB->query("select t.*,f.title as forumtitle,f.mainid,f.parentlist,f.forumid from "._PREFIX_."thread t LEFT JOIN "._PREFIX_."forum f on(f.forumid=t.forumid) where t.threadid='$tid'");
                   while($thread=$DB->fetch_array($thread_query))
                   {
                     $thread=$bbcode->clearhtml($thread);
        $local['whereurl']='thread.php?tid='.$tid;
        $local['wheretitle']=addslashes($thread['title']);
        $postsbit   = '';
        $limit      = '';
        $modsqladd  = '';
        $perpage=$options['threadperpage'];


                 $thread['title']=$bbcode->clearhtml($thread['title']);

           update_online();
        $total=$DB->num_rows($DB->query("select postid from "._PREFIX_."post where threadid='$thread[threadid]'"));
           if(($arbb->input['do']=="newpost")||($arbb->input['goto']=="newpost")||($arbb->input['goto']=="lastpost"))
           {
               $page=ceil($total/$perpage);
               $newurl=$local['whereurl'].'&page='.$page;
               if(isset($pid))
               {
                   $newurl.="#post$pid";
                       }
               die("<meta http-equiv=\"Refresh\" content=\"0; URL=$newurl\">");
           }

         $DB->query("update "._PREFIX_."thread set views=views+1 where threadid='$thread[threadid]'");
         $canmoderate=0;
         if(is_moderator($thread['forumid']))
         {
           $canmoderate=1;
         }

        if($thread['pollid']>0)
        {
           $poll_query=$DB->query("select * from "._PREFIX_."poll where pollid='$thread[pollid]'");
           while($poll=$DB->fetch_array($poll_query))
           {
               $showresult=0;
               ($evalp = $plugins->load('thread_poll_start'))?eval($evalp):'';

               if($poll['timeout']>0)
               {

                  $timeout=TIMENOW+($poll['timeout']*60*60*24);
                  $closedate=mydate($timeout,'last');
                  $show['pollenddate']=1;

                  if(TIMENOW < $closedate)
                  {
                      $showresult=1;
                  }

               }

                               $votes_query=$DB->query("select * from "._PREFIX_."pollvote where pollid='$poll[pollid]'");

                               $votenum=0;
                               $option=array();

                               while($vote=$DB->fetch_array($votes_query))
                               {

                                $option[$vote[option]]['votes']++;
                                $option['user'][$vote[userid]]=1;
                                $votenum++;

                               }

               if($option['user']["$local[userid]"]==1)
               {
                    $showresult=1;
                       }

               if(!$showresult)
               {
                   $opt=explode('\n',$poll['options']);
                   $i=0;

                   while(isset($opt[$i])&&(strlen($opt[$i])>0))
                   {

                    $option['num']=$i+1;
                    $option['option']=$opt[$i];
                    $pollbits.=$TP->GetTemp('poll_optionbit');
                    $i++;

                    }
                    ($evalp = $plugins->load('thread_polloption'))?eval($evalp):'';

                    $TP->WebTemp('poll_options_table');

                       }
                       else
                       {


                                           $opt=explode('\n',$poll['options']);
                                           $i=0;

                                           while(isset($opt[$i])&&(strlen($opt[$i])>0))
                                           {

                                            $option['num']     = $i+1;
                                            $option['option']  = $opt[$i];
                                            $option['votes']   = checkval($option[$option[num]]['votes']);
                                            $option['percent'] = ($option['votes'] / $votenum)*100;

                                            if($lang['dir']=='ltr')
                                            {
                                               $option['open']='open';
                                               $option['close']='close';
                                            }
                                            else
                                            {
                                               $option['open']='open';
                                               $option['close']='start';
                                             }

                                            $option['barwidth']=$option['percent']*2;


                                            $pollbits.=$TP->GetTemp('poll_result');
                                            $i++;

                                            }

                                            $poll['numbervotes']=$votenum;
                                            ($evalp = $plugins->load('thread_results'))?eval($evalp):'';

                                            $TP->webtemp('poll_results_table');

                               }


                      }

                }


        $pages_table = next_page($thread['threadid'],$total,$perpage);
           $end=$perpage*$page;
           $start=$end-$perpage;

                   $posts_query=$DB->query("select p.*,u.usergroupid,u.birthday,u.joindate,u.posts,u.usertitle,u.avatarid,i.iconpath,i.title as icontitle,u.signature,u.location,u.ipaddress,u.username as musername,ug.opentag,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."post p
                                      LEFT JOIN "._PREFIX_."users u on (u.userid=p.userid)
                                      LEFT JOIN "._PREFIX_."icon i on(i.iconid=p.iconid)
                                      LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                      where p.threadid='$tid' order by postid ASC limit $start,$perpage");



//# Get thread forum and main forums for negavation bar
    $threadf=$thread;
    $threadf['title']=$thread['forumtitle'];
    build_nav_tree($threadf,1);
//# Continue for displaying thread

                           $thread['active']=$thread['visible'];

                           $i=$start;
                                 if(is_moderator($thread[forumid]))
                                 {

                                 if($thread['open']==1)
                                 {
                                 $show['replylink']=1;
                                 }
                                 $show['editlink']=1;

                                 }

                   while($post=$DB->fetch_array($posts_query))
                   {
                   ($evalp = $plugins->load('thread_post_start'))?eval($evalp):'';

                   foreach($post as $key => $val)
                   {
                     if($key != 'post' && $key != 'signature')
                     {
                      $post[$key]=$bbcode->clearhtml($val);
                     }
                   }
                   $i++;
                   $post['posttime']    = mydate($post['dateline'],'last');
                   $post['threadpostid']= $i;
                   $post['joindate']    = mydate($post['joindate'],'date');

                   if($post['showsignature']>0)
                   {
                    $post['signature']   = $bbcode->build($post['signature']);
                   }
                   $pbday=explode('-',$post['birthday']);
                   $ptday=explode('-',mydate(TIMENOW,'date'));
                    $post['age']=$ptday[2]-$pbday[2];
                    if(($ptday[1]-$pbday[1]) < 0)
                    {
                     $post['age']--;
                    }
                    $show['attachment']=0;
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
                    $post['attachments'].=$TP->GetTemp("thread_attachmentbit");
                   }


                                 if(($local['userid']==$post['userid'])&&($localgroup['caneditpost']==1))
                                 {
                                 $show['editlink']=1;
                                 }

                                 if(($localgroup['canpost']==1)&&($thread['open']==1))
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

                   if($post['iconid']>0)
                   {
                       $show['posticon']=1;
                           }
                           else
                           {
                               $show['posticon']=0;
                                   }
                   $post['title'] = $bbcode->clearhtml($post['title']);
                   $post['post']  = $bbcode->build($post['post'],$post['allowsmilie']);


                   ($evalp = $plugins->load('thread_postbit_create'))?eval($evalp):'';

                   $postsbit.=$TP->GetTemp('thread_postbit');
                   }
          if($localgroup['canviewonline'])
          {

            $timer=60*15;

         $activenow=time()-$timer;
         $act=array();

         $online_users=$DB->query("select o.username,o.userid,u.usergroupid,ug.opentag,ug.closetag
                                   from "._PREFIX_."online o
                                   LEFT JOIN "._PREFIX_."users u on (u.userid=o.userid)
                                   LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                   where dateline > $activenow and o.whereurl like '$local[whereurl]%'");

         $act['num']=$DB->num_rows($online_users);
         $act['guests']=0;
         $act['users']=0;


             $activeusers='';
             $comma='';

             if($act['num']>0)
             {
                    $show['activeusers']=1;
                    while($online=$DB->fetch_array($online_users))
                    {
                    ($evalp = $plugins->load('thread_loggedinuser'))?eval($evalp):'';


                     if($online[userid]>0)
                     {
                            $act['users']++;
                            $activeusers.=$comma."<a href=\"member.php?action=profile&userid=$online[userid]\">".$online['opentag'].$online['username'].$online['closetag']."</a>";
                            $comma=", ";
                     }
                     else
                     {
                            $act['guests']++;
                      }

                    }

             }
                   eval("\$lang[currently_active_users]=\"".$lang['currently_active_users']."\";");
                   eval("\$lang[x_members_y_guests]=\"".$lang['x_members_y_guests']."\";");
          }

      if($local['autosubscribe']>0)
      {
      $poptionschecked['emailnotify']='checked';
      }
      else
      {
      $poptionschecked['emailnotify']='';
      }

      if($local['showsignature']>0)
      {
       $poptionschecked['signature']='Checked';
      }
      else
      {
       $poptionschecked['signature']='';
      }

      if($localgroup['canpost']&&$thread['open']==1)
      {

      $show['quick_reply']=1;

      $quickreply=$TP->GetTemp('thread_quickreply');

      }
      else
      {

         $show['quick_reply']=0;
          $quickreply="";
      }
                      $TP->WebTemp('thread');
   $local['wheretitle']=$bbcode->clearhtml($local['wheretitle']);
   build_nav_location(stripslashes($local['wheretitle']),$local['whereurl'],'add',1);
   $titleetc=$thread[title].' - ';
                 }

  ($evalp = $plugins->load('thread_complete'))?eval($evalp):'';

   print_page();
?>