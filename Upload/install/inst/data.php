<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/
$datas=array();
$query=array();

$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('1','settings','-1','','1');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('2','stylemanager','-1','','2');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('3','langmanager','-1','','3');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('4','announcement','-1','','4');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('5','forummanager','-1','','5');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('6','usersmanager','-1','','6');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('7','usergroup','-1','','7');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('8','usertitles','-1','','8');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('9','avatars','-1','','9');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('10','posticons','-1','','10');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('11','smilies','-1','','11');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('12','bbcodes','-1','','12');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('13','plugins','-1','','13');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('14','faq','-1','','14');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('15','maintenance','-1','','15');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('36','forumsetting','1','setting.php','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('37','stylemanage','2','style.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('38','templatesmanage','2','style.php?do=templates','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('39','styledownup','2','style.php?do=downup','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('40','langmanage','3','lang.php?do=lang','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('41','phrasemanage','3','lang.php?do=phrases','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('42','langdownup','3','lang.php?do=downup','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('43','addannouncement','4','announcement.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('44','announcementmanage','4','announcement.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('45','addforum','5','forums.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('46','forummanage','5','forums.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('47','addmoderator','5','forums.php?do=add_mod','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('48','editpermission','5','forums.php?do=editpermission','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('49','usersearch','6','users.php?do=search','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('50','banuser','6','users.php?do=ban','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('51','viewbanedusers','6','users.php?do=viewban','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('52','mailusers','6','users.php?do=sendmail','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('53','generatemaillist','6','users.php?do=generate','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('54','addusergroup','7','usergroups.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('55','usergroupmanage','7','usergroups.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('56','usergrouppermissions','7','usergroups.php?do=permissions','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('57','addusertitle','8','usertitles.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('58','usertitlemanage','8','usertitles.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('59','avatarsmanager','9','avatars.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('60','addavatar','9','avatars.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('61','posticonmanager','10','posticon.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('62','addposticon','10','posticon.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('63','smiliesmanager','11','smilies.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('64','addsmilies','11','smilies.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('65','bbcodemanage','12','bbcodes.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('66','addbbcode','12','bbcodes.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('67','pluginmanager','13','plugins.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('68','addplugin','13','plugins.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('69','downup','13','plugins.php?do=downup','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('70','faqmanager','14','faq.php?do=manage','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('71','addfaq','14','faq.php?do=add','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('72','databasebackup','15','maintenance.php?do=backups','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('73','repairoptimize','15','maintenance.php?do=dbtools','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('74','sqlquery','15','maintenance.php?do=sql','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('75','updatecounters','15','maintenance.php?do=counters','0');";
$datas['adminmenu'][]="INSERT INTO `"._PREFIX_."adminmenu` VALUES ('76','phpinfo','15','maintenance.php?do=phpinfo','0');";


$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('1','gif','Content-type: image/gif','200','620','280','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('2','jpeg','Content-type: image/jpeg','200','620','280','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('3','jpg','Content-type: image/jpeg','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('4','jpe','Content-type: image/jpeg','200','620','280','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('5','txt','Content-type: text/plain','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('6','png','Content-type: image/png','200','620','280','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('7','doc','Content-type: application/msword','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('8','pdf','Content-type: application/pdf','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('9','bmp','Content-type: image/bitmap','200','620','280','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('10','psd','Content-type: application/octet-stream','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('11','zip','Content-type: application/zip','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('12','mp3','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('13','php','Content-type: unknown/unknown','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('14','rtf','Content-type: application/msword','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('15','ram','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('16','rm','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('17','rar','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('18','tif','Content-type: unknown/unknown','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('19','tiff','Content-type: unknown/unknown','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('20','wmv','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('21','xml','Content-type: text/xml','200','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('22','gz','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('23','tar','Content-type: unknown/unknown','1025','0','0','0');";
$datas['attachmenttype'][]="INSERT INTO `"._PREFIX_."attachmenttype` VALUES ('24','css','Content-type: text/css','200','0','0','0');";


$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('1','glow','<div style=\"filter:glow(Color=$1,Strength=5);\"; width:100%;\";padding:3;\";margin:-3\">$2</div>','It is used to add effect like glow to the text','2','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('2','flash','<EMBED src=\"$3\" quality=high loop=true menu=false width=\"$1\" heigh=\"$2\" TYPE=\"application/x-shockwave-flash\"</EMBED>','','3','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('3','marquee','<marquee direction=\"$1\" scrolldelay=\"120\">$2</marquee>','','2','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('4','php','<table width=\"95%\" class=phpcode>
                          <tr>
                              <td class=phpcode><b>PHPCode:</b></td>
                          </tr>
                          <tr>
                              <td class=phpcodeblock><phpcode>$1</phpcode></td>
                          </tr>
                     </table>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('5','quote','<table width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
                          <tr>
                              <td class=quote><b>Quote:</b></td>
                          </tr>
                          <tr>
                              <td class=\"quote2\">$1</td>
                          </tr>
                     </table>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('6','code','<table width=\"95%\" class=code>
                          <tr>
                              <td class=code><b>PHPCode:</b></td>
                          </tr>
                          <tr>
                              <td class=codeblock>$1</td>
                          </tr>
                     </table>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('7','rams','<div align=\"center\">
        <embed SRC=\"$1\" type=\"audio/x-pn-realaudio-plugin\" CONSOLE=\"Clip1\" CONTROLS=\"ControlPanel,StatusBar\" HEIGHT=\"60\" WIDTH=300\" AUTOSTART=\"false\">
        </embed>
 </div>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('8','align','<div align=\"$1\">
$2
</div>','','2','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('9','ramv','<div align=\"center\">
        <embed SRC=\"$1\" type=\"audio/x-pn-realaudio-plugin\" CONSOLE=\"Clip1\" CONTROLS=\"ImageWindow,ControlPanel,StatusBar\" HEIGHT=\"230\" WIDTH=\"300\" AUTOSTART=\"false\">
        </embed>
</div>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('10','media','<div align=\"center\">
<embed src=\"$1\">
</embed>
</div>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('11','img','
<img src=\"$1\">','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('12','b','<b>$1</b>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('13','i','<i>$1</i>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('14','u','<u>$1</u>','','1','','');";
$datas['bbcode'][]="INSERT INTO `"._PREFIX_."bbcode` VALUES ('15','color','<font color=$1>$2</color','','2','','');";

//
// Forum data [[]]...
//
$datas['forum'][]="INSERT INTO `"._PREFIX_."forum` VALUES ('1','1','Main Category','Main Category Description','1','0','1','1176719879','Thaer','1','1','Welcome To ArBB','2','-1','1','0','','0','1','0','','lastpost','desc');";
$datas['forum'][]="INSERT INTO `"._PREFIX_."forum` VALUES ('2','1','Main Forum','Main Forum Description','1','0','1','1176719879','Thaer','1','1','Welcome To ArBB','2','1','1,2','0','','1','1','1','','lastpost','desc');";

$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('1','Post','images/icons/icon1.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('2','Birthday','images/icons/icon2.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('3','Lightbulb','images/icons/icon3.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('4','Question','images/icons/icon4.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('5','Exclamation','images/icons/icon5.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('6','WoOoOow','images/icons/icon6.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('7','Unhappy','images/icons/icon7.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('8','Angry','images/icons/icon8.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('9','Cool','images/icons/icon9.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('10','Talking','images/icons/icon10.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('11','Red face','images/icons/icon11.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('12','Wink','images/icons/icon12.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('13','Smile','images/icons/icon13.gif','1');";
$datas['icon'][]="INSERT INTO `"._PREFIX_."icon` VALUES ('14','Arrow','images/icons/icon14.gif','1');";


$datas['imagecat'][]="INSERT INTO `"._PREFIX_."imagecat` VALUES ('1','Default Smilies','1','1');";
$datas['imagecat'][]="INSERT INTO `"._PREFIX_."imagecat` VALUES ('2','Default Icons','2','1');";
$datas['imagecat'][]="INSERT INTO `"._PREFIX_."imagecat` VALUES ('3','Default Avatars','3','1');";
$datas['imagecat'][]="INSERT INTO `"._PREFIX_."imagecat` VALUES ('4','Users Avatars','3','0');";


$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('announcement','Announcements');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('editor','Editor');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('forumdisplay','Forum Display');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('global','Global');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('index','Index Page');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('login','Login');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('memberlist','Members List');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('newpost','New posting');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('online','Online users list');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('poll','Polls');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('profile','User Profile');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('showpost','Show Post');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('showteams','Show Forum Teams');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('showthread','Show Thread');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('contactus','Contact Us');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('register','Register');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('search','Search Engine');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('usercp','User Control Panel');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('calendar','Calendar');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('tools','Thread/Forum Tools');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('attachments','Attachments');";
$datas['phrasetype'][]="INSERT INTO `"._PREFIX_."phrasetype` VALUES ('admincp','Admin Control Panel');";


//
//
//  Settings and Settings groups ...
//
//
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (1, 'boardonoff', 'Turn your Forums on or off', 1);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (2, 'sitedetails', 'Your Website informations Title / Url / HomePage', 2);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (3, 'generalsetting', 'General Settings', 3);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (4, 'serveroptimization', 'Server Settings and optimization.', 4);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (5, 'bbcode', 'Your Codes Settings', 5);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (6, 'styleandlang', 'Style And Language settings', 6);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (7, 'registersetting', 'User Registeration and profile settings', 7);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (8, 'userban', 'User Banning Options', 8);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (9, 'messagepost', 'Threads And posts options', 9);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (10, 'attachments', 'Attachments options', 10);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (11, 'searchoptions', 'Search Engine Options', 11);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (12, 'homepage', 'Forum home page settings', 12);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (13, 'forumdisplay', 'Forum display settings and prefrences', 13);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (14, 'onlineandmemberlist', 'Online And members list options', 14);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (15, 'privatemessages', 'Private message options', 15);";
$datas['settinggroup'][]="INSERT INTO `"._PREFIX_."settinggroup` VALUES (16, 'admincpoptions', 'Admin Control panel options', 16);";



$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('1','BigGrin',':biggrin:','images/smilies/biggrin.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('2','Confused',':confused:','images/smilies/confused.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('3','Cool',':cool:','images/smilies/cool.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('4','Cools',':cool2:','images/smilies/cool2.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('5','DozingOff',':dozingoff:','images/smilies/dozingoff.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('6','Dry',':dry:','images/smilies/dry.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('7','Huh,!?',':huh:','images/smilies/huh.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('8','ImInLve',':inlove:','images/smilies/inlove.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('9','Laugh',':laugh:','images/smilies/laugh.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('10','Look Around',':lookaround:','images/smilies/lookaround.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('11','Mad',':mad:','images/smilies/mad.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('12','Notify',':notify:','images/smilies/notify.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('13','OhMy',':ohmy:','images/smilies/ohmy.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('14','RollEyes',':rolleyes:','images/smilies/rolleyes.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('15','Sad',':sad:','images/smilies/sad.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('16','Smile :)',':)','images/smilies/smile.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('17','Thumbs',':thumbs:','images/smilies/thumbs.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('18','Tounge',':p','images/smilies/tounge.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('19','Wink',';)','images/smilies/wink.gif','1');";
$datas['smilies'][]="INSERT INTO `"._PREFIX_."smilies` VALUES ('20','WuB,!!',':wub:','images/smilies/wub.gif','1');";

$datas['stats'][]="INSERT INTO `"._PREFIX_."stats` VALUES ('0','0','0','0','0','0','0','0');";

$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('1','Unregistered','','','50','5','','','0','1','1','1','1','1','0','0','1','1','1','0','0','0','1','1','1','0','1','1','1','1','0','0','0','1','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('2','Registered','','','50','5','','','0','1','1','1','1','1','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','0','0','1','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('3','Users Awaiting Email Confirmation','','','50','5','','','0','1','1','1','0','0','0','1','1','1','1','0','0','0','1','1','1','0','1','1','1','1','0','0','0','1','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('4','(COPPA) Users Awaiting Moderation','','','50','5','','','0','1','1','1','0','1','0','1','1','1','1','0','0','0','1','1','1','0','1','1','1','1','0','0','0','1','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('5','Super Moderators','','Super Moderator','50','5','<font color=\"blue\">','</font>','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('6','Administrators','For The Top Permissions Users','Administrator','50','5','<b><i><font color=\"red\">','</font></i></b>','1','1','1','1','1','1','1','1','0','0','0','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('7','Moderators','','Moderator','50','5','<font color=\"green\">','</font>','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','0','1','1','0','5','80','80','75000','5');";
$datas['usergroup'][]="INSERT INTO `"._PREFIX_."usergroup` VALUES ('8','Banned Users','','Banned','50','5','','','0','0','0','0','0','0','0','1','1','1','1','0','0','0','1','1','1','0','1','1','1','1','0','0','0','1','1','5','80','80','75000','5');";


//
// Users Titles
//

?>
