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
#    showteams File started
#
/*
        File name       -> showteams.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='showteams,showteams_team,showteams_userbit,showteams_modbit';

$phrasearray = array('showteams','profile');

require 'global.php';

$plugins->cache('showteams_start,showteams_complete');

$plugins->load('showteams_start');

        $local['whereurl']='showteams.php';
        $local['wheretitle']=addslashes($lang['viewing_forum_teams']);

            $usersbit='';
            $limit='';
            update_online();

           $groups=array();
           $users=array();
           $comma='';
           $teamsquery='';

           $qroup_query=$DB->query("select * from " . _PREFIX_ . "usergroup where isforumteam='1' order by canuseadmincp desc");

           while($ug=$DB->fetch_array($qroup_query))
           {
                   $groups[$ug[usergroupid]]=$ug;
                   $teamsquery.=$comma."'$ug[usergroupid]'";
                   $comma=',';
           }

           $users_query=$DB->query("select * from "._PREFIX_."users where usergroupid in ($teamsquery)");

           while($u=$DB->fetch_array($users_query))
           {
                   $users['ok']=1;
                 $users[$u[usergroupid]][$u[userid]]=$u;
                 $users[$u[usergroupid]][$u[userid]]['username']=$groups[$u[usergroupid]]['opentag'].$u['username'].$groups[$u[usergroupid]]['closetag'];
           }

           $teams="";

           while(list($usergroupid,$ug) = each($groups))
           {

                 if(is_array($users[$usergroupid]))
                 {
                         while(list($uid,$u) = each($users[$usergroupid]))
                         {
                              $usersbit.=$TP->GetTemp('showteams_userbit');
                                  }

                        $teams.= $TP->Gettemp('showteams_team');

                        $usersbit='';
                 }
           }

           if($users['ok'] != 1)
           {
              $breaak=1;
           }

unset($users);
unset($groups);
unset($u);
unset($ug);


             $mods_query=$DB->query("select m.userid,m.forumid,u.username,u.usergroupid,ug.opentag,ug.closetag,f.title,f.forumid from "._PREFIX_."moderator m
                                     LEFT JOIN "._PREFIX_."users u on (u.userid=m.userid)
                                     LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                     LEFT JOIN "._PREFIX_."forum f on (f.forumid=m.forumid)
                                     order by m.userid,f.forumid");

             $modforums = array();
             $mods      = array();

             while($mod=$DB->fetch_array($mods_query))
             {

              $mods[$mod[userid]]=$mod;
              $mods[$mod[userid]]['username']=$mod['opentag'].$mod['username'].$mod['closetag'];

              if($modforums[$mod[userid]])
              {
                      $modforums[$mod['userid']] .= "<br><a href=\"forumdisplay.php?fid=$mod[forumid]\">$mod[title]</a>";
              }
              else
              {
                      $modforums[$mod['userid']]= "<a href=\"forumdisplay.php?fid=$mod[forumid]\">$mod[title]</a>";
              }

              $breaak=0;

             }

             $mods_list="";

             while(list($userid,$u) = each($mods))
             {
               $u['modforums'] = $modforums[$u[userid]];
               $mods_list.=$TP->GetTemp("showteams_modbit");

             $show['mods']=1;
             }


           if($breaak == 1)
           {
              error_message($lang['no_users_on_groups']);
           }

           $TP->webtemp("showteams");

  $plugins->load("showteams_complete");

   build_nav_location(stripslashes($local['wheretitle']),$local['whereurl']);

   $titleetc="$lang[viewing_forum_teams] - ";

   print_page();
?>