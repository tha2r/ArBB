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

//# Checking if installation file exists .. will die here !
if(!1&is_dir("./install"))
{
die('
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>ArBB -> Error ..</title>
<style>
body{ FONT-SIZE: 14; FONT-FAMILY: Tahoma, Arial, Helvetica, sans-serif; TEXT-DECORATION: None; FONT-WEIGHT: Bold;}
a{ COLOR: #000;}
a:hover{ COLOR: #c0c0c0;}
</style>
</head>
<body>
<br />
<br />
<br />
<br />
 <center>
  <div style="border: 1px solid #000000;width:70%;">
   <div style="background:#E5E5E5;COLOR: red;font-weight:bold;">
   Security Error - Installation file is exists ..
   </div>
   <div style="border-top: 1px solid #000000;font-weight:bold;background:#F5F5F5;COLOR: #000000;text-align:left;">
    Please Delete/or change the name for (Install Dir) to enable the board .. it will stay disabled until it is deleted ..
   <br>
   If you want to install ArBB (Arabian Bulletin Board) click <a href="install/index.php">here to install</a>.
   </div>
  </div>
 </center>
</body>
');
}

//# Killing Globals if its automaticly registered --
//#(_POST|_GET|_COOKIE|_SERVER|_FILES|GLOBALS)
if((@ini_get('register_globals') || !@ini_get('gpc_order')) && (isset($_POST) || isset($_GET) || isset($_COOKIE)))
{
        foreach(array_keys($_POST+$_GET+$_COOKIE+$_SERVER+$_FILES) as $key)
        {
                if(($key != 'templatelist')&&($key != 'phrasearray'))
                {

                $$key='';
                unset($$key);
                $$key='';

                }
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

        foreach($arbb->input as $key => $val)
        {
           if(!get_magic_quotes_gpc())
           {
               $arbb->input[$key] = addslashes($val);
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
if(!$dbconnect)
{
 Die('ArBB Error .. Make sure you have configured arbb with currect information for your database');
}
$dbselect  = $DB->selectdb($db_name,$dbconnect);
if(!$dbselect)
{
 Die('ArBB Error .. Make sure you have configured arbb with currect information for your database');
}


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
$st       = array('styleid','langid');

      $st['styleid']=checkval($arbb->input['styleid']);
      if($st['styleid']>0)
      {
      $arbb->input[''._CPREFIX_.'styleid']=$arbb->input['styleid'];
          newcookie('styleid',$styleid);
              }
      $language->langid=checkval($arbb->input['langid']);
      if($language->langid>0)
      {
      $arbb->input[''._CPREFIX_.'langid']=$arbb->input['langid'];
          newcookie('langid',$language->langid);
              }

//#
//#           GLOBAL Classes Files (bbcode, templates, language and plugins)
//#

require('./includes/class_templates.php');
require('./includes/class_bbcode.php');
require('./includes/class_language.php');
require('./includes/class_plugins.php');

//#
//#  Making Classes variables
//#

$TP       = new arbb_templates;
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
  ini_set('zlib.output_compression_level', $options['gziplevel']);
  if(function_exists('ob_gzhandler') AND function_exists('ob_start'))
  {
      ob_start('ob_gzhandler');
  }
}


//#
//#   Check For default Style And language
//#


    $TP->checkstyle();
    $language->checklang();

    if(!is_array($phrasearray))
    {
        $phrasearray='global';
    }
    else
    {
      /*
        $globalphrases=array("global");
        $phrasearray=array_merge($phrasearray,$globalphrases);
      */

         $phrasearray[]='global';

    }

    $st['css'] = $TP->buildcss();
    $stylevar  = $TP->buildstylevars($st['stylevar']);
    $stylevar  = array_merge($stylevar,$st);
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
//#           Getting The Commons ..
//#
//#

$local      = array();
$localgroup = array();
$updates    = "";
$local      = checklogin();

if(is_array($local))
{
foreach($local as $key => $val)
{

 $local[$key]=($key != 'signature')?$bbcode->clearhtml($val):$val;
}
}
if($local['userid']>0)
{

 $local['ipaddress2']=getip();
 $local['whereurl']=$bbcode->clearhtml(addslashes($HTTP_SERVER_VARS['REQUEST_URI']));

 if($local['ipaddress'] != $local['ipaddress2'])
 {
 $DB->query("update "._PREFIX_."users set ipaddress='$local[ipaddress2]'$updates where userid='$local[userid]'");
 }

                $lastvisit=checkval($arbb->input[''._CPREFIX_.'lastvisit']);
                $lastactivity=checkval($arbb->input[''._CPREFIX_.'lastactivity']);

                if($local['lastvisit']<$lastvisit)
                {

                   $local['lastvisit']=$lastvisit;
                   $updates=",lastvisit='$lastvisit'";

                }


                if($local['lastactivity']<$lastactivity)
                {

                   $local['lastactivity']=$lastactivity;
                   $updates=",lastactivity='$lastactivity'";

                }

$localgroup=$DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='$local[usergroupid]'");

        $show['modcp_link']=0;
        $show['admincp_link']=0;


if($localgroup['canuseadmincp']==1)
{

    $show['admincp_link']=1;

        }
if($localgroup['canusemodcp']==1)
{

    $show['modcp_link']=1;

        }

        build_nav_button($lang['user_cp'],'usercp.php');
        build_nav_button($lang['faq'],'faq.php');
        build_nav_button($lang['members_list'],'memberlist.php');
        build_nav_button($lang['today_posts'],'search.php?do=todayposts');
        build_nav_button($lang['search'],'search.php','nav_search');
        build_nav_button($lang['calendar'],'calendar.php');
        build_nav_button($lang['log_out'],'login.php?do=logout');
        $local['lastvisit']=mydate($local[lastvisit],'last');
             eval("\$lang['nav_pm']=\"".$lang['nav_pm']."\";");

             if($local['pmpopup'] > 0)
             {
              $show['pmbox']=1;
             }

        }
        else
        {

$localgroup=$DB->query_now("select * from "._PREFIX_."usergroup where usergroupid='1'");

        $local['userid']    = 0;
        $local['username']  = 'Guest';
        $local['ipaddress'] = getip();
        $local['whereurl']  = urlencode($HTTP_SERVER_VARS['REQUEST_URI']);

                $lastvisit=checkval($arbb->input[''._CPREFIX_.'lastvisit']);
                $lastactivity=checkval($arbb->input[''._CPREFIX_.'lastactivity']);

                if($local['lastvisit']<$lastvisit)
                {

                   $local['lastvisit']=$lastvisit;

                }

                if($local['lastactivity']<$lastactivity)
                {

                   $local['lastactivity']=$lastactivity;

                }

        build_nav_button($lang['register'],'register.php');
        build_nav_button($lang['faq'],'faq.php');
        build_nav_button($lang['members_list'],'memberlist.php');
        build_nav_button($lang['search'],'search.php','nav_search');
        build_nav_button($lang['login'],'login.php');
        build_nav_button($lang['calendar'],'calendar.php');
                }

     $selectstyle_query=$DB->query("select * from "._PREFIX_."styles where userselect='1' order by styleid asc");

     if($DB->num_rows($selectstyle_query)>1)
     {

             $show['quickstylechooser']=1;
             $quickstylechooser='';

             while($styleoptions=$DB->fetch_array($selectstyle_query))
             {
             if($styleoptions['styleid']==$st['styleid'])
             {
                  $quickstylechooser.="<option value='$styleoptions[styleid]' class='td1' selected>$styleoptions[title]</option>";
                  }
                  else
                  {
                      $quickstylechooser.="<option value='$styleoptions[styleid]' class='td2'>$styleoptions[title]</option>";
                          }
                     }

     }

     $selectlanguage_query=$DB->query("select * from "._PREFIX_."language where userselect='1' order by languageid asc");

     if($DB->num_rows($selectlanguage_query)>1)
     {

             $show['quicklangchooser']=1;

             $quicklangchooser='';

             while($langoptions=$DB->fetch_array($selectlanguage_query))
             {
                   if($langoptions['languageid']==$language->langid)
                   {
                      $quicklangchooser.="<option value='$langoptions[languageid]' selected class='td2'>$langoptions[title]</option>";
                           }
                           else
                           {
                               $quicklangchooser.="<option value='$langoptions[languageid]' class='td1'>$langoptions[title]</option>";
                                       }
                     }

     }

     $forumjump = build_forumjump();

//#
//#          Get The Templates
//#

if(!empty($templatelist))
{
        $templatelist.=',';
}
else
{
        $templatelist ='';
}

if($language->lang['textdirection']=='rtl')
{
   $stylevar['right']   = 'left';
   $stylevar['left']    = 'right';
   $lang['dir']         = 'rtl';
   $stylevar['bodytag'] = str_replace('ltr','rtl',$stylevar['bodytag']);
   $stylevar['charset'] = $language->lang['charset'];
}
else
{
   $stylevar['right']   = 'right';
   $stylevar['left']    = 'left';
   $lang['dir']         = 'ltr';
   $stylevar['bodytag'] = str_replace('rtl','ltr',$stylevar['bodytag']);
   $stylevar['charset'] = $language->lang['charset'];
        }

$templatelist.='alert,header,headinclude,footer,navbar,forumpm,forum_page,redirection,error';

$TP->templatesused($templatelist);

//#
//#   Check if user isn't moderator and forum status is setted off !
//#
if($options['boardstat'] != 1)
{
if(!($show['admincp_link'] && $show['modcp_link']) && !(eregi('/login.php?',$HTTP_SERVER_VARS['PHP_SELF'])))
{
  alert($options['boardmsg']);
  }
  else
  {

   $show['offline_message']='on';

  }
}

if($show['pmbox']==1 && !(eregi('/login.php?',$HTTP_SERVER_VARS['PHP_SELF'])))
{
$DB->query("update "._PREFIX_."users set pmpopup=0");
$pmq=$DB->query("select p.*,u.usergroupid,u.joindate,u.birthday,u.posts,u.usertitle,u.avatarid,u.signature,u.location,u.ipaddress,u.username as musername,ug.opentag,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."pm p
                                      LEFT JOIN "._PREFIX_."users u on (u.userid=p.userid)
                                      LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                                      where p.userid='$local[userid]' Order BY p.pmid desc limit 1");

    while($pm=$DB->fetch_array($pmq))
    {


    $pm['pmtime']       = mydate($pm['dateline'],"last");
    $pm['title']        = $bbcode->clearhtml($pm['title']);
    $pm['message']      = $bbcode->build(substr($pm['message'],'0','350'));
    $pm['fusername']    = $pm['opentag'].$pm['fusername'].$pm['closetag'];

         if($localgroup['canviewip'])
         {
          $pm['user_ip']      = "<img src=\"$stylevar[dir]/status/user_ip.gif\" alt=\"$pm[ipaddress]\">";
         }

    $pmbox_pm = $TP->GetTemp('forumpm');
    }
}
                           $header       = $TP->GetTemp('header');
                           $headinclude  = $TP->GetTemp('headinclude');
                           $footer       = $TP->GetTemp('footer');

//#
//#
//#


/****************************************/
//# Globals File EnD
?>