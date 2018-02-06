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
#    Admin Forums manager File Started
#
/*
        File name       -> forums.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'forums_add,forums_mod_delete,forums_mod_edit,forums_mod_manager,forums_mod_manager_modbit,forums_add_moderator,forums_permissions,forums_edit_grouppermissions,forums_manager,forums_edit,forums_delete,forums_manager_forumbit';

$phrasearray=array('admincp','forumdisplay','showthread');

require('global.php');
$arbb->input['do']=($arbb->input['do'])?$arbb->input['do']:'manage';

build_nav_location($lang['adminmenu_forummanager'],"forums.php?sid=$sid");

if(($arbb->input['do']=='add')||($arbb->input['do']=='edit'))
{
$query=$DB->query('select * from '._PREFIX_.'forum');
$forumsoptions="<option value=\"-1\" class=\"td2\"> ------- $lang[all_forums] ------ </option>";
$forums='';
while($f=$DB->fetch_array($query))
{
   $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
}

$forumid=$arbb->input['forumid'];
$sforumid=($forumid)?$forumid:'-';
    $titleetc=$lang['adminmenu_addforum'].' - ';
if($arbb->input['do']=='edit')
{
    $titleetc=$lang['edit'].' '.$lang['forum'].' - ';
        $sort=array();
        $checked=array();
$forumid=$arbb->input['fid'];
 $forum=$DB->query_now("select * from "._PREFIX_."forum where forumid='$forumid'");

 $sforumid=$forum['mainid'];
 if(!$forum)
 {
  error_message('');
 }
 $sort[$forum[sortfield]]='selected';
 $ar=array('canusepassword','isforum','active','open');
 foreach($ar as $key => $val)
 {
 $vall=($forum[$val]==1)?'yes':'no';
  $checked[$val.'_'.$vall]='checked';
 }

}

    while(list($disprder,$info) = each($forums[-1]))
    {

     foreach($info as $id => $f)
     {
       $sel=($f['forumid']==$sforumid)?'selected':'';

       $forumsoptions.="\n<option value=\"$f[forumid]\" class=\"td2\" $sel>[$f[title]]</option>\n";
       if(is_array($forums[$id]))
       {
               $sel="";
        $jumpforums="";
        $forumsoptions.=forumjump_tree($forums,$id,'0',$sforumid,'-&nbsp;');
       }
     }
    }

 $TP->webtemp('forums_'.$arbb->input['do']);
}
elseif(($arbb->input['do']=='do_add')||($arbb->input['do']=='do_edit'))
{
 $inserted=array();
 $array=array('title','description','link','displayorder','mainid','canusepassword','password','sortfield','open','active','isforum');
 foreach($array as $key => $val)
 {
  $inserted[$val]=$DB->escape_string($arbb->input[$val]);
 }
 if(empty($inserted['title']))
 {
 error_message($lang['fill_all_required_fields']);
 }
 $ar=array('isforum','active','open','canusepassword');
 foreach($ar as $key => $val)
 {
  $inserted[$val]=($inserted[$val]=='yes')?1:0;
 }

 if($arbb->input['do']=='do_add')
 {
   $query = $DB->multible_insert($inserted,'forum');
   $fid   = $DB->insert_id();

   $parentlist = makeparentlist($fid);
   $DB->query("update "._PREFIX_."forum set parentlist='$parentlist' where forumid='$fid'");
   $phrase = 'forum_added';
 }
 else
 {

   $fid=$arbb->input['fid'];

   $updates='';
   $parentlist = makeparentlist($fid);
   $inserted['parentlist']=$parentlist;
   foreach($inserted as $key => $val)
   {
    $comma=($updates)?',':'';
    $updates.=$comma."$key='$val'";
   }
   $DB->query("update "._PREFIX_."forum set $updates where forumid='$fid'");

   $phrase = 'forum_edited';

 }


 redirect($lang[$phrase],"forums.php?sid=$sid");

}
elseif($arbb->input['do']=='manage')
{

$query=$DB->query("select * from "._PREFIX_."forum order by displayorder ASC");
$forumsbits='';
$forums=array();
while($f=$DB->fetch_array($query))
{
$forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
}
reset($forums);

while(list($disporder,$f) = each($forums[-1]))
{
  foreach($f as $fid => $forum)
  {
  $i=2;
  $show['cutoff']=1;
  $forumsbits .= $TP->GetTemp('forums_manager_forumbit');

         if(is_array($forums[$fid]))
         {
           $forumsbits  .= build_forumbits($forums,$forum['forumid'],'- - ');
         }
  }
}

$TP->webtemp('forums_manager');
}
elseif($arbb->input['do']=='delete')
{
    $titleetc=$lang['delete'].' '.$lang['forum'].' - ';
  $forumid=$arbb->input['forumid'];
 $query=$DB->query("select * from "._PREFIX_."forum where forumid='$forumid'");
 while($forum=$DB->fetch_array($query))
 {
  $TP->WebTemp('forums_delete');
 }
}
elseif($arbb->input['do']=='do_delete')
{

  $forumid   = $arbb->input['forumid'];
  $forums    = '';
  $threads   = '';
  $posts     = '';
  $forum     = array();
  $usercount = array();
  $polls     = array();

  $query   = $DB->query("select forumid from "._PREFIX_."forum where parentlist like '%$forumid%'");
  while($f = $DB->fetch_array($query))
  {
    if($f['forumid']==$forumid)
    {
     $forum=$f;
    }
    $comma=($forums)?',':'';
    $forums.=$comma.$f['forumid'];
  }

if(strlen($forums)>0)
{
   $tquery=$DB->query("select threadid from "._PREFIX_."thread where forumid in ($forums)");
   while($t = $DB->fetch_array($tquery))
   {
    $comma=($threads)?',':'';
    $threads.=$comma.$t['threadid'];
    if($t['pollid'] != 0)
    {
      $polls[]=$t['pollid'];
    }
   }
}
if(strlen($threads)>0)
{
   $pquery=$DB->query("select userid,postid from "._PREFIX_."post where threadid in($threads)");
   while($p = $DB->fetch_array($pquery))
   {
    $comma=($posts)?',':'';
    $posts.=$comma.$p['postid'];
    if(!isset($usercount[$p['userid']]))
    {
       $usercount[$p['userid']]=-1;
    }
    else
    {
       $usercount[$p['userid']]--;
    }
   }
}

   if(strlen($threads)>0)
   {
    $DB->query("DELETE FROM "._PREFIX_."thread where threadid IN ($threads)");
    $DB->query("DELETE FROM "._PREFIX_."threadrate threadid IN ($threads)");
    $DB->query("DELETE FROM "._PREFIX_."threadsubscribe threadid IN ($threads)");
   }
   if(strlen($posts)>0)
   {
    $DB->query("DELETE FROM "._PREFIX_."posts where postid IN ($posts)");
    $DB->query("DELETE FROM "._PREFIX_."attachment WHERE postid IN ($posts)");
   }

   if (is_array($usercount))
   {
     while(list($userid,$count)=each($usercount))
     {
       $DB->query("UPDATE "._PREFIX_."users SET posts=posts$count WHERE userid='$userid'");
     }
   }
   if(is_array($polls))
   {
    $pollids=implode(",",$polls);
    if(strlen($pollids)>0)
    {
    $DB->query("DELETE FROM "._PREFIX_."poll WHERE pollid in ($pollids)");
    $DB->query("DELETE FROM "._PREFIX_."pollvote WHERE pollid in ($pollids)");
    }
   }


   if(strlen($forums)>0)
   {
    $DB->query("DELETE FROM "._PREFIX_."forum where forumid in ($forums)");
    $DB->query("DELETE FROM "._PREFIX_."forumpermission where forumid in ($forums)");
    $DB->query("DELETE FROM "._PREFIX_."forumread where forumid in ($forums)");
    $DB->query("DELETE FROM "._PREFIX_."moderator where forumid in ($forums)");
    $DB->query("DELETE FROM "._PREFIX_."announcement where forumid in ($forums)");
   }

       $ex=explode(',',$forum['parentlist']);
       $ar=array_sum($ex);

       for($i=0;$i<=$ar;$i++)
       {
          if($ex[$i] != $forum['forumid'])
          {
           updateforumcount($ex[$i]);
          }
       }


   updatestats();
   redirect($lang['forum_deleted'],"forums.php?sid=$sid");

}
elseif($arbb->input['do']=='editpermission')
{
    $titleetc=$lang['adminmenu_editpermission'].' - ';
$fq  = $DB->query('select * from '._PREFIX_.'forum');
$fpq = $DB->query('select * from '._PREFIX_.'forumpermission');
$ugq = $DB->query('select * from '._PREFIX_.'usergroup');

$usergroups       = array();
$forumpermissions = array();
$forums           = array();
$forumsbits       = '';

                while($usergroup = $DB->fetch_array($ugq))
                {
                        $usergroups[$usergroup['usergroupid']] = $usergroup;
                }
                while($forumpermission = $DB->fetch_array($fpq))
                {
                        $forumpermissions[$forumpermission['forumid']][$forumpermission['usergroupid']] = $forumpermission;
                }
                while($forum = $DB->fetch_array($fq))
                {
                        $forums[$forum['mainid']][$forum['displayorder']][$forum['forumid']] = $forum;
                }


$forumsbits = build_permission_forumsbits();


$TP->webtemp('forums_permissions');

}
elseif($arbb->input['do']=='editpermissions')
{
$fid=$arbb->input['fid'];
$gid=$arbb->input['gid'];
$group = $DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='$gid'");
$forum = $DB->query_now("select * from "._PREFIX_."forum where forumid='$fid'");
$perms = get_forum_group_permissions($forum,$group);
$checked=array();
if(!$perms)
{
 $group['usecustom']=0;
 $perms = $group;
}
else
{
 if($perms['usergroupid']==$group['usergroupid'])
 {
  $perms['usecustom']=1;
 }
 else
 {
  $perms['usecustom']=0;
 }
}

foreach($perms as $key => $val)
{
 $checked[$key.$val]='checked';
}
 $TP->WebTemp('forums_edit_grouppermissions');
}
elseif($arbb->input['do']=='do_editpermissions')
{
$forumid=$arbb->input['forumid'];
$groupid=$arbb->input['groupid'];

if($arbb->input['usecustom']=='no')
{
   $DB->query("DELETE FROM "._PREFIX_."forumpermission where forumid='$forumid' and usergroupid='$groupid'");
}
else
{
   $query=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$forumid' and usergroupid='$groupid'");
   $num=$DB->num_rows($query);
   $arrayed=array('canviewforum',
                  'canviewthreads',
                  'canviewcontent',
                  'candownattach',
                  'canpost',
                  'caneditpost',
                  'candelposts',
                  'canratethread',
                  'canpostattach',
                  'caneditattach',
                  'canaddpoll',
                  'canvotepoll',
                  'caneditpoll',
                  'candelpoll');

foreach($arrayed as $key => $val)
{
 $ins[$val]=($arbb->input[$val]=='yes')?'1':'0';
}

   if($num > 0)
   {
    $DB->update($ins,'forumpermission',"forumid='$forumid' and usergroupid='$groupid'");
   }
   else
   {
    $ins['forumid']=$forumid;
    $ins['usergroupid']=$groupid;
    $DB->multible_insert($ins,'forumpermission');
   }
}

redirect($lang['permissions_updated'],"forums.php?sid=$sid&do=editpermission#pers_$forumid");

}
elseif($arbb->input['do']=='add_mod')
{
$query=$DB->query("select * from "._PREFIX_."forum");
$forumsoptions='
<option value="-1" class="td2"> ------------------- </option>';
$forums='';
$forum=array();
while($f=$DB->fetch_array($query))
{
if($f['forumid']==$arbb->input['forumid'])
{
 $forum=$f;
}
   $forums[$f[mainid]][$f[displayorder]][$f[forumid]]=$f;
}
$sforumid=($forum['forumid'])?$forum['forumid']:"";
    while(list($disprder,$info) = each($forums[-1]))
    {

     foreach($info as $id => $f)
     {
       $sel=($f['forumid']==$sforumid)?'selected':'';

       $forumsoptions.="\n<option value=\"$f[forumid]\" class=\"td2\" $sel>[$f[title]]</option>\n";
       if(is_array($forums[$id]))
       {
               $sel='';
        $jumpforums='';
        $forumsoptions.=forumjump_tree($forums,$id,"0",$sforumid,"-&nbsp;");
       }
     }
    }
 $titleetc=$lang['add_moderator'].' - '.$titleetc;
 $TP->WebTemp('forums_add_moderator');
}
elseif($arbb->input['do']=='do_add_mod')
{
 $username = $arbb->input['username'];
 $forumid  = $arbb->input['forumid'];

 if($forumid == -1)
 {
  error_message($lang['not_valid_forum']);
 }

 $u=$DB->query_now("select u.*,ug.* from "._PREFIX_."users u LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid) where u.username='".$DB->escape_string($username)."'");
 if(!$u)
 {
  error_message($lang['user_not_exists']);
 }
 if($u['ismoderator'] != 1)
 {
  $DB->query("update "._PREFIX_."users set usergroupid='7' where userid='$u[userid]'");
 }

 $qu=$DB->query("select * from "._PREFIX_."moderator where userid='$u[userid]' and forumid='$forumid'");
 if($DB->num_rows($qu) > 0)
 {
  error_message($lang['moderator_already_exists']);
 }


 $ins = array('userid'         => $u['userid'],
              'forumid'        => $forumid,
              'caneditpost'    => $arbb->input['caneditpost'],
              'candelposts'    => $arbb->input['candelpost'],
              'canviewips'     => $arbb->input['canviewips'],
              'canmovethreads' => $arbb->input['canmovethreads']);


  $ch = array('caneditpost'    => $arbb->input['caneditpost'],
              'candelposts'    => $arbb->input['candelpost'],
              'canviewips'     => $arbb->input['canviewips'],
              'canmovethreads' => $arbb->input['canmovethreads']);

  foreach($ch as $key => $val)
  {
   $ins[$key]=($val=='yes')?'1':'0';
  }
 $DB->multible_insert($ins,'moderator');

 redirect($lang['moderator_added'],"forums.php?sid=$sid");

}
elseif($arbb->input['do']=='manage_mods')
{
$titleetc=$lang['manage_moderator']." - ";
$forumid=$arbb->input['forumid'];
$moderators="";
$query=$DB->query("select m.*,u.*,f.title,f.forumid from "._PREFIX_."moderator m LEFT JOIN "._PREFIX_."users u on (u.userid=m.userid) LEFT JOIN "._PREFIX_."forum f on (f.forumid=m.forumid) where m.forumid='$forumid'");
while($mod = $DB->fetch_array($query))
{
  $moderators .= $TP->GetTemp('forums_mod_manager_modbit');
  $forumtitle=$mod['title'];
  $forumid=$mod['forumid'];
}

$TP->WebTemp('forums_mod_manager');

}
elseif(($arbb->input['do']=='edit_mod')||($arbb->input['do']=='delete_mod'))
{
 $titleetc=$lang['manage_moderator'].' - ';
 $checked=array();

$modid=$arbb->input['modid'];
$query=$DB->query("select m.*,u.*,f.title,f.forumid from "._PREFIX_."moderator m LEFT JOIN "._PREFIX_."users u on (u.userid=m.userid) LEFT JOIN "._PREFIX_."forum f on (f.forumid=m.forumid) where m.modid='$modid'");
 while($mod=$DB->fetch_array($query))
 {
  $ch = array('caneditpost',
              'candelposts',
              'canviewips',
              'canmovethreads');

  foreach($ch as $key => $val)
  {

    $checked[$val.$mod[$val]]='checked';
  }

  $tp=explode('_',$arbb->input['do']);
  $TP->WebTemp('forums_mod_'.$tp[0]);
 }

}
elseif(($arbb->input['do']=='do_edit_mod')||($arbb->input['do']=='do_delete_mod'))
{

 $modid=checkval($arbb->input['modid']);

 $mod=$DB->query_now("select u.*,m.* from "._PREFIX_."moderator m LEFT JOIN "._PREFIX_."users u where (u.userid=m.userid) where m.modid='$modid'");

if(!$mod)
{
 error_message($lang['moderator_not_exists']);
}
  $ch = array('caneditpost'    => $arbb->input['caneditpost'],
              'candelposts'    => $arbb->input['candelposts'],
              'canviewips'     => $arbb->input['canviewips'],
              'canmovethreads' => $arbb->input['canmovethreads']);

  foreach($ch as $key => $val)
  {
   $ch[$key]=($val=='yes')?'1':'0';
  }
if($arbb->input['do']=='do_edit_mod')
{
  $DB->update($ch,'moderator',"modid='$mod[modid]'");
  $phrase='moderator_updated';
}
else
{
  $DB->query("delete from "._PREFIX_."moderator where modid='$mod[modid]'");
  $qu=$DB->query("select * from "._PREFIX_."moderator where userid='$mod[userid]'");
  if(($DB->num_rows($qu)<1)&&($mod['usergroupid']=='7'))
  {
   $DB->query("update "._PREFIX_."users set usergroupid='2' where userid='$mod[userid]'");
  }
  $phrase='moderator_deleted';
}

  redirect($lang[$phrase],"forums.php?sid=$sid&do=manage_mods&forumid=$mod[forumid]");
}

if(!$titleetc)
{
    $titleetc=$lang['adminmenu_forummanage'].' - ';
}
print_page();
?>