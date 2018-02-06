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
#    announcements File started
#
/*
        File name       -> announcement.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

// Used Templates list ,,

$templatelist='thread_postbit';

$phrasearray = array('announcement','forum','thread','profile');

require('global.php');

// Caching plugins for requiring in the right place ,,
$plugins->cache('announcement_start,announcement_complete');

($evalp = $plugins->load('announcement_start'))?eval($evalp):'';

$fid   = checkval($arbb->input['fid']);
$aid   = checkval($arbb->input['aid']);
$where = "";


$local['wheretitle']  = $lang['view_announcements'];
$local['whereurl']    = 'announcement.php?';

if(isset($aid)&&($aid>0))
{
   $where .= "a.aid='$aid'";
$local['whereurl'].="aid=$aid&";

   if($fid>0)
   {
           $local['whereurl'].="fid=$fid&";
      build_nav_tree($fid);
           }
        }
        else
        {
                $local['whereurl'].="fid=$fid";
        if($fid>0)
        {
            build_nav_tree($fid);
            $where .= "a.forumid='-1' or a.forumid='$fid'";
         }
         else
         {
            $where .= "a.forumid='-1'";
                 }
                }

             $announcement_query=$DB->query("select a.*,u.username,u.signature,u.joindate,u.location,u.customtitle,u.ipaddress,u.showsignature,u.birthday
                                             ,u.posts,u.usertitle,u.usergroupid,ug.usertitle as ugusertitle,ug.opentag,ug.closetag
                                             From ". _PREFIX_ ."announcement a
                                             LEFT JOIN ". _PREFIX_ ."users u on(u.userid=a.userid)
                                             LEFT JOIN ". _PREFIX_ ."usergroup ug on (ug.usergroupid=u.usergroupid)
                                             where $where");

                   while($post = $DB->fetch_array($announcement_query))
                   {

                        if($fid<1&&$post[forumid]>0)
                        {
                            build_nav_tree($post['forumid']);
                        }

                   if($post['userid']>0)
                   {
                           $show['profile']=1;
                           }
                           else
                           {
                               $show['profile']=0;
                                   }

                   $post['musername']=$post['opentag'].$bbcode->clearhtml($post['username']).$post['closetag'];

                   if($post['showsignature']>0)
                   {
                    $post['signature']   = $bbcode->build($post['signature']);
                   }
                   $pbday=explode('-',$post['birthday']);
                   $ptday=explode('-',mydate(TIMENOW,'date'));
                    $post['age']=$ptday[2]-$pbday[2];

                             if($post['userid']>0)
                             {
                               if(empty($post['usertitle']))
                               {
                                $post['usertitle']=$post['ugusertitle'];
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
                   $post['onlinestatus']="<img src=\"$stylevar[dir]/status/user_$statusbutton.gif\" alt=\"$post[username] $lang[$statusbutton]\">";

                   if($localgroup['canviewip'])
                   {
                    $post['user_ip']="<img src=\"$stylevar[dir]/status/user_ip.gif\" alt=\"$post[ipaddress]\">";
                   }

                   $post['post']     = $bbcode->clearhtml($bbcode->build($post['announcement']));
                   $post['posttime'] = mydate($post['startdate'],'last');
                   $post['joindate'] = mydate($post['joindate'],'date');

                   if(strlen($post['signature'])>0)
                   {
                        $post['showsignature']=1;
                           }
                           $DB->query("update "._PREFIX_."announcement set views=views+1 where aid='$post[aid]'");
                        $TP->webtemp('thread_postbit');
                           }
   build_nav_location(stripslashes($local['wheretitle']),$local['whereurl'],'add',1);
   $titleetc=$local[wheretitle].' - ';
($evalp = $plugins->load('announcement_complete'))?eval($evalp):'';

   print_page();
?>