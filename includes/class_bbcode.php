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
#    BBcode Class started
#
/*
        File name       -> class_bbcode.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> class
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

Class arbb_bbcode{

// Start Variables Which will be used here

                var $message      = '';
                var $cache        = array();
                var $smiliescache = array();

// End Variables Which will be used here :)



        function highlightwords($text)
        {
                GLOBAL $arbb;
         if(isset($arbb->input['highlight']))
         {
            $highlight = urldecode($arbb->input['highlight']);
            $text      = str_replace($highlight , '<font color="#FF0000"><span style="background-color: #FFFF00">'.$highlight.'</span></font>',$text);
         }

          return ($text);
        }


              function build($message,$smilie=1,$html=0,$bbcode=1,$highlight=1)
              {

                            if($html==0)
                            {
                               $message = $this->clearhtml($message);
                               $message = nl2br($message);
                            }


                            if($smilie==1)
                            {
                               $message = $this->smilies($message);
                            }

                            if($highlight==1)
                            {
                             $message=$this->highlightwords($message);
                            }


                            if($bbcode==1)
                            {

                               $message = $this->bbcode($message);

                            }

               return $message;
              }

              function clearhtml($message)
              {
                       if(!is_array($message))
                       {
                        Return htmlspecialchars($message);
                        }
                        else
                        {
                         foreach($message as $key => $val)
                         {
                          $message[$key]=$this->clearhtml($val);
                         }
                         return $message;
                        }
              }


              function unclearhtml($message)
              {
                        Return htmlentities($message);
              }

              function cachesmilies()
              {
                GLOBAL $DB;

                   $query = $DB->query('SELECT * FROM '._PREFIX_.'smilies');
                   while($smilie = $DB->fetch_array($query))
                   {
                      $this->smiliescache['cached']='cached';
                      $this->smiliescache[$smilie[sid]]=$smilie;
                   }
              }


              function smilies($message)
              {
                       Global $DB;

                      $this->message=$message;
                      if(is_array($this->smiliescache)&&strlen($this->smiliescache['cached']>0))
                      {

                        foreach($this->smiliescache as $sid => $smilie)
                        {
                           if($sid != 'cached')
                           {
                            $this->message = str_replace($smilie['text'], "<img src='$smilie[path]'>",$this->message);
                           }
                        }
                      }
                      else
                      {
                              $this->cachesmilies();
                          foreach($this->smiliescache as $sid => $smilie)
                          {
                           if($sid != 'cached')
                           {
                            $this->message = str_replace($smilie['text'], "<img src='$smilie[path]'>",$this->message);
                           }
                          }
                       }

                 return $this->message;
              }

              function startcache()
              {
              GLOBAL $DB;



           $this->cache = array(
                                '1'        => array('tag' => 'b'     , 'parms'=>1, 'replacement' => '<b>$1</b>'),
                                '2'        => array('tag' => 'i'     , 'parms'=>1, 'replacement' => '<i>$1</i>'),
                                '3'        => array('tag' => 'u'     , 'parms'=>1, 'replacement' => '<u>$1</u>'),
                                '4'        => array('tag' => 'url'   , 'parms'=>1, 'replacement' => '<a href="$1">$1</a>'),
                                '5'        => array('tag' => 'img'   , 'parms'=>1, 'replacement' => '<img src="$1" border="0" />'),
                                '6'        => array('tag' => 'size'  , 'parms'=>2, 'replacement' => '<font size="$1">$2</font>'),
                                '7'        => array('tag' => 'color' , 'parms'=>2, 'replacement' => '<span style="color: $1">$2</span>'),
                                '8'        => array('tag' => 'email' , 'parms'=>2, 'replacement' => '<a href="mailto:$1">$2</a>'),
                                '9'        => array('tag' => 'font'  , 'parms'=>2, 'replacement' => '<span style="font-family: $1;">$2</span>')
                               );


                $query=$DB->query('Select * from '._PREFIX_.'bbcode');
                while($bbc=$DB->fetch_array($query))
                {
                      $this->cache[]=$bbc;
                }


              }


              function bbcode($message)
              {
                      Global $DB;

                $this->message=$message;

                if( !is_array($this->cache['1']) )
                {

                 $this->startcache();

                }



//                      $this->message = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', '<a href="\\1" target="_blank">\\1</a>',$this->message);
//                      $this->message = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})','<a href=\"mailto:\\1\">\\1</a>',$this->message);


                    $Search = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
                    $this->message = preg_replace("/\[url\]([$Search]*)\[\/url\]/", '<a href="$1" target="_blank">$1</a>', $this->message);
                    $this->message = preg_replace("(\[url\=([$Search]*)\](.+?)\[/url\])", '<a href="$1" target="_blank">$2</a>', $this->message);

                    $Search = $Search . " a-zA-Z0-9\.@";
                    $this->message = preg_replace("(\[mail\]([$Search]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $this->message);
                    $this->message = preg_replace("/\[mail\=([$Search]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $this->message);

                    foreach($this->cache as $bbcid => $row)
                    {
                       if($bbcid != 'selected')
                       {
                            Extract($row);
                            $replacement=stripslashes($replacement);

                                 if($parms==1)
                                 {
                                   $this->message = preg_replace("(\[$tag\](.+?)\[\/$tag])is",$replacement,$this->message);
                                 }
                                 else
                                 {
                                   $this->message = preg_replace("/\[$tag\=(.+?)\](.+?)\[\/$tag\]/",$replacement, $this->message);
                                 }


                             $this->message =  preg_replace_callback('/\<phpcode\>(.*?)\<\/phpcode\>/is','change',$this->message);
                       }
                    }

                    $array=array('center','left','right');
                    foreach($array as $key => $tag)
                    {
                         $replacement='<div align="'.$tag.'">$1</div>';
                            $this->message = preg_replace("(\[$tag\](.+?)\[\/$tag])is",$replacement,$this->message);
                    }

                    return $this->message;
              }
              function clear($message)
              {
                return nl2br($this->clearbbcode($message));
              }

              function clearbbcode($message)
              {
                      Global $DB;
                      $this->message=$message;


                if( !is_array($this->cache['1']) )
                {

                 $this->startcache();

                }
                    $Search = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
                    $this->message = preg_replace("/\[url\]([$Search]*)\[\/url\]/", '$1', $this->message);
                    $this->message = preg_replace("(\[url\=([$Search]*)\](.+?)\[/url\])", '$2', $this->message);

                    $Search = $Search . " a-zA-Z0-9\.@";
                    $this->message = preg_replace("(\[mail\]([$Search]*)\[/mail\])", '$1', $this->message);
                    $this->message = preg_replace("/\[mail\=([$Search]*)\](.+?)\[\/mail\]/", '$2', $this->message);

                    foreach($this->cache as $bbcid => $row)
                    {
                        if($bbcid != 'selected')
                        {
                            Extract($row);

                            $replacement=stripslashes($replacement);
                            if($parms==1)
                            {
                             $this->message = preg_replace("(\[$tag\](.+?)\[\/$tag])is","$1",$this->message);
                            }
                            else
                            {
                             $this->message = preg_replace("/\[$tag\=(.+?)\](.+?)\[\/$tag\]/","$2", $this->message);
                            }

                        }
                    }
                    $array=array('center','left','right');
                    foreach($array as $key => $tag)
                    {
                         $replacement='<div>$1</div>';
                            $this->message = preg_replace("(\[$tag\](.+?)\[\/$tag])is",$replacement,$this->message);
                    }
                    return $this->message;

              }


              }

//# All Done .. BBcode class Finished
?>