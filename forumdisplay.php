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
#    forumdisplay File started
#
/*
        File name       -> forumdisplay.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'forumdisplay,forumdisplay_subforumbit,forumdisplay_threadbit,forumdisplay_announcementbit,forumdisplay_password';

$phrasearray=array('forumdisplay');

require('global.php');
$plugins->cache('forumdisplay_start,forumdisplay_complete,forumdisplay_onlineuser,forumdisplay_moderator,forumdisplay_announcement');
require_once('./includes/functions_forumdisplay.php');


$plugins->load('forumdisplay_start');

if(empty($arbb->input['do']))
{
//# if the forumid is invalid

      $show['invalid_forum']=1;

//# Securing _GET vriables which are going to be used

 $fid       = checkval($arbb->input['fid']);
 $perpage   = checkval($arbb->input['pp']);
 $page      = checkval($arbb->input['page']);

//# Some variables for sql orders

 $limit     = '';
 $modsqladd = '';
 $navarray  = '';

//# page and perpage for sql orders

    ($page)?$page=$page:$page=1;
    ($perpage)?$perpage=$perpage:$perpage=$options['forumperpage'];

//# the forum's main query

      $mainforumquery=$DB->query("select * from "._PREFIX_."forum where forumid='$fid' and active='1'");

//# forum content bits (subforums, threads, sticky threads and announcements)

             $subforumsbit='';
             $threadsbit='';
             $stickythreadsbit='';
             $announcementsbit='';

//# fetching forum query

      while($mainforum=$DB->fetch_array($mainforumquery))
      {
      $plugins->load('forumdisplay_query');
       $show['invalid_forum']=0;

//# if forum is link

        if(strlen($mainforum['link'])>0)
        {
        header('location:'.$mainforum['link'].'');
         exit;
        }

//#  Online updating variables location by title and url

        $local['whereurl']='forumdisplay.php?fid='.$fid;
        $local['wheretitle']=$mainforum['title'];
                 update_online();

                 $wheretitle='';

//# forum permission query for special permissions

     $localgroup=get_forum_permissions($mainforum);
//# main forums for the navigation bar

    build_nav_tree($mainforum);

//    $local['wheretitle']=$local['wheretitle'].$mainforum['title'];

    $wheretitle=$mainforum['title'];

//# if the administrator added password for this forum , ,

    if(($mainforum['canusepassword']==1)&&(strlen($mainforum['password'])>0))
    {

    //# cookie Value ,, if it was set

    $forumpass=$arbb->input[''. _CPREFIX_ .$mainforum[forumid].'_password'];

        if($forumpass==$mainforum['password'])
        {

           $show['require_forum_password']=0;

        }
        else
        {
                if(($localgroup['canuseadmincp']==1)||($localgroup['canusemodcp']==1)||($localgroup['ismoderator']==1))
                {

                     $show['require_forum_password']=0;

                }
                else
                {

                     $show['require_forum_password']=1;
                }


        }

    }

//# making sure the visitor or user group have permission for viewing this forum

    if($localgroup['canviewforum']==0)
    {

        error_permission();

            }
            else
            {

            $canmoderate=is_moderator($mainforum);

          if(!$show['require_forum_password'])
          {

          //# sub forums query

          $subforumsquery=$DB->query("select f.*,i.title as icontitle,i.iconpath,p.iconid from "._PREFIX_."forum f
                                      LEFT JOIN "._PREFIX_."post p on(p.postid=f.lastpostid)
                                      LEFT JOIN "._PREFIX_."icon i on(i.iconid=p.iconid)
                                      where mainid='$fid' and active='1' order by displayorder ASC");

          if($DB->num_rows($subforumsquery)>0)
          {

             $show['subforums']=1;
              while($forum=$DB->fetch_array($subforumsquery))
              {

                  $forum['statusimg'] = forumstatusimg($forum);
                  if($forum['iconid']>0)
                  {
                      $show['posticon']=1;
                  }
                   $forum = $bbcode->clearhtml($forum);
                   $forum['lastposttime']=mydate($forum['lastpost'],'last');
                   $forum['lastthread']=$bbcode->clearhtml($forum[lastthread]);
                         $plugins->load('forumdisplay_subforum');
                   $subforumsbit.=$TP->GetTemp('forumdisplay_subforumbit');

              }


          }

             //# default values for sort field and sort order for threads query

              $sortfield = $mainforum['sortfield'];
              $sortorder = $mainforum['sortorder'];


              $order     = array();
              $sort      = array();

             //# getting the values from the browser if they were setted

              if(isset($arbb->input['sort']))
              {
              $sortfield=$arbb->input['sort'];
              }

              if(isset($arbb->input['order']))
              {
              $sortorder=$arbb->input['order'];
              }


/*/
/
/     making an array for allowed values for query sort and order
/          that protect query against wrong type of values
/
/*/

              $sortorderfields=array('asc','desc','ASC','DESC');
              $sortfields=array('lastpost','title','dateline','replycount','views','postusername');


              if(!in_array($sortorder,$sortorderfields))
              {
                   $sortorder=$mainforum['sortorder'];
              }

              if(!in_array($sortfield,$sortfields))
              {
                   $sortfield=$mainforum['sortfield'];
              }

              $order[$sortorder] = 'selected';
              $sort[$sortfield]  = 'selected';

                  $sortfield='t.'.$sortfield;

                  $end=$page*$perpage;

                  $start=$end-$perpage;

                  $limit=$start.','.$perpage;



             if($mainforum['isforum']>0)
             {

              if($localgroup['canviewthreads']==0)
              {
                  $mainforum['isforum']=0;
              }
              else
              {

              $threadsquery       = $DB->query("select t.*,p.post,i.title as icontitle,i.iconpath,i.iconid from "._PREFIX_."thread t
                                                LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
                                                LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                                                where t.forumid='$mainforum[forumid]' and sticky<>'1'
                                                order by $sortfield $sortorder limit $limit");

              $stickythreadsquery = $DB->query("select t.*,p.post,i.title as icontitle,i.iconpath,i.iconid from "._PREFIX_."thread t
                                                LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
                                                LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                                                where t.forumid='$mainforum[forumid]' and sticky='1'
                                                order by $sortfield $sortorder");
              $thread_contain_attachment=$lang['thread_contain_attachment'];

              $threadsnum=$DB->num_rows($threadsquery)+$DB->num_rows($stickythreadsquery);

              $posticon='&nbsp;';

                      while($thread=$DB->fetch_array($stickythreadsquery))
                      {

                            $thread['post']=str_replace('<br>','',substr($bbcode->clearhtml($thread['post']),0,350));

                      $thread=$bbcode->clearhtml($thread);

                          $thread['lastposttime']=mydate($thread['lastpost'],'last');
                          $thread['statusimg'] = threadstatusimg($thread);

                          if($thread['iconid']>0)
                          {
                          $posticon="<img src=\"$thread[iconpath]\" alt=\"$thread[icontitle]\">";
                          }

                              eval("\$lang['thread_attachments']=\"".$thread_contain_attachment."\";");
                               $plugins->load("forumdisplay_thread");
                            $stickythreadsbit.=$TP->GetTemp("forumdisplay_threadbit");
                              $posticon='&nbsp;';

                      }

                      while($thread=$DB->fetch_array($threadsquery))
                      {
                          $thread['post']=str_replace('<br>','',substr($bbcode->clearhtml($thread['post']),0,350));

                          $thread=$bbcode->clearhtml($thread);

                          $thread['lastposttime']=mydate($thread['lastpost'],'last');
                          $thread['statusimg'] = threadstatusimg($thread);

                          if($thread['iconid']>0)
                          {
                            $posticon="<img src=\"$thread[iconpath]\" alt=\"$thread[icontitle]\">";
                          }
                          eval("\$lang['thread_attachments']=\"".$thread_contain_attachment."\";");
                          $plugins->load('forumdisplay_thread');
                          $threadsbit.=$TP->GetTemp('forumdisplay_threadbit');
                           $posticon='&nbsp;';
                      }
              }

             }

             $announcement_query=$DB->query("select a.*,u.username,u.customtitle,u.usertitle,u.usergroupid,ug.usertitle as ugusertitle,ug.opentag,ug.closetag
                                             From ". _PREFIX_ ."announcement a
                                             LEFT JOIN ". _PREFIX_ ."users u on(u.userid=a.userid)
                                             LEFT JOIN ". _PREFIX_ ."usergroup ug on (ug.usergroupid=u.usergroupid)
                                             where a.enddate > '".TIMENOW."' and a.startdate < '".TIMENOW."' and a.forumid='-1' or a.forumid in ($mainforum[parentlist])");

             while($an=$DB->fetch_array($announcement_query))
             {

                  $an['username']=$an['opentag'].$an['username'].$an['closetag'];

                  if($an['customtitle']==1)
                  {
                      $an['usertitle']=$an['usertitle'];
                  }
                  else
                  {
                      $an['usertitle']=$an['ugusertitle'];
                  }

                  $an['startdate']=mydate($an['startdate'],'last');
                  $plugins->load('forumdisplay_announcement');
                 $announcementsbit.=$TP->GetTemp('forumdisplay_announcementbit');

             }


             $modquery=$DB->query("select m.userid,m.forumid,u.username,u.usergroupid,ug.opentag,ug.closetag from "._PREFIX_."moderator m
                                   LEFT JOIN "._PREFIX_."users u on (u.userid=m.userid)
                                   LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                   where m.forumid in(".$mainforum['parentlist'].")");

             if($DB->num_rows($modquery)>0)
             {
                    $show['moderators'] = 1;
                    $comma              = '';
                    $moderatorslist     = '';

             $totalmods = $DB->num_rows($modquery);
             $mods      = array();

              while($mod=$DB->fetch_array($modquery))
              {
                $mods[$mod[userid]]=$mod;
                $mods[$mod[userid]]['username']=$mod['opentag'].$mod['username'].$mod['closetag'];
              }

              while(list($userid,$mod) = each($mods))
              {
                  $plugins->load('forumdisplay_moderator');
                  $comma=($moderatorslist)?',':'';
                  $moderatorslist.=$comma."<a href=\"member.php?action=profile&userid=$mod[userid]\">".$mod['opentag'].$mod['username'].$mod['closetag']."</a>";
              }

             }

        if($localgroup['canviewonline']==1)
        {

            $timer       = 60*15;
            $activenow   = TIMENOW-$timer;
            $act         = array();
            $activeusers = "";
            $comma       = "";

         $online_users=$DB->query("select o.username,o.userid,u.usergroupid,ug.opentag,ug.closetag
                                   from "._PREFIX_."online o
                                   LEFT JOIN "._PREFIX_."users u on (u.userid=o.userid)
                                   LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                   where dateline > $activenow and o.whereurl like 'forumdisplay.php?fid=$fid%'");

         $act['num']    = $DB->num_rows($online_users);
         $act['guests'] = 0;
         $act['users']  = 0;


             if($act['num']>0)
             {
                    $show['activeusers']=1;

                    while($online=$DB->fetch_array($online_users))
                    {
                       $plugins->load('forumdisplay_onlineuser');
                     if($online[userid]>0)
                     {
                            $act['users']++;
                            $comma=($activeusers)?',':'';
                            $activeusers.=$comma."<a href=\"member.php?action=profile&userid=$online[userid]\">".$online['opentag'].$online['username'].$online['closetag']."</a>";
                     }
                     else
                     {
                            $act['guests']++;
                     }

                    }

             }

             }

                    $end   = ($perpage*$page);
                    $start = ($end-$perpage)+1;

                    $total=$DB->num_rows($DB->query("select threadid from "._PREFIX_."thread where forumid='$mainforum[forumid]'"));

                 $pages_table = next_page($fid,$total,$perpage);

                    if($end > $total)
                    {
                     $end=$total;
                    }

                   eval("\$lang[currently_active_users]=\"".$lang['currently_active_users']."\";");
                   eval("\$lang[x_members_y_guests]=\"".$lang['x_members_y_guests']."\";");
                   eval("\$lang[showing_threads_x_to_y_of_z]=\"".$lang['showing_threads_x_to_y_of_z']."\";");

                   $TP->webtemp('forumdisplay');

                   }
                   else
                   {

                       $message=$TP->GetTemp('forumdisplay_password');
                       error_message($message);

                   }

             }

            }

                         if($show['invalid_forum'])
                         {
                             $local['whereurl']="forumdisplay.php?fid=".$fid;
                             error_message($lang['invalid_forum']);
                         }

                      }
                      elseif($arbb->input['do']=='markread')
                      {

                      //# if the requested was to mark the forum(s) read

                         $local['whereurl']='forumdisplay.php?do=markread';
                         $wheretitle=$lang['do_mark_read'];

                         $fid=checkval($arbb->input['fid']);

                         ($fid)?$fid=$fid:$fid=-1;

                              $mark_read         = mark_forums_read($fid);
                              $url               = $mark_read['url'];
                              $redirect_message  = $mark_read['phrase'];
                              $local['whereurl'].= "&fid=$fid";

                              redirect($redirect_message,$url);

                              }
                              elseif($arbb->input['do']=='password')
                              {

                                  $fid=checkval($arbb->input['fid']);
                                  $query=$DB->query("select password,forumid,title from "._PREFIX_."forum where forumid='$fid'");

                                  while($f=$DB->fetch_array($query))
                                  {
                                       if($bbcode->clearhtml($arbb->input['forum_password'])==$f['password'])
                                       {

                                            $cname = $fid .'_password';

                                            newcookie($cname,$f['password'],900);

                                            $redirect_message=$lang['forum_password_accepted'];

                                            $url=$bbcode->clearhtml(urldecode($arbb->input['url']));

                                             redirect($redirect_message,$url);

                                               }
                                               else
                                               {

                                                   error_message($lang['forum_password_error']);

                                                       }
                                          }

                                      }
   $titleetc=$wheretitle.' - ';

   $plugins->load('forumdisplay_complete');

   print_page();

?>