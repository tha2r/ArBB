<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/
$lang=array(
"dir" => "ltr",
"left" => "left",
"right" => "right",
"charset"=>"iso-8859-1",
"title" => "ArBB installation script",
"title_sub" => "Arabian Bulletin Board v 1.0 Beta installation script",
"steps"=>array("","Welcome & Choose lang","Requirements Check","License Agreement","Database Configuration","Tables Creation","Data Insertion","Theme And Language Exporting","Board Configuration","Administrator User","Finishing Setup"),
"welcome_message" => " Welcome To ArBB Installation script.\n           <br> This script will be used to make installing your forums more easy\n           <br> After Going in the next simple stips you will be able to have your Bulletin Board Ready.\n           <br> First of all you will have to choose the language you want from below and continue your installation.\n           <br> Best Wishes\n           <br> ArBB Team.\n           <br>\n           <br>\n           <br>Please Choose tha language you want proceed with.\n           <br> This language will be used in installation and installed as default language.",
"choose" => "Choose",
"requirements_check" => "Requirements Check",
"requirements_check_note" => "Before You Continue installing your Board you must check the requirements for this board.<br>To Prevent Having Errors in Future..",
"php_xml_extension" => "PHP XML Extension",
"ok" => "<font color=\"green\">Ok</font>",
"error" => "<font color=\"red\">Error</font>",
"installed" => "<font color=\"green\">Installed</font>",
"not_installed" => "<font color=\"red\">Not Installed</font>",
"php_version" => "PHP Version",
"mysql_support" => "MySQL Database Support",
"writable" => "<font color=\"green\">Writable</font>",
"not_writable" => "<font color=\"red\">Not Writable</font>",
"avatars_dir_writable" => "Avatars Directory Writable:",
"error_cannot_continue" => "<br><b><font color=\"red\">Error Cannot Continue .. please fix the errors above.</font></b>",
"continue" => "Continue",
"license_agreement" => "Lincense Agreement",
"iagree" => "I Agree . . Continue ->",
"database_configuration" => "Database Configuration",
"database_configuration_note" => "Before creating tables or inserting data you should Configure the script to be able to connect to your database.<br>You Can Edit or modify this informations by editiong the file <font color=\"green\">includes/config.php</font> then <a href=\"#\" onclick=\"document.location.href=document.location.href\">refresh</a> this page.<br><font color=\"red\">This version accepts MySQL Database only ..</font>",
"database_host" => "Database Host",
"database_user" => "Database UserName",
"database_pass" => "Database Password",
"database_name" => "Database Name",
"table_prefix" => "Table Prefix",
"mysql_config_error" => "Make sure you have changed the informations in includes/config.php file to the currect information.<br>Please Change them then refresh this page or run the installation script again ..",
"createdberror" => " Creating table %s -> <font color=\"red\">Error</font>",
"createdbdone"  => " Creating table %s -> <font color=\"green\">Done</font>",
"insertdataerror" => " Inserting Data To %s -> <font color=\"red\">Error</font>",
"insertdatadone"  => " Inserting Data To %s -> <font color=\"green\">Done</font>",
"default_style" => "Default Style",
"default_lang" => "Default Language",
"importing_lang" => "Importing Default Language",
"importing_style" => "Importing Default Style",
"done" => "Done",
"board_configuration" => "Board Configuration",
"forum_info" => "Forum Info",
"forum_title" => "Forum Title",
"forum_url" => "Forum URL",
"web_title" => "Website Title",
"web_url" => "Website Url",
"web_info" => "Website Informations",
"contact_info" => "Contact Information",
"email" => "Email Address",
"userinfo" => "User informations",
"username" => "User Name",
"password" => "Password",
"password2" => "Retype Password",
"configured_error" => "<br><br><h3><font color=\"red\">There seems to be a problem with your board Configurations.</font></h3><br><br><center>Please Make sure you have configured your board with currect informations.</center><br><br><br>",
"password_not_match" => "There is a problem in adding administrator user.<br>User Name And Password must be at least Four letters<br>You Must Match the two password fields ..<br> it's necessary to verify your informations",
"setup_finished_message" => "You Board Setup has successfully completed ..<br>
                             you can now use your username and password to log into your board or your administrator control panel to control your board<br>
                             <br><br>
                             <a href=\"../admin/index.php\">Go To Administrator Control panel.</a><br><br>
                             <a href=\"../index.php\">Go to your board.</a><br><br>
                             <font color=\"red\">It's necessary to delete this folder to prevent any action may affect your board.</font>"
);
?>

