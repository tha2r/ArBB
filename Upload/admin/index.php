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
#    admin Control panel File started
#
/*
        File name       -> index.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'main,head,main_page,menu,menu_sub,menu_cat';

$phrasearray=array('admincp');

require('global.php');
$cpstyle['dir']='default';
$show['location_bar']=0;
if(empty($arbb->input['action']))
{

    $TP->webtemp('main');
    $show['bodytag']=0;
}
elseif($arbb->input['action']=='head')
{
   $TP->webtemp('head');
}
elseif($arbb->input['action']=='main')
{
$show['location_bar']=1;
$st=array();
$st = $DB->query_now('select * from '._PREFIX_.'stats');
$attach  = $DB->query_now('select count(*) as attachments,sum(filesize) as attachmentsspace from '._PREFIX_.'attachment');

$ex=explode(' ',IN_ARBB);
$st['arbb']=implode(' ',$ex);
$st['attachments']      = $attach['attachments'];
$st['attachmentsspace'] = checkval($attach['attachmentsspace']);
$st['mysql']            = mysql_get_server_info();
$st['php']              = phpversion();


 $TP->webtemp('main_page');

}
elseif($arbb->input['action']=='menu')
{

$menu  = array();
$menus = '';
$query=$DB->query('select * from '._PREFIX_.'adminmenu order by disporder');
while($m = $DB->fetch_array($query))
{
 $menu[$m[cat]][$m[disporder]][$m[mid]]=$m;
}

while(list($mid,$m) = each($menu[-1]))
{
        $catcontents='';
        $cat=array();
  foreach($m as $key => $val)
  {
    $cat=$val;

    $cat['name']=$lang['adminmenu_'.$cat['name']];
  if(is_array($menu[$cat[mid]]))
  {
    foreach($menu[$cat[mid]] as $disp => $midarray)
    {
     while(list($id,$sub) = each($midarray))
     {
      $sub['name']=$lang['adminmenu_'.$sub['name']];
      $sub['url'] = (eregi('&',$sub['url'])||eregi('=',$sub['url']))?$sub['url'].'&sid='.$sid:$sub['url'].'?sid='.$sid;
      $catcontents .= $TP->GetTemp('menu_sub');
     }
    }
  }
$nonedisp='none';
$src='expand';

if(($cat['mid']==1)||($arbb->input['nojs']==1))
{
   $nonedisp='';
   $src='collapse';
}
$langexpcoll=$lang[$src];
    $menus.=$TP->GetTemp('menu_cat');
  }
}
 $TP->webtemp('menu');
}
elseif($arbb->input['action']=='phpinfo')
{
 phpinfo();
 die();
}



print_page();
?>