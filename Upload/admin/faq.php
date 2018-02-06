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
#    Admin Faq's manager File Started
#
/*
        File name       -> faq.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'faq_add,faq_manager,faq_manager_bit,faq_edit,faq_delete';

$phrasearray=array('admincp');

require('global.php');

build_nav_location($lang['adminmenu_faq'],'faq.php?sid=$sid');
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:'manage';

if($arbb->input['do']=='add')
{
$query = $DB->query("select * from "._PREFIX_."faq where cat='-1'");
$cats='
<option value="-1"> - - - - - - </option>';
while($faq = $DB->fetch_array($query))
{
($arbb->input['cat']==$faq['faqid'])?$sqll=' selected':$sqll='';
$cats.="<option value=\"$faq[faqid]\"$sqll>$faq[phrasetitle]</option>\n";
}
 $titleetc=$lang['adminmenu_addfaq'].' - ';
 $TP->WebTemp('faq_add');
}
elseif($arbb->input['do']=='do_add')
{
$arrayed = array('cat','phrasetitle','title','description','document');
$ins=array();
   foreach($arrayed as $key => $val)
   {
     $ins[$val]=$arbb->input[$val];
   }

   if(!((ereg("^[a-zA-Z0-9_\.\-]+$",$ins['title'])) && (ereg("^[a-zA-Z0-9_\.\-]+$",$ins['cat']))))
   {
      error_message($lang['faq_ins_error']);
   }

   $DB->insert($ins,'faq');

   redirect($lang['faq_inserted'],"faq.php?sid=$sid");

}
elseif($arbb->input['do']=='manage')
{
$query=$DB->query("select * from "._PREFIX_."faq");

   while($faq = $DB->fetch_array($query))
   {
    $faqs["$faq[cat]"]["$faq[faqid]"]=$faq;
   }
   if(is_array($faqs))
   {
   reset($faqs);
while(list($id,$faqc)=each($faqs[-1]))
{
$faqsc="";
  while(list($faqid,$faq)=each($faqs["$id"]))
  {
      ($i==2)?$i--:$i++;
    $faqsc .= $TP->GetTemp('faq_manager_bit');

  }
  $TP->WebTemp('faq_manager');
}
}
else
{
 alert($lang['error_message']);
}
  $TP->WebTemp('footer');
}
elseif($arbb->input['do']=='edit')
{
$q = $DB->query("select * from "._PREFIX_."faq where faqid='".$arbb->input['faqid']."'");
 while($faq = $DB->fetch_array($q))
 {
   $query = $DB->query("select * from "._PREFIX_."faq where cat='-1'");
   $cats='
   <option value="-1"> - - - - - - </option>';
   while($faqq = $DB->fetch_array($query))
   {
   ($faq['cat']==$faqq['faqid'])?$sqll=' selected':$sqll='';
   $cats.="<option value=\"$faqq[faqid]\"$sqll>$faqq[phrasetitle]</option>\n";
   }
    $titleetc=$lang['edit'].' : '.$faq['title'].' - ';
    $TP->WebTemp('faq_edit');
 }
}
elseif($arbb->input['do']=='do_edit')
{
$arrayed = array('cat','phrasetitle','title','description','document');
$upda=array();
   foreach($arrayed as $key => $val)
   {
     $upda[$val]=$arbb->input[$val];
   }

   if(!((ereg("^[a-zA-Z0-9_\.\-]+$",$upda['title'])) && (ereg("^[a-zA-Z0-9_\.\-]+$",$upda['cat']))))
   {
      error_message($lang['faq_ins_error']);
   }

   $DB->update($upda,'faq',"faqid='".$arbb->input['faqid']."'");

   redirect($lang['faq_updated'],"faq.php?sid=$sid");

}
elseif(($arbb->input['do']=='delete') OR ($arbb->input['do']=='do_delete'))
{
$qu=$DB->query("select * from "._PREFIX_."faq where faqid='".$arbb->input['faqid']."'");
while($faq = $DB->fetch_array($qu))
{
      if($arbb->input['do']=='delete')
      {
        $TP->WebTemp('faq_delete');
      }
      else
      {
        if($faq['cat']=='-1')
        {
         $DB->query("delete from "._PREFIX_."faq where faqid='".$faq['faqid']."'");
         $DB->query("delete from "._PREFIX_."faq where cat='".$faq['faqid']."'");
        }
        else
        {
         $DB->query("delete from "._PREFIX_."faq where faqid='".$faq['faqid']."'");
        }
        redirect($lang['faq_deleted'],"faq.php?sid=$sid");
      }
}

}


if(!$titleetc)
{
    $titleetc=$lang['adminmenu_faq'].' - ';
}
print_page();
?>