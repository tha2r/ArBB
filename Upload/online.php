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
#    Online File started
#
/*
        File name       -> online.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist='online,online_usersbit';

$phrasearray = array('online');

Include 'global.php';

require_once ('./includes/functions_online.php');

$plugins->cache('online_start,online_user,online_complete');

($evalp = $plugins->load('online_start'))?eval($evalp):'';

if($localgroup['canviewonline'])
{

$page=checkval($arbb->input['page']);
      ($page)?$page=$page:$page=1;

        $local['whereurl']='online.php?page='.$page;
        $local['wheretitle']=addslashes($lang['viewing_whose_online']);

        $limit='';
           $perpage=$options['onlineperpage'];
            $timer=60*15;

         $activenow=TIMENOW-$timer;
         $act=array();

         if(empty($arbb->input['do']))
         {

           $sqladd="o.dateline > $activenow";

           }
           elseif($arbb->input['do']=='today')
           {

           $local['whereurl']='online.php?do=today';

             $datee=mydate();
             $sqladd="o.day='$datee[mday]' and o.userid > 0";

                }

           update_online();

                  $end=$page*$perpage;
                  $start=$end-$perpage;

                  $limit=$start.','.$perpage;

             $onque=$DB->query("select dateline,userid from "._PREFIX_."online where dateline > $activenow");
             $total=$DB->num_rows($onque);

             $pagenav=next_page($total,$perpage);

         $online_users=$DB->query("select o.*,u.usergroupid,ug.opentag,ug.closetag
                                   from "._PREFIX_."online o
                                   LEFT JOIN "._PREFIX_."users u on (u.userid=o.userid)
                                   LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                   where $sqladd order by o.userid desc limit $limit");

         $act['num']      = $total;

         $act['guests']   = 0;
         $act['users']    = 0;

         $onlineusersbit  = "";
         $on              = array();

         while($on=$DB->fetch_array($online_users))
         {
               $on['time']=mydate($on['dateline'],'hour');
               $on['username']=$on['opentag'].$on['username'].$on['closetag'];
               ($evalp = $plugins->load('online_user'))?eval($evalp):'';
               $onlineusersbit.=$TP->GetTemp('online_usersbit');
         }

         while($onn=$DB->fetch_array($onque))
         {
          if($onn['userid']>0)
          {
             $act['users']++;
          }
          else
          {
             $act['guests']++;
          }
         }


             eval("\$lang[online_in_past_min]=\"".$lang['online_in_past_min']."\";");

             $TP->webtemp('online');
}
else
{

    error_permission();

        }

($evalp = $plugins->load('online_complete'))?eval($evalp):'';

   build_nav_location(stripslashes($local['wheretitle']),$local['whereurl']);

   $titleetc=$lang[viewing_whose_online].' - ';

   print_page();

?>