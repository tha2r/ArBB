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
#    Global File started
#

if(eregi('global.php',$HTTP_SERVER_VARS['PHP_SELF']))
{
die('You Cant Access This File ');
}



if((@ini_get('register_globals') || !@ini_get('gpc_order')) && (isset($_POST) || isset($_GET) || isset($_COOKIE)))
{
        foreach(array_keys($_GET+$_POST+$_COOKIE) as $key)
        {
                unset($$key);
        }
}

if(isset($_POST['GLOBALS'])||isset($_GET['GLOBALS']))
{
    die('you cant make you own global variables :)');
        }
//# Making The Define So i Will Be More Safe For your Forum ,,,

Define('IN_ARBB','ArBB 1.0.0 Beta 1',true);
 $IN_ARBB=IN_ARBB;
//# now we include the class variable $arbb class file

require('../includes/class_main.php');

//# Now We Kill the Globals so the forum will be more safe against attacks

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
//#      Getting The Config File ..
//#

require('../includes/config.php');

//#
//#            Defining Some Variables
//#

DEFINE('_PREFIX_',$dbprefix,true);
DEFINE('_CPREFIX_',$cookieprefix,true);

//#
//#     Get The DB Functions
//#


require('../includes/class_db.php');
$DB=new arbb_dbclass;
//#
//#      Connect To DB
//#

$dbconnect=$DB->connect($db_host,$db_user,$db_pass);
$dbselect=$DB->selectdb($db_name,$dbconnect);


//#
//#       Requiring The Functions And classes Files and making the class var
//#
$CP=1;

require('../includes/functions.php');
require('../includes/admin_functions.php');

require('../includes/admin_class_templates.php');
require('../includes/class_bbcode.php');
require('../includes/class_language.php');

//#  Making Classes variables

$TP          = new arbb_templates;
$bbcode      = new arbb_bbcode;
$language    = new arbb_language;


//#
//#          fetching forum options and defaults
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
  ini_set('zlib.output_compression_level', $options['gziplevel']);
  if(function_exists('ob_gzhandler') AND function_exists('ob_start'))
  {
      ob_start('ob_gzhandler');
  }
}
    if(!is_array($phrasearray))
    {
        $phrasearray='global';
            }
            else
            {
                $globalphrases=array('global');
                $phrasearray=array_merge($phrasearray,$globalphrases);
                    }

$language->checklang();
$lang = $language->getphrases($phrasearray);
//#
//#               Get The PSID Val
//#         The Variable In The Http Vars
//#               Like 985b830814175fa135340a744eb5f3f6
//#
$SID=md5(time());
$sid=$SID;

//#
//#           Getting The Commons
//#

$local      = array();
$localgroup = array();
$updates    = "";



//#
//#          Get The Templates
//#
//#
//#
//#
if(!empty($templatelist))
{
        $templatelist.=',';
}
else
{
        $templatelist ='';
}
$templatelist.='alert,footer,forum_page,redirection,error,login';

$TP->templatesused($templatelist);
$show['location_bar']=1;
/****************************************/
//# Globals File EnD
$cpstyle['dir']='default';
$cpstyle['right']='right';
$cpstyle['left']='left';

$titleetc="";
$show['bodytag']=1;

session_start();
if(session_is_registered('admin'))
{
$u=$_SESSION['local'];
       $query=$DB->query("select * from "._PREFIX_."users where userid='".addslashes(htmlspecialchars($u['userid']))."' and password = '".addslashes(htmlspecialchars($u['password']))."'");
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

if($login != 1)
{
if(
   (!$localgroup['canuseadmincp'])
   OR
   (!$local['userid'])
   OR
   (!$_SESSION['admin'])
   OR
   (!session_is_registered('admin'))
   OR
   (!session_is_registered('local'))
  )
{
       $query=$DB->query("select * from "._PREFIX_."users where userid='".addslashes(htmlspecialchars($arbb->input[''._CPREFIX_.'userid']))."'");
        while($row=$DB->fetch_array($query))
        {
          $user=$row;
        }
header("location:login.php");
die();
}
}

?>