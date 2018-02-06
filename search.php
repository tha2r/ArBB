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
#    Search Engine File started
#
/*
        File name       -> search.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/
$templatelist='search,search_results,search_options_forum,search_results,search_results_result_threads,search_results_result_posts';

$phrasearray = array('search','thread','forum','profile');

Include 'global.php';

if($localgroup['cansearch'] != 1)
{
        error_permission();
}

$fids='';
$where='';

switch($arbb->input['do'])
{
        case 'results':
         build_nav_location(stripslashes($lang['search_engine']),'search.php','add');
         build_nav_location(stripslashes($lang['search_results']),'search.php','add',1);

        break;
        case '';
         $arbb->input['do']='search';
        default:

         build_nav_location(stripslashes($lang['search_engine']),'search.php','add',1);
        break;
}

if($arbb->input['do']=='findposts')
{
$arbb->input['do']='do_search';
$arbb->input['resulttype']='posts';
$arbb->input['userid']=intval($arbb->input['u']);
}

if($arbb->input['do']=='findthreads')
{
$arbb->input['do']='do_search';
$arbb->input['resulttype']='threads';
$arbb->input['userid']=intval($arbb->input['u']);
}



if($arbb->input['do']=='results')
{

$query=$DB->query("select * from search where sid='".$arbb->input['searchid']."'");
$search=$DB->fetch_array($query);
        $order  = strtolower($arbb->input['order']);
        $sortby = $arbb->input['sortby'];
        $page=(intval($arbb->input['page']))?intval($arbb->input['page']):1;

        $perpage=15;
        $start=(intval($page)*$perpage)-$perpage;
        $limit  = $start.','.$perpage;
        $sel    = array();
$pagenav='';

        $search_results = '';

        if($sortby=='replycount')
        {
             $sortfield = 't.replycount';
        }
        elseif($sortby=='views')
        {
             $sortfield = 't.views';
        }
        elseif($sortby=='dateline')
        {
             if($search['resulttype'] == 'threads')
             {
                     $sortfield = 't.dateline';
             }
             else
             {
                     $sortfield = 'p.dateline';
             }
        }
        elseif($sortby=='title')
        {
             if($search['resulttype'] == 'threads')
             {
                     $sortfield = 't.title';
             }
             else
             {
                     $sortfield = 'p.title';
             }
        }
        elseif($sortby=='username')
        {
             if($search['resulttype'] == 'threads')
             {
                     $sortfield = 't.postusername';
             }
             else
             {
                     $sortfield = 'p.username';
             }
        }
        else
        {
             if($search['resulttype'] == 'threads')
             {
                     $sortfield = 't.lastpost';
             }
             else
             {
                     $sortfield = 'p.dateline';
             }
             $sortby='lastpost';
        }

        if($order != 'asc')
        {
                $order = 'desc';
        }

        $sel["$sortby"]='selected';
        $sel["$order"]='selected';

         if($search['resulttype']=='threads')
         {
           if(strlen($search['querycache'])>0)
           {

           $where=$search['querycache'];

           }
           else
           {

           $where=' t.threadid in('.$search['threads'].')';

           }

           $where.=' and t.visible>0';
$nquery=$DB->query("select t.*,p.post,i.title as icontitle,i.iconpath from "._PREFIX_."thread t
                                                LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
                                                LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                                                where $where");
$num=$DB->num_rows($nquery);
$pagenav=pagesnav($num,$page,$perpage,'search.php?do=results&searchid='.$arbb->input['searchid']."&sortby=$sortby&order=$order");
                             $query=$DB->query("select t.*,p.post,i.title as icontitle,i.iconpath from "._PREFIX_."thread t
                                                LEFT JOIN ". _PREFIX_ ."post p on(p.postid = t.firstpostid)
                                                LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                                                where $where
                                                order by $sortfield $order limit $limit");

while($thread=$DB->fetch_array($query))
{

      if($thread['open']==0)
      {
      $thread['statusimg']='thread_lock';
      }

      if($thread['lastpost']>$newthread)
      {
      $thread['statusimg']='thread_new';

      if(($thread['replycount']>15)||($thread['views']>150))
      {

      $thread['statusimg']='thread_hot';

      }

      }
      else
      {

      $thread['statusimg']='thread_old';

      }
$posticon='&nbsp;';
      if($thread['iconid']>0)
      {
      $posticon="<img src=\"$thread[iconpath]\" alt=\"$thread[icontitle]\">";
      }


      $thread['post']=$bbcode->clearbbcode(substr($bbcode->clearhtml($thread['post']),0,350));
      $thread['lastposttime']=mydate($thread['lastpost'],'last');
      $thread['title']=$bbcode->clearhtml($thread['title']);


$search_results.=$TP->GetTemp('search_results_result_'.$search['resulttype'].'');
}

if($search['resulttype']=='threads')
{
 $show['threadorpost'] = 1;
}
else
{
 $show['threadorpost'] = 0;
}
$TP->webtemp('search_results');

         }
         elseif($search['resulttype'] == 'posts')
         {

           if(strlen($search['querycache'])>0)
           {

           $where=$search['querycache'];

           }
           else
           {

           $where=' p.postid in('.$search['posts'].')';

           }

           $where.=' and t.visible>0';
                             $nquery=$DB->query("select p.*,u.usergroupid,u.joindate,u.posts,u.usertitle,u.avatarid,u.signature,u.location,u.ipaddress,u.username as musername,t.open,ug.opentag,ug.usertitle,t.title as threadtitle,t.forumid,f.title as forumtitle,i.title as icontitle,i.iconpath from "._PREFIX_."post p
                                                LEFT JOIN ". _PREFIX_ ."thread t on(t.threadid = p.threadid)
                                                LEFT JOIN ". _PREFIX_ ."forum f on(f.forumid = t.forumid)
                                                LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                                                LEFT JOIN ". _PREFIX_ ."users u on (u.userid=p.userid)
                                                LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                                where $where");
$num=$DB->num_rows($nquery);
$pagenav=pagesnav($num,$page,$perpage,'search.php?do=results&searchid='.$arbb->input['searchid']."&sortby=$sortby&order=$order");

                             $query=$DB->query("select p.*,u.usergroupid,u.joindate,u.posts,u.usertitle,u.avatarid,u.signature,u.location,u.ipaddress,u.username as musername,t.open,ug.opentag,ug.usertitle,t.title as threadtitle,t.forumid,f.title as forumtitle,i.title as icontitle,i.iconpath from "._PREFIX_."post p
                                                LEFT JOIN ". _PREFIX_ ."thread t on(t.threadid = p.threadid)
                                                LEFT JOIN ". _PREFIX_ ."forum f on(f.forumid = t.forumid)
                                                LEFT JOIN ". _PREFIX_ ."icon i on(i.iconid=t.iconid)
                                                LEFT JOIN ". _PREFIX_ ."users u on (u.userid=p.userid)
                                                LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                                where $where
                                                order by $sortfield $order limit $limit");

                   while($post=$DB->fetch_array($query))
                   {

                   $post['posttime']     = mydate($post['dateline'],'last');
                   $post['threadpostid'] = $i;
                   $post['joindate']     = mydate($post['joindate'],'date');
                   $post['title']        = $bbcode->clearhtml($post['title']);

                   if($post['userid']>0)
                   {
                           $show['profile']=1;
                           }
                           else
                           {
                               $show['profile']=0;
                                   }

                             if($post['userid']>0)
                             {
                               if(empty($post['usertitle']))
                               {
                                $post['usertitle']=$post['gusertitle'];
                               }

                               if(empty($post['usertitle']))
                               {
                                  $post['usertitle']=build_title($post['posts']);

                               }

                             }
                             else
                             {
                                 $post['usertitle']=$lang['guest'];
                             }

                             if(get_user_status($post['userid'])>0)
                             {
                                 $statusbutton='online';
                                     }
                                     else
                                     {
                                         $statusbutton='offline';
                                             }
                   $post['user_status']=$lang[$statusbutton];
                   $post['onlinestatus']="<img src=\"$stylevar[dir]/status/user_$statusbutton.gif\" alt=\"$post[musername] $lang[$statusbutton]\">";

                   if($localgroup['canviewip'])
                   {
                    $post['user_ip']="<img src=\"$stylevar[dir]/status/user_ip.gif\" alt=\"$post[ipaddress]\">";
                   }

                   $post['post']=$bbcode->build($post['post']);

                   $search_results.= $TP->GetTemp('search_results_result_posts');

                   }
                   $TP->webtemp('search_results');
         }
         else
         {
          error_message($lang['search_not_recorded']);
         }
}
elseif($arbb->input['do']=='todayposts')
{

         $timeoff = TIMENOW - 86400;
         $where = "t.lastpost>=\'".$timeoff."\'";

if(checkval($arbb->input['fid'])>0)
{
         $where.="t.fid = \'".checkval($arbb->input['fid'])."\'";
}
         $notinforums = get_unsearchable_forums();
        if($notinforums)
        {
                $where .= " AND t.forumid NOT IN ($notinforums)";
        }

        $queryins=array('uid'         => $local['userid'],
                        'dateline'    => TIMENOW,
                        'ipaddress'   => $local['ipaddress'],
                        'searchtype'  => 'threads',
                        'resulttype'  => 'threads',
                        'querycache'  => $where);
        $query = $DB->multible_insert($queryins,'search');

        $sid=$DB->insert_id($query);
        redirect($lang['search_done'],"search.php?do=results&searchid=$sid");

}
elseif($arbb->input['do']=='search')
{
$query=$DB->query("select * from "._PREFIX_."forum where active='1' order by displayorder ASC");
      $forums="";
       while($fetchf=$DB->fetch_array($query))
       {
             $mforums[$fetchf[mainid]][$fetchf[displayorder]][$fetchf[forumid]]=$fetchf;
       }
while(list($forumidinfo,$foruminf) = each ($mforums[-1]))
{
                foreach($foruminf as $forumidinfo => $foruminfo)
                {
                     $mainforum=$foruminfo;
                $forum=$mainforum;
                  $forums.= $TP->GetTemp('search_options_forum');
                             if(is_array($mforums[$forumidinfo]))
                             {
                               foreach($mforums[$forumidinfo] as $r => $t)
                               {
                                    foreach($t as $subforumid => $subforuminfo)
                                    {
                                        $forum = $subforuminfo;
                                        $forum['title']='&nbsp;&nbsp;&nbsp;&nbsp;'.$forum['title'];
                                        $forums.=$TP->GetTemp('search_options_forum');
                                    }
                               }
                             }
               }
}
 $TP->webtemp('search');

}
elseif($arbb->input['do']=='do_search')
{

if($arbb->input['userid']==$arbb->input['u'] && $arbb->input['userid'] > 0)
{
  $where="p.userid='".$arbb->input['userid']."'";
}
else
{
if(strlen($arbb->input['searchwords'])<4)
{

 error_message($lang['search_words_less_than_four']);

}
$arbb->input['searchwords']=str_replace(' ','%',$arbb->input['searchwords']);
$arbb->input['searchwords']=str_replace('"','\"',$arbb->input['searchwords']);
$arbb->input['searchwords']=str_replace("'","\'",$arbb->input['searchwords']);

if(strlen($arbb->input['username'])>0)
{
   if($arbb->input['matchusername']>0)
   {
     $where="p.username='".$arbb->input['username']."'";
   }
   else
   {
     $where="p.username like '%".$arbb->input['username']."%'";
   }

   $where.=' and ';
}
else
{
    $where='';
}



if($arbb->input['postthread'] == 1)
{
//if we should search the entire post and titles
  $where.="p.post like '%".$arbb->input['searchwords']."%' or p.title like '%".$arbb->input['searchwords']."%' or t.title like '%".$arbb->input['searchwords']."%'";
}
else
{
//if we should search the titles only
  $where.="p.title like '%".$arbb->input['searchwords']."%' or t.title like '%".$arbb->input['searchwords']."%'";
}


if(strlen(intval($arbb->input['numreplies']))>0 && $arbb->input['numreplies'] != 0)
{
#if the number of replies is specified
        if($arbb->input['findthreads']==1)
        {
         $where.=' and t.replycount > '.$arbb->input['numreplies'].'';
        }
        else
        {
         $where.=' and t.replycount < '.$arbb->input['numreplies'].'';
        }
}


         if(is_array($arbb->input['forums']))
         {
         $fids=implode(',',$arbb->input['forums']);
               if(!eregi('all',$fids))
               {
               $where.=" and t.forumid in ($fids)";
               }
         }

         $notinforums = get_unsearchable_forums();

        if($notinforums)
        {
                $where .= ' AND t.forumid NOT IN ('.$notinforums.')';
        }
}
        $sortby='t.lastpost';
        $orderby = 'desc';
        $sort=array('username','lastpost','forumid');
        $order = array('asc','desc');

         if(in_array($arbb->input['sortby'],$sort))
         {
          $sortby="t.".$arbb->input['sortby'];
         }
         if(in_array($arbb->input['orderby'],$order))
         {
          $sortby=$arbb->input['orderby'];
         }

$where.=" order by $sortby $orderby";


if($arbb->input['resulttype']=='threads')
{

$query = $DB->query("select t.*,p.post,p.title as posttitle,p.username from "._PREFIX_."thread t left join "._PREFIX_."post p on (p.threadid=t.threadid) where $where");

         if($DB->num_rows($query) == 0)
         {
         error_message($lang['search_has_no_results']);

         }
         else
         {
         $comma     = '';
         $threadids = '';

                       while($s=$DB->fetch_array($query))
                       {

                       $threadids.=$comma.$s['threadid'];
                       $comma=',';
                       }

         }

}
else
{

$query = $DB->query("select p.*,t.forumid,t.replycount,t.lastpost,t.postusername from "._PREFIX_." post p LEFT JOIN thread t on (t.threadid=p.threadid) where $where");

         if($DB->num_rows($query) == 0)
         {
         error_message($lang['search_has_no_results']);

         }
         else
         {
         $comma='';
         $postids='';

                     while($s=$DB->fetch_array($query))
                     {

                     $postids.=$comma.$s['postid'];
                     $comma=',';
                     }

         }

}

      $search_ins=array('uid'         => $local['userid'],
                        'dateline'    => TIMENOW,
                        'ipaddress'   => $local['ipaddress'],
                        'threads'     => $threadids,
                        'posts'       => $postids,
                        'searchtype'  => $arbb->input['resulttype'],
                        'resulttype'  => $arbb->input['resulttype'],
                        'querycache'  => '');
        $query = $DB->multible_insert($search_ins,'search');

        $sid=$DB->insert_id($query);
        redirect($lang['search_done'],'search.php?do=results&searchid='.$sid);



//Finally finished ,,
}
else
{
 error_message($lang['wrong_page']);
}


   $titleetc=$lang['search_engine'].' - ';
   print_page();
?>