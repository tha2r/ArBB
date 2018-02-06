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
#    Config File started
#
/*
        File name       -> config.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Variables
*/

/*********************************************************/

/*
@@
@@ The Database Informations .
@@
*/
# DB User
$db_user  = 'root';              //User Name

# DB Pass
$db_pass  = '';                  //Password

# DB Name
$db_name  = 'arbb';              //Database Name

# DB Host
$db_host  = 'localhost';         //Database Host
# ---------------------------------------------
/*/
/*
/* The Database Prefix .
/*  Used For making the databases with another table name ..
/*
/*/
$dbprefix='';
# ---------------------------------------------
/*/
/*
/* The Cookies Prefix .
/*
/*/
$cookieprefix='arbb_';
# ---------------------------------------------
/*
@@
@@ The Admin Control Panel Dir .
@@
*/
$admincp_dir='admin';
# ---------------------------------------------
/*
@@
@@ The Moderators Control Panel Dir .
@@
*/
$modcp_dir='modcp';
# ---------------------------------------------
/*
@@
@@ This users will not be ever deleted or edited by the Control panel .
@@ Use (,) As sperator Between User And The Other
@@
*/
$uneditableusers = '1,2';
# ---------------------------------------------
/*
@@
@@ This users will have a special permissions
@@ like executing sql query(s) in Control Panel .
@@ Use (,) As sperator Between User And The Other
@@
*/
$massusers = '1';
/*********************************************************/

//#  Config File Finished

?>