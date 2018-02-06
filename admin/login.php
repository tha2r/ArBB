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
        File name       -> login.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = '';
$login=1;
$phrasearray=array('admincp');

require('global.php');

session_start();
if(session_is_registered('admin'))
{
$u=$_SESSION['local'];
       $query=$DB->query("select * from "._PREFIX_."users where userid='".addslashes(htmlspecialchars($u['userid']))."' and password = '".md5(addslashes(htmlspecialchars($u['password'])))."'");
        while($row=$DB->fetch_array($query))
        {
          $local=$row;
        }

       $query=$DB->query("select * from "._PREFIX_."usergroup where usergroupid='".addslashes(htmlspecialchars($local['usergroupid']))."'");
        while($row=$DB->fetch_array($query))
        {
          $localgroup=$row;
        }
}

if($arbb->input['action'] =='logout')
{
session_unregister('admin');
session_unregister('local');
session_destroy();
header('location:index.php');
}
elseif($arbb->input['action']=='login')
{
       $query=$DB->query("select * from "._PREFIX_."users where username='".addslashes(htmlspecialchars($arbb->input['username']))."' and password = '".md5(addslashes(htmlspecialchars($arbb->input['password'])))."'");
        while($row=$DB->fetch_array($query))
        {
          $local=$row;
        }
        if($local['userid'] > 0)
        {
       $query=$DB->query("select * from "._PREFIX_."usergroup where usergroupid='".addslashes(htmlspecialchars($local['usergroupid']))."'");
        while($row=$DB->fetch_array($query))
        {
          $localgroup=$row;
        }

        $admin='Administrator';

        session_register('admin');
        session_register('local');
        $arbb->input['action']='';

               redirect('Logged in successfully',"index.php?sid=$sid");
        }
        else
        {

                redirect('Wrong User Or Password',"login.php?sid=$sid");

        }
}
else
{
   
$TP->webtemp('login');
print_page();
die();

}
?>