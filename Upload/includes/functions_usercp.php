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
#    User Control Panel Function File started
#

/*
        File name       -> functions_usercp.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Functions
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

//#
//#        Function next_page for multible pages in usercp.php
//#

           function next_page($action,$num,$perpage)
           {
                   global $perpage,$page,$lang;
            $tid=$threadid;

            $num=$num;
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
               $pages_table.="<td class=\"td2\"><a href=\"usercp.php?action=$action&page=1\">&nbsp;<< $lang[first]&nbsp;</a></td>";
               }
               if($page!=$ppages['first'])
               {

                       if(($page-2)>=$ppages['first'])
                       {

                               $pppage['1']=$page-2;
                               $pppage['2']=$page-1;
                               if($pppage['1']>0)
                               {
               $pages_table.="<td class=\"td2\">&nbsp;&nbsp;<a href=\"usercp.php?action=$action&page=$pppage[1]\">$pppage[1]</a></td>";
                               }
                               if($pppage['2']>0)
                               {
               $pages_table.="<td class=\"td2\">&nbsp;<a href=\"usercp.php?action=$action&page=$pppage[2]\">$pppage[2]</a>&nbsp;</td>";
                                  }

                               }
                               elseif(($page-1)>=$ppages['first'])
                               {
                                       $pppage['1']=$page-1;
                                       if($pppage['1']>0)
                                       {
               $pages_table.="<td class=\"td2\">&nbsp;<a href=\"usercp.php?action=$action&page=$pppage[1]\">$pppage[1]</a>&nbsp;</td>";
                                          }
                                       }

               }
               $pages_table.="<td class=\"td1\">&nbsp;<strong>$page</strong>&nbsp;</td>";
               if($page!=$ppage['last'])
               {
                       if(($page+2) <= $ppages['last'])
                       {
                               $pppage['1']=$page+1;
                               $pppage['2']=$page+2;
                               if($ppage['1'] <= $ppages['last'])
                               {
                                $pages_table.="<td class=\"td2\">&nbsp;<a href=\"usercp.php?action=$action&page=$pppage[1]\">$pppage[1]</a>&nbsp;</td>";
                                  }
                                  if($ppage['2'] <= $ppages['last'])
                                  {
                                      $pages_table.="<td class=\"td2\">&nbsp;<a href=\"usercp.php?action=$action&page=$pppage[2]\">$pppage[2]</a>&nbsp;</td>";
                                          }
                               }
                               elseif(($page+1) <= $ppages['last'])
                               {
                                       $pppage['1']=$page+1;
                                       if($pppage['1'] <= $ppages['last'])
                                       {
               $pages_table.="<td class=\"td2\">&nbsp;<a href=\"usercp.php?action=$action&page=$pppage[1]\">$pppage[1]</a>&nbsp;</td>";
                                          }
                                       }

               }
               if(($page != $ppages[last])&&($page != $ppages[last]-1)&&($page != $ppages[last]-2))
               {
               $pages_table.="<td class=\"td2\"><a href=\"usercp.php?action=$action&page=$ppages[last]\">&nbsp;$lang[last] >>&nbsp;</a></td>";
               }
            $pages_table.='
                </tr>
               </table>';
            }


            return $pages_table;
           }


//# All Done .. Functions File Finished

?>