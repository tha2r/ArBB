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
#    Archive File started
#
/*
        File name       -> Archive.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

// Used Templates list ,,

$templatelist='';

$phrasearray = array('announcement','forumdisplay','showthread','profile');
DEFINE('IN_ARCHIVE',1,true);
//# Killing Globals if its automaticly registered --
//#(_POST|_GET|_COOKIE|_SERVER|_FILES|GLOBALS)
if((@ini_get('register_globals') || !@ini_get('gpc_order')) && (isset($_POST) || isset($_GET) || isset($_COOKIE)))
{
        foreach(array_keys($_POST+$_GET+$_COOKIE+$_SERVER+$_FILES) as $key)
        {
                $$key='';
                unset($$key);
                $$key='';
        }
}


//# check if there was any try to add globals ,,

if(isset($_POST['GLOBALS'])||isset($_GET['GLOBALS'])||isset($_FILES['GLOBALS'])||isset($_COOKIE['GLOBALS'])||isset($_REQUEST['GLOBALS'])||isset($_ENV['GLOBALS']))
{
    die('Hacking attempt !!<br>you cant make your own global variables :)');
}

//# Making The Defines For the time and included files

Define('IN_ARBB','ArBB 1.0.0 Beta 1',true);
Define('TIMENOW',time(),true);
 $IN_ARBB=IN_ARBB;

//# now we include the class variable $arbb class file

if(file_exists('./.htaccess'))
{
$htaccess = 1;

}
chdir('./../');

require('./includes/class_main.php');

//# Now We Get our own inputs array

$arbb = new arbb_main;

$arbb->input = $_GET;

if(!is_array($arbb->input))
{

        $arbb->input = $_POST;
        }
        else
        {
                if(is_array($_POST))
                  {

                $arbb->input = array_merge($arbb->input,$_POST);

                               }
                }

                if(is_array($_COOKIE))
                {
                    if(is_array($arbb->input))
                    {
                        $arbb->input = array_merge($arbb->input,$_COOKIE);
                            }
                            else
                            {
                                $arbb->input = $_COOKIE;
                                    }

                        }



        //#
        //#         Checking if magic quotes are on
        //#  if not this code add slashes to the GPC keys
        //#
        function addslashes_array($var)
        {
         if(is_array($var))
         {
           foreach($var as $key => $val)
           {
              $var[$key]=addslashes_array($val);
           }

         }
         else
         {
           $var=addslashes($var);
         }

         return $var;
        }

        foreach($arbb->input as $key => $val)
        {
           if(!get_magic_quotes_gpc() || $key=='var')
           {

               $arbb->input[$key] = addslashes_array($val);
           }
           else
           {
               $arbb->input[$key] = $val;
           }
        }


//#
//#      Getting The Config File ..
//#

require('./includes/config.php');

//#
//#            Defining Table Prefix And Cookie Prefix
//#

DEFINE('_PREFIX_',$dbprefix,true);
DEFINE('_CPREFIX_',$cookieprefix,true);

//#
//#     Get The DB Functions
//#

require('./includes/class_db.php');
$DB = new arbb_dbclass;

//#
//#      Connect To DB
//#

$dbconnect = $DB->connect($db_host,$db_user,$db_pass);
$dbselect  = $DB->selectdb($db_name,$dbconnect);


//#
//#       Requiring The Functions And classes Files and making the class var
//#

//#
//#          The Functions File
//#
  $CP=0;
require('./includes/functions.php');

//#
//#         Requesting the selected Style and style variables
//#
$st       = array();

      $language->langid=checkval($arbb->input['langid']);
      if($language->langid>0)
      {
      $arbb->input[''._CPREFIX_.'langid']=$arbb->input['langid'];
          newcookie('langid',$language->langid);
              }

//#
//#           GLOBAL Classes Files (bbcode, templates, language and plugins)
//#

require('./includes/class_bbcode.php');
require('./includes/class_language.php');
require('./archive/templates.php');
require('./includes/class_plugins.php');
//#
//#  Making Classes variables
//#

$bbcode   = new arbb_bbcode;
$language = new arbb_language;
$plugins  = new arbb_plugins;



//#
//#          fetching Forum options and defaults
//#

 $options = getoptions();
 $show    = array();
 $lang    = array();
 $nav     = array();

//#
//#   Check if GZIP Compression is enabled
//#

if($options['usegzip'] == 1)
{
  @ini_set('zlib.output_compression_level', $options['gziplevel']);
  if(function_exists('ob_gzhandler') AND function_exists('ob_start'))
  {
      ob_start('ob_gzhandler');
  }
}

    $language->checklang();

    if(!is_array($phrasearray))
    {
        $phrasearray='global';
    }
    else
    {
         $phrasearray[]='global';
    }

    $lang      = $language->getphrases($phrasearray);
    $nav       = array();

    $titleetc              = '';
    $nav['whereurl']       = '';
    $options['webcontent'] = '';

//#
//#                  Get The SID Val
//#             The Variable In The Http Vars
//#          Like 985b830814175fa135340a744eb5f3f6
//#

$SID=md5(TIMENOW);

//#
//#           Getting The Common file ..
//#           Contains Some Variables
//#

//require('./common.php');

//#
//#          Get The Templates
//#


if($language->lang['textdirection']=='rtl')
{
   $lang['right']   = 'left';
   $lang['left']    = 'right';
   $lang['dir']         = 'rtl';
}
else
{
   $lang['right']   = 'right';
   $lang['left']    = 'left';
   $lang['dir']         = 'ltr';
}
   $lang['charset'] = $language->lang['charset'];

//#
//#   Check if user isn't moderator and forum status is setted off !
//#
if($options['boardstat'] != 1)
{
   header('location:../index.php');
}

//#
//#
//#
$options['use_friendly_archive']=1;

if(($options['use_friendly_archive']) OR ($arbb->input['htaccess']==1) OR ($htaccess == 1))
{
        $base_url = $options['address'].'/archive/%s-%s.html';
}
else
{
        $base_url = $options['address'].'/archive/index.php?do=%s&id=%s&.html';
}

$id=checkval($arbb->input['id']);
switch($arbb->input['action'])
{
case 'f':
$fullversionurl="../forumdisplay.php?fid=$id";
break;
case 't':
$fullversionurl="../showthread.php?tid=$id";
break;
default:
$fullversionurl='../index.php';
break;
}
// Caching plugins for requiring in the right place ,,
$plugins->cache('archive_start,archive_forum,archive_forum_thread,archive_thread_post,archive_complete');


$plugins->load('archive_start');

$fullversiontitle = '';
$id=checkval($arbb->input['id']);
if(empty($arbb->input['action']) OR ($arbb->input['action']==''))
{

$query=$DB->query("select * from "._PREFIX_."forum where active='1' order by displayorder ASC");

       while($fetchf=$DB->fetch_array($query))
       {
             $forums[$fetchf[mainid]][$fetchf[displayorder]][$fetchf[forumid]]=$fetchf;
       }
$mainforums='';
$subforumsbit='';


while(list($forumidinfo,$foruminf) = each ($forums[-1]))
{
     foreach($foruminf as $forumidinfo => $foruminfo)
     {
         $mainforum=$bbcode->clearhtml($foruminfo);
         if(is_array($forums[$forumidinfo]))
         {
             foreach($forums[$forumidinfo] as $r => $t)
             {
                 foreach($t as $subforumid => $subforuminfo)
                 {

                         $forum = $bbcode->clearhtml($subforuminfo);
                         $subforumsbit.=subbit(sprintf($base_url,'f',$forum['forumid']),$forum['title']);
                 }
             }
         }

         $mainforums.=mainbit($subforumsbit,sprintf($base_url,'f',$mainforum['forumid']),$mainforum['title']);
         $subforumsbit='';

     }
}
$options['webcontent'].=archive_table($mainforums,$lang['forums']);
          $fullversiontitle = $options['sitetitle'];
}
elseif($arbb->input['action']=='f')
{

$threadbits="";
$forum=$DB->query_now("select * from forum where forumid='$id'");
if(!$forum)
{
 die('Unknown Forum .. !! .. Hacking Attampt<br>ArBB');
}
$plugins->load('archive_forum');
    build_nav_tree($forum);
$fullversiontitle = $forum['title'];
$fullversionurl   = '../forumdisplay.php?fid='.$forum['forumid'];
$threadsq = $DB->query("select * from "._PREFIX_."thread where forumid='$forum[forumid]'");
while($td = $DB->fetch_array($threadsq))
{
$plugins->load('archive_forum_thread');
$threadbits.=subbit(sprintf($base_url,'t',$td['threadid']),$bbcode->clearhtml($td['title'])." <i> ($td[replycount] $lang[thread_replies])</i>");
}
          $subforumsquery=$DB->query("select * from "._PREFIX_."forum where mainid='$id' and active='1' order by displayorder ASC");
          $subforumsbit='';
          if($DB->num_rows($subforumsquery)>0)
          {
             $show['subforums']=1;
              while($sf=$DB->fetch_array($subforumsquery))
              {
                   $subforumsbit.=subbit(sprintf($base_url,'f',$sf['forumid']),$sf['title']);
              }
          }

if(strlen($subforumsbit)>0)
{
$options['webcontent'].=archive_table($subforumsbit,"$lang[sub_forums_from] : $forum[title]");
}
if(strlen($threadbits)>0)
{
  $options['webcontent'].=archive_table($threadbits,$forum['title']);
}

$titleetc = $forum['title'].' - ';
}
elseif($arbb->input['action']=='t')
{
$query=$DB->query("select t.*,f.title as ftitle,f.forumid,f.mainid,f.parentlist from "._PREFIX_."thread t left join "._PREFIX_."forum f on (f.forumid=t.forumid) where t.threadid='$id'");
$done=0;
while($td = $DB->Fetch_array($query))
{
$titleetc=$td['title'].' - ';
$td = $bbcode->clearhtml($td);
$forum=array('forumid' => $td['forumid'],
             'title' => $td['ftitle'],
             'mainid' => $td['mainid'],
             'parentlist' => $td['parentlist']);
build_nav_tree($forum);
build_nav_location($td['title'],'','add',1);
$fullversiontitle = $td['title'];
$fullversionurl   = '../showthread.php?tid='.$td['threadid'];
                   $posts_query=$DB->query("select p.*,u.usergroupid,u.usertitle,ug.opentag,u.posts,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."post p
                                      LEFT JOIN "._PREFIX_."users u on (u.userid=p.userid)
                                      LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                      where p.threadid='$td[threadid]' order by postid ASC");

while($post = $DB->fetch_array($posts_query))
{
$post['post']     = nl2br($bbcode->clearhtml($post['post']));
$post['date']     = mydate($post['dateline'],'last');
$post['username'] = $post['opentag'].$bbcode->clearhtml($post['username']).$post['closetag'];

 if($post['userid']>0)
 {
   if(empty($post['usertitle']))
   {
    $post['usertitle']=$post['gusertitle'];
   }
   if(empty($post['usertitle']))
   {
      $post['usertitle']=build_title($post['posts']);
   }
 }
 else
 {
     $post['usertitle']=$lang['guest'];
 }
$plugins->load('archive_thread_post');
$options['webcontent'].=print_post($post);

}
$done=1;
}

if($done==0)
{
die('Unknown Thread .. !! .. Hacking Attampt<br>ArBB');
}
}
$plugins->load('archive_complete');
print_archive();
?>