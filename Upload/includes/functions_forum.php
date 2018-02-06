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
#    Forum Display Function File started
#

/*
        File name       -> functions_forum.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Functions
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

           function mark_forums_read($forumid = -1)
           {
                   global $arbb,$lang,$DB,$options;



                   $return_url = $options['forumhome'] . '.php';
                   $return_phrase = 'mark_read_all';

                   if ($forumid==-1)
                   {
                           if ($local['userid'])
                           {
                                  newcookie('lastactivity', TIMENOW);
                                  newcookie('lastvisit', TIMENOW - 1);


                                           $query = '';
                                           foreach ($arbb->forumcache AS $fid => $finfo)
                                           {
                                                   $query .= ", ($fid, " . $local['userid'] . ", " . TIMENOW . ")";
                                           }

                                           if ($query)
                                           {
                                                   $query = substr($query, 2);
                                                   $DB->query_write("
                                                           REPLACE INTO " . TABLE_PREFIX . "forumread
                                                                   (forumid, userid, readtime)
                                                           VALUES
                                                                   $query
                                                   ");
                                           }

                           }
                           else
                           {
                                   newcookie('lastvisit', TIMENOW);
                           }


                   }
                   else
                   {

                                   $query = "($forumid, " . $local['userid'] . ", " . TIMENOW . ")";

                                   $DB->query_write("
                                           REPLACE INTO " . TABLE_PREFIX . "forumread
                                                   (forumid, userid, readtime)
                                           VALUES
                                                   $query
                                   ");

                         }
                           if ($forumid == -1)
                           {
                                   $return_url = $options['forumhome'] . '.php' . $arbb->session->vars['sessionurl_q'];
                                    $return_phrase = 'mark_read_all';
                           }
                           else
                           {
                                   $return_url = 'forum.php?' . 'f=' . $arbb->forumcache["$forumid"]['mainid'];
                                    $return_phrase = 'mark_read_single';
                           }




                   return array('url' => $return_url,'phrase' => $lang[$return_phrase]);
           }

//#
//#        Function next_page for multible pages in forum.php
//#

           function next_page($forumid,$threadnum,$perpage)
           {
                   global $perpage,$page,$sortorder,$sortfield,$lang;
            $fid=$forumid;
            $num=$threadnum;
            $pp=$perpage;
            $page=$page;

            $pages = ceil($num / $pp);

            $ppage=array();
            $pppage=array();

            if($pages > 1)
            {

               $pages_table="
               <table class=\"table_border\" cellpadding=\"0\" cellspacing=\"0\">
                <tr class=\"smallfont\" align=center>
                    <td class=\"tcat\">$lang[page] $page $lang[of] $pages</td>
                    ";

                $ppages['last']=$pages;


               if(($page != $ppages[first])&&($page != $ppages[first]+1)&&($page != $ppages[first]+2))
               {
               $pages_table.="<td class=\"td2\"><a href=\"forum.php?fid=$fid&page=1&pp=$pp&sort=$sortfield&order=$sortorder\">&nbsp;<< $lang[first]&nbsp;</a></td>";
               }
               if($page!=$ppages['first'])
               {

                       if(($page-2)>=$ppages['first'])
                       {

                               $pppage['1']=$page-2;
                               $pppage['2']=$page-1;
                               if($pppage['1']>0)
                               {
               $pages_table.="<td class=\"td2\" width=\"15\"><a href=\"forum.php?fid=$fid&page=$pppage[1]&pp=$pp&sort=$sortfield&order=$sortorder\">$pppage[1]</a></td>";
                               }
                               if($pppage['2']>0)
                               {
               $pages_table.="<td class=\"td2\" width=\"15\"><a href=\"forum.php?fid=$fid&page=$pppage[2]&pp=$pp&sort=$sortfield&order=$sortorder\">$pppage[2]</a></td>";
                                  }

                               }
                               elseif(($page-1)>=$ppages['first'])
                               {
                                       $pppage['1']=$page-1;
                                       if($pppage['1']>0)
                                       {
               $pages_table.="<td class=\"td2\" width=\"15\"><a href=\"forum.php?fid=$fid&page=$pppage[1]&pp=$pp&sort=$sortfield&order=$sortorder\">$pppage[1]</a></td>";
                                          }
                                       }

               }
               $pages_table.="<td class=\"td1\" width=\"15\"><strong>$page</strong></td>";
               if($page!=$ppage['last'])
               {
                       if(($page+2) <= $ppages['last'])
                       {
                               $pppage['1']=$page+1;
                               $pppage['2']=$page+2;
                               if($ppage['1'] <= $ppages['last'])
                               {
                                $pages_table.="<td class=\"td2\" width=\"15\"><a href=\"forum.php?fid=$fid&page=$pppage[1]&pp=$pp&sort=$sortfield&order=$sortorder\">$pppage[1]</a></td>";
                                  }
                                  if($ppage['2'] <= $ppages['last'])
                                  {
                                      $pages_table.="<td class=\"td2\" width=\"15\"><a href=\"forum.php?fid=$fid&page=$pppage[2]&pp=$pp&sort=$sortfield&order=$sortorder\">$pppage[2]</a></td>";
                                          }
                               }
                               elseif(($page+1) <= $ppages['last'])
                               {
                                       $pppage['1']=$page+1;
                                       if($pppage['1'] <= $ppages['last'])
                                       {
               $pages_table.="<td class=\"td2\" width=\"15\"><a href=\"forum.php?fid=$fid&page=$pppage[1]&pp=$pp&sort=$sortfield&order=$sortorder\">$pppage[1]</a></td>";
                                          }
                                       }

               }
               if(($page != $ppages[last])&&($page != $ppages[last]-1)&&($page != $ppages[last]-2))
               {
               $pages_table.="<td class=\"td2\"><a href=\"forum.php?fid=$fid&page=$ppages[last]&pp=$pp&sort=$sortfield&order=$sortorder\">&nbsp;$lang[last] >>&nbsp;</a></td>";
               }
            $pages_table.="
                </tr>
               </table>";
            }


            return $pages_table;
           }


//# All Done .. Functions File Finished

?>