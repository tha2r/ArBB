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
#    admin Templates Class started
#
/*
        File name       -> admin_class_templates.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> class
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}


Class arbb_templates{

// Start Variables Which will be used here

var $returned    = '';
var $Row         = array();
var $template    = array();
var $cache       = array();

// End Variables Which will be used here :)


/****************************************************/



              function GetTemp($TempName)
              {

                  Extract($GLOBALS);
                         $temp = $this->cache[$TempName];

                  if($this->cache[$TempName][exists]==1)
                  {

                     $temp = $this->cache[$TempName]['template'];
                    }
                    else
                    {
                              Echo $TempName;
                             $temp = addslashes(file_get_contents('templates/'.$TempName.'.tpl'));
                             $this->cache[$TempName]['exists']=1;
                             $this->cache[$TempName]['template']=$temp;

                            }

                         $temp= '$returned = "'.$temp.'";';
                    $temp = preg_replace("(\<if condition=(.+?)\>)is",'"; if($1){ $returned.="',$temp);
                    $temp = preg_replace("(\<elseif condition=(.+?)\>)is",'"; } elseif($1) { $returned.="',$temp);
                    $temp = preg_replace("(\<else\>)is",'"; } else { $returned.="',$temp);
                    $temp = preg_replace("(\</if\>)is",'"; } $returned.="',$temp);
                            $temp=str_replace('(\"','(',$temp);
                            $temp=str_replace('\")',')',$temp);
                            $temp=str_replace("\'","'",$temp);
                            $temp=str_replace("['","[",$temp);
                            $temp=str_replace("']","]",$temp);
                        eval($temp);
                        return $returned;
              }




              function templatesused($templates)
              {
               GLOBAL $DB,$st;
               $sql='';
                $tempnames = explode(',', $templates);
                foreach($tempnames as $arrayid => $title)
                {
                         $title=trim($title);
                        $this->cache[$title]['template'] = addslashes(file_get_contents('templates/'.$title.'.tpl'));
                        $this->cache[$title]['exists']=1;
                }
              }

              function webtemp($tempname)
              {
                      GLOBAL $options;
                      $options['webcontent'].=$this->GetTemp($tempname);
                      GLOBAL $options;
              }


              }

//# All Done .. Templates (class) Finished
?>