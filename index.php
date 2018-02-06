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
#    index File started
#
/*
        File name       -> index.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/
$templatelist='index_subforum,index_mainforum,index_whats_going_on,index_forum_status_icons';
$phrasearray=array('index');
require('global.php');
$plugins->cache('index_start,index_complete,index_mainforum_start,index_mainforum_complete,index_subforum,index_event,index_loggedinuser');

($evalp = $plugins->load('index_start'))?eval($evalp):'';

if($localgroup['canviewforum']==0)
{
  error_permission();

}
$month = mydate('n');
$year  = mydate('Y');
$day   = mydate('d');



   $local['whereurl']='index.php?';
   $local['wheretitle']=$options['sitetitle'];
     update_online();

$addon='';
$birthdays='';

  if($month == 3 && date('L', mktime(0, 0, 0, $month, 1, $year)) != 1)
  {
    $addon=" or birthday like '29-2-%'";
  }

         $show['stats']     = $options['showstats'];
         $show['birthdays'] = $options['showbirthdays'];


$query=$DB->query("select f.*,i.title as icontitle,i.iconpath,p.iconid from "._PREFIX_."forum f
                   LEFT JOIN "._PREFIX_."post p on(p.postid=f.lastpostid)
                   LEFT JOIN "._PREFIX_."icon i on(i.iconid=p.iconid)
                   where f.active='1' order by f.displayorder ASC");

       while($fetchf=$DB->fetch_array($query))
       {
             $forums[$fetchf[mainid]][$fetchf[displayorder]][$fetchf[forumid]]=$fetchf;
       }


while(list($forumidinfo,$foruminf) = each ($forums[-1]))
{
     foreach($foruminf as $forumidinfo => $foruminfo)
     {
         $mainforum=$bbcode->clearhtml($foruminfo);
($evalp = $plugins->load('index_mainforum_start'))?eval($evalp):'';
         if(is_array($forums[$forumidinfo]))
         {
             foreach($forums[$forumidinfo] as $r => $t)
             {
                 foreach($t as $subforumid => $subforuminfo)
                 {

                         $forum = $bbcode->clearhtml($subforuminfo);
                         $forum['lastthread']=$bbcode->clearhtml($forum['lastthread']);

                         $forum['statusimg'] = forumstatusimg($forum);

                         if($forum['iconid']>0)
                         {
                             $show['posticon']=1;
                         }

                         $forum['lastposttime']=mydate($forum['lastpost'],'last');
                         ($evalp = $plugins->load('index_subforum'))?eval($evalp):'';
                         $subforumsbit.=$TP->GetTemp('index_subforum');


                 }
             }
         }
         ($evalp = $plugins->load('index_mainforum_complete'))?eval($evalp):'';

         $TP->WebTemp('index_mainforum');
         $subforumsbit='';

     }
}


           $stats=$DB->query_now('select * from '._PREFIX_.'stats');

         $timer=60*15;
         $activenow=time()-$timer;
         $online_users=$DB->query("select o.username,o.userid,u.usergroupid,ug.opentag,ug.closetag
                                   from "._PREFIX_."online o
                                   LEFT JOIN "._PREFIX_."users u on (u.userid=o.userid)
                                   LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                   where dateline > $activenow");

         $stats['activeusers']=$DB->num_rows($online_users);
         $stats['activemembers']=0;
         $stats['activeguests']=0;

         $comma='';
         $stats['active_usernames']='';
         while($online=$DB->fetch_array($online_users))
         {
($evalp = $plugins->load('index_loggedinuser'))?eval($evalp):'';

                 if($online['userid']>0)
                 {
                      //   $online['username']=$bbcode->clearhtml($online['username']);
                     $stats['active_usernames'].=$comma."<a href=\"member.php?action=profile&userid=$online[userid]\">".$online['opentag'].$online['username'].$online['closetag']."</a>";
                     $comma=', ';
                         $stats['activemembers']++;
                         }
                         else
                         {
                              $stats['activeguests']++;
                                 }
                 }

         $stats['maxusersondate']=mydate($stats[maxusersondate],'last');
         if(($stats['activeusers']==$stats['maxuserson'])||($stats['activeusers']>$stats['maxuserson']))
         {

             $DB->query("update "._PREFIX_."stats set maxuserson='".$stats['activeusers']."',maxusersondate='".time()."'");
         }

         eval("\$lang[currently_index_active_users]=\"".$lang['currently_index_active_users']."\";");
         eval("\$lang[most_active_users]=\"".$lang['most_active_users']."\";");
         eval("\$lang[forum_stats]=\"".$lang['forum_stats']."\";");
if($show['birthdays'] > 0)
{
$bd = $DB->query("select u.userid,u.birthday,u.username,u.usergroupid,ug.opentag,ug.closetag from "._PREFIX_."users u LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid) where u.birthday like '%$day-$month-%' $addon");

$show['birthdays']=0;
while($birthday = $DB->fetch_array($bd))
{
$show['birthdays']=1;
 foreach($birthday as $key => $val)
 {
         if($key != 'opentag' && $key != 'closetag')
         {
         $birthday[$key]=$bbcode->clearhtml($val);
         }
 }
$m=explode("-",$birthday['birthday']);


$old=$year-$m[2];
$username="<a href=\"member.php?action=profile&userid=$birthday[userid]\">".$birthday['opentag'].$birthday['username'].$birthday['closetag']."</a>";
$comma=($birthdays)?' , ':'';

($evalp = $plugins->load('index_event'))?eval($evalp):'';
$birthdays.=$comma."$username ($old $lang[years_old])";

}


}
    $stats['nusername']=$bbcode->clearhtml($stats['nusername']);

         $TP->webtemp('index_whats_going_on');
         $TP->webtemp('index_forum_status_icons');

($evalp = $plugins->load('index_complete'))?eval($evalp):'';
$titleetc='';
   print_page();


?>