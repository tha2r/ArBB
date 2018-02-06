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
#    Admin Users Groups manager File Started
#
/*
        File name       -> usergroups.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'usergroups_manage,
                 usergroups_add,
                 forums_permissions,
                 usergroups_manage_group,
                 usergroups_edit';

$phrasearray=array('admincp');

require('global.php');
$arbb->input['do']=($arbb->input['do'])?$arbb->input['do']:'manage';
build_nav_location($lang['adminmenu_usergroup'],'users.php?sid=$sid');

if($arbb->input['do']=='manage')
{
$query = $DB->query('select * from '._PREFIX_.'usergroup');

$primarygroups   = '';
$secondarygroups = '';

   while($ug = $DB->fetch_array($query))
   {
    $primarygroups   .= ($ug['usergroupid'] < 9)?$TP->GetTemp('usergroups_manage_group'):'';
    $show['subgroup'] = ($ug['usergroupid'] < 9)?0:1;
    $secondarygroups .= ($ug['usergroupid'] > 8)?$TP->GetTemp('usergroups_manage_group'):'';
   }

$TP->WebTemp('usergroups_manage');
}
elseif(($arbb->input['do']=='delete') OR ($arbb->input['do']=='do_delete'))
{
$gid=$arbb->input['gid'];
if($gid < 9)
{
 error_message($lang['cant_delete_primary_group']);
}

$ug=$DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='$gid'");
if(!$ug)
{
 error_message($lang['usergroup_not_exists']);
}

 if($arbb->input['do']=='delete')
 {
  $TP->webtemp('usergroups_delete');
 }
 else
 {
  $DB->query("delete from "._PREFIX_."usergroup where usergroupid='$gid'");
  $DB->query("update "._PREFIX_."users set usergroupid='2' where usergroupid='$gid'");
  redirect($lang['usergroup_deleted'],"usergroups.php?sid=$sid");
 }

}
elseif($arbb->input['do']=='edit')
{
$gid=$arbb->input['gid'];
$checked=array();
$ug=$DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='$gid'");
if(!$ug)
{
 error_message($lang['usergroup_not_exists']);
}
 foreach($ug as $key => $val)
 {
 $ug[$key]=$bbcode->clearhtml($val);
  $checked[$key.$val]='checked';
 }

$TP->WebTemp('usergroups_edit');

}
elseif($arbb->input['do']=='do_edit')
{

$groupid=$arbb->input['groupid'];

$query=$DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='$groupid'");
if(!$query)
{
 error_message($lang['usergroup_not_exists']);
}
$array = array('title'           => $arbb->input['title'],
               'description'     => $arbb->input['description'],
               'usertitle'       => $arbb->input['usertitle'],
               'pmquota'         => $arbb->input['pmquota'],
               'pmsendmax'       => $arbb->input['pmsendmax'],
               'opentag'         => $arbb->input['opentag'],
               'closetag'        => $arbb->input['closetag'],
               'isforumteam'     => $arbb->input['isforumteam'],
               'canviewforum'    => $arbb->input['canviewforum'],
               'canviewthreads'  => $arbb->input['canviewthreads'],
               'candownattach'   => $arbb->input['candownattach'],
               'canviewcontent'  => $arbb->input['canviewcontent'],
               'canviewonline'   => $arbb->input['canviewonline'],
               'canviewip'       => $arbb->input['canviewip'],
               'cansearch'       => $arbb->input['cansearch'],
               'canviewcalendar' => $arbb->input['canviewcalendar'],
               'caneditevents'   => $arbb->input['caneditevents'],
               'canaddevents'    => $arbb->input['canaddevents'],
               'canpost'         => $arbb->input['canpost'],
               'caneditpost'     => $arbb->input['caneditpost'],
               'candelposts'     => $arbb->input['candelposts'],
               'canratethread'   => $arbb->input['canratethread'],
               'canpostattach'   => $arbb->input['canpostattach'],
               'caneditattach'   => $arbb->input['caneditattach'],
               'canusepm'        => $arbb->input['canusepm'],
               'canaddpoll'      => $arbb->input['canaddpoll'],
               'canvotepoll'     => $arbb->input['canvotepoll'],
               'candelpoll'      => $arbb->input['candelpoll'],
               'caneditpoll'     => $arbb->input['caneditpoll'],
               'ismoderator'     => $arbb->input['ismoderator'],
               'canuseadmincp'   => $arbb->input['canuseadmincp'],
               'canusemodcp'     => $arbb->input['canusemodcp'],
               'canuseusercp'    => $arbb->input['canuseusercp'],
               'isbanned'        => $arbb->input['isbanned'],
               'attachlimit'     => $arbb->input['attachlimit'],
               'avatarmaxwidth'  => $arbb->input['avatarmaxwidth'],
               'avatarmaxheigh'  => $arbb->input['avatarmaxheigh'],
               'avatarmaxsize'   => $arbb->input['avatarmaxsize'],
               'sigmaximages'    => $arbb->input['sigmaximages']);
foreach($array as $key => $val)
{
 if($val == 'yes' OR $val == 'no')
 {
  $array[$key]=($val=='yes')?1:0;
 }
}

$DB->update($array,'usergroup',"usergroupid='$groupid'");
redirect($lang['usergroup_edited'],"usergroups.php?sid=$sid");

}
elseif($arbb->input['do']=='permissions')
{
    $titleetc=$lang['adminmenu_editpermission']." - ";
$fq  = $DB->query("select * from "._PREFIX_."forum");
$fpq = $DB->query("select * from "._PREFIX_."forumpermission");
$ugq = $DB->query("select * from "._PREFIX_."usergroup");

$usergroups       = array();
$forumpermissions = array();
$forums           = array();
$forumsbits       = "";

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
elseif($arbb->input['do']=='add')
{
$titleetc=$lang['add_usergroup'].' - ';
$checked=array();
$ug=$DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='2'");
if(!$ug)
{
 error_message($lang['usergroup_not_exists']);
}
 foreach($ug as $key => $val)
 {
 $ug[$key]=$bbcode->clearhtml($val);
  $checked[$key.$val]='checked';
 }
$TP->WebTemp('usergroups_add');
}
elseif($arbb->input['do']=='do_add')
{
$array = array('title'           => $arbb->input['title'],
               'description'     => $arbb->input['description'],
               'usertitle'       => $arbb->input['usertitle'],
               'pmquota'         => $arbb->input['pmquota'],
               'pmsendmax'       => $arbb->input['pmsendmax'],
               'opentag'         => $arbb->input['opentag'],
               'closetag'        => $arbb->input['closetag'],
               'isforumteam'     => $arbb->input['isforumteam'],
               'canviewforum'    => $arbb->input['canviewforum'],
               'canviewthreads'  => $arbb->input['canviewthreads'],
               'candownattach'   => $arbb->input['candownattach'],
               'canviewcontent'  => $arbb->input['canviewcontent'],
               'canviewonline'   => $arbb->input['canviewonline'],
               'canviewip'       => $arbb->input['canviewip'],
               'cansearch'       => $arbb->input['cansearch'],
               'canviewcalendar' => $arbb->input['canviewcalendar'],
               'caneditevents'   => $arbb->input['caneditevents'],
               'canaddevents'    => $arbb->input['canaddevents'],
               'canpost'         => $arbb->input['canpost'],
               'caneditpost'     => $arbb->input['caneditpost'],
               'candelposts'     => $arbb->input['candelposts'],
               'canratethread'   => $arbb->input['canratethread'],
               'canpostattach'   => $arbb->input['canpostattach'],
               'caneditattach'   => $arbb->input['caneditattach'],
               'canusepm'        => $arbb->input['canusepm'],
               'canaddpoll'      => $arbb->input['canaddpoll'],
               'canvotepoll'     => $arbb->input['canvotepoll'],
               'candelpoll'      => $arbb->input['candelpoll'],
               'caneditpoll'     => $arbb->input['caneditpoll'],
               'ismoderator'     => $arbb->input['ismoderator'],
               'canuseadmincp'   => $arbb->input['canuseadmincp'],
               'canusemodcp'     => $arbb->input['canusemodcp'],
               'canuseusercp'    => $arbb->input['canuseusercp'],
               'isbanned'        => $arbb->input['isbanned'],
               'attachlimit'     => $arbb->input['attachlimit'],
               'avatarmaxwidth'  => $arbb->input['avatarmaxwidth'],
               'avatarmaxheigh'  => $arbb->input['avatarmaxheigh'],
               'avatarmaxsize'   => $arbb->input['avatarmaxsize'],
               'sigmaximages'    => $arbb->input['sigmaximages']);
foreach($array as $key => $val)
{
 if($val == 'yes' OR $val == 'no')
 {
  $array[$key]=($val=='yes')?1:0;
 }
}
   $DB->multible_insert($array,'usergroup');
   redirect($lang['usergroup_added'],"usergroups.php?sid=$sid");
}

if(!$titleetc)
{
    $titleetc=$lang['adminmenu_usergroup'].' - ';
}
print_page();
?>