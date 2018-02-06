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
#    Templates Class started
#
/*
        File name       -> class_templates.php
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


              function checkstyle()
              {
                       Global $DB,$st,$arbb;
                      $styleid=$arbb->input[''._CPREFIX_.'styleid'];
                      $error=1;

                      if(!Empty($styleid))
                      {
                        $query=$DB->query("select * from "._PREFIX_."styles where styleid='$styleid'");
                        while($row=$DB->fetch_array($query))
                        {
                              $error=0;
                              $GLOBALS['st']=$row;
                              $styleid=$row['styleid'];
                              newcookie('styleid',$row['styleid']);
                        }
                      }

                      if($error==1)
                      {
                           $st=$DB->query_now("select * from "._PREFIX_."styles where type='default'");
                              $GLOBALS['st']=$st;
                              $styleid=$st['styleid'];
                              newcookie('styleid',$st['styleid']);

                      }

                      $this->styleid=$styleid;
              }

              function buildcss()
              {

                      GLOBAL $DB,$st;

                  $query = $DB->query("select * from "._PREFIX_."templates where templatetype='css' and styleid='$this->styleid'");
                  $csstemp='<style type="text/css">'."\n";

                  while($css=$DB->fetch_array($query))
                  {

                      $cs=unserialize($css['template']);

                      foreach($cs as $key => $val)
                      {
                       $cs[$key]=stripslashes($val);
                      }

                      $csstemp.=$css['title']."\n{\n";

                      $main=array('background','color','font_size','font_family','font_style','font_weight');

                      foreach($main as $key => $val)
                      {
                        if(strlen($cs[$val])>0)
                        {
                         $csstemp.='         '.str_replace('_','-',$val).':'.str_replace(';','',$cs[$val]).';'."\n";
                        }

                      }

                      if($cs["extra"] != '')
                      {
                         $csstemp.=$cs['extra']."\n";

                      }

                      $csstemp.="}\n";

                      $array=array('a_link','a_visited','a_hover');

                      foreach($array as $key => $val)
                      {
                          if((strlen($cs[$val.'_background'])>0)||(strlen($cs[$val.'_color'])>0)||(strlen($cs[$val.'_text_decoration'])>0))
                          {

                          $vval=str_replace('_',':',$val);

                                     if($css['title'] != "a")
                                     {

                                     $csstemp.=$css['title']." $vval,";
                                     $csstemp.=$css['title']."_$val\n{\n";

                                     }
                                     else
                                     {
                                     $csstemp.="$vval\n{\n";

                                     }

                              if(strlen($cs[$val."_background"])>0)
                              {
                                 $csstemp.='         '.'background:'.$cs[$val.'_background'].";\n";
                              }

                              if(strlen($cs[$val."_color"])>0)
                              {
                                 $csstemp.='         '.'color:'.$cs[$val.'_color'].";\n";

                              }

                              if(strlen($cs[$val."_text_decoration"])>0)
                              {
                                 $csstemp.='         '.'text-decoration:'.$cs[$val.'_text_decoration'].";\n";

                              }

                          $csstemp.="}\n";

                          }

                          }

                  }

                  $csstemp.=$st['cssaddition']."\n</style>";


                   return $csstemp;
              }

              function buildstylevars($stylevars)
              {
                  return unserialize($stylevars);
              }

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


                           $dbquery=$DB->query("Select template From "._PREFIX_."templates Where title='$TempName' And styleid='$st[styleid]'");
                           while($Row=$DB->fetch_array($dbquery))
                           {
                             $temp = $Row['template'];
                             $this->cache[$TempName]=$row;
                             $this->cache[$TempName]['exists']=1;
                                  }

                            }

                         $temp= '$returned = "'.$temp.'";';
                    $temp = preg_replace("(\<if condition=(.+?)\>)is",'"; if($1){ $returned.="',$temp);
                    $temp = preg_replace("(\<elseif condition=(.+?)\>)is",'"; } elseif($1) { $returned.="',$temp);
                    $temp = preg_replace("(\<else\>)is",'"; } else { $returned.="',$temp);
                    $temp = preg_replace("(\</if\>)is",'"; } $returned.="',$temp);
                            $temp=str_replace('if(\"','if(',$temp);
                            $temp=str_replace('\"){ $returned.=','){ $returned.=',$temp);
                            $temp=str_replace("\'","'",$temp);
                            $temp=str_replace("['","[",$temp);
                            $temp=str_replace("']","]",$temp);

                        eval($temp);
                        return $returned;
              }




              function templatesused($templates)
              {
               GLOBAL $DB,$st;
               $sql="";
                $tempnames = explode(",", $templates);
                foreach($tempnames as $arrayid => $title)
                {
                        $sql .= ",'".trim($title)."'";
                }

                $query = $DB->query("SELECT title,template FROM ". _PREFIX_ ."templates WHERE title IN (''$sql) And styleid='$st[styleid]'");
                while($template = $DB->fetch_array($query))
                {
                        $this->cache[$template[title]] = $template;
                        $this->cache[$template[title]]['exists']=1;
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