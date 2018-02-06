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
#    New Post Function File started
#

/*
        File name       -> functions_newpost.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Functions
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

           function new_subscribe_mail($userinfo,$post)
           {
            GLOBAL $lang,$options;
            $post['postcut']=substr($post['post'],0,255);
            eval("\$message = \"".$lang['message_subscription']."\";");
             sendmail($userinfo['email'], $lang['new_reply_thread'].' : '.$post['threadtitle'], $message,$options['webmasteremail'], $options['sitetitle']);
           }

//# All Done .. New post Functions File Finished

?>