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
#    Login File started
#
/*
        File name       -> login.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'lostpassword';
$phrasearray  = array('login');

require('global.php');

if(empty($arbb->input['do']))
{

   if($local['userid']>0)
   {
       header('location:index.php');

           }
           else
           {
               error_permission();

                   }

        }
        elseif($arbb->input['do']=='login')
        {
             $username = addslashes($arbb->input['username']);
             $password = $bbcode->clearhtml(md5($arbb->input['password']));

             $uid = verify_login($username,$password);

            if(!$uid)
            {

                error_message($lang['login_error']);

                    }
                    else
                    {

                        newcookie('userid',$uid);
                        newcookie('password',$password);

                        $url = ($arbb->input['url'])? $arbb->input['url'] : $HTTP_SERVER_VARS['HTTP_REFERER'];
                        $url=$bbcode->clearhtml(urldecode($url));
                        $url = ($url)?$url:'index.php?';

                              redirect($lang['logined_succefully'],$url);

                            }
                }
                elseif($arbb->input['do']=='logout')
                {

                       $cookies=array('userid','password');

                        unsetcookie($cookies);

                        $url = ($arbb->input['url'])? $arbb->input['url'] : $HTTP_SERVER_VARS['HTTP_REFERER'];
                        $url = $bbcode->clearhtml(urldecode($url));
                        $url = ($url)?$url:'index.php?';

                        redirect($lang['logged_out_succefully'],$url);

                        }
                        elseif($arbb->input['do']=='lostpass')
                        {
                           build_nav_location($lang['restore_password'],"login.php?do=lostpass","add",1);
                           $titleetc=$lang['restore_password'].' - ';

                        $TP->webtemp('lostpassword');

                        }
                        elseif($arbb->input['do']=='do_lost')
                        {
                           build_nav_location($lang['restore_password'],'#','add',1);
                           $titleetc=$lang['restore_password'].' - ';
                           $email=$bbcode->clearhtml(addslashes($arbb->input['email']));
                           $error=1;

                           $qu = $DB->query("select * from "._PREFIX_."users where email='$email'");
                           while($u = $DB->fetch_array($qu))
                           {
                                   $error=0;
                              $dateline=TIMENOW;
                              $randomcode = random_string(10);
                              $newpass    = random_string(6);
                              eval("\$message=\"".$lang['message_restore_password']."\";");
                              $DB->query("insert into "._PREFIX_."verification (userid,code,query,dateline,addition) values ('$u[userid]','$randomcode','users set password=\'$newpass\' where userid=\'$u[userid]\'','$dateline','$newpass')");
                              sendmail($u['email'], $lang['password_change_verification'], $message,$options['webmasteremail'], $options['sitetitle']);
                           }

                           if($error==1)
                           {
                            error_message($lang['restore_email_invalid']);
                           }
                           else
                           {
                              redirect($lang['restore_message_sent'],$options['forumhome'].'.php');
                           }


                        }

        print_page();
?>