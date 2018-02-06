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
#    EditPost File started
#
/*
        File name       -> editpost.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'editpost';
$phrasearray = array('editor','newpost','forum','thread','showteam','profile');

require('global.php');

$pid=checkval($arbb->input['pid']);

$local['whereurl'] = '';
$wheretitle        = '';
$post              = array();
$allowdextensions  = '';
$p                 = array();

       $query=$DB->query('select extension from '._PREFIX_.'attachmenttype');

        while($atype = $DB->fetch_array($query))
        {
            $allowdextensions.="&nbsp $atype[extension]";
        }
    $query=$DB->query("select p.*,t.forumid,t.title as threadtitle from "._PREFIX_."post p
                       LEFT JOIN "._PREFIX_."thread t on (t.threadid=p.threadid)
                        where postid='$pid'");
    while($p=$DB->fetch_array($query))
    {
    $post=$p;

  $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$post[forumid]' and usergroupid='$local[usergroupid]'");
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
          }


    build_nav_tree($post['forumid'],1);

   if(is_moderator($post['forumid']))
   {
      $show['moderator_options']=1;
   }

   if((!$localgroup['caneditpost']) OR (($post['userid'] != $local['userid']) && !$show['moderator_options']))
   {
    error_permission();
   }




    build_nav_location($post['threadtitle'],"thread.php?tid=$post[threadid]");

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

      if(strlen($local['showsignature'])>0)
      {
       $checked['signature']='checked';
      }
      else
      {
       $checked['signature']='';
      }

   $query    = $DB->query("select * from "._PREFIX_."icon");
   $i        = 0;

   while($icon=$DB->fetch_array($query))
   {
    $i++;

    if($i>7)
    {
       $post_icons.="</tr><tr>\n<td width=\"12%\">&nbsp;</td>\n";
       $i=0;
            }

       $post_icons.="<td><input type=\"radio\" name=\"iconid\" POST_ICON_$icon[iconid] value=\"$icon[iconid]\" id=\"iconid_$icon[iconid]\"></td><td width=\"12%\"><label for=\"iconid_$icon[iconid]\"><img src=\"$icon[iconpath]\" alt=\"$icon[title]\" id=\"icon_$icon[iconid]\"></label></td>\n";

           }

         foreach($post as $p => $value)
         {

             $post[$p]=$bbcode->clearhtml($value);
         }

         if($post['iconid']>0)
         {
          $post_icons=str_replace("POST_ICON_$post[iconid]",'checked',$post_icons);
         }

if(empty($arbb->input['do']))
{
    $whereurl="editpost.php?pid=$pid";
    $wheretitle=$lang['edit_post'].':'.$post['title'];
    $post['attachments']='';


    if($post['attach']>0)
    {
    $post['attachments']='';

        $at_query=$DB->query("select * from "._PREFIX_."attachment where postid='$post[postid]'");
        while($at=$DB->fetch_array($at_query))
        {

            $post['attachments'].="-> <img src=\"images/attach/$at[filetype].gif\"> ".$bbcode->clearhtml($at['filename'])."<br>";

        }

            }
          if($localgroup['caneditpost']==1)
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
             $TP->webtemp('editpost');
                  }
                  else
                  {
                      error_permission();
                          }

        }
        elseif($arbb->input['do']=='edit')
        {

           $tid    = checkval($arbb->input['tid']);
           $iconid = checkval($arbb->input['iconid']);

           $message  = $arbb->input['message'];
           $title    = $arbb->input['title'];
           $poptions = $arbb->input['poptions'];

           $updates="iconid='$iconid'";

           $attach_query=$DB->query("select atid from attachment where postid='$post[postid]'");
           $attach = $DB->num_rows($attach_query);


              if($post['title']!=$title)
              {
                   $updates.=",title='$title'";
                      }

              if($post['post'] != $message)
              {
                  $updates.=",post='$message'";
                      }
              if($post['attach'] != $attach)
              {
                  $updates.=",attach='$attach'";
                      }
              if($post['userid'] == $local['userid'])
              {
                 $updates.=",ipaddress='$local[ipaddress]'";
                      }

              if($poptions['disablesmilies']==1)
              {
                  $poptions['disablesmilies']=0;
                      }

              if($post['allowsmilie']!=$poptions['disablesmilies'])
              {
                 $updates.=",allowsmilie='$poptions[disablesmilies]'";
                      }

              if($post['showsignature']!=$poptions['signature'])
              {
                 $updates.=",showsignature='$poptions[signature]'";
                      }
                     if((($localgroup['caneditpost']==1)&&($post['userid']==$local['userid']))||is_moderator($post['forumid']))
                     {
                      $upda = $DB->query("update "._PREFIX_."post set $updates where postid='$post[postid]'");

                      updatethreadcount($post['threadid']);
                      updateforumcount($post['forumid']);
                      updateusercount($post['userid']);
                      updatestats();

                      if(!$upda)
                      {
                          error_message($lang['error_editing_post']);
                              }
                              else
                              {
                                  $url="thread.php?tid=$post[threadid]";
                                  $redirect_message=$lang['post_successfully_edited'];
                                    redirect($redirect_message,$url);
                                      }
                      }
                      else
                      {
                          error_permission();
                              }
                }
                elseif($arbb->input['do']=='delete')
                {
                    $tid=checkval($arbb->input['tid']);
                    $pid=checkval($arbb->input['pid']);
                    $del=$bbcode->clearhtml($arbb->input['del']);
                         $ok=2;
                         if($localgroup['candelposts']==1)
                         {
                         if($del=='yes')
                         {

                           $query=$DB->query("select firstpostid,forumid from "._PREFIX_."thread where threadid='$post[threadid]'");
                            while($t=$DB->fetch_array($query))
                            {

                                            if($t['firstpostid']==$pid)
                                            {
                                                 deletethread($t['threadid']);
                                                $url="forum.php?fid=$t[forumid]";
                                                $redirect_message=$lang['thread_successfully_deleted'];
                                                    }
                                                    else
                                                    {
                                                             deletepost($post['postid']);
                                                       $url="thread.php?tid=$tid";
                                                       $redirect_message=$lang['post_successfully_deleted'];
                                                            }

                                                            updatethreadcount($post['threadid']);
                                                            updateforumcount($post['forumid']);
                                                            updateusercount($post['userid']);
                                                            updatestats();
                                                        redirect($redirect_message,$url);
                                             }
                                 }
                                 else
                                 {
                                    error_message($lang['del_box_not_checked']);
                                         }

                                         }
                                         else
                                         {
                                             error_permission();
                                                 }
                        }
                        else
                        {
                             error_message("");
                                }

   build_nav_location($wheretitle,$local['whereurl'],'add',1);
   $titleetc=$wheretitle.' - ';
   print_page();

?>