<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/
$query=array();
             GLOBAL $furl,$ftitle,$wurl,$wtitle,$cmail;
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (1, 'boardstat', 'Is you forums active', 'If you want to turn you forums off for changes or restoring backups just turn it off , else just keep it on and you forums will still actived .', 'yesno', '1', 1, 1);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (2, 'boardmsg', 'Board message', 'This message will be shown if you chose to turn your forums off', 'textarea', 'We are sorry but we are doing some changes in our forums<br>we will be back soon', 1, 1);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (3, 'sitetitle', 'Your forums title', 'Name of your forum. This appears in the title of every page.', 'textinput', '".$ftitle."', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (4, 'address', 'The Address Of your website', 'URL address of your forums.\r\nNote: do not add a slash in the end.', 'textinput', '".$furl."', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (5, 'hometitle', 'Home page title', 'The title of your homepage', 'textinput', '".$wtitle."', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (6, 'homeurl', 'Home page url', 'The Link of your home page .. appears in the forums footer', 'textinput', '".$wurl."', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (7, 'contactuslink', 'Contact us Link', 'This is the link of the page which will allow users and guests to send you suggestions and messages. <br><srtong>Desfault : contact.php</strong>', 'textinput', 'contact.php', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (8, 'contactusoptions', 'Contact us Options', 'You may set a titles for the messages which will the senders choose from or they can make there own.', 'textarea', 'Suggetion\r\nSite Feed Back', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (9, 'webmasteremail', 'Webmaster Email', 'The Email of website administrators .. the message will be sent from the forum will be from this email and this email will recive contact us mails.', 'textinput', '".$cmail."', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (10, 'copyright_text', 'Copyright Text', 'Copyright text to insert in the footer of the page.', 'textinput', 'Copyright &copy; 2006-2007, Arbb team.', 1, 2);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (11, 'metakeys', 'Meta Keywords', 'Enter the meta keywords for all pages. These are used by search engines to index your pages with more relevance.', 'textinput', 'forums,arbb,arabian,bulletin,board,arabian bulletin board,bulletin board system,web,system', 1, 3);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (12, 'metadescription', 'Meta Description', 'Enter the meta description for all pages. This is used by search engines to index your pages more relevantly.', 'textinput', 'This is ArBB (Arabian bulletin board) .. free for personal use ,, to know more about it visit www.ar-bb.com.', 1, 3);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (13, 'useforumjump', 'Use Forum Jump Menu', 'Use The Forum Jump menu.', 'yesno', '1', 1, 3);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (14, 'allowbbcode', 'Allow BBcodes', 'Allow bbcodes will make threads and posts and any text in the forum easy and quick and safe', 'yesno', '1', 1, 5);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (15, 'allowsmilies', 'Allow Smilies', 'Allow users to include smilies in their posts and signatures etc.', 'yesno', '1', 1, 5);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (16, 'allowimgtag', 'Allow Images', 'Allow users to include images in their posts and signature etc.', 'yesno', '1', 1, 5);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (17, 'allowhtml', 'Allow Html', 'Allow users to use html tags in their posts , sinature etc.<br>Warning : Allowing this feauture will make your forums unsafe and might cause security problems.', 'yesno', '0', 1, 5);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (18, 'defaultlang', 'Default Language', 'Select the default language for your forums. This language will be used for all guests, and any members who have not expressed a language preference in their options.', 'language', '1', 1, 6);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (19, 'defaultstyle', 'Default Style', 'Select the default style for your forums. This language will be used for all guests, and any members who have not expressed a Style preference in their options.', 'style', '1', 1, 6);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (20, 'archiveenabled', 'Enable Archive', 'The Search-Friendly Archive It provides a basic structure that search engines can spider to grab all the content on your site.', 'yesno', '1', 1, 3);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (21, 'forumhome', 'Forum home url', 'This is forum home url if you want change it and put another index page.<br><strong>Default : index</strong>', 'textinput', 'index', 1, 12);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (22, 'forumperpage', 'Forum Threads per page', 'This options limits the number of threads displayed in forum page ..', 'textinput', '20', 1, 13);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (23, 'threadperpage', 'Threads posts per page', 'This options limits the number of posts displayed in thread page ..', 'textinput', '20', 1, 9);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (24, 'fastreply', 'Fast Reply Enabled', 'Enabling fast reply will make adding new reply to a thread more easy.', 'yesno', '1', 1, 9);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (25, 'allowattach', 'Allow attachments', 'Allowing attachment will allow you to upload files easy and safe with your posts.', 'yesno', '1', 1, 10);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (26, 'onlineperpage', 'Online list members perpage', 'This is to limit online users list rows .. this will make viewing list faster.', 'textinput', '20', 1, 14);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (27, 'memberlistperpage', 'Member list members perpage', 'This is to limit users list rows .. this will make viewing list faster.', 'textinput', '20', 1, 14);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (28, 'showstats', 'Show Stats section on forum home page.', 'Do You want show small stats section shows the numbers off total users,threads,posts and the last registered user name.', 'onoff', '1', 0, 12);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (29, 'showbirthdays', 'Show Today birthdays', 'Show the user names and ages who are today is their birthday.', 'onoff', '1', 0, 12);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (30, 'registerclosed', 'Disable Registeration', 'This option will disallow unregistered visitors to register new memberships on your forums.', 'yesno', '0', 0, 7);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (31, 'minusername', 'Minimum username length', 'This will prevent signing with small not understanded usernames and will set number of letters which usernames must be more than this number of letters.', 'textinput', '3', 0, 7);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (32, 'maxusername', 'Maximum username letters', 'This will prevent signing with large usernames .', 'textinput', '25', 0, 7);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (33, 'registeractivation', 'Register verification method', 'Please select the method of registration to use when users register.', 'select\r\ninstatntactivation\r\nemailactivation', 'instatntactivation', 0, 7);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (34, 'minpassword', 'Minimum password charsets', 'Minimum user password charsets .', 'textinput', '5', 0, 7);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (35, 'maxpassword', 'Maximum password charsets', 'Maximum user password charsets', 'textinput', '30', 0, 7);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (36, 'usegzip', 'Use GZIP Page Compression?', 'Do you want to compress pages in GZip format ?<br> This means quick browsing, and less traffic usage for you.', 'yesno', '1', 0, 4);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (37, 'gziplevel', 'GZIP Compressing Level', 'Select the level for GZip Compression from 1-9.(1=min , 9=max).<br> This will only take effect if GZip Compression is enabled above.', 'select\r\n1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9', '9', 0, 4);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (38, 'bannedips', 'Banned IPS', 'Write the ip addresses you dont want them to be able to access your board. you may ban a range of ip addresses here <br> Use A Comma Sperator', 'textarea', '', 1, 8);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (39, 'searchengingon', 'Active The Search engine', 'Search enging is the feature which allows your forum users to search and find the topics and what ever they want easily', 'yesno', '1', 1, 11);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (40, 'cpstyle', 'Default Admin Control Panel Style', 'Select Your AdminCP Style you want use here.<br>You May change it to another style but make sure its currect and tested successfully<br>This change may affects your admincp.', 'cpstyle', 'default', 1, 16);";
$query[]="INSERT INTO `"._PREFIX_."setting` VALUES (41, 'allowpm', 'Allow Private Messages', 'Allow users to use Private Messages System .. This feature will allow your forum members to send messages to each other through the forum with out needing emails.', 'yesno', '1', 1, 15);";

?>