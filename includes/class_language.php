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
#    Language Class started
#
/*
        File name       -> class_languge.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Class
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

Class arbb_language{

// Start Variables Which will be used here


  var $langid=1;
  var $powered_by='ArBB';


// End Variables Which will be used here :)
              function checklang()
              {
                       Global $DB,$arbb;


                      $langid = checkval(trim($arbb->input[''._CPREFIX_.'langid']));
                      $error=1;

                      if(!empty($langid))
                      {
                        $query=$DB->query('select * from '._PREFIX_."language where languageid='$langid'");

                        while($row=$DB->fetch_array($query))
                        {

                        $error=0;
                              $this->langid=$row['languageid'];
                              $this->lang=$row;
                        }
                      }

                      if($error==1)
                      {
                        $query=$DB->query('select * from '._PREFIX_."language where type='default'");
                        while($row=$DB->fetch_array($query))
                        {

                              $this->langid=$row['languageid'];
                              $this->lang=$row;
                              newcookie('langid',$this->langid);
                        }
                      }

              }

              function GetPhrases($GroupName)
              {
               Global $DB,$lang,$language;

               if(is_array($GroupName))
               {
                       $groups='';
                       $comma='';

                  foreach($GroupName as $num => $value)
                  {
                           $groups.=$comma."'$value'";
                           $comma=",";
                   }

                        $query=$DB->query('SELECT varname,text FROM '._PREFIX_."phrase where phrasetype in($groups) and languageid='$language->langid'");
                       }
                       else
                       {

               $query=$DB->query('SELECT varname,text FROM '._PREFIX_."phrase where phrasetype='$GroupName' and languageid='$language->langid'");

                           }


               while($row=$DB->fetch_array($query))
               {

               extract($row);
               $langg[$varname] = $text;

               }

               if(is_array($lang))
               {

               $lange=array_merge($langg,$lang);

               }
               else
               {

                $lange=$langg;

               }

               return $lange;
              }


              }
//# All Done .. Language Class Finished
?>