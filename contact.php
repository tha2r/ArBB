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
#    announcements File started
#
/*
        File name       -> announcement.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

// Used Templates list ,,

$templatelist='contactus,contactus_option';

$phrasearray = array('contactus','profile');

Include 'global.php';

// Caching plugins for requiring in the right place ,,
$plugins->cache('contactus_start,contactus_complete');

($evalp = $plugins->load('contactus_start'))?eval($evalp):'';


$contactusoptions = '';
$checked          = '';
$contact_options  = array();
$other_option     = '';

$opt=explode('\n',$options['contactusoptions']);

foreach($opt as $index => $title)
{

if($arbb->input['subject'] == $index)
{
   $checked = 'checked';
   }
   elseif($arbb->input['subject']=='other')
   {

   $other_option = 'checked';
           }

   $contactusoptions.=$TP->GetTemp('contactus_option');
   $contact_options["$index"]=$title;

   $checked = '';
}


if(empty($arbb->input['do']))
{
  $name    = $local['username'];
  $email   = $local['email'];
  $message = '';
   $TP->webtemp('contactus');
        }
        elseif($arbb->input['do']=='contactus')
        {
          $name          = $bbcode->clearhtml($arbb->input['name']);
          $email         = $bbcode->clearhtml($arbb->input['email']);
          $message       = $bbcode->clearhtml($arbb->input['message']);
          $subject_other = $bbcode->clearhtml($arbb->input['subject_other']);
          $subject       = $bbcode->clearhtml($arbb->input['subject']);

          if($subject == 'other')
          {
             $mail_subject = $subject_other;
          }
          else
          {
             $mail_subject = $contact_options["$subject"];
          }

          if(empty($name)||empty($email)||empty($message)||empty($mail_subject))
          {
               $show['errors']=1;
               $error_messages = '';
               $errors = array();

               if(empty($name))
               {
                 $errors[]=$lang['fill_name_field'];
               }
               if(empty($email))
               {
                 $errors[]=$lang['fill_email_field'];
               }
               if(empty($message))
               {
                 $errors[]=$lang['fill_message_field'];
               }
               if(empty($mail_subject))
               {
                 $errors[]=$lang['fill_subject_filed'];
               }
                 $error_messages=implode('<br><li>',$errors);
              $TP->webtemp('contactus');

          }
          else
          {
              $send = sendmail($options['webmasteremail'], $mail_subject, $message,$email, $name);

              if(!$send)
              {
                  error_message($lang['error_sending_message']);
                      }
                      else
                      {
                      $url = $options['forumhome'].'.php';
                      $redirect_message = $lang['message_sent_succefully'];

                          redirect($redirect_message,$url);
                              }
                  }
                }
                else
                {
                   error_message($lang['contact_page_error']);
                        }

   build_nav_location(stripslashes($lang['contact_us']),'contact.php','add',1);
   $titleetc=$lang['contact_us'].' - ';

($evalp = $plugins->load('contactus_complete'))?eval($evalp):'';

   print_page();
?>