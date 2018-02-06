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
#    newpost File started
#
/*
        File name       -> newpost.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'newpost_post,newpost_thread,newpost_preview_post,forum_password';
$phrasearray = array('editor','newpost','forum','thread','showteam','profile');

include 'global.php';
require_once('./includes/functions_newpost.php');

$fid=checkval($arbb->input['f']);
$tid=checkval($arbb->input['tid']);
$pid=checkval($arbb->input['pid']);
($fid)?$fid=$fid:$fid=$arbb->input['fid'];
$local['whereurl']= '';
$allowdextensions = '';

       $query=$DB->query("select extension from "._PREFIX_."attachmenttype");

        while($atype = $DB->fetch_array($query))
        {
            $allowdextensions.='&nbsp '.$atype['extension'];
        }

$checked=array();

if($arbb->input['quote']==1)
{
    $arbb->input['do']='post';
        }

if($tid>0)
{
   $wheretitle=$lang['new_post'];
   $local['whereurl']="newpost.php?tid=$tid&do=post";
      }
      else
      {
        $wheretitle=$lang['new_thread'];
           $local['whereurl']="newpost.php?f=$fid";
           }

   if($options['allowattach'])
   {
      $show['attachment_options']=1;
           }

   if($local['userid']>0)
   {
       $show['subscription_options']=1;
           }

   if($localgroup['canaddpoll'])
   {
       $show['poll_options']=1;
           }

      if($local['autosubscribe']>0)
      {
      $checked['notify']='checked';
      }
      else
      {
      $checked['notify']='';
      }

      if($local['showsignature']>0)
      {
       $checked['signature']='checked';
      }
      else
      {
       $checked['signature']='';
      }


   $hashtext   = TIMENOW.$local['username'].rand(0,9999).$local['userid'].$fid.$pid.$tid;

   $posthash   = md5($hashtext);
   $post_icons = "";

   $query    = $DB->query("select * from "._PREFIX_."icon");
   $tabindex = 0;
   $i        = 0;

   while($icon=$DB->fetch_array($query))
   {
    $tabindex++;
    $i++;

    if($i>7)
    {
       $post_icons.="</tr><tr>\n<td width=\"12%\">&nbsp;</td>\n";
       $i=0;
            }

       $post_icons.="<td><input type=\"radio\" name=\"iconid\" value=\"$icon[iconid]\" id=\"iconid_$icon[iconid]\" tabindex=\"$tabindex\"></td>
<td width=\"12%\"><label for=\"iconid_$icon[iconid]\"><img src=\"$icon[iconpath]\" alt=\"$icon[title]\" id=\"icon_$icon[iconid]\"></label></td>\n";

           }

if(empty($arbb->input['do']))
{

        $forum_query=$DB->query("select * from forum where forumid='$fid'");
        $f=array();

        while($forum=$DB->fetch_array($forum_query))
        {
           build_nav_tree($forum,1);
           $f=$forum;
   if(is_moderator($forum['forumid']))
   {
      $show['moderator_options']=1;
           }
        }

        $localgroup=get_forum_permissions($f['forumid']);

                $show['require_password']=0;
     if($fid==0)
     {
      error_message($lang['no_forum_selected']);
     }
     else
     {
      $forumpass=$arbb->input[''. _CPREFIX_ .$f[forumid].'_password'];
      if($forumpass==$f['password'])
      {
         $show['require_password']==0;
              }
              else
              {

             if(($f['canusepassword']==1)&&(strlen($f['password'])>1))
             {

             if(!is_moderator($f['forumid']))
             {
                $show['require_password']="1";
                  }
                  else
                  {
                      $show['require_password']==0;
                          }
                     }

                     }
     if(!$show['require_password'])
     {
       if(($localgroup['canpost']==1)&&($f['isforum']==1)&&(strlen($f['link'])<1))
       {
        $buttons="";
       $bbcode->cachesmilies();


       $smilies='';
             $i=0;
             $ii=0;
       foreach($bbcode->smiliescache as $key => $val)
       {
        if($key != 'cached')
        {
        $i++;
        $ii++;
        $smilies.="\n<td><a href='javascript:void(0);' onclick=\"insert_smiley('$val[text]')\" title='".$val['title']."'><img src='$val[path]' border='0'></a></td>";
        if($i == 4)
        {
         $smilies.='</tr><tr class="td1" align="center">';
         $i=0;
        }
        if($ii==20)
        {
                break;
        }

        }
       }

        $TP->webtemp("newpost_thread");
       }
       else
       {
           error_message($lang['you_cant_add_thread_to_forum']);
               }
           }
           else
           {
           $mainforum['forumid']=$f['forumid'];
               $message=$TP->GetTemp('forum_password');
                       error_message($message);
                   }
            }

        }
        elseif($arbb->input['do']=='thread')
        {
            $threadoptions = $arbb->input['threadoptions'];
            $title         = $arbb->input['title'];
            $post          = $arbb->input['message'];
            $iconid        = checkval($arbb->input['iconid']);
            $fid           = checkval($arbb->input['fid']);
            $posthash      = $bbcode->clearhtml($arbb->input['posthash']);

            $attach        = $DB->num_rows($DB->query("select * from "._PREFIX_."attachment where posthash='$posthash'"));

   if(is_moderator($fid))
   {
      $show['moderator_options']=1;
           }


            if($threadoptions['signature']==1)
            {
                 $threadoptions['signature']=1;
            }
            else
            {
                 $threadoptions['signature']=0;
            }
            if($threadoptions['disablesmilies']==1)
            {
                 $threadoptions['disablesmilies']=1;
            }
            else
            {
                 $threadoptions['disablesmilies']=0;
            }
            if($threadoptions['subscription']==1)
            {
                 $threadoptions['subscription']=1;
            }

            if(($threadoptions['postpoll']=='yes')||($threadoptions['postpoll']==1))
            {
               $threadoptions['postpoll']=1;
            }
            else
            {
               $threadoptions['postpoll']=0;
            }

            if($threadoptions['openclose']==1)
            {
               $threadoptions['openclose']=0;
            }
            else
            {
               $threadoptions['openclose']=1;
            }

            if($threadoptions['stickunstick']==1)
            {
               $threadoptions['stickunstick']=1;
            }
            else
            {
               $threadoptions['stickunstick']=0;
            }

                                  $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$fid' and usergroupid='$local[usergroupid]'");
                                  if($DB->num_rows($forumpermission)>0)
                                  {
                                          $nfp=$DB->fetch_array($forumpermission);

                                          foreach($nfp as $f => $p)
                                          {
                                                  if(($f != 'usergroupid')&&($f != 'forumid')&&($f != 'fpid'))
                                                  {
                                                      $localgroup[$f]=$p;
                                                  }
                                          }
                                  }
            $mainforum=$DB->query_now("select * from "._PREFIX_."forum where forumid='$fid'");
            $show['require_password']=0;
            $forumpass=$arbb->input[''. _CPREFIX_ .$f[forumid].'_password'];
            if($forumpass==$f['password'])
            {
               $show['require_password']=0;
                    }
                    else
                    {

                   if(($f['canusepassword']==1)&&(strlen($f['password'])>1))
                   {

                   if(!$show['moderator_options'])
                   {
                      $show['require_password']='1';
                        }
                        else
                        {
                            $show['require_password']=0;
                                }
                           }

                           }

            if($show['require_password'])
            {

               $message=$TP->GetTemp('forum_password');
                       error_message($message);
            }
            elseif(strlen($title)==0)
            {
               error_message($lang['no_thread_subject']);
            }
            elseif(strlen($post)<5)
            {
               error_message($lang['post_less_five_chars']);
            }
            else
            {
            if($localgroup['canpost']==1)
            {
            if($arbb->input['preview'])
            {
                    $message=$post;
                    $post=array();
                    foreach($local as $l => $v)
                    {
                        $post[$l]=$v;
                            }
                 $post['message']     = $message;
                 $post['post']        = $bbcode->build($post['message']);
                 $post['posttime']    = mydate(time(),'last');
                 $post['joindate']    = mydate($post['joindate'],'date');
                 $post['title']       = $title;

                           $post['showsignature']=$threadoptions['signature'];

                             if($local['userid']>0)
                             {
                               if(empty($local['usertitle']))
                               {
                                 $post['usertitle']=$localgroup['usertitle'];
                               }

                               if(empty($post['usertitle']))
                               {
                                  $post['usertitle']=build_title($local['posts']);

                               }

                             }
                             else
                             {
                                 $post['usertitle']=$lang['guest'];
                             }
                         if($post['userid']>0)
                         {
                           $show['profile']=1;
                           }
                           else
                           {
                               $show['profile']=0;
                                   }

            $etc="do=thread&fid=$fid";
            $TP->webtemp('newpost_preview_post');

            }
            else
            {
             $inserted=array('threadid'       => '0',
                             'username'       => $local['username'],
                             'userid'         => $local['userid'],
                             'title'          => $title,
                             'dateline'       => TIMENOW,
                             'post'           => $post,
                             'allowsmilie'    => $threadoptions['disablesmilies'],
                             'showsignature'  => $threadoptions['signature'],
                             'ipaddress'      => $local['ipaddress'],
                             'iconid'         => $iconid,
                             'visible'        => '1',
                             'attach'         => $attach,
                             'reportthreadid' => '0');

              $postinsert=$DB->multible_insert($inserted,'post');

              if(!$postinsert)
              {
                 error_message($lang['post_insert_error']);
                      }
                      else
                      {
                      $newpost=$DB->insert_id($postinsert);

                      if(!is_moderator($fid))
                      {
                       $threadoptions['stickunstick']    = 0;
                       $threadoptions['openclose']       = 1;
                      }

                      $threadinsarray=array('firstpostid'  => $newpost,
                                            'title'        => $title,
                                            'lastpostid'   => $newpost,
                                            'lastpost'     => TIMENOW,
                                            'forumid'      => $fid,
                                            'pollid'       => '0',
                                            'open'         => $threadoptions['openclose'],
                                            'postusername' => $local['username'],
                                            'postuserid'   => $local['userid'],
                                            'lastposter'   => $local['username'],
                                            'dateline'     => TIMENOW,
                                            'views'        => '0',
                                            'iconid'       => $iconid,
                                            'visible'      => '1',
                                            'sticky'       => $threadoptions['stickunstick'],
                                            'attach'       => $attach,
                                            'replycount'   => '0');

                      $thread=$DB->multible_insert($threadinsarray,'thread');

                      $tid=$DB->insert_id();

                      $DB->query("update "._PREFIX_."attachment set postid='$newpost' where posthash='$posthash'");

                      $DB->query("update ". _PREFIX_ ."post set threadid = '$tid' where postid='$newpost'");

                       updatethreadcount($tid);
                       updateusercount($local['userid']);
                       updateforumcount($fid);
                       updatestats();

                      if($threadoptions['subscription']==1)
                      {
                       $DB->query("insert into "._PREFIX_."threadsubscribe (userid,threadid) VALUES ('$local[userid]','$tid')");
                      }

                      if($threadoptions['postpoll'] == 1)
                      {
                               $url="poll.php?tid=$tid&do=addpoll&num=$threadoptions[polloptions]";
                               $redirect_message=$lang['thread_add_poll'];
                                 redirect($redirect_message,$url);
                              }
                              else
                              {
                               $url="thread.php?tid=$tid&do=newpost&pid=$newpostid";
                               $redirect_message=$lang['thread_add_ok'];
                                 redirect($redirect_message,$url);
                              }

                }
                }
                }
                else
                {
                    error_message($lang['you_cant_add_thread_to_forum']);
                        }
                        }
                }
                elseif($arbb->input['do']=='post')
                {
                $thread_query=$DB->query("select * from "._PREFIX_."thread where threadid='$tid'");
                while($thread=$DB->fetch_array($thread_query))
                {

                         $thread['title']=$bbcode->clearhtml($thread[title]);


                       build_nav_tree($thread['forumid'],1);
                          if(is_moderator($thread['forumid']))
                          {
                           $show['moderator_options']=1;
                          }
                       build_nav_location($thread['title'],"thread.php?tid=$thread[threadid]");


                       $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$thread[forumid]' and usergroupid='$local[usergroupid]'");
                       if($DB->num_rows($forumpermission)>0)
                       {
                            $nfp=$DB->fetch_array($forumpermission);

                                  foreach($nfp as $f => $p)
                                  {
                                         if(($f != 'usergroupid')&&($f != 'forumid')&&($f != 'fpid'))
                                         {
                                             $localgroup[$f]=$p;
                                         }
                                  }
                        }

                       if($thread['open']==1)
                       {
                        if($localgroup['canpost']==1)
                        {
                                $post=array();
                        if($arbb->input['quote'])
                        {
                                $pid=checkval($arbb->input['pid']);
                        $query=$DB->query("select * from "._PREFIX_."post where postid='$pid'");
                        while($po=$DB->fetch_array($query))
                        {
                            $post=$po;
                            $post['title']=$bbcode->clearhtml($post[title]);
                            $post['post']=str_replace('<br>','',$post['post']);
                                }

                                }

        $buttons="";
       $bbcode->cachesmilies();


       $smilies='';
             $i=0;
             $ii=0;
       foreach($bbcode->smiliescache as $key => $val)
       {
        if($key != 'cached')
        {
        $i++;
        $ii++;
        $smilies.="\n<td><a href='javascript:void(0);' onclick=\"insert_smiley('$val[text]')\" title='".$val['title']."'><img src='$val[path]' border='0'></a></td>";
        if($i == 4)
        {
         $smilies.='</tr><tr class="td1" align="center">';
         $i=0;
        }
        if($ii==20)
        {
                break;
        }

        }
       }
                         $TP->webtemp('newpost_post');
                         }
                         else
                         {
                             error_message($lang['no_permission_for_posting']);
                                 }
                         }
                         else
                         {
                             error_message($lang['thread_closed_for_posting']);
                                 }

                         }
                                     }
                                      elseif($arbb->input['do']=='newreply')
                                      {

                                          $title       = $arbb->input['title'];
                                          $post        = $arbb->input['message'];
                                          $poptions    = $arbb->input['poptions'];
                                          $threadtitle = $arbb->input['threadtitle'];
                                          $iconid      = checkval($arbb->input['iconid']);
                                          $posthash    = $arbb->input['posthash'];

                                          $qu=$DB->query("select forumid from "._PREFIX_."thread where threadid='$tid'");
                                          while($t=$DB->fetch_array($qu))
                                          {
                                  $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$t[forumid]' and usergroupid='$local[usergroupid]'");
                                  if($DB->num_rows($forumpermission)>0)
                                  {
                                          $nfp=$DB->fetch_array($forumpermission);

                                          foreach($nfp as $f => $p)
                                          {
                                                  if(($f != 'usergroupid')&&($f != 'forumid')&&($f != 'fpid'))
                                                  {
                                                      $localgroup[$f]=$p;
                                                  }
                                          }
                                  }

                                  if($localgroup['canpost']==1)
                                  {
                                       $canpost=1;
                                          }
                                          else
                                          {
                                              $canpost=0;
                                                  }
                                                  }
                                          $query=$DB->query("select posthash from "._PREFIX_."attachment where posthash='$posthash'");
                                          $attach=$DB->num_rows($query);




                                           if(($poptions['disablesmilies']!= 0)&&($poptions['disablesmilies']!="")||($poptions['disablesmilies']=="on"))
                                           {
                                               $poptions['allowsmilies']   = 0;
                                               $poptions['disablesmilies'] = 1;
                                                   }
                                                   else
                                                   {
                                                       $poptions['allowsmilies']   = 1;
                                                       $poptions['disablesmilies'] = 0;
                                                           }

                                           if(($poptions['signature'] != '')&&($poptions['signature'] != 0)||($poptions['signature'] == 'on'))
                                           {
                                               $poptions['signature']=1;
                                                   }
                                                   else
                                                   {
                                                       $poptions['signature']=0;
                                                           }

                                           if(($poptions['subscription']!="")&&($poptions['subscription']!=0)||($poptions['subscription']=="on"))
                                           {
                                               $poptions['subscription']=1;
                                                   }
                                                   else
                                                   {
                                                       $poptions['subscription']=0;
                                                           }

                                       if($canpost == 1)
                                       {
                                          if($arbb->input['previewpost'])
                                          {
                                          $message=$post;
                                          $post=array();
                                          foreach($local as $l => $v)
                                          {
                                              $post[$l]=$v;
                                                  }
                                          $post['message']     = $message;
                                          $post['post']        = $bbcode->build($post['message']);
                                          $post['posttime']    = mydate(time(),'last');
                                          $post['joindate']    = mydate($post['joindate'],'date');
                                          $post['title']       = $title;


                                       $post['showsignature']=$poptions['signature'];

                             if($local['userid']>0)
                             {
                               if(empty($local['usertitle']))
                               {
                                 $post['usertitle']=$localgroup['usertitle'];
                               }

                               if(empty($post['usertitle']))
                               {
                                  $post['usertitle']=build_title($local['posts']);

                               }

                             }
                             else
                             {
                                 $post['usertitle']=$lang['guest'];
                             }
                         if($post['userid']>0)
                         {
                           $show['profile']=1;
                           }
                           else
                           {
                               $show['profile']=0;
                                   }

                                          $etc="do=newreply&tid=$tid";
                                          $show['poptions']=1;

                                          $TP->webtemp('newpost_preview_post');

                                          }
                                          else
                                          {
                                           if(strlen($post)>4)
                                           {
                                           $inserted=array('threadid'       => $tid,
                                                           'username'       => $local['username'],
                                                           'userid'         => $local['userid'],
                                                           'title'          => $title,
                                                           'dateline'       => TIMENOW,
                                                           'post'           => $post,
                                                           'allowsmilie'    => $poptions['allowsmilies'],
                                                           'showsignature'  => $poptions['signature'],
                                                           'ipaddress'      => $local['ipaddress'],
                                                           'iconid'         => $iconid,
                                                           'visible'        => '1',
                                                           'attach'         => $attach,
                                                           'reportthreadid' => '0');

                                           $newpost   = $DB->multible_insert($inserted,'post');
                                           $newpostid = $DB->insert_id();

                                              if(!$newpost)
                                              {
                                               error_message($lang['post_insert_error']);
                                              }
                                              else
                                              {

                                              $query=$DB->query("select ts.*,u.email,u.username from "._PREFIX_."threadsubscribe ts
                                                                 LEFT JOIN "._PREFIX_."users u on(u.userid=ts.userid)
                                                                 where ts.threadid='$tid'");

                                              while($u=$DB->fetch_array($query))
                                              {
                                                    $inserted['threadtitle']=$threadtitle;
                                                    new_subscribe_mail($u,$inserted);
                                                    if($u['userid']==$local['userid'])
                                                    {
                                                        $ins='no';
                                                            }
                                              }

                                              if($ins != 'no')
                                              {
                                               $DB->query("insert into "._PREFIX_."threadsubscribe (userid,threadid) VALUES ('$local[userid]','$tid')");
                                              }

                                              $DB->query("update "._PREFIX_."attachment set postid='$newpostid' where posthash='$posthash'");

                                              updatethreadcount($tid);
                                              updateusercount($local['userid']);
                                              updateforumcount($fid);
                                              updatestats();

                                                      $url="thread.php?tid=$tid&do=newpost&pid=$newpostid";
                                                      $redirect_message=$lang['post_add_ok'];
                                                  redirect($redirect_message,$url);
                                              }
                                            }
                                            else
                                            {

                                                error_message($lang['post_less_five_chars']);

                                                    }
                                                  }
                                                  }
                                                  else
                                                  {
                                                      error_message($lang['you_cant_add_post_to_forum']);
                                                          }




                        }


   build_nav_location($wheretitle,$local['whereurl'],'add',1);

   $titleetc=$wheretitle.' - ';
   print_page();

?>