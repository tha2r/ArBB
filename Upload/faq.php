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
#    Faq(Frequently Asked Questions) File started
#
/*
        File name       -> faq.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='faq_main_table,faq_main_row,faq_document';

$phrasearray = array('faq');

require('global.php');
// Caching plugins for requiring in the right place ,,
$plugins->cache('faq_start,faq_display_bit,faq_complete');

// Protect variables from injections,,
$faq        = '';
$subfaqbits = '';


// Load Plugins and complete the file
($evalp = $plugins->load('faq_start'))?eval($evalp):'';

if(empty($arbb->input['page']))
{

$query=$DB->query("select * from "._PREFIX_."faq where enabled=1 order by disporder ASC");

while($fetch = $DB->fetch_array($query))
{
             $faq[$fetch[cat]][$fetch[disporder]][$fetch[faqid]]=$fetch;
}

while(list($id,$info) = each ($faq[-1]))
{
  foreach($info as $key => $faqmain)
  {
         if(is_array($faq[$faqmain[faqid]]))
         {
           foreach($faq[$faqmain[faqid]] as $k => $v)
           {foreach($v as $faqbitkey => $faqbit)
           {
            $faqbit['faqtitle']=$faqbit['phrasetitle'];
            $subfaqbits.=$TP->GetTemp('faq_main_row');

           }
           }
         }
            $faqmain['faqtitle']=$faqmain['phrasetitle'];
         $TP->WebTemp('faq_main_table');
         $subfaqbits='';
  }

}

   build_nav_location(stripslashes($lang['faq']),'faq.php','add',1);
   $titleetc=' '.$lang['faq'].' - ';
                 }
                 else
                 {
                     $page=$bbcode->clearhtml($arbb->input['page']);
                     $query=$DB->query("select * from "._PREFIX_."faq where title='$page'");


                     while($faq=$DB->fetch_array($query))
                     {

                     $faq['faqtitle']    = $faq['phrasetitle'];
                     $faq['document']    = $bbcode->build($faq['document']);
                     ($evalp = $plugins->load('faq_display_bit'))?eval($evalp):'';
                          $TP->webtemp('faq_document');

                  build_nav_location(stripslashes($lang['faq']),'faq.php','add');
                  build_nav_location(stripslashes($faq['faqtitle']),"faq.php?page=$faq[title]",'add',1);
                    $titleetc=" $faq[faqtitle] -> $lang[faq] - ";
                             }

                         }
($evalp = $plugins->load('faq_complete'))?eval($evalp):'';
   print_page();
?>