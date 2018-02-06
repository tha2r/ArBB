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
#    Install File started
#
/*
        File name       -> install.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

chdir('./../');
Define('PATH',GetCWD().'/',true);
if((@ini_get('register_globals') || !@ini_get('gpc_order')) && (isset($_POST) || isset($_GET) || isset($_COOKIE)))
{
        foreach(array_keys($_POST+$_GET+$_COOKIE+$_SERVER+$_FILES) as $key)
        {
                unset($$key);
        }
}
if(isset($_POST['GLOBALS'])||isset($_GET['GLOBALS'])||isset($_FILES['GLOBALS'])||isset($_COOKIE['GLOBALS'])||isset($_REQUEST['GLOBALS'])||isset($_ENV['GLOBALS']))
{
    die('Hacking attempt !!<br>you cant make your own global variables :)');
}
Define('IN_ARBB','ArBB 1.0.0 Beta 1',true);
Define('TIMENOW',time(),true);
 $IN_ARBB=IN_ARBB;

require_once('./includes/class_main.php');
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
unset($_GET,$_POST,$_COOKIE);
$contents='';
$step=($arbb->input['step'])?$arbb->input['step']:1;
$langfile=$arbb->input['lang'];


if(strlen($langfile)>0)
{
 $find    = array('http','.','\\','/','index');
 $replace = array('','','','','');
  $langfile = str_replace($find,$replace,$langfile);
  $languagefile='install/languages/'.$langfile.'.php';

 if(@file_exists($languagefile))
 {
require_once(PATH."$languagefile");
 }
 else
 {
$langfile='english';
require_once(PATH.'install/languages/english.php');
 }

}
else
{
$langfile='english';
  $languagefile='install/languages/'.$langfile.'.php';
  require_once(PATH."$languagefile");
}
$license_file='install/languages/'.$langfile.'_license.txt';
if($step > 3)
{
 require_once(PATH.'includes/config.php');
 require_once(PATH.'includes/class_db.php');
}

if($step > 4)
{

DEFINE('_PREFIX_',$dbprefix,true);
DEFINE('_CPREFIX_',$cookieprefix,true);
$DB = new arbb_dbclass;
$dbconnect = $DB->connect($db_host,$db_user,$db_pass);
$dbselect  = $DB->selectdb($db_name,$dbconnect);
}
if(!$dbselect&&$step > 4)
{

  $contents=error($lang['mysql_config_error']);
}
else
{
if($step==1)
{
$contents="$lang[welcome_message]
           <form action=\"install.php?step=2\" method=\"post\">
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <select name=\"lang\">";
$dr=opendir(PATH.'install/languages');
while($language = readdir($dr))
{
 if(($language != '.') AND ($language != '..') AND ($language != 'index.php') And (!eregi('.txt',$language)))
 {
 $language=str_replace('.php','',$language);
  $contents.="<option value=\"$language\">$language</option>";
 }
}
$contents.='</select>&nbsp;&nbsp;'.div(submit($lang['choose']),''," align=\"$lang[right]\"").'</form>';

}
elseif($step==2)
{
$tcons = tr(td($lang['requirements_check'],'',2));

  $version = @phpversion();
  $tcons.= tr(td($lang['php_version'],'td2').td($version,'td2'));

  if(!function_exists('mysql_query'))
  {
    $error=1;
    $phrase=$lang['error'];
  }
  else
  {
    $phrase=$lang['ok'];
  }
  $tcons.= tr(td($lang['mysql_support'],'td1').td($phrase,'td1'));

  if(!function_exists('xml_parser_create'))
  {
    $error=1;
    $phrase=$lang['not_installed'];
  }
  else
  {
    $phrase=$lang['installed'];
  }
  $tcons.= tr(td($lang['php_xml_extension'],'td2').td($phrase,'td2'));

  $writable = is_writable(PATH."images/avatars");
  if(!$writable)
  {
   $error = 1;
   $phrase=$lang['not_writable'];
  }
  else
  {
   $phrase=$lang['writable'];
  }
  $tcons.= tr(td($lang['avatars_dir_writable'],'td1').td($phrase,'td1'));


        $contents="<h2>$lang[requirements_check]</h1>
                   <br>$lang[requirements_check_note]
                   <br>
                   <br>
                   ".table($tcons);
        if(!$error)
        {
          $contents.=form('3',div(submit($lang['continue']),''," align=\"$lang[right]\""));
        }
        else
        {
          $contents.=div($lang['error_cannot_continue'],''," align=\"center\"");
        }

}
elseif($step==3)
{
        $contents="<h2>$lang[license_agreement]</h1>
                   <br>
                   <br>
                   ".div(''.file_get_contents(PATH.$license_file).'','agreement');
          $contents.=form('4',div(submit($lang['iagree']),''," align=\"$lang[right]\""));
}
elseif($step==4)
{
$tcons  = tr(td($lang['database_configuration'],"",2));
$tcons .= tr(td($lang['database_host'],'td2').td(input('text','dbhost',$db_host,'ReadOnly'),'td1'));
$tcons .= tr(td($lang['database_user'],'td2').td(input('text','dbuser',$db_user,'ReadOnly'),'td1'));
$tcons .= tr(td($lang['database_pass'],'td2').td(input('password','dbpass',$db_pass,'ReadOnly'),'td1'));
$tcons .= tr(td($lang['database_name'],'td2').td(input('text','dbname',$db_name,'ReadOnly'),'td1'));
$tcons .= tr(td($lang['table_prefix'],"tcat",2));
$tcons .= tr(td($lang['table_prefix'],'td2').td(input("text","prefix",$dbprefix,"ReadOnly"),'td1'));
        $contents="<h2>$lang[database_configuration]</h1>
                   <br>$lang[database_configuration_note]
                   <br>
                   <br>".table($tcons,'95%');
          $contents.=form('5',div(submit($lang['continue']),''," align=\"$lang[right]\""));
}
elseif($step==5)
{
require_once(PATH.'install/inst/tables.php');
   foreach($tables as $key => $val)
   {
     $query[$key]=$DB->query($val,false);
   }
   $tablesc="";

   $error=0;
   foreach($query as $key => $val)
   {
    if(!$val)
    {
       $tablesc.=sprintf($lang['createdberror'],$key)."\n<br>\n";
       $error=1;
    }
    else
    {
       $tablesc.=sprintf($lang['createdbdone'],$key)."\n<br>\n";
    }
   }
   $contents.= $tablesc;
   if(!$error)
   {
     $contents.=form('6',div(submit($lang['continue']),''," align=\"$lang[right]\""));
   }
   else
   {

   }

}
elseif($step == 6)
{
$error=0;
require_once(PATH.'install/inst/data.php');
    foreach($datas as $key => $val)
    {
     $query="";
     foreach($val as $key2 => $val)
     {

      $query=$DB->query($val);
     }
     if(!$query)
     {
       $error=1;
       $tablesc.=sprintf($lang['insertdataerror'],$key)."\n<br>\n";
     }
     else
     {
       $tablesc.=sprintf($lang['insertdatadone'],$key)."\n<br>\n";
     }
    }
   $contents.=$tablesc;
   if(!$error)
   {
     $contents.=form('7',div(submit($lang['continue']),''," align=\"$lang[right]\""));
   }
   else
   {

   }
}
elseif($step==7)
{
require_once(PATH.'includes/class_xml.php');

$xml  = new arbb_xml;
$lxml = new arbb_xml;

$xml->xml('',PATH.'install/arbb-style.xml');
$lxml->xml('',PATH.'install/'.$langfile.'-language.xml');

$st = $xml->parse();
$st['title']=$lang['default_style'];
$contents.='<h2>'.$lang['importing_style'].'</h2>';
$ins = $DB->query("insert into "._PREFIX_."styles (title,stylevar,cssaddition,dir,userselect,type) values ('$st[title]','$st[stylevar]','$st[cssaddition]','$st[dir]','1','default')");
$styleid=$DB->insert_id();

foreach($st['cssbits']['css'] as $key => $val)
{
$DB->query("insert into "._PREFIX_."templates (styleid,title,template,templatetype,dateline,username,version) values('$styleid','$val[title]','".addslashes($val[value])."','css','$val[dateline]','$val[username]','$val[version]')");
}

foreach($st['templates']['template'] as $key => $val)
{
$DB->query("insert into "._PREFIX_."templates (styleid,title,template,templatetype,dateline,username,version) values('$styleid','$val[title]','".addslashes($val[value])."','template','$val[dateline]','$val[username]','$val[version]')");
}
$contents.='&nbsp;&nbsp;<b><font size="5" color="green">'.$lang['done'].'</font></b><br>';
$lng = $lxml->parse();
if((!is_array($lng))||(!isset($lng['charset']))||(!isset($lng['textdirection'])))
{
 error_message($lang['error_file_not_valid']);
}

$contents.='<h2>'.$lang['importing_lang'].'</h2>';
 $lng['title']=($lng['title'])?$lng['title']:$lang['default_lang'];
$ins = $DB->query("insert into "._PREFIX_."language (title,textdirection,charset,userselect,type) values ('$lng[title]','$lng[textdirection]','$lng[charset]','1','default')");
$langid=$DB->insert_id();
foreach($lng['phrasetype'] as $ky => $vl)
{
$phrasetype=$vl['name'];
if(is_array($vl['phrase'][0]))
{
 foreach($vl['phrase'] as $key => $val)
 {

  foreach($val as $k => $v)
  {
   $val[$k]=addslashes($v);
  }
  $DB->query("insert into "._PREFIX_."phrase (languageid,varname,phrasetype,text,username,dateline,version) values ('$langid','$val[varname]','$phrasetype','$val[value]','$val[username]','$val[date]','$val[version]')");
 }
}
else
{
  $phrase=$vl['phrase'];
  foreach($phrase as $k => $v)
  {
   $phrase[$k]=addslashes($v);
  }
  $DB->query("insert into "._PREFIX_."phrase (languageid,varname,phrasetype,text,username,dateline,version) values ('$langid','$phrase[varname]','$phrasetype','$phrase[value]','$phrase[username]','$phrase[date]','$phrase[version]')");
}
}
$contents.="&nbsp;&nbsp;<b><font size=\"5\" color=\"green\">".$lang['done']."</font></b><br>";
$contents.=form("8",div(submit($lang['continue']),""," align=\"$lang[right]\""));
}
elseif($step==8)
{
$tcons  = tr(td($lang['forum_info'],'',2));
$tcons .= tr(td($lang['forum_title'],'td2').td(input('text','ftitle','Forums'),'td1'));
$tcons .= tr(td($lang['forum_url'],'td2').td(input('text','furl',dirname(dirname($_SERVER['HTTP_REFERER']))),'td1'));
$tcons .= tr(td($lang['web_info'],'',2));
$tcons .= tr(td($lang['web_title'],'td2').td(input('text','wtitle','My Website'),'td1'));
$tcons .= tr(td($lang['web_url'],'td2').td(input('text','wurl',dirname(dirname(dirname($_SERVER['HTTP_REFERER'])))),'td1'));
$tcons .= tr(td($lang['contact_info'],'',2));
$tcons .= tr(td($lang['email'],'td2').td(input('text','cmail','mail@web.com'),'td1'));
        $contents="<h2>$lang[board_configuration]</h1>
                   <br>
                   <br>".table($tcons,'95%');
          $contents=form('9',$contents.div(submit($lang['continue']),''," align=\"$lang[right]\""));
}
elseif($step==9)
{  $contents='';
 $arrayed=array('ftitle','furl','wtitle','wurl','cmail');
    foreach($arrayed as $key => $val)
    {
      $$val = $arbb->input[$val];
    }
 require_once(PATH.'install/inst/settings.php');
   $result=false;
    foreach($query as $key => $val)
    {
      $result=$DB->query($val);
    }
    if(!$result)
    {
       $contents.=error($lang['configured_error']);
    }
    else
    {
       $contents.=' . . . . . . . . . . Board Configured . . . . . . . . . . ';

$tcons  = tr(td($lang['userinfo'],'',2));
$tcons .= tr(td($lang['username'],'td2').td(input('text','username',''),'td1'));
$tcons .= tr(td($lang['password'],'td2').td(input('password','password1',''),'td1'));
$tcons .= tr(td($lang['password2'],'td2').td(input('password','password2',''),'td1'));
$tcons .= tr(td($lang['contact_info'],'',2));
$tcons .= tr(td($lang['email'],'td2').td(input('text','cmail','mail@web.com'),'td1'));
        $form = '<h2>'.$lang['steps']['9'].'</h1>
                 <br>
                 <br>'.table($tcons,'95%');
       $contents.=form("10",$form.div(submit($lang['continue']),''," align=\"$lang[right]\""));
    }


}
elseif($step==10)
{
$username  = $arbb->input['username'];
$password1 = $arbb->input['password1'];
$password2 = $arbb->input['password2'];
$email     = $arbb->input['cmail'];
$dateline  = time();
$ipaddress = getip();

  if((md5($password1) == md5($password2)) && ($password1 != '') && (strlen($password1)>3) && (strlen($username) > 3))
  {
    $password = md5($password1);
    $DB->query("INSERT INTO `"._PREFIX_."thread` VALUES (1, 'Welcome To ArBB', 1, 1, 0, 2, 0, 1, 0, '', 1, '', 1, 0, 0, 10, '', 1, 0, 0, 0, 0, '');");
    $DB->query("INSERT INTO `"._PREFIX_."post` VALUES (1, 1, '', 1, 'Welcome To ArBB', '".time()."', 'Welcome To your forums..\r\nYour (Arabian bulletin board) Forum has been successfully installed ..\r\nYou Can Login and edit this post by logging in with your main administartor account and click edit post ..\r\n\r\nThank you for installing ArBB.', 0, 1, '127.0.0.1', 10, 1, 0, 0)");
    $DB->query("INSERT INTO "._PREFIX_."`users` VALUES (1, 6, '".$username."', '".$password."', '".$email."', 0, '', '', '', '', '', 1, 1, 1, '0','1', ".$dateline.", 0, 0, 0, '', 0, 1, 1, '',0, '', '".$ipaddress."', 0, 1, 1, 0, 0, 0, '', '')");
    $DB->query("UPDATE "._PREFIX_."thread set dateline='".$dateline."',lastpost='".$dateline."',postusername='".$username."',lastposter='".$username."' where threadid='1'");
    $DB->query("UPDATE "._PREFIX_."post set dateline='".$dateline."',username='".$username."',dateline='".$dateline."',ipaddress='".$ipaddress."' where postid='1'");
    $DB->query("UPDATE "._PREFIX_."stats set users='1',threads='1',posts='1',dateline='".$dateline."',nusersid='1',nusername='".$username."'");
      $trs  = tr(td($lang['steps']['10'],''));
      $trs .= tr(td($lang['setup_finished_message'],'td1'));
    $contents.= '<br>'.table($trs,'95%');
  }
  else
  {
   $contents.=error($lang['password_not_match']);
  }

}

//End ..
}



  $lnsteps=$lang['steps'];
   foreach($lnsteps as $key => $val)
   {
    if($val !== '')
    {
     if($key == $step)
     {
      $steps.='&raquo;&nbsp;'.$val.'\n<br>';
     }
     else
     {
      $steps.='&nbsp;&nbsp;&nbsp;'.$val.'\n<br>';
     }
    }
   }

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"$lang[dir]\">\n<head>\n        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=$lang[charset]\">\n        <meta name=\"Author\" content=\"Thaer\">\n        ";
//<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
Echo '<style>'.file_get_contents("install/style.css").'</style>';
Echo "\n        <title>$lang[title]</title>\n</head>\n<body>\n        <div id=\"content\">\n                <div class=\"header\">\n                    <h1>$lang[title]</h1>\n                </div>\n                <div class=\"subheader\">\n                                <b>$lang[title_sub]</b>\n                </div>\n                <div class=\"right\">$contents\n                </div>\n                <div class=\"left\">$steps<br>\n                </div>\n                <div class=\"footer\">\n                ArBB Inatallation script V 1.0<br>\n                All Copyrights Are Saved &copy; 2007 ArBB Team\n                </div>\n        </div>\n</body>\n</html>";

function table($contents,$width='90%',$cellspacing='1',$cellpadding='4',$class='table_border',$align='center')
{
 return "
 <table width=\"$width\" cellspacing=\"$cellspacing\" cellpadding=\"$cellpadding\" class=\"$class\" align=\"$align\">
   $contents
 </table>
        ";
}

function tr($contents,$class='tcat')
{
 return "
    <tr class=\"$class\">
    $contents
    </tr>";
}
function td($contents,$class='',$colspan='0')
{
$class=($class)?" class=\"$class\"":'';
$colspand=($colspan)?" colspan=\"$colspan\"":'';
 return '<td'.$colspand.$class.">$contents</td>";
}
function div($contents,$class='',$etc='')
{
 $class=($class)?" class=\"$class\"":'';
 return '<div '.$etc.$class.">$contents</div>";
}
function form($step,$contents)
{
        GLOBAL $langfile;
 return "<form action=\"install.php?step=$step&lang=$langfile\" method=\"post\">$contents</form>";
}
function submit($value)
{
 return "<input type=\"submit\" value=\"$value\" class=\"submit\">";
}
function input($type='text',$name='',$value='',$additional='')
{
 return "<input type=\"$type\" value=\"$value\" name=\"$name\" $additional>";
}
function error($errorvalue)
{

return '<br>'.table(tr(td($errorvalue,'td2')),'95%');
}
              function getip()
              {
               global $_SERVER;

                      if (isset($_SERVER['HTTP_CLIENT_IP']))
                      {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                      }
                      else if($_SERVER['HTTP_X_FORWARDED_FOR'])
                      {
                         if(preg_match_all("#[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}#s", $_SERVER['HTTP_X_FORWARDED_FOR'], $ips))
                         {
                              while(list($key, $val) = each($ips[0]))
                              {
                                   if(!preg_match("#^(10|172\.16|192\.168)\.#", $val))
                                   {
                                         $ip = $val;
                                         break;
                                   }
                              }
                         }
                      }
                      else if (isset($_SERVER['REMOTE_ADDR']))
                      {
                       $ip = $_SERVER['REMOTE_ADDR'];
                      }

                return $ip;
              }
//###############################################################\\
//#                ArBB Installation script                     #\\
//#                     Ver 1.0 Beta 1                          #\\
//#                    Done By : Thaer                          #\\
//###############################################################\\
?>
