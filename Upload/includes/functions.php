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
#    Function File started
#

/*
        File name       -> functions.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Functions
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

        function change($var)
        {
                global $bbcode;

           $bcoded = highlight_string(html_entity_decode($var[1]),TRUE);

                return $bcoded;

        }

              function redirect($message,$link)
              {
                GLOBAL $TP,$lang,$CP,$stylevar,$options;
                GLOBAL $headinclude,$DB;

                  $GLOBALS['redirect_message'] = $message;
                  $GLOBALS['url']              = $link;

                      Echo $TP->GetTemp("redirection");
                      exit;
              }


              function getoptions()
              {
                   Global $DB;

                   $options=array();
                   $qu=$DB->query('SELECT * FROM '._PREFIX_.'setting',false);
                   if(!$qu)
                   {
                    die('ArBB is not installed yet..');
                   }
                   while($row=$DB->fetch_array($qu))
                   {
                    $options[$row['name']]=$row['value'];
                   }

                   return $options;
              }


              function checkmail($email)
              {
                    $email=$email;
                       if (ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $email))
                       {
                         return true;
                       }
                       else
                       {
                         return false;
                       }
              }


              function checklogin()
              {

                        Global $DB,$arbb;

                        $userid=$arbb->input[''._CPREFIX_.'userid'];
                        $password=$arbb->input[''._CPREFIX_.'password'];

                           $query=$DB->query('select * from '._PREFIX_."users where userid='$userid' and password = '$password'");

                            while($row=$DB->fetch_array($query))
                            {
                              $user=$row;
                            }

                    return $user;
              }

              function verify_login($username,$password)
              {
                GLOBAL $DB;
                    $query=$DB->query('select userid from '._PREFIX_."users where username='$username' and password='$password'");

                    $u=array();
                    if($DB->num_rows($query)>0)
                    {
                       $u=$DB->fetch_array($query);
                    }

                    return $u['userid'];
              }

              function checkval($variable)
              {
                      $val=intval(trim($variable));
                      return $val;
              }

              function checkvar($variable)
              {
                       return htmlspecialchars($variable);
              }



              function newcookie($CNAME,$CVALUE='',$cookietime='99999999')
              {
                       $cname=$CNAME;
                       $cvalue=$CVALUE;
                       SetCookie(''._CPREFIX_.$cname,$cvalue,time()+$cookietime);
              }

              function unsetcookie($name)
              {
                       if(is_array($name))
                       {
                           foreach($name AS $a => $v)
                           {

                              setcookie(''._CPREFIX_.$v.'',-1,time()+360);
                           }
                       }
                       else
                       {
                            setcookie(''._CPREFIX_.$name.'',-1,time()+360);
                       }

              }

              function build_nav_button($text,$url,$addition='')
              {
                   GLOBAL $nav;
                   /*
                if($addition)
                {

                $button=$nav['butcom'].'<div id="''">'."<a href=\"$url\" $addition>$text</a></div>";
                }
                else
                {*/
                           ($addition)?$addition='id="'.$addition.'"':'';
                $button=$nav['butcom']."<a href=\"$url\" >$text</a>";

                $nav['butcom']=' | ';
                $nav['buttons'].=$button;
                GLOBAL $nav;
              }

              function build_nav_location($text,$url,$type='add',$br=0)
              {
               GLOBAL $lang,$stylevar,$options,$nav,$CP,$cpstyle;
                      if(
                         ($type=='add')
                                        OR
                                           ($type==1)
                                                      )
                      {
                          if( (
                             ($br==1)
                                      OR
                                         ($type==1))
                                                 AND (!defined('IN_ARCHIVE'))
                                                   )
                          {

                            $nav['locatio'].='<BR>';

                                if(!$CP)
                                {
                                 $dir=$stylevar['dir'].'/misc/';

                                }
                                else
                                {

                                 $dir='../cpstyles/'.$cpstyle['dir'];
                                }

                            $nav['locatio'].="<img src=\"$dir/nav_bit.gif\" border=\"0\"> $text";
                          }
                          elseif(
                                 ($br==1)
                                       and
                                          (DEFINED('IN_ARCHIVE'))
                                            )
                          {
                            $nav['locatio'].='<br>&nbsp;&raquo;&nbsp; '.$text;
                          }
                          else
                          {
                            $nav['locatio'].='&nbsp;&raquo;&nbsp; <a href="'.$url.'">'.$text.'</a>';
                          }
                      }
                      elseif($type=='build')
                      {

                        $nav['location']="<div><b><a href=\"$options[forumhome].php\">$options[sitetitle]</a></b> $nav[locatio] </div>";
                      }
                   GLOBAL $nav;
              }


              function print_page($content='')
              {
                       GLOBAL $options,$TP,$lang,$DB,$local,$nav,$template;
                       GLOBAL $navbar,$footer,$headinclude,$header;
                       GLOBAL $stylevar,$st,$CP,$titleetc;

                        if($CP != 1)
                        {
                           build_nav_location('','',"build");
                           $navbar       = $TP->GetTemp('navbar');
                        }
                        else
                        {
                            $ex=explode('-',$titleetc);
                          if(strlen($ex[0])>0)
                          {
                            build_nav_location($ex[0],"",1);
                          }
                        }


                          if(($options['webcontent']=='')&&($content==''))
                          {

                                  error_message($lang['not_found']);
                          }
                          else
                          {
                           $DB->close();
                          }
                           if($content=='')
                           {
                            print(''.$TP->GetTemp('forum_page').'');
                           }
                           else
                           {
                                   print($content);
                           }
              }


              function get_extension($file)
              {
                return strtolower(substr(strrchr($file, '.'), 1));
              }




              function random_string($length="8")
              {
                      $set = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
                      $str = '';
                      $i=1;
                      while($i <= $length)
                      {
                            $i++;
                              $ch = rand(0, count($set)-1);
                              $str .= $set[$ch];
                      }
                      return $str;
              }

              function mydate($timestring='now',$type='normal')
              {
              GLOBAL $lang;
              if($timestring=='now')
              {
                 $timestring=time();
              }
              if(strlen($timestring)>1)
              {
              $date=getdate($timestring);

              if($type=='normal')
              {
                  $datee = $date;
                      }
                      elseif($type=='last')
                      {
                          $date2=getdate(time());
                          $datee='';
                          if(($date['year']==$date2['year'])&&($date['month']==$date2['month']))
                          {
                              if($date['mday']==$date2['mday'])
                              {
                                  $datee=$lang['today'];
                                      }
                                      elseif($date2['mday']==$date['mday']+1)
                                      {
                                          $datee=$lang['yesturday'];
                                              }
                                              else
                                              {
                                                  $datee=$date['mday'].'-'.$date['mon'].'-'.$date['year'];
                                                      }

                                  }
                                  else
                                  {
                                      $datee=$date['mday'].'-'.$date['mon'].'-'.$date['year'];
                                          }
                                           $pmam=$lang['am'];

                                          if($date['hours']==12)
                                          {
                                               $pmam=$lang['pm'];
                                          }
                                          elseif($date['hours']==24)
                                          {
                                           $pmam=$lang['am'];
                                           $date['hours']='00';
                                          }
                                          elseif($date['hours']>12)
                                          {
                                           $date['hours']=$date['hours']-12;
                                           $pmam=$lang['pm'];
                                          }
                                      $datee.= ' ,'.$lang['at'].'&nbsp;'.$date['hours'].':'.$date['minutes'].'&nbsp;'.$pmam;

                              }
                              elseif($type=='time')
                              {
                                   $datee = time();
                                      }
                                      elseif($type=='hour')
                                      {
                                      $pmam=$lang['am'];

                                          if($date['hours']==12)
                                          {
                                               $pmam=$lang['pm'];
                                          }
                                          elseif($date['hours']==24)
                                          {
                                           $pmam=$lang['am'];
                                           $date['hours']='00';
                                          }
                                          elseif($date['hours']>12)
                                          {
                                           $date['hours']=$date['hours']-12;
                                           $pmam=$lang['pm'];
                                          }
                                      $datee= $date['hours'].':'.$date['minutes'].'&nbsp;'.$pmam;
                                              }
                                              elseif($type='date')
                                              {
                                                  $datee=$date['mday'].'-'.$date['mon'].'-'.$date['year'];
                                                      }
                          }
                          else
                          {
                           $datee = date($timestring, time());
                          }
                         return $datee;
              }

              function getip()
              {
               global $_SERVER;

                      if (isset($_SERVER['HTTP_CLIENT_IP']))
                      {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                      }
                      else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                      {
                         if(preg_match_all("#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}#s", $_SERVER['HTTP_X_FORWARDED_FOR'], $ips))
                         {
                              while(list($key, $val) = each($ips[0]))
                              {
                                   if(!preg_match("#^(10|172\.16|192\.168)\.#", $val))
                                   {
                                         $ip = $val;
                                         break;
                                   }
                              }
                         }
                      }
                      else if (isset($_SERVER['REMOTE_ADDR']))
                      {
                       $ip = $_SERVER['REMOTE_ADDR'];
                      }

                return $ip;
              }


              function update_online($place='')
              {
                global $local,$DB;


                      if($local['userid']>0)
                      {

                         $query=$DB->query("select dateline from "._PREFIX_."online where userid='$local[userid]'");
                         if($DB->num_rows($query)<1)
                         {
                             $DB->query("delete from "._PREFIX_."online where userip='$local[ipaddress]'");
                             $DB->query("insert into "._PREFIX_."online(`day`, `dateline` , `whereurl` , `wheretitle` , `userid` , `username` , `userip` )VALUES ('".date(d)."','".time()."', '$local[whereurl]', '$local[wheretitle]', '$local[userid]', '$local[username]', '$local[ipaddress]')");
                         }
                         else
                         {
                           $DB->query("UPDATE `"._PREFIX_."online` SET `dateline` = '".time()."',`whereurl` = '$local[whereurl]',`wheretitle` = '$local[wheretitle]',`userid` = '$local[userid]',`username` = '$local[username]',`userip` = '$local[ipaddress]' WHERE userid='$local[userid]'");

                           $min=time()-3600;
                           $DB->query("UPDATE `". _PREFIX_ ."users` SET lastvisit='".time()."' where userid='$local[userid]' and lastvisit<$min");

                         }
                      }
                      else
                      {

                       $query=$DB->query("select dateline from "._PREFIX_."online where userip='$local[ipaddress]'");
                        if($DB->num_rows($query)<1)
                        {
                          $DB->query("delete from "._PREFIX_."online where userip='$local[ipaddress]'");
                          $DB->query("insert into "._PREFIX_."online(`day`, `dateline` , `whereurl` , `wheretitle` , `userid` , `username` , `userip` )VALUES ('".date(d)."','".time()."', '$local[whereurl]', '$local[wheretitle]', '0', 'Guest', '$local[ipaddress]')");
                        }
                        else
                        {
                           $DB->query("UPDATE `"._PREFIX_."online` SET `dateline` = '".time()."',`whereurl` = '$local[whereurl]',`wheretitle` = '$local[wheretitle]',`userid` = '$local[userid]',`username` = '$local[username]',`userip` = '$local[ipaddress]' WHERE userip='$local[ipaddress]'");
                        }
                      }

              $day=date(d);
              $timestring=time();
              $oldtime=3600*48;
              $deltime=$timestring-$oldtime;

              $DB->query("delete from "._PREFIX_."online where dateline < $deltime or day != $day");
              }

              function error_permission()
              {
                GLOBAL $TP,$local,$lang,$stylevar,$show,$DB;
                build_nav_location(stripslashes($lang['error_permission']),'#error_table','add',1);                $show['permission_error']=1;
                $TP->WebTemp('error');
                print_page();
                   exit;
              }

              function error_message($error)
              {
                GLOBAL $TP,$local,$lang,$stylevar,$errormessage,$arbb,$DB;

                build_nav_location($lang['error_message'],urldecode($local['whereurl']),'add',1);
                $show['permission_error']=0;
                $errormessage=$error;

                       if(isset($arbb->input['url']) AND strlen($arbb->input['url'])>0)
                       {

                         $local['whereurl'] = urldecode($arbb->input['url']);
                       }

                $TP->WebTemp('error');
                   print_page();
                   exit;
              }

              function alert($alert)
              {
              GLOBAL $TP,$local,$lang,$stylevar,$alertmessage,$arbb,$DB;

              build_nav_location($lang['alert_message'],urldecode($local['whereurl']),'add',1);
              $alertmessage = $alert;

                       if(isset($arbb->input['url'])&&strlen($arbb->input['url'])>0)
                       {
                         $local['whereurl'] = urldecode($arbb->input['url']);
                       }

                $TP->WebTemp('alert');
                   print_page();
                   exit;
              }

              function build_forumjump()
              {
                           GLOBAL $lang,$DB;

                           $forums = array();
                           $forumjumpforums="";

                           $forum=$DB->query('select forumid,mainid,displayorder,title from '._PREFIX_.'forum where active = '."'1'".' order by displayorder ASC');
                           while($f=$DB->fetch_array($forum))
                           {
                              $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
                           }


                           while(list($disprder,$info) = each($forums[-1]))
                           {

                            foreach($info AS $id => $f)
                            {
                              $forumjumpforums.="\n<option value=\"forum.php?fid=$f[forumid]\" class=\"td2\">$f[title]</option>\n";
                              if(is_array($forums[$id]))
                              {
                              $jumpforums="";
                               $forumjumpforums.=forumjump_tree($forums,$id,'0');
                              }
                            }
                           }


               $forumjump="
               <select name=\"forumjump\" id=\"forumjump\" onchange=\"window.location.href=this.value\">
               <option value=\"#forumjump\">[ $lang[forum_jump] ]</option>
                <optgroup label=\"$lang[forumjump_site_areas]\">
                        <option value=\"usercp.php\" >$lang[forumjump_usercp]</option>
                        <option value=\"pm.php\" >$lang[forumjump_pm]</option>
                        <option value=\"online.php\" >$lang[forumjump_whosonline]</option>
                        <option value=\"search.php\" >$lang[forumjump_search]</option>
                        <option value=\"$options[forumhome].php\" >$lang[forumjump_home]</option>
                </optgroup>
                <optgroup label=\"$lang[forumjump_forums]\">
                        $forumjumpforums
                </optgroup>
                </select>";

                return $forumjump;
              }

              function forumjump_tree($forums,$id,$count,$addition='',$ex='&nbsp;')
              {
                              if(is_array($forums[$id]))
                              {
                                      $count++;
                               $i=$count;

                              while($i > 0)
                              {
                               $titlee.=$ex;
                               $i--;
                              }
                                while(list($disprder,$info) = each($forums[$id]))
                                {
                                   foreach($info AS $fid => $f)
                                   {

                                     $sel = ($addition==$fid)?'selected':'';


                                     $value=($addition)?"$f[forumid]":"forum.php?fid=$f[forumid]";
                                      $jumpforums.="\n<option value=\"$value\" $sel class=\"td2\">$titlee$f[title]</option>\n";

                                      if(is_array($forums[$fid]))
                                      {

                                       $jumpforums.=forumjump_tree($forums,$fid,$count,$addition,$ex);
                                      }
                                   }
                                }
                              }
                     return $jumpforums;
              }

              function build_title($postcount,$u=0)
              {
              GLOBAL $DB;


               $query = $DB->query("select title from "._PREFIX_."usertitle where minposts<=$postcount order by minposts DESC limit 1");
               while($nt=$DB->fetch_array($query))
               {
                     $newtitle=$nt['title'];
               }

               return $newtitle;
              }

              function get_user_status($userid)
              {
                GLOBAL $DB;

                $query=$DB->query("select userid from online where userid='$userid'");
                if($DB->num_rows($query)>0)
                {
                    return 1;
                        }
                        else
                        {
                            return False;
                                }
              }

              function is_moderator($forum='*')
              {
                  GLOBAL $DB,$local,$localgroup;
                  $sqladd='';

                  if(($localgroup['canuseadmincp'])||($localgroup['canusemodcp']))
                  {
                       return 1;
                  }
                  else
                  {
                       if($forum!='*')
                       {
                        if(!is_array($forum))
                        {
                          $forum=$DB->query_now("select * from "._PREFIX_."forum where forumid='$forum'");
                        }
                             $where = 'forumid in ('.$forum['parentlist'].') and';
                       }
                          $qu=$DB->query('select userid from '._PREFIX_."moderator where $where userid='$local[userid]'");

                          if($DB->num_rows($qu)>0)
                          {
                              return 1;
                          }
                  }


              }

                  function build_nav_tree($f,$brlast=false)
                  {
                           GLOBAL $lang,$DB,$base_url;

                           $forums = array();

                           if(!is_array($f))
                           {
                               $forum=$DB->query_now('select forumid,mainid,parentlist,title from '._PREFIX_."forum where forumid = '$f'");
                           }
                           else
                           {
                               $forum=$f;
                           }

                        $query=$DB->query('select forumid,mainid,title from '._PREFIX_."forum where forumid in (".$forum['parentlist'].")");
                        while($fetch = $DB->fetch_array($query))
                        {
                          $forums[$fetch['forumid']]=$fetch;
                        }

                        $ex=explode(',',$forum['parentlist']);
                        $ar=array_sum($ex);

                             for($i=0;$i<=$ar;$i++)
                             {
                               if(is_array($forums[$i]))
                               {

                                  if(!$brlast)
                                  {
                                   $br = ($forums[$i]['forumid'] == $f['forumid'])?1:0;
                                  }
                                  else
                                  {
                                   $br=0;
                                  }

                                  if(!defined('IN_ARCHIVE'))
                                  {
                                   build_nav_location(''.$forums[$i]['title'].'','forum.php?fid='.$forums[$i]['forumid'].'',$br);
                                  }
                                  else
                                  {
                                   build_nav_location(''.$forums[$i]['title'].'',sprintf($base_url,'f',$forums[$i]['forumid']),$br);
                                  }
                               }
                             }
                  }

                  function updatestats()
                  {
                     GLOBAL $DB;

                         $query  = $DB->query("select count(*) as threads,SUM(replycount) as posts from "._PREFIX_."thread where visible='1'");
                         $query2 = $DB->query("select count(*) as users from "._PREFIX_."users");
                         $query3  = $DB->query("select username,userid from "._PREFIX_."users order by userid desc limit 0,1");

                         $row=array_merge($DB->fetch_array($query),$DB->fetch_array($query2),$DB->fetch_array($query3));
                         $DB->query("update "._PREFIX_."stats set users='$row[users]',posts='$row[posts]',threads='$row[threads]',nusername='$row[username]',nusersid='$row[userid]'");
                  }

                  function updateusercount($userid)
                  {
                     GLOBAL $DB,$local;

                     $comma   = '';
                     $updates = '';
                     $user    = array();

                        $query=$DB->query("select title,postid from "._PREFIX_."post where userid='$userid' and visible='1' order by postid asc");

                        while($post = $DB->fetch_array($query))
                        {
                          $user['lastpost']     = $post['title'];
                          $user['lastpostid']   = $post['postid'];
                        }
                          $user['posts']        = $DB->num_rows($query);
                          $user['lastactivity'] = TIMENOW;

                          foreach($user AS $key => $val)
                          {
                            $updates.=$comma."$key='$val'";$comma=",";
                          }

                         $DB->query("update "._PREFIX_."users set $updates where userid='$userid'");

                  }

                  function updatethreadcount($threadid)
                  {
                   GLOBAL $DB;
                   $replycount=0;

                   $query=$DB->query("select count(*) as replycount from post where threadid='$threadid'");
                   while($recount=$DB->fetch_array($query))
                   {
                    $replycount=$recount['replycount'];
                   }
                               if(($replycount<=0) || ($replycount==''))
                               {
                                  $replycount = 0;
                               }
                               else
                               {
                                 $replycount = $replycount - 1;
                               }

                               $attach=0;

                               $query=$DB->query("select attach from "._PREFIX_."post where threadid='$threadid'");
                               while($pp = $DB->fetch_array($query))
                               {
                                $attach = $attach + $pp['attach'];
                               }

                               $query=$DB->query("select u.userid,u.username,p.username as pusername,p.postid,p.dateline from post p LEFT JOIN users u on (u.userid=p.userid) where p.threadid=$threadid AND p.visible='1' ORDER BY p.dateline DESC LIMIT 0,1");
                               $lastpost=$DB->fetch_array($query);

                               $query=$DB->query("select u.userid,u.username,p.username as pusername,p.postid,p.dateline from post p LEFT JOIN users u on (u.userid=p.userid) where p.threadid=$threadid AND p.visible='1' ORDER BY p.dateline ASC LIMIT 0,1");
                               $firstpost=$DB->fetch_array($query);

                               $lastpost['username']  = ($lastpost['username'])?$lastpost['username']:$lastpost['pusername'];
                               $firstpost['username'] = ($firstpost['username'])?$firstpost['username']:$firstpost['pusername'];

                               $lastpost['username']  = ($lastpost['username'])?$lastpost['username']:$firstpost['username'];
                               $lastpost['userid']    = ($lastpost['userid'])?$lastpost['userid']:$firstpost['userid'];
                               $lastpost['dateline']  = ($lastpost['dateline'])?$lastpost['dateline']:$firstpost['dateline'];

                                      $DB->query("UPDATE "._PREFIX_."thread SET postusername='".$firstpost['username']."', postuserid='".$firstpost['userid']."', lastpost='".$lastpost['dateline']."', lastposter='".$lastpost['username']."', replycount='$replycount',lastpostid='".$lastpost['postid']."',lastposterid='".$lastpost['userid']."',attach='".$attach."' WHERE threadid='$threadid'");
                  }
                  function updatepostcount($postid)
                  {
                   GLOBAL $DB;
                               $attach=0;

                     $query=$DB->query("select attach from "._PREFIX_."post where postid='$postid'");
                      while($pp = $DB->fetch_array($query))
                      {
                            $attach = $attach + $pp['attach'];
                      }

                     $u=$DB->query_now("select u.userid,u.username from post p LEFT JOIN users u on (u.userid=p.userid) where p.postid=$postid AND p.visible='1' LIMIT 0,1");


                      $DB->query("UPDATE "._PREFIX_."post SET username='".$u['username']."',attach='".$attach."' WHERE postid='$postid'");
                  }

                  function updateforumcount($forumid)
                  {
                  GLOBAL $DB;

                  $lastsqladd='';

                  $mainid=0;

                  $forumslist='';
                  $parentlist='';

                  $lastpost=0;
                  $lastposter='';

                  $lastthread='';
                  $lastthreadid='';

                   $childforums=$DB->query("SELECT * FROM "._PREFIX_."forum  WHERE parentlist LIKE '%$forumid%' or forumid='$forumid'");
                   while($childforum = $DB->fetch_array($childforums))
                   {

                     if($childforum['forumid']==$forumid)
                     {

                        $parentlist = $childforum['parentlist'];
                        $lastpost   = $childforum['lastpost'];
                        $mainid     = $childforum['mainid'];

                     }
                     else
                     {
                      if($childforum['mainid']==$forumid)
                      {

                         $threadcount = $threadcount + $childforum['threadcount'];
                         $replycount  = $replycount + $childforum['replycount'];
                      }
                     }

                       $forumslist.=",$childforum[forumid]";

                   }

                   $DB->free_result($chilforums);

                   $lastq=$DB->query_now("select MAX(lastpost) as lastpost from "._PREFIX_."thread where forumid in (0$forumslist)");

                   if($lastpost != $lastq['lastpost'])
                   {
                     $last_query = $DB->query("select lastpost,lastpostid,threadid,lastposter,title,lastposterid from thread where lastpost='$lastq[lastpost]'");
                     $last=$DB->fetch_array($last_query);

                     $lastpost     = $last['lastpost'];
                     $lastposter   = addslashes($last['lastposter']);
                     $lastthread   = addslashes($last['title']);
                     $lastthreadid = $last['threadid'];
                     $lastpostid   = $last['lastpostid'];
                     $lastposterid = $last['lastposterid'];
                     $lastsqladd=",lastpostid='$lastpostid',lastposterid='$lastposterid',lastpost='$lastpost',lastposter='$lastposter',lastthread='$lastthread',lastthreadid='$lastthreadid'";
                   }

                              $query = $DB->query("SELECT COUNT(*) AS threads, SUM(replycount) AS replies FROM "._PREFIX_."thread WHERE forumid='$forumid' and visible='1'");
                              $posts = $DB->fetch_array($query);
                              if($posts)
                              {
                                      $threadcount = $posts['threads'] + $threadcount;
                                      $replycount  = $posts['replies'] + $replycount;
                              }

                   $DB->query("update "._PREFIX_."forum set threadcount='$threadcount',replycount='$replycount' $lastsqladd where forumid='$forumid'");

                          if(($mainid != -1) && eregi($mainid,$parentlist))
                          {
                              updateforumcount($mainid);
                          }

                  }

                  function deletepost($postid)
                  {

                  GLOBAL $DB;

                  $post=$DB->query_now("select * from "._PREFIX_."post where postid='$postid'");

                         if ($post['attach']==1)
                         {

                             $DB->query("DELETE FROM "._PREFIX_."attachment WHERE postid='$post[postid]'");
                             $DB->query("UPDATE "._PREFIX_."thread SET attach = attach - 1 WHERE threadid = '$post[threadid]'");

                         }

                          $DB->query("update "._PREFIX_."users set posts=posts-1 where userid='$local[userid]'");
                          $DB->query("update "._PREFIX_."thread set replycount=replycount-1 where threadid='$post[threadid]'");

                         $DB->query("DELETE FROM "._PREFIX_."post WHERE postid='$post[postid]'");

                  }

                  function deletethread($threadid)
                  {
                          GLOBAL $DB;

                          $usercount=array();

                           $postids='';
                           $comma='';
                  $threadinfo=$DB->query_now("select * from "._PREFIX_."thread where threadid='$threadid'");

                 $posts_query=$DB->query("SELECT userid,postid FROM "._PREFIX_."post WHERE threadid='$threadid'");

                 while ($post=$DB->fetch_array($posts_query))
                 {
                     if (!isset($usercount["$post[userid]"]))
                     {
                       $usercount["$post[userid]"] = -1;
                     }
                     else
                     {
                       $usercount["$post[userid]"]--;
                     }

                   $postids.=','.$post['postid'];
                 }

                     $DB->query("DELETE FROM "._PREFIX_."attachment WHERE postid IN ('0'$postids)");

                                  if (is_array($usercount))
                                  {

                                    while(list($userid,$count)=each($usercount))
                                    {

                                      $DB->query("UPDATE "._PREFIX_."users SET posts=posts$count WHERE userid='$userid'");

                                    }

                                  }


                                  if ($threadinfo['pollid']!=0)
                                  {
                                    $DB->query("DELETE FROM "._PREFIX_."poll WHERE pollid='$threadinfo[pollid]'");
                                    $DB->query("DELETE FROM "._PREFIX_."pollvote WHERE pollid='$threadinfo[pollid]'");
                                  }

                                  $DB->query("DELETE FROM "._PREFIX_."post WHERE threadid='$threadinfo[threadid]'");
                                  $DB->query("DELETE FROM "._PREFIX_."thread WHERE threadid='$threadinfo[threadid]'");
                                  $DB->query("DELETE FROM "._PREFIX_."threadrate WHERE threadid='$threadinfo[threadid]'");
                                  $DB->query("DELETE FROM "._PREFIX_."threadsubscribe WHERE threadid='$threadinfo[threadid]'");
                  }

                  function sendmail($to_email, $subject, $message, $from = '', $username = '',$addition=false)
                  {

                     global $options,$lang,$stylevar;

                      $to_email = trim($to_email);

                      if ($to_email != '')
                      {
                              $subject = trim($subject);
                              $message = preg_replace("/(\r\n|\r|\n)/s", "\r\n", trim($message));
                              $from = trim($from);
                              $username = trim($username);
                              if($addition==true)
                              {
                                      $headers = 'From: "' . "$from". "\" <$options[webmasteremail]>\r\n" . $headers;
                              }
                              else
                              {
                                if ($from == '')
                                {
                                        $headers = "From: \"$options[sitetitle] $lang[mailer]\" <$options[webmasteremail]>\r\n" . $headers;
                                }
                                else
                                {
                                        $headers = 'From: "' . "$username @ $options[sitetitle]". "\" <$from>\r\n" . $headers;
                                }
                              }

                              $headers.='Date: '.date('r')."\r\n"
                                        .'MIME-Version: 1.0'."\r\n"
                                        .'Content-transfer-encoding: 8bit'."\r\n"
                                        .'Content-type: text/plain; charset='.$stylevar['charset']."\r\n"
                                        .'X-Mailer: ArBB Mailer Via PHP';
                              mail($to_email, $subject, $message, trim($headers));
                              return true;

                      }
                      else
                      {
                              return false;
                      }

                  }

                  function get_unsearchable_forums()
                  {

                  }

                  if(!function_exists('file_get_contents'))
                  {
                     function file_get_contents($file)
                     {
                         $fp=fopen($file,"r");
                         $contents="";
                          while($line=fread($fp,1024))
                          {
                               $contents.=$line;
                          }
                          return $contents;
                     }

                  }

                  function get_forum_permissions($forum)
                  {

                  global $local,$DB,$localgroup;

                  $permissions=array();

                     if(!is_array($forum))
                     {
                        $forum=$DB->query_now("select parentlist from "._PREFIX_."forum where forumid='$forum'");
                     }
                        $parentlist=$forum['parentlist'];

                        $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid in ($parentlist) and usergroupid='$local[usergroupid]'");
                        if($DB->num_rows($forumpermission)>0)
                        {
                           while($nfp=$DB->fetch_array($forumpermission))
                           {
                               $permissions[$nfp['forumid']]=$nfp;
                           }

                             $ex=explode(',',$forum['parentlist']);

                             $ar=array_sum($ex);

                             for($i=$ar;$i>=0;$i--)
                             {
                              $fid = $ex[$i];
                                if(is_array($permissions[$fid]))
                                {
                                 $permission=$permissions[$fid];
                                 $i=0;
                                }
                             }

                         }
                            if(is_array($permission))
                            {
                             foreach($permission as $f => $p)
                             {
                                 if(($f != 'usergroupid')&&($f != 'forumid')&&($f != 'fpid'))
                                   {
                                       $localgroup[$f]=$p;
                                   }
                             }
                            }

                            return $localgroup;

                  }

                  function forumstatusimg($forum)
                  {

                         $newforumtime=3600*12;
                         $newforum=TIMENOW-$newforumtime;
                         if($forum['lastpost']>$newforum)
                         {
                           $statusimg='forum_new';
                         }
                         else
                         {
                           $statusimg='forum_old';
                         }

                         if($forum['open']==0)
                         {
                           $statusimg='forum_lock';
                         }

                         if($forum['link'])
                         {
                           $statusimg='forum_link';
                         }

                         return $statusimg;

                  }

                  function getsize($size)
                  {
                   if($size>=1024)
                   {
                      $size=ceil($size/1024);

                      if($size>1024)
                      {
                        $size=ceil($size/1024).'&nbsp;MB';
                      }
                      else
                      {
                        $size.='&nbsp;KB';
                      }
                   }
                   else
                   {
                     $size.='&nbsp;Byte';
                   }

                   return $size;
                  }

                  function threadstatusimg($thread)
                  {
                          $newthreadtime=3600*12;
                          $newthread=TIMENOW-$newthreadtime;

                          if($thread['open']==0)
                          {
                            $statusimg='thread_lock';
                          }
                          else
                          {

                            if($thread['lastpost']>$newthread)
                            {
                              $statusimg='thread_new';

                              if(($thread['replycount']>15)||($thread['views']>150))
                              {
                                $statusimg='thread_hot';
                              }
                            }
                            else
                            {

                              $statusimg='thread_old';

                            }
                          }
                  return $statusimg;
                  }

                  function size($value)
                  {
                  global $lang;
                        if($value >= (1024*1000*1000*1000))
                        {
                          $size=($value/(1024*1000*1000*1000));
                          $ex = 'tb';
                        }
                        elseif($value >= (1024*1000*1000))
                        {
                          $size=($value/(1024*1000*1000));
                          $ex = 'gb';
                        }
                        elseif($value >= (1024*1000))
                        {
                          $size=($value/(1024*1000));
                          $ex='mb';
                        }
                        elseif($value >= 1024)
                        {
                          $size=($value/1024);
                          $ex='kb';
                        }
                        else
                        {
                          $size=$value;
                          $ex = 'byte';
                        }

                    return @round($size,2).$lang[$ex];
                  }

                  function pagesnav($num,$page,$perpage,$link)
                  {
                  global $lang;

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
                <tr align=center>
                    <td class=\"tcat\">$lang[page] $page $lang[of] $pages</td>
                    ";

                $ppages['last']=$pages;


               if(($page != $ppages[first])&&($page != $ppages[first]+1)&&($page != $ppages[first]+2))
               {
               $pages_table.="<td class=\"td2\"><a href=\"$link&page=1\">&nbsp;<< $lang[first]&nbsp;</a></td>";
               }
               if($page!=$ppages['first'])
               {

                       if(($page-2)>=$ppages['first'])
                       {

                               $pppage['1']=$page-2;
                               $pppage['2']=$page-1;
                               if($pppage['1']>0)
                               {
               $pages_table.="<td class=\"td2\">&nbsp;&nbsp;<a href=\"$link&page=$pppage[1]\">$pppage[1]</a></td>";
                               }
                               if($pppage['2']>0)
                               {
               $pages_table.="<td class=\"td2\">&nbsp;<a href=\"$link&page=$pppage[2]\">$pppage[2]</a>&nbsp;</td>";
                                  }

                               }
                               elseif(($page-1)>=$ppages['first'])
                               {
                                       $pppage['1']=$page-1;
                                       if($pppage['1']>0)
                                       {
               $pages_table.="<td class=\"td2\">&nbsp;<a href=\"$link&page=$pppage[1]\">$pppage[1]</a>&nbsp;</td>";
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
                                $pages_table.="<td class=\"td2\">&nbsp;<a href=\"$link&page=$pppage[1]\">$pppage[1]</a>&nbsp;</td>";
                                  }
                                  if($ppage['2'] <= $ppages['last'])
                                  {
                                      $pages_table.="<td class=\"td2\">&nbsp;<a href=\"$link&page=$pppage[2]\">$pppage[2]</a>&nbsp;</td>";
                                          }
                               }
                               elseif(($page+1) <= $ppages['last'])
                               {
                                       $pppage['1']=$page+1;
                                       if($pppage['1'] <= $ppages['last'])
                                       {
               $pages_table.="<td class=\"td2\">&nbsp;<a href=\"$link&page=$pppage[1]\">$pppage[1]</a>&nbsp;</td>";
                                          }
                                       }

               }
               if(($page != $ppages[last])&&($page != $ppages[last]-1)&&($page != $ppages[last]-2))
               {
               $pages_table.="<td class=\"td2\"><a href=\"$link&page=$ppages[last]\">&nbsp;$lang[last] >>&nbsp;</a></td>";
               }
            $pages_table.="
                </tr>
               </table>";
            }


            return $pages_table;
                  }
//# All Done .. Functions File Finished

?>