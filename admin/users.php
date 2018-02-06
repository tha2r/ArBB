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
#    Admin Users manager File Started
#
/*
        File name       -> users.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'users_edit,users_moderate_userbit,users_moderate,users_mailform,users_search_result_userbit,users_search_result,users_search,users_addban,users_viewban,users_viewban_userbit';

$phrasearray=array('admincp','profile','contactus','search','register','memberlist','usercp');

require('global.php');
$arbb->input['do']=($arbb->input['do'])?$arbb->input['do']:'search';
build_nav_location($lang['adminmenu_usersmanager'],"users.php?sid=$sid");

if($arbb->input['do']=='generate')
{
$emails='';
$query = $DB->query('select email from '._PREFIX_.'users');
 while($u = $DB->fetch_array($query))
 {
   $comma=($emails)?",\n":'';
   $emails.=$comma.$u['email'];
 }
        header('content-type:application/octet-stream');
        header('Content-disposition:attachment; filename=emails.txt');
        header("Content-length: ".strlen($emails)."");
        header('Pragma: no-cache');
        header('Expires: 0');
        die($emails);
}
elseif($arbb->input['do']=='sendmail')
{
$query=$DB->query("select * from "._PREFIX_."usergroup");
$groupsoptions="<option value=\"all\">- - - $lang[all_groups] - - -</option>";
while($group = $DB->fetch_array($query))
{
 $groupsoptions.="<option value=\"$group[usergroupid]\">$group[title]</option>";
}
    $titleetc=$lang['adminmenu_mailusers'].' - ';
    $TP->webtemp('users_mailform');

}
elseif($arbb->input['do']=='do_sendmail')
{
$from     = $arbb->input['from'];
$subject  = $arbb->input['subject'];
$message  = $arbb->input['message'];
$perround = $arbb->input['perround'];
$page     = ($arbb->input['page'])?$arbb->input['page']:1;
$contents = "";

$where = ($arbb->input['group'] == 'all')?'':"where usergroupid='".checkval($arbb->input['group'])."'";

$qu=$DB->query('select * from '._PREFIX_."users $where");
$num=$DB->num_rows($qu);

                  $end=$page*$perround;
                  $start=$end-$perround;
                  $limit=$start.','.$perround;
                  $i=$start;

$nextpage=$page+1;
$pages=ceil($num/$perround);

$query=$DB->query('select * from '._PREFIX_."users $where limit $limit");
       $i=$start;

       while($u = $DB->fetch_array($query))
       {
        $i++;
        $arr    = array('{uid}','{username}','{email}','{btitle}','{burl}');
        $reparr = array($u['userid'],$u['username'],$u['email'],$options['sitetitle'],$options['address']);
        $msg=str_replace($arr,$reparr,$message);

         sendmail($u['email'], $subject, $msg,$from, $u['username'],true);
        $contents.="[$i] ".$lang['mailing'].' : '.$u['username'].' -> '.$lang['done']."<br>\n";
       }

if($pages < $nextpage)
{

 $value="  $lang[done]  ";
 $formaction='users.php?do=sendmail';

}
else
{

 $value="  $lang[next_page] $nextpage / $pages  ";
 $formaction="users.php?do=do_sendmail&page=$nextpage&perround=$perround";

}
       $options['webcontent'].="$contents";
       $options['webcontent'].="<br>\n<br>\n".'<form action="'.$formaction.'" method="post">
                                 '."<input type=\"hidden\" name=\"subject\" value=\"$subject\">\n
                                    <input type=\"hidden\" name=\"from\" value=\"$from\">\n
                                    <input type=\"hidden\" name=\"message\" value=\"$message\">\n
                                    <input type=\"hidden\" name=\"group\" value=\"".$arbb->input['group']."\">\n".'
                                 <table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
                                 <tr class="tcat"><td align="center">'.
                                 "<input type=\"submit\" value=\"$value\">"
                                 .'</td></tr></table></form>
                                 <div align="center">
                                 <br><br>
                                         <div class="smallfont" align="center">'."
                                         $lang[powered_by]".'
                                         </div>
                                         <div class="smallfont" align="center">'."
                                         $options[copyright_text]".'
                                         </div>
                                 </div>
                                 ';
}
elseif($arbb->input['do']=='ban')
{
$titleetc=$lang['adminmenu_banuser'].' - ';
$groupsoptions='';
 $query = $DB->query("select * from "._PREFIX_."usergroup where isbanned='1'");
     while($ug = $DB->fetch_array($query))
     {
        $groupsoptions.="<option value=\"$ug[usergroupid]\">$ug[title]</option>";
     }
$TP->WebTemp('users_addban');

}
elseif($arbb->input['do']=='do_ban')
{
 $titleetc = $lang['adminmenu_banuser'].' - ';
 $username = $DB->escape_string($arbb->input['username']);
 $userid   = checkval($arbb->input['userid']);
 $groupid  = $DB->escape_string($arbb->input['groupid']);
 if(!$groupid)
 {
  $groupid=8;
 }
 if($userid > 0)
 {
  $where = "userid='$userid'";
 }
 else
 {
  $where = "username='$username'";
 }

 $u=$DB->query_now("select * from "._PREFIX_."users where $where");
 if(!$u)
 {
    error_message($lang['user_not_exists']);
 }
 $DB->query("update "._PREFIX_."users set usergroupid='$groupid' where userid='$u[userid]'");

 redirect($lang['user_banned'],"users.php?do=viewban&sid=$sid");

}
elseif($arbb->input['do']=='delete_ban')
{
 $titleetc=$lang['lift_ban'].' - ';
 $uid=checkval($arbb->input['uid']);
 $DB->query("update "._PREFIX_."users set usergroupid='2' where userid='$uid'");
 redirect($lang['userban_removed'],"users.php?do=viewban&sid=$sid");
}
elseif($arbb->input['do']=='viewban')
{
$titleetc=$lang['adminmenu_viewbanedusers'].' - ';
 $query = $DB->query("select * from "._PREFIX_."usergroup where isbanned='1'");
 $ugids = array();
 $ugs   = array();

     while($ug = $DB->fetch_array($query))
     {

      $ugs[$ug['usergroupid']]=$ug;
      $ugids[]=$ug['usergroupid'];
     }

 $bannedusers='';

$quer=$DB->query("select * from "._PREFIX_."users where usergroupid in(".implode(",",$ugids).")");
while($u = $DB->fetch_array($quer))
{

$i++;
$u['title']=$ugs[$u['usergroupid']][title];
$bannedusers.=$TP->GetTemp("users_viewban_userbit");
$i=($i=1)?1:0;
}

$TP->WebTemp('users_viewban');

}
elseif($arbb->input['do']=='search')
{
$query=$DB->query("select * from "._PREFIX_."usergroup");
$groupsoptions="<option value=\"all\">- - - $lang[all_groups] - - -</option>";
while($group = $DB->fetch_array($query))
{
 $groupsoptions.="<option value=\"$group[usergroupid]\">$group[title]</option>";
}
$titleetc=$lang['adminmenu_usersearch'].' - ';
        $TP->webtemp('users_search');

}
elseif($arbb->input['do']=='do_search')
{
         $sortbyarray  = array('username',
                               'joindate',
                               'posts',
                               'lastactivity');

         $orderarray   = array('ASC',
                               'DESC');

         $sort         = $sortbyarray[0];
         $order        = $orderarray[1];

         $user         = $arbb->input['user'];
         $search       = '';
         $page         = (checkval($arbb->input['page'])>0)?$arbb->input['page']:1;
         $perpage      = (checkval($arbb->input['perpage'])>0)?$arbb->input['perpage']:30;

         $usersbits    = '';
         $hiddeninputs = '';

         $searchfields = array('username',
                               'usergroupid',
                               'email',
                               'homepage',
                               'icq',
                               'aim',
                               'yahoo',
                               'msn');

         if(in_array($arbb->input['sortby'],$sortbyarray))
         {
           $sort=$arbb->input['sortby'];
         }

         if(in_array($arbb->input['order'],$orderarray))
         {
           $order=$arbb->input['order'];
         }


      foreach($searchfields as $key => $val)
      {
       if(strlen($user[$val])>0)
       {
         if(!(($val == 'homepage')&&($user[$val] == 'http://')) AND ! (($val == 'usergroupid') && $user[$val]=='all'))
         {
           $andd          = ($search)?' and':'';
           $search       .= $andd." $val='".$user[$val]."'";
           $hiddeninputs .= "\n\t".'<input type="hidden" name="user['.$val.']" value="'.$user[$val].'">';
         }
       }
      }

     if(strlen($search)>0)
     {

             $search = 'where'.$search;
     }

      $end    = $page*$perpage;
      $start  = $end-$perpage;
      $limit  = $start.','.$perpage;
      $q   = $DB->query('select * from '._PREFIX_."users $search");
      $num = $DB->num_rows($q);

      $pages = ceil($num / $perpage);


      $prevpage = $page - 1;
      $nextpage = $page + 1;

      $query=$DB->query("select * from "._PREFIX_."users $search order by $sort $order limit $limit");
      while($user = $DB->fetch_array($query))
      {
      foreach($user AS $key => $value)
      {
       $user[$key]=$bbcode->clearhtml($value);
      }
       $user['joindate']=mydate($user['joindate'],'date');
       $user['lastactivity']=mydate($user['lastactivity'],'date');

       $usersbits .= $TP->GetTemp('users_search_result_userbit');
      }
         $buttons=array();
      if($arbb->input['limited'] != 1)
      {
       if($prevpage >= 1)
       {
         $pvalue    = "  $lang[previus_page] $prevpage / $pages  ";
         $buttons[] = "<input type=\"button\" value=\"$pvalue\" onclick=\"javascript:history.back();\">";
       }
       if($nextpage <= $pages)
       {
         $nvalue    = "  $lang[next_page] $nextpage / $pages  ";
         $buttons[] = "<input type=\"submit\" value=\"$nvalue\">";
       }

       $pagenav = implode('&nbsp;&nbsp; - &nbsp;&nbsp;',$buttons);
      }
      else
      {
       $pagenav = '';
      }

      $TP->WebTemp('users_search_result');
      $titleetc=$lang['search_results'].' - ';
}
elseif(
        ($arbb->input['do']=='delete')
                                       OR
                                          ($arbb->input['do']=='do_delete')
      )
{
  $userid=checkval($arbb->input['userid']);
  $user = $DB->query_now("select * from "._PREFIX_."users where userid='$userid'");
    if(!$user)
    {
      error_message($lang['user_not_exists']);
    }
  if(strlen($uneditableusers) > 0)
  {
   $ex = explode(',',$uneditableusers);
   if(in_array($user['userid'],$ex))
   {
   error_message($lang['user_not_deletable_editable']);
   }
  }
  $user['username']=$bbcode->clearhtml($user['username']);

   if($arbb->input['do'] == 'delete')
   {
    $TP->WebTemp('users_delete');
   }
   else
   {
    $DB->query("DELETE from "._PREFIX_."users where userid='$user[userid]'");
    redirect($lang['user_deleted'],"users.php?sid=$sid");
   }
}
elseif($arbb->input['do']=='edit')
{
$query=$DB->query('select * from '._PREFIX_.'usergroup');
  $userid=checkval($arbb->input['userid']);
  $user = $DB->query_now('select * from '._PREFIX_."users where userid='$userid'");
    if(!$user)
    {
      error_message($lang['user_not_exists']);
    }
$sel=array('autosubscribe' => array('yes' => '','no' => ''),
           'showbbcode' => array('yes' => '','no' => ''),
           'showsignature' => array('yes' => '','no' => ''),
           'showbirthday' => array('yes' => '','no' => ''),
           'pmpopup' => array('yes' => '','no' => ''));

foreach($sel as $key => $val)
{

 if($user[$key] == 1)
 {
  $sel[$key.'yes']='checked';
  $sel[$key.'no']='';
 }
 else
 {
  $sel[$key.'yes'] = '';
  $sel[$key.'no']  = 'checked';
 }

}

$stq=$DB->query('select * from '._PREFIX_.'styles');

while($sty=$DB->fetch_array($stq))
{

  $selected      = ($local['styleid']==$sty['styleid'])?' selected':'';
  $styleoptions .= "<option value=\"$sty[styleid]\"$selected>$sty[title]</option>";

}

foreach($user AS $key => $value)
{
 $user[$key]=$bbcode->clearhtml($value);
}
$groupoptions="";
while($group = $DB->fetch_array($query))
{
$selected=($group['usergroupid'] == $user['usergroupid'])?'selected':'';

 $groupoptions.="<option value=\"$group[usergroupid]\" $selected>$group[title]</option>";
}
  $TP->WebTemp('users_edit');
}
elseif($arbb->input['do']=='do_edit')
{
       $user = array('username'      => $arbb->input['username'],
                     'email'         => $arbb->input['email'],
                     'usergroupid'   => $arbb->input['usergroupid'],
                     'pmpopup'       => $arbb->input['pmpopup'],
                     'posts'         => $arbb->input['posts'],
                     'ipaddress'     => $arbb->input['ipaddress'],
                     'styleid'       => $arbb->input['styleid'],
                     'homepage'      => $arbb->input['homepage'],
                     'icq'           => $arbb->input['icq'],
                     'yahoo'         => $arbb->input['yahoo'],
                     'msn'           => $arbb->input['msn'],
                     'aim'           => $arbb->input['aim'],
                     'showsignature' => $arbb->input['showsignature'],
                     'showbbcode'    => $arbb->input['showbbcode'],
                     'signature'     => $arbb->input['signature'],
                     'showbirthday'  => $arbb->input['showbirthday'],
                     'birthday'      => $arbb->input['birthday'],
                     'autosubscribe' => $arbb->input['autosubscribe']);

   if(strlen($arbb->input['new_password'])>0)
   {
        $user['password']=md5($arbb->input['new_password']);
   }
   $userid=checkval($arbb->input['userid']);


foreach($user as $key => $val)
{
 $user[$key]=$DB->escape_string($val);
}
    $DB->update($user,'users',"userid='$userid'");
    redirect($lang['user_updated'],"users.php?sid=$sid");
}
elseif($arbb->input['do']=='moderate')
{
// Edit this !!
$quer=$DB->query("select * from "._PREFIX_."users where usergroupid='4'");
while($u = $DB->fetch_array($quer))
{
$i++;
$u['username']=$bbcode->clearhtml($u['username']);
$u['date']=mydate($u['joindate'],'date');
$modusers.=$TP->GetTemp("users_moderate_userbit");
$i=($i=1)?1:0;
}

$TP->WebTemp('users_moderate');
}
elseif($arbb->input['do']=='do_moderate')
{

    redirect($lang['user_updated'],"users.php?sid=$sid");
}

if(!$titleetc)
{
    $titleetc=$lang['adminmenu_usersmanager'].' - ';
}
print_page();
?>