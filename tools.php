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
#    Thread Tools File started
#
/*
        File name       -> tools.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='tools_forum_threads_delete,tools_thread_move,tools_forum_threads_move,tools_thread_delete,tools_thread_delete_posts';

$phrasearray = array('tools');

Include 'global.php';


if($arbb->input['action']=='forumtools')
{

   $fid=checkval($arbb->input['fid']);
   build_nav_tree($fid);
   if(!is_moderator($fid))
   {
    error_permission();
   }
    if(is_array($arbb->input['threads']))
    {
       $threads=implode(',',$arbb->input['threads']);
    }
    else
    {
      error_message($lang['no_threads_selected']);
    }

    $threads=$bbcode->clearhtml(addslashes($threads));

    $addition=0;

switch($arbb->input['do'])
{
   case 'closethreads';
   $updaq="open='0'";
   $error_phrase='tools_error_threads_not_closed';
   $redirect_phrase='tools_threads_closed';
   break;
   case 'openthreads';
   $updaq="open='1'";
   $error_phrase='tools_error_threads_not_opened';
   $redirect_phrase='tools_threads_opened';
   break;
   case 'stickthreads';
   $updaq="sticky='1'";
   $error_phrase='tools_error_threads_not_sticked';
   $redirect_phrase='tools_threads_sticked';
   break;
   case 'unstickthreads';
   $updaq="sticky='0'";
   $error_phrase='tools_error_threads_not_unsticked';
   $redirect_phrase='tools_threads_unsticked';
   break;
   case 'deletethreads';
   case 'do_deletethreads';
   case 'movethreads';
   case 'do_movethreads';
   $addition=1;
   break;
   default:

   error_message($lang['no_threads_selected']);
   break;
}

    if($addition==0)
    {
        $upda=$DB->query("update "._PREFIX_."thread set $updaq where threadid in ($threads) and forumid='$fid'");
        if(!$upda)
        {
            error_message($lang[$error_phrase]);
        }
        else
        {
            redirect($lang[$redirect_phrase],"forum.php?fid=$fid");
        }
    }
    else
    {

       if($arbb->input['do']=='deletethreads')
       {
        $add_phrase = $lang['delete_threads'];
          $TP->webtemp('tools_forum_threads_delete');

       }
       elseif($arbb->input['do']=='movethreads')
       {
        $add_phrase = $lang['move_threads'];
        $movetoforums="";
                           $forums = array();
                           $movetoforums="\n<optgroup label=\"$lang[forumjump_forums]\">";

                           $forum=$DB->query("select forumid,mainid,displayorder,title from "._PREFIX_."forum where active = '1' order by displayorder ASC");
                           while($f=$DB->fetch_array($forum))
                           {
                              $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
                           }


                           while(list($disprder,$info) = each($forums[-1]))
                           {

                            foreach($info as $id => $f)
                            {
                            $sle='';
                            if($id==$fid)
                            {
                             $sle='selected';
                            }

                              $movetoforums.="\n<option $sle value=\"$f[forumid]\" class=\"td2\">$f[title]</option>\n";
                              if(is_array($forums[$id]))
                              {
                               $jumpforums='';
                               $movetoforums.=forumjump_tree($forums,$id,"0",$fid);
                              }
                            }
                           }

                           $movetoforums.="\n</optgroup>";
          $TP->webtemp('tools_forum_threads_move');
       }
       elseif($arbb->input['do']=='do_deletethreads')
       {
       if($arbb->input['del']=='yes')
       {
        $th=explode(',',$threads);
        foreach($th as $key => $val)
        {
         deletethread($val);
        }

            updateforumcount($fid);
                updatestats();
        redirect($lang['tools_forum_threads_deleted'],"forum.php?fid=$fid");
       }
       else
       {
        error_message($lang['confirm_box_not_checked']);
       }
       }
       elseif($arbb->input['do']=='do_movethreads')
       {
       $newfid=checkval($arbb->input['newfid']);

       $forum = $DB->query_now("select * from "._PREFIX_."forum where forumid='$newfid'");


       if($forum['active']==0||$forum['isforum']==0||$forum['link'] != '')
       {
        error_message($lang['wrong_forum']);
       }

       $upda=$DB->query("update "._PREFIX_."thread set forumid='$newfid' where threadid in ($threads) and forumid='$fid'");

       if(!$upda)
       {
         error_message($lang['tools_forum_threads_not_moved']);
       }
       else
       {

            updateforumcount($fid);
            updateforumcount($newfid);
                updatestats();
            redirect($lang['tools_forum_threads_moved'],"forum.php?fid=$newfid");
       }

       }
   build_nav_location($add_phrase,'#','add',1);
   $titleetc=$add_phrase." - ";

    }
}
elseif($arbb->input['action']=='threadtools')
{
$tid=checkval($arbb->input['tid']);
$fid=checkval($arbb->input['fid']);
$thread=$DB->query_now("select * from "._PREFIX_."thread where threadid='$tid' and forumid='$fid'");

        if(!is_moderator($thread['forumid'])||!$thread)
        {
         error_permission();
        }
foreach($thread as $key => $val)
{
 $thread[$key]=addslashes($bbcode->clearhtml($val));
}
        build_nav_tree($thread['forumid']);
if(is_array($arbb->input['posts']))
{
$posts=addslashes($bbcode->clearhtml(implode(",",$arbb->input['posts'])));
}
       switch($arbb->input['do'])
       {
          case 'closethread';
          $updaq="open='0'";
          $error_phrase='tools_error_threads_not_closed';
          $redirect_phrase='tools_threads_closed';
          break;

          case 'openthread';
          $updaq="open='1'";
          $error_phrase='tools_error_threads_not_opened';
          $redirect_phrase='tools_threads_opened';
          break;

          case 'stick';
          $updaq="sticky='1'";
          $error_phrase='tools_error_threads_not_sticked';
          $redirect_phrase='tools_threads_sticked';
          break;

          case 'unstick';
          $updaq="sticky='0'";
          $error_phrase='tools_error_threads_not_unsticked';
          $redirect_phrase='tools_threads_unsticked';
          break;

          case 'deleteposts';
          case 'do_deleteposts';
          if(!isset($posts)||strlen($posts)<1)
          {
           error_message($lang['no_selected_posts']);
          }
          case 'deletethread';
          case 'do_deletethread';
          case 'move';
          case 'do_move';
          $addition=1;
          break;
          default:

          error_message($lang['no_threads_selected']);
          break;
       }

       if($addition==0)
       {

        $upda=$DB->query("update "._PREFIX_."thread set $updaq where threadid='$thread[threadid]' and forumid='$thread[forumid]'");
        if(!$upda)
        {
            error_message($lang[$error_phrase]);
        }
        else
        {
            redirect($lang[$redirect_phrase],"thread.php?tid=$tid");
        }
       }
       else
       {
        if($arbb->input['do']=='deletethread')
        {
        $add_phrase=$lang['delete_thread'].' : '.$thread['title'];
         $TP->WebTemp('tools_thread_delete');
        }
        elseif($arbb->input['do']=='deleteposts')
        {
        $add_phrase=$lang['delete_selected_posts'].' : '.$thread['title'];
         $TP->WebTemp('tools_thread_delete_posts');
        }
        elseif($arbb->input['do']=='move')
        {
        $add_phrase = $lang['move_threads'];
        $movetoforums="";
                           $forums = array();
                           $movetoforums="\n<optgroup label=\"$lang[forumjump_forums]\">";

                           $forum=$DB->query("select forumid,mainid,displayorder,title from "._PREFIX_."forum where active = '1' order by displayorder ASC");
                           while($f=$DB->fetch_array($forum))
                           {
                              $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
                           }


                           while(list($disprder,$info) = each($forums[-1]))
                           {

                            foreach($info as $id => $f)
                            {
                            $sle='';
                            if($id==$fid)
                            {
                             $sle='selected';
                            }

                              $movetoforums.="\n<option $sle value=\"$f[forumid]\" class=\"td2\">$f[title]</option>\n";
                              if(is_array($forums[$id]))
                              {
                               $jumpforums='';
                               $movetoforums.=forumjump_tree($forums,$id,"0",$fid);
                              }
                            }
                           }

                           $movetoforums.="\n</optgroup>";

        $TP->webtemp('tools_thread_move');
        }
        elseif($arbb->input['do']=='do_deletethread')
        {
          if($arbb->input['del'] != 'yes')
          {
           error_message($lang['confirm_box_not_checked']);
          }

            deletethread($thread['threadid']);
            updateforumcount($thread['forumid']);
                updatestats();
          redirect($lang['tools_forum_threads_deleted'],"forum.php?fid=$thread[forumid]");
        }
        elseif($arbb->input['do']=='do_deleteposts')
        {
          if($arbb->input['del'] != 'yes')
          {
           error_message($lang['confirm_box_not_checked']);
          }
          $p=explode(',',$posts);
          foreach($p as $key => $val)
          {
           deletepost($val);
          }
          updatethreadcount($thread['threadid']);

          redirect($lang['tools_thread_posts_deleted'],"thread.php?tid=$thread[threadid]");
        }
        elseif($arbb->input['do']=='do_move')
        {
               $newfid=checkval($arbb->input['newfid']);

               $forum = $DB->query_now("select * from "._PREFIX_."forum where forumid='$newfid'");


               if($forum['active']==0||$forum['isforum']==0||$forum['link'] != "")
               {
                error_message($lang['wrong_forum']);
               }

               $upda=$DB->query("update "._PREFIX_."thread set forumid='$newfid' where threadid ='$thread[threadid]'");

               if(!$upda)
               {
                 error_message($lang['tools_forum_threads_not_moved']);
               }
               else
               {

                    updateforumcount($thread['forumid']);
                    updateforumcount($newfid);
                        updatestats();
                    redirect($lang['tools_forum_threads_moved'],"thread.php?tid=$thread[threadid]");
               }

        }
          build_nav_location($add_phrase,'#','add',1);
          $titleetc=$add_phrase.' - ';
       }

}


print_page();


?>