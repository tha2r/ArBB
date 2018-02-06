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
#    Register File started
#
/*
        File name       -> register.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/


$templatelist='register,register_rules,register_birthday';

$phrasearray = array('register','profile');

require('global.php');

  $url = ($arbb->input['url'])? $arbb->input['url'] : $HTTP_SERVER_VARS['HTTP_REFERER'];
  $url = $bbcode->clearhtml(urldecode($url));
  $url = ($url)?$url:'index.php?';
  $avatarbits   = '';
  $styleoptions = '';

  $avatars = array();
  $daysel  = array();
  $msel    = array();
  $year    = '';


if($options['registerclosed'] == 1)
{
 error_message($lang['registeration_is_closed']);
}
$stq=$DB->query("select * from "._PREFIX_.'styles');

while($sty=$DB->fetch_array($stq))
{
  $styleoptions .= "<option value=\"$sty[styleid]\">$sty[title]</option>";
}

  $birthdaybit = $TP->GetTemp('register_birthday');


if($local['userid']>0)
{
   error_message($lang['error_already_registered']);
        }
        else
        {
        eval("\$lang[register_optional_information]=\"".$lang['register_optional_information']."\";");
        if(empty($arbb->input['action']))
        {
           $TP->webtemp('register_rules');
        }
        elseif($arbb->input['action']=='register')
        {

         if($arbb->input['agree'] == 1)
         {
        $imagestring = random_string(5);
        $imagehash   = md5($imagestring);

        $DB->query("insert into "._PREFIX_."regimage values('$imagehash','$imagestring','".TIMENOW."')");

          $TP->WebTemp('register');
             }
             else
             {
                error_message($lang['register_not_agreed']);

                   }
              }
              elseif($arbb->input['action']=='do_register')
              {
              $errors=array();

              $emex = $DB->query("select userid from "._PREFIX_."users where email='".addslashes($bbcode->clearhtml($arbb->input['email']))."'");
              $unex = $DB->query("select userid from "._PREFIX_."users where username='".addslashes($bbcode->clearhtml($arbb->input['username']))."'");

              if($DB->Num_rows($emex)>0)
              {
                      $show['error']=1;

                      $errors[]=$lang['email_already_used'];
              }


              if($DB->Num_rows($unex)>0)
              {
                      $show['error']=1;

                      $errors[]=$lang['username_already_used'];
              }

              if(empty($arbb->input['username'])||empty($arbb->input['password'])||empty($arbb->input['passwordconfirm'])||empty($arbb->input['email'])||empty($arbb->input['emailconfirm']))
              {
                      $show['error']=1;

                      $errors[]=$lang['fill_all_required_fields'];
              }

              if($arbb->input['password'] != $arbb->input['passwordconfirm'])
              {
                      $show['error']=1;

                      $errors[]=$lang['password_fields_must_match'];
              }

              if($arbb->input['email'] != $arbb->input['emailconfirm'])
              {
                      $show['error']=1;

                      $errors[]=$lang['email_fields_must_match'];
              }

              if(!checkmail($arbb->input['email']))
              {
                      $show['error']=1;

                      $errors[]=$lang['not_valid_email'];
              }

              if((strlen($arbb->input['password'])<$options['minpassword'])||(strlen($arbb->input['password'])>$options['maxpassword']))
              {
                      $show['error']=1;
                      $lang['password_to_long_small']=str_replace('{1}',$options['minpassword'],$lang['password_to_long_small']);
                      $lang['password_to_long_small']=str_replace('{2}',$options['maxpassword'],$lang['password_to_long_small']);
                      $errors[]=$lang['password_to_long_small'];
              }

              if((strlen($arbb->input['username'])<$options['minusername'])||(strlen($arbb->input['username'])>$options['maxusername']))
              {
                      $show['error']=1;
                      $lang['username_to_long_small']=str_replace('{1}',$options['minusername'],$lang['username_to_long_small']);
                      $lang['username_to_long_small']=str_replace('{2}',$options['maxusername'],$lang['username_to_long_small']);

                      $errors[]=$lang['username_to_long_small'];
              }

              $imagestring = strtoupper($arbb->input['imagestring']);
              $imagehash   = md5($imagestring);

              $query = $DB->query("select * from "._PREFIX_."regimage where imagehash='$imagehash'");

              if($DB->num_rows($query)>0)
              {
                       $DB->query("delete from "._PREFIX_."regimage where imagehash='".md5($imagestring)."'");
              }
              else
              {


                      $show['error'] = 1;
                      $errors[]=$lang['verification_image_error'];
              }

              if($show['error']==1)
              {
                  $imagestring = random_string(5);
                  $imagehash   = md5($imagestring);


              $DB->query("insert into "._PREFIX_."regimage values('$imagehash','$imagestring','".TIMENOW."')");

               $error=implode('<li>',$errors);

               $TP->WebTemp('register');

                 }
                 else
                  {

                     if(strlen($arbb->input['signature'])>0)
                     {
                             $showsignature = 1;
                     }
                     else
                     {
                             $showsignature = 0;
                     }

                     if(($arbb->input['year'] > 0)||(($arbb->input['month']>0)&&($arbb->input['day']>0)))
                     {

                        $showbirthday = 1;

                           $birthday = $arbb->input['day'].'-'.$arbb->input['month'];

                        if($arbb->input['year']>0)
                        {
                         $birthday .= '-'.$arbb->input['year'];
                        }

                     }
                     else
                     {
                        $showbirthday = 0;
                     }

                  $user = array('username'      => addslashes($arbb->input['username']),
                                'password'      => md5($arbb->input['password']),
                                'email'         => $arbb->input['email'],
                                'usergroupid'   => '2',
                                'styleid'       => $arbb->input['styleid'],
                                'homepage'      => $arbb->input['homepage'],
                                'icq'           => $arbb->input['icq'],
                                'yahoo'         => $arbb->input['yahoo'],
                                'msn'           => $arbb->input['msn'],
                                'aim'           => $arbb->input['aim'],
                                'showsignature' => $showsignature,
                                'pmpopup'       => $arbb->input['pmpopup'],
                                'showbbcode'    => $arbb->input['showbbcode'],
                                'signature'     => $arbb->input['signature'],
                                'showbirthday'  => $showbirthday,
                                'showsignature' => $arbb->input['showsignature'],
                                'birthday'      => $birthday,
                                'autosubscribe' => $arbb->input['autosubscribe'],
                                'daysprune'     => '-1',
                                'joindate'      => TIMENOW);

                        $ins=$DB->multible_insert($user,'users');

                        if(!$ins)
                        {
                         error_message($lang['registeration_error']);
                        }
                        else
                        {
                        if($options['registeractivation'] == 'emailactivation')
                        {
                        $options['require_email_verify']=$lang['registeration_reqire_verify'];
                        $u=$user;

                        $randomcode = random_string(10);
                        $dateline=TIMENOW;
                        $DB->query("insert into "._PREFIX_."verification (userid,code,query,dateline) values ('$u[userid]','$randomcode','users set usergroup=\'2\' where userid=\'$u[userid]\'','$dateline')");

                        eval("$message=\"".$lang['message_register_verification']."\";");
                        sendmail($u['email'], $lang['verify_registeration'], $message,$options['webmasteremail'], $options['sitetitle']);
                           }
                           else
                           {
                              $options['require_email_verify']='';
                                }
                         updatestats();
                        eval("\$lang[registeration_finished]=\"".$lang['registeration_finished']."\";");
                          alert($lang['registeration_finished']);
                        }

                      }

                      }//Actions

                }//User Is Guest

build_nav_location(stripslashes($lang['register']),'register.php');

   $titleetc = $lang['register'].' - ';
   print_page();
?>