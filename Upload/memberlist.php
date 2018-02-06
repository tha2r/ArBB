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
#    MemberList File started
#
/*
        File name       -> memberlist.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='memberlist,memberlist_userbit';
$phrasearray=array('memberlist','profile');

require('global.php');
$plugins->cache('memberslist_start,memberslist_userbit,memberslist_complete');
($evalp = $plugins->load('memberslist_start'))?eval($evalp):'';

require_once ('./includes/functions_memberlist.php');
$localgroup['canviewmemberlist']=1;

if($localgroup['canviewmemberlist'])
{
 $page=checkval($arbb->input['page']);
 $perpage=checkval($arbb->input['pp']);
      ($page)?$page=$page:$page=1;
      ($perpage)?$perpage=$perpage:$perpage=$options['memberlistperpage'];

        $local['whereurl']='memberlist.php?page='.$page;
        $local['wheretitle']=addslashes($lang['viewing_memberlist']);

         $sortbyarray=array('username','joindate','posts');
         $orderarray=array('ASC','DESC');

         $sort=$sortbyarray[0];
         $orderby=$orderarray[1];

         $listusersbit='';

         $sortby=array();
         $order=array();

         if(in_array($arbb->input['sortby'],$sortbyarray))
         {
         $sortby[$arbb->input['sortby']]='selected';
         $sort=$arbb->input['sortby'];
         }

         if(in_array($arbb->input['order'],$orderarray))
         {
         $order[$arbb->input['order']]='selected';
         $orderby=$arbb->input['order'];
         }
         /*
                  Some variables for sql query ,, from to and much
         */

        $end=$page*$perpage;
        $start=$end-$perpage;
        $limit=$start.','.$perpage;

         $usersearch=$bbcode->clearhtml($arbb->input['usersearch']);
         if(!$usersearch)
         {
             $where='where 1=1';
                 }
                 else
                 {
                     $where="where username like '%$usersearch%'";
                         }

           $num=$DB->num_rows($DB->query("select userid from users $where"));
           $pagenav=next_page($num,$perpage);

           $members=$DB->query("select u.*,ug.opentag,ug.closetag from "._PREFIX_."users u LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)$where order by $sort $orderby limit $limit");

           while($u=$DB->fetch_array($members))
           {
                 $u['username'] =$u['opentag'].$u['username'].$u['closetag'];
                 $u['regdate']  =mydate($u['joindate'],'date');
                 $u['location'] =htmlspecialchars($u['location']);
                 $u['location'] =($u['location'])?$u['location']:"-";
                 $u['userip']   =$u['ipaddress'];
                 ($evalp = $plugins->load('memberslist_userbit'))?eval($evalp):'';
                 $listusersbit .=$TP->GetTemp('memberlist_userbit');
                   }

           $TP->webTemp('memberlist');
}
else
{
    error_permission();
        }
   build_nav_location(stripslashes($local['wheretitle']),$local['whereurl']);

   $titleetc=$lang['viewing_memberlist'].' - ';
($evalp = $plugins->load('memberslist_complete'))?eval($evalp):'';

   print_page();
?>