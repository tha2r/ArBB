<?php
/*******************************************************************\
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
# @                      ArBB V 1.0.0 Beta 1                      @ #
# @       All Copyrights are saved Arabian bulletin board team    @ #
# @                   Copyright © 2009 ArBB Team                  @ #
# @         ArBB Is Free Bulletin Board and not for sale          @ #
# @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ #
\*******************************************************************/
$tables=array();
$query=array();
$tables['administrator'] = "CREATE TABLE `"._PREFIX_."administrator` (
  `userid` int(10) unsigned NOT NULL default '0',
  `adminpermissions` int(10) unsigned NOT NULL default '0',
  `navprefs` mediumtext,
  `cssprefs` varchar(250) NOT NULL default '',
  `notes` mediumtext,
  `languageid` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`userid`)
) TYPE=MyISAM;";
$tables['adminmenu'] = "CREATE TABLE `"._PREFIX_."adminmenu` (
  `mid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(120) NOT NULL default '',
  `cat` varchar(100) NOT NULL default '-1',
  `url` varchar(120) NOT NULL default '',
  `disporder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`mid`),
  KEY `cat` (`cat`)
) TYPE=MyISAM;";

$tables['announcement'] = "CREATE TABLE `"._PREFIX_."announcement` (
  `aid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `userid` int(10) unsigned NOT NULL default '0',
  `startdate` int(10) unsigned NOT NULL default '0',
  `enddate` int(10) unsigned NOT NULL default '0',
  `announcement` mediumtext,
  `forumid` smallint(6) NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `announcementoptions` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`aid`),
  KEY `forumid` (`forumid`),
  KEY `startdate` (`enddate`,`forumid`,`startdate`)
) TYPE=MyISAM;";

$tables['attachment'] = "CREATE TABLE `"._PREFIX_."attachment` (
  `atid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `filename` varchar(100) NOT NULL default '',
  `filedata` mediumblob,
  `visible` smallint(5) unsigned NOT NULL default '0',
  `counter` int(10) unsigned NOT NULL default '0',
  `filesize` int(10) unsigned NOT NULL default '0',
  `postid` int(10) unsigned NOT NULL default '0',
  `filehash` varchar(32) NOT NULL default '',
  `posthash` varchar(32) NOT NULL default '',
  `thumbnail` mediumblob,
  `filetype` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`atid`),
  KEY `filesize` (`filesize`),
  KEY `filehash` (`filehash`),
  KEY `userid` (`userid`),
  KEY `posthash` (`posthash`,`userid`),
  KEY `postid` (`postid`),
  KEY `visible` (`visible`)
) TYPE=MyISAM;";
$tables['attachmenttype'] = "CREATE TABLE `"._PREFIX_."attachmenttype` (
  `attachtypeid` int(10) unsigned NOT NULL auto_increment,
  `extension` varchar(20) NOT NULL default '',
  `mimetype` varchar(255) NOT NULL default '',
  `maxsize` int(10) unsigned NOT NULL default '0',
  `maxwidth` smallint(5) unsigned NOT NULL default '0',
  `maxheigh` smallint(5) unsigned NOT NULL default '0',
  `thumbnail` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`attachtypeid`),
  KEY `extension` (`extension`)
) TYPE=MyISAM;";

$tables['avatar'] = "CREATE TABLE `"._PREFIX_."avatar` (
  `avid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `path` varchar(100) NOT NULL default '',
  `catid` smallint(5) unsigned NOT NULL default '0',
  `displayorder` smallint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (`avid`)
) TYPE=MyISAM;";


$tables['bbcode'] = "CREATE TABLE `"._PREFIX_."bbcode` (
  `bid` smallint(5) unsigned NOT NULL auto_increment,
  `tag` varchar(200) NOT NULL default '',
  `replacement` mediumtext NOT NULL,
  `explanation` mediumtext NOT NULL,
  `parms` smallint(5) unsigned NOT NULL default '0',
  `example` varchar(200) NOT NULL default '',
  `image` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`bid`)
) TYPE=MyISAM;";
$tables['events'] = "CREATE TABLE `"._PREFIX_."events` (
  `eid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(120) NOT NULL default '',
  `userid` int(10) unsigned NOT NULL default '0',
  `date` varchar(50) NOT NULL default '',
  `details` text NOT NULL,
  `private` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`eid`),
  KEY `private` (`private`)
) TYPE=MyISAM;";

$tables['faq'] = "CREATE TABLE `"._PREFIX_."faq` (
  `faqid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(120) NOT NULL default '',
  `phrasetitle` varchar(120) NOT NULL default '',
  `cat` varchar(100) NOT NULL default '-1',
  `description` varchar(120) NOT NULL default '',
  `document` text NOT NULL,
  `enabled` tinyint(3) unsigned NOT NULL default '1',
  `disporder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`faqid`,`title`),
  KEY `cat` (`cat`)
) TYPE=MyISAM;";

$tables['forum'] = "CREATE TABLE `"._PREFIX_."forum` (
  `forumid` smallint(5) unsigned NOT NULL auto_increment,
  `styleid` smallint(5) unsigned NOT NULL default '1',
  `title` varchar(100) NOT NULL default '',
  `description` text,
  `displayorder` smallint(6) NOT NULL default '1',
  `replycount` int(10) unsigned NOT NULL default '0',
  `threadcount` mediumint(8) unsigned NOT NULL default '0',
  `lastpost` int(11) NOT NULL default '0',
  `lastposter` varchar(100) NOT NULL default '',
  `lastposterid` int(11) NOT NULL default '0',
  `lastpostid` int(10) unsigned NOT NULL default '0',
  `lastthread` varchar(100) NOT NULL default '',
  `lastthreadid` int(11) NOT NULL default '0',
  `mainid` smallint(6) NOT NULL default '-1',
  `parentlist` varchar(50) NOT NULL default '',
  `canusepassword` tinyint(4) NOT NULL default '0',
  `password` varchar(50) NOT NULL default '',
  `isforum` tinyint(4) NOT NULL default '1',
  `active` tinyint(4) NOT NULL default '1',
  `open` tinyint(4) NOT NULL default '1',
  `link` varchar(200) NOT NULL default '',
  `sortfield` varchar(50) NOT NULL default 'lastpost',
  `sortorder` enum('asc','desc') NOT NULL default 'desc',
  PRIMARY KEY  (`forumid`)
) TYPE=MyISAM;";

$tables['forumpermission'] = "CREATE TABLE `"._PREFIX_."forumpermission` (
  `fpid` smallint(5) unsigned NOT NULL auto_increment,
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `usergroupid` smallint(5) unsigned NOT NULL default '0',
  `canviewforum` tinyint(4) NOT NULL default '1',
  `canviewthreads` tinyint(4) NOT NULL default '1',
  `candownattach` tinyint(4) NOT NULL default '1',
  `canviewcontent` tinyint(4) NOT NULL default '1',
  `canratethread` tinyint(1) unsigned NOT NULL default '1',
  `caneditattach` tinyint(1) unsigned NOT NULL default '1',
  `canpostattach` tinyint(1) unsigned NOT NULL default '1',
  `canpost` tinyint(4) NOT NULL default '1',
  `caneditpost` tinyint(4) NOT NULL default '1',
  `candelposts` tinyint(4) NOT NULL default '1',
  `canaddpoll` tinyint(3) NOT NULL default '1',
  `canvotepoll` tinyint(3) NOT NULL default '1',
  `candelpoll` tinyint(3) NOT NULL default '1',
  `caneditpoll` tinyint(3) NOT NULL default '1',
  PRIMARY KEY  (`fpid`),
  UNIQUE KEY `gidfid` (`usergroupid`,`forumid`)
) TYPE=MyISAM;";


$tables['forumread'] = "CREATE TABLE `"._PREFIX_."forumread` (
  `userid` int(10) unsigned NOT NULL default '0',
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `readtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`forumid`,`userid`),
  KEY `readtime` (`readtime`)
) TYPE=MyISAM;";

$tables['icon'] = "CREATE TABLE `"._PREFIX_."icon` (
  `iconid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `iconpath` varchar(100) NOT NULL default '',
  `cat` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`iconid`)
) TYPE=MyISAM;";

$tables['imagecat'] = "CREATE TABLE `"._PREFIX_."imagecat` (
  `catid` smallint(5) unsigned NOT NULL auto_increment,
  `title` char(100) NOT NULL default '',
  `type` tinyint(4) unsigned NOT NULL default '0',
  `default` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`catid`)
) TYPE=MyISAM;";

$tables['language'] = "CREATE TABLE `"._PREFIX_."language` (
  `languageid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `type` varchar(50) NOT NULL default '',
  `textdirection` varchar(12) NOT NULL default '',
  `userselect` smallint(5) unsigned NOT NULL default '1',
  `charset` varchar(12) NOT NULL default '',
  PRIMARY KEY  (`languageid`)
) TYPE=MyISAM;";

$tables['moderator'] = "CREATE TABLE `"._PREFIX_."moderator` (
  `modid` smallint(5) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `forumid` smallint(6) NOT NULL default '0',
  `caneditpost` tinyint(4) NOT NULL default '1',
  `candelposts` tinyint(4) NOT NULL default '1',
  `canviewips` tinyint(4) NOT NULL default '1',
  `canmovethreads` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`modid`),
  KEY `userid` (`userid`,`forumid`)
) TYPE=MyISAM;";

$tables['online'] = "CREATE TABLE `"._PREFIX_."online` (
  `dateline` int(10) unsigned NOT NULL default '0',
  `whereurl` varchar(250) NOT NULL default '',
  `wheretitle` varchar(250) NOT NULL default '',
  `userid` int(10) unsigned NOT NULL default '0',
  `username` varchar(250) NOT NULL default '',
  `userip` varchar(250) NOT NULL default '',
  `day` smallint(5) unsigned NOT NULL default '0',
  KEY `dateline` (`dateline`)
) TYPE=MyISAM;";

$tables['phrase'] = "CREATE TABLE `"._PREFIX_."phrase` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `languageid` smallint(6) NOT NULL default '0',
  `varname` varchar(250) binary NOT NULL default '',
  `phrasetype` varchar(20) NOT NULL default '',
  `text` mediumtext,
  `username` varchar(100) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `version` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `languageid` (`languageid`)
) TYPE=MyISAM;";

$tables['phrasetype'] = "CREATE TABLE `"._PREFIX_."phrasetype` (
  `name` varchar(50) NOT NULL default '',
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`name`)
) TYPE=MyISAM;";

$tables['plugin'] = "CREATE TABLE `"._PREFIX_."plugin` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `phpcode` text,
  `place` varchar(25) NOT NULL default '',
  `active` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`pid`),
  KEY `active` (`active`)
) TYPE=MyISAM;";

$tables['pm'] = "CREATE TABLE `"._PREFIX_."pm` (
  `pmid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL default '0',
  `fuid` int(10) unsigned NOT NULL default '0',
  `tuid` int(10) unsigned NOT NULL default '0',
  `fusername` varchar(100) NOT NULL default '',
  `tusername` varchar(100) NOT NULL default '',
  `opened` tinyint(4) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `message` mediumtext,
  `iconid` smallint(5) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `showsignature` smallint(5) unsigned NOT NULL default '0',
  `allowsmilie` smallint(5) unsigned NOT NULL default '1',
  `folder` smallint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (`pmid`),
  KEY `fuid` (`fuid`)
) TYPE=MyISAM;";

$tables['poll'] = "CREATE TABLE `"._PREFIX_."poll` (
  `pollid` int(10) unsigned NOT NULL auto_increment,
  `question` varchar(100) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `options` text,
  `active` smallint(6) NOT NULL default '1',
  `numberoptions` smallint(5) unsigned NOT NULL default '0',
  `timeout` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pollid`)
) TYPE=MyISAM;";

$tables['pollvote'] = "CREATE TABLE `"._PREFIX_."pollvote` (
  `voteid` int(10) unsigned NOT NULL auto_increment,
  `pollid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `date` int(10) unsigned NOT NULL default '0',
  `option` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`voteid`),
  KEY `pollid` (`pollid`,`userid`)
) TYPE=MyISAM;";

$tables['post'] = "CREATE TABLE `"._PREFIX_."post` (
  `postid` int(10) unsigned NOT NULL auto_increment,
  `threadid` int(10) unsigned NOT NULL default '0',
  `username` varchar(100) NOT NULL default '',
  `userid` int(10) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `post` mediumtext,
  `allowsmilie` smallint(6) NOT NULL default '0',
  `showsignature` smallint(6) NOT NULL default '0',
  `ipaddress` varchar(15) NOT NULL default '',
  `iconid` smallint(5) unsigned NOT NULL default '0',
  `visible` tinyint(1) NOT NULL default '0',
  `attach` smallint(5) unsigned NOT NULL default '0',
  `reportthreadid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`postid`),
  KEY `userid` (`userid`),
  KEY `threadid` (`threadid`,`userid`),
  FULLTEXT KEY `title` (`title`,`post`)
) TYPE=MyISAM;";


$tables['regimage'] = "CREATE TABLE `"._PREFIX_."regimage` (
  `imagehash` varchar(32) NOT NULL default '',
  `imagestring` varchar(8) NOT NULL default '',
  `dateline` bigint(30) NOT NULL default '0'
) TYPE=MyISAM;";

$tables['search'] = "CREATE TABLE `"._PREFIX_."search` (
  `sid` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL default '0',
  `dateline` int(11) NOT NULL default '0',
  `ipaddress` varchar(20) NOT NULL default '',
  `threads` text NOT NULL,
  `posts` text NOT NULL,
  `searchtype` varchar(10) NOT NULL default '',
  `resulttype` varchar(10) NOT NULL default '',
  `querycache` text NOT NULL,
  PRIMARY KEY  (`sid`)
) TYPE=MyISAM;";

$tables['setting'] = "CREATE TABLE `"._PREFIX_."setting` (
  `sid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(120) NOT NULL default '',
  `title` varchar(120) NOT NULL default '',
  `description` text NOT NULL,
  `optionscode` text NOT NULL,
  `value` text NOT NULL,
  `disporder` smallint(5) unsigned NOT NULL default '0',
  `sgid` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sid`)
) TYPE=MyISAM;";

$tables['settinggroup'] = "CREATE TABLE `"._PREFIX_."settinggroup` (
  `sgid` smallint(5) unsigned NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `title` varchar(220) NOT NULL default '',
  `disporder` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sgid`)
) TYPE=MyISAM;";

$tables['smilies'] = "CREATE TABLE `"._PREFIX_."smilies` (
  `sid` smallint(5) unsigned NOT NULL auto_increment,
  `title` char(100) NOT NULL default '',
  `text` char(20) NOT NULL default '',
  `path` char(100) NOT NULL default '',
  `cat` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`sid`)
) TYPE=MyISAM;";

$tables['stats'] = "CREATE TABLE `"._PREFIX_."stats` (
  `dateline` int(10) unsigned NOT NULL default '0',
  `users` mediumint(8) unsigned NOT NULL default '0',
  `threads` mediumint(8) unsigned NOT NULL default '0',
  `posts` mediumint(8) unsigned NOT NULL default '0',
  `nusersid` mediumint(8) unsigned NOT NULL default '0',
  `nusername` char(100) NOT NULL default '',
  `maxuserson` mediumint(8) unsigned NOT NULL default '0',
  `maxusersondate` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`dateline`)
) TYPE=MyISAM;";

$tables['styles'] = "CREATE TABLE `"._PREFIX_."styles` (
  `styleid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `type` varchar(50) NOT NULL default '',
  `stylevar` mediumtext,
  `cssaddition` text NOT NULL,
  `userselect` smallint(5) unsigned NOT NULL default '1',
  `dir` varchar(50) NOT NULL default 'images',
  PRIMARY KEY  (`styleid`)
) TYPE=MyISAM;";

$tables['templates'] = "CREATE TABLE `"._PREFIX_."templates` (
  `templateid` int(10) unsigned NOT NULL auto_increment,
  `styleid` smallint(6) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `template` mediumtext,
  `templatetype` enum('template','css') NOT NULL default 'template',
  `cssaddition` mediumtext,
  `dateline` int(10) unsigned NOT NULL default '0',
  `username` varchar(100) NOT NULL default '',
  `version` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`templateid`),
  UNIQUE KEY `title` (`title`,`styleid`)
) TYPE=MyISAM;";

$tables['thread'] = "CREATE TABLE `"._PREFIX_."thread` (
  `threadid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `firstpostid` int(10) unsigned NOT NULL default '0',
  `lastpostid` int(10) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL default '0',
  `forumid` smallint(5) unsigned NOT NULL default '0',
  `pollid` int(10) unsigned NOT NULL default '0',
  `open` smallint(6) NOT NULL default '0',
  `replycount` int(10) unsigned NOT NULL default '0',
  `postusername` varchar(100) NOT NULL default '',
  `postuserid` int(10) unsigned NOT NULL default '0',
  `lastposter` varchar(50) NOT NULL default '',
  `lastposterid` int(10) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `views` int(10) unsigned NOT NULL default '0',
  `iconid` smallint(5) unsigned NOT NULL default '0',
  `notes` varchar(250) NOT NULL default '',
  `visible` smallint(6) NOT NULL default '0',
  `sticky` smallint(6) NOT NULL default '0',
  `votenum` smallint(5) unsigned NOT NULL default '0',
  `votetotal` smallint(5) unsigned NOT NULL default '0',
  `attach` smallint(5) unsigned NOT NULL default '0',
  `similar` varchar(55) NOT NULL default '',
  PRIMARY KEY  (`threadid`),
  KEY `postuserid` (`postuserid`),
  KEY `pollid` (`pollid`),
  KEY `forumid` (`forumid`,`visible`,`sticky`,`lastpost`),
  KEY `lastpost` (`lastpost`,`forumid`),
  KEY `dateline` (`dateline`),
  FULLTEXT KEY `title` (`title`)
) TYPE=MyISAM;";

$tables['threadrate'] = "CREATE TABLE `"._PREFIX_."threadrate` (
  `threadrateid` int(10) unsigned NOT NULL auto_increment,
  `threadid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `vote` smallint(6) NOT NULL default '0',
  `ipaddress` char(15) NOT NULL default '',
  PRIMARY KEY  (`threadrateid`),
  KEY `threadid` (`threadid`,`userid`)
) TYPE=MyISAM;";

$tables['threadsubscribe'] = "CREATE TABLE `"._PREFIX_."threadsubscribe` (
  `stid` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `threadid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`stid`),
  UNIQUE KEY `threadid` (`threadid`,`userid`),
  KEY `userid` (`userid`)
) TYPE=MyISAM;";

$tables['usergroup'] = "CREATE TABLE `"._PREFIX_."usergroup` (
  `usergroupid` smallint(5) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `description` varchar(250) NOT NULL default '',
  `usertitle` varchar(100) NOT NULL default '',
  `pmquota` smallint(5) unsigned NOT NULL default '50',
  `pmsendmax` smallint(5) unsigned NOT NULL default '5',
  `opentag` varchar(100) NOT NULL default '',
  `closetag` varchar(100) NOT NULL default '',
  `isforumteam` smallint(5) unsigned NOT NULL default '0',
  `canviewforum` smallint(5) unsigned NOT NULL default '1',
  `canviewthreads` smallint(5) unsigned NOT NULL default '1',
  `candownattach` tinyint(4) NOT NULL default '1',
  `canviewcontent` tinyint(4) NOT NULL default '1',
  `canviewonline` tinyint(4) NOT NULL default '1',
  `canviewip` tinyint(4) unsigned NOT NULL default '0',
  `cansearch` tinyint(1) unsigned NOT NULL default '1',
  `canviewcalendar` tinyint(1) unsigned NOT NULL default '1',
  `caneditevents` tinyint(1) unsigned NOT NULL default '1',
  `canaddevents` tinyint(1) unsigned NOT NULL default '1',
  `canpost` tinyint(4) NOT NULL default '1',
  `caneditpost` tinyint(4) NOT NULL default '1',
  `candelposts` tinyint(4) NOT NULL default '1',
  `canratethread` tinyint(1) unsigned NOT NULL default '1',
  `canpostattach` tinyint(1) unsigned NOT NULL default '1',
  `caneditattach` tinyint(1) unsigned NOT NULL default '1',
  `canusepm` smallint(5) unsigned NOT NULL default '1',
  `canaddpoll` smallint(3) unsigned NOT NULL default '1',
  `canvotepoll` smallint(3) unsigned NOT NULL default '1',
  `candelpoll` smallint(3) unsigned NOT NULL default '1',
  `caneditpoll` smallint(3) unsigned NOT NULL default '1',
  `ismoderator` tinyint(4) NOT NULL default '1',
  `canuseadmincp` smallint(5) unsigned NOT NULL default '0',
  `canusemodcp` smallint(5) unsigned NOT NULL default '0',
  `canuseusercp` tinyint(1) unsigned NOT NULL default '1',
  `isbanned` tinyint(3) unsigned NOT NULL default '0',
  `attachlimit` int(10) unsigned NOT NULL default '0',
  `avatarmaxwidth` smallint(5) unsigned NOT NULL default '80',
  `avatarmaxheigh` smallint(5) unsigned NOT NULL default '80',
  `avatarmaxsize` int(10) unsigned NOT NULL default '2000',
  `sigmaximages` smallint(5) unsigned NOT NULL default '5',
  PRIMARY KEY  (`usergroupid`)
) TYPE=MyISAM;";

$tables['users'] = "CREATE TABLE `"._PREFIX_."users` (
  `userid` int(10) unsigned NOT NULL auto_increment,
  `usergroupid` smallint(5) unsigned NOT NULL default '0',
  `username` varchar(100) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `styleid` smallint(5) unsigned NOT NULL default '0',
  `homepage` varchar(100) NOT NULL default '',
  `icq` varchar(20) NOT NULL default '',
  `aim` varchar(20) NOT NULL default '',
  `yahoo` varchar(32) NOT NULL default '',
  `msn` varchar(100) NOT NULL default '',
  `showsignature` smallint(4) unsigned NOT NULL default '1',
  `showbbcode` smallint(5) unsigned NOT NULL default '0',
  `showbirthday` smallint(5) unsigned NOT NULL default '2',
  `usertitle` varchar(250) NOT NULL default '',
  `customtitle` smallint(6) NOT NULL default '0',
  `joindate` int(10) unsigned NOT NULL default '0',
  `daysprune` smallint(6) NOT NULL default '0',
  `lastvisit` int(10) unsigned NOT NULL default '0',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  `lastpost` varchar(250) NOT NULL default '0',
  `lastpostid` int(10) unsigned NOT NULL default '0',
  `posts` int(10) unsigned NOT NULL default '0',
  `pmpopup` smallint(6) NOT NULL default '0',
  `folders` text NOT NULL,
  `avatarid` smallint(6) NOT NULL default '0',
  `birthday` varchar(15) NOT NULL default '',
  `ipaddress` varchar(15) NOT NULL default '',
  `referrerid` int(10) unsigned NOT NULL default '0',
  `languageid` smallint(5) unsigned NOT NULL default '0',
  `autosubscribe` smallint(6) NOT NULL default '-1',
  `pmtotal` smallint(5) unsigned NOT NULL default '0',
  `pmunread` smallint(5) unsigned NOT NULL default '0',
  `ipoints` int(10) unsigned NOT NULL default '0',
  `signature` text NOT NULL,
  `location` varchar(150) NOT NULL default '0',
  PRIMARY KEY  (`userid`),
  KEY `usergroupid` (`usergroupid`),
  KEY `username` (`username`),
  KEY `birthday` (`birthday`,`showbirthday`)
) TYPE=MyISAM;";

$tables['usertitle'] = "CREATE TABLE `"._PREFIX_."usertitle` (
  `usertitleid` smallint(5) unsigned NOT NULL auto_increment,
  `minposts` smallint(5) unsigned NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`usertitleid`)
) TYPE=MyISAM;";

$tables['verification'] = "CREATE TABLE `"._PREFIX_."verification` (
  `userid` smallint(5) unsigned NOT NULL default '0',
  `dateline` int(11) unsigned NOT NULL default '0',
  `code` varchar(150) NOT NULL default '',
  `query` text NOT NULL,
  `addition` varchar(25) NOT NULL default ''
) TYPE=MyISAM;";
?>
