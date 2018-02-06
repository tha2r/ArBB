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
#    Plugins Class started
#
/*
        File name       -> class_plugins.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Class
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

Class arbb_plugins{

// Start Variables Which will be used here

        var $plugincache = array();

// End Variables Which will be used here :)

              function load($place)
              {
                       global $DB,$lang,$options,$stylevar;


                       if(is_array($this->plugincache[$place]))
                       {

                          foreach($this->plugincache[$place] as $pl => $code)
                          {
                                    $returned .= $code;
                          }
                       }
                       else
                       {
                          $this->plugincache[$plugin[place]]=array();
                          $query=$DB->query('select phpcode,place,title from '._PREFIX_."plugin where place='$place' and active='1'");

                            while($plugin=$DB->fetch_array($query))
                            {
                               $this->plugincache[$plugin[place]][$plugin[title]]=$plugin['phpcode'];
                                $returned .= $plugin['phpcode'];
                            }
                       }

                       return $returned;
              }

              function cache($name)
              {

              GLOBAL $DB;

              $q = explode(',',$name);

              $comma = '';
              $place = '';

              foreach($q as $num => $pl)
              {
               $place.=$comma."'".addslashes($pl)."'";
               $comma=',';
                 $this->plugincache[$pl]=array();
              }
              $plguins_query = $DB->query("select phpcode,place,title from ". _PREFIX_ ."plugin where place in($place) and active='1'");

              while($plugin=$DB->fetch_array($plguins_query))
              {
                               $this->plugincache[$plugin[place]][$plugin[title]]=$plugin['phpcode'];
              }


              }


              }
//# All Done .. Plugins Class Finished
?>