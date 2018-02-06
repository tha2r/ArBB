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
#    Admin Control panel Functions File started
#

/*
        File name       -> admin_functions.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> Functions
*/

if(!defined('IN_ARBB'))
{
die("<title>ArBB</title>\nYou Cant Access This File !!\n<br>\nArBB");
}

              function build_input($name,$optionscode,$value)
              {
                 GLOBAL $lang,$options,$DB;

                 $sel=array();
                 $value=htmlspecialchars($value);

                switch($optionscode)
                {
                case 'yesno';


                   if($value==1)
                   {
                      $sel['yes']='checked';
                   }
                   else
                   {
                      $sel['no']='checked';
                   }

                   $returned="<input type=\"radio\" $sel[yes] value=\"1\" name=\"setting[$name]\">$lang[yes]\n<input type=\"radio\" $sel[no]  value=\"0\" name=\"setting[$name]\">$lang[no]";
                break;
                case 'onoff':
                   if($value==1)
                   {
                      $sel['yes']='checked';
                   }
                   else
                   {
                      $sel['no']='checked';
                   }

                   $returned="<input type=\"radio\" $sel[yes] value=\"1\" name=\"setting[$name]\">$lang[on]\n<input type=\"radio\" $sel[no]  value=\"0\" name=\"setting[$name]\">$lang[off]";
                break;
                case 'textarea';

                $returned="<textarea name=\"setting[$name]\" rows=\"8\" wrap=\"virtual\" cols=\"40\">$value</textarea>";

                break;
                case 'textinput';
                 $returned="<input type=\"text\" name=\"setting[$name]\" value=\"$value\" size=\"40\">";
                break;
                case 'style';
                case 'language';
                case 'cpstyle';
                case 'cplanguage';
                $returned="\n<select name=\"setting[$name]\">";
                break;
                }

                 if($optionscode=='style')
                 {
                  $query=$DB->query('select * from '._PREFIX_.'styles');

                  while($st = $DB->fetch_array($query))
                  {
                     $sel['yes']=($st['styleid']==$options['defaultstyle'])?'selected':'';

                     $returned.="\n<option $sel[yes] value=\"$st[styleid]\">$st[title]</option>";
                  }

                  $returned.="\n</select>";
                 }
                 elseif($optionscode=='language')
                 {
                  $query=$DB->query('select * from '._PREFIX_.'language');

                  while($l = $DB->fetch_array($query))
                  {
                     $sel['yes']=($l['languageid']==$options['defaultlang'])?'selected':'';

                     $returned.="\n<option $sel[yes] value=\"$l[languageid]\">$l[title]</option>";
                  }

                  $returned.="\n</select>";
                 }
                 elseif($optionscode=='cpstyle')
                 {
                 $dirname=dirname(getcwd());
                 $directory=$dirname.'/cpstyles';
                 $dir=opendir($directory);
                 while($fp=readdir($dir))
                 {
                  if(($fp != '.') && ($fp != '..') And (is_dir($directory.'/'.$fp)))
                  {

                     $sel['yes']=($fp==$value)?'selected':'';
                     $returned.="\n".'<option '.$sel['yes'].' value="'.$fp.'">'.$fp.'</option>';
                  }
                 }
                  $returned.='</select>';
                 }
                 elseif($optionscode=='cplanguage')
                 {
                  $returned.='</select>';
                 }
                 else
                 {

                if(eregi('select',$optionscode))
                {
                $returned="\n<select name=\"setting[$name]\">";
                 $exp=explode("\n",$optionscode);

                 foreach($exp as $key => $val)
                 {
                  if($key > 0)
                  {
                  $option = ($lang[trim($val)])?$lang[trim($val)]:trim($val);
                  $selected=($value==$val)?'selected':'';
                   $returned.='<option value="'.trim($val).'" $selected>'.$option.'</option>';
                  }
                 }
                 $returned.='</select>';
                }
                elseif(eregi('radio',$optionscode))
                {
                 $exp=explode("\n",$optionscode);
                 $returned='';

                 foreach($exp as $key => $val)
                 {
                  if($key > 0)
                  {
                    $sel['yes']=($val==$value)?'checked':'';
                    $returned.='<input type="radio" '.$sel['yes'].' value="'.$val.'" name="settings[$name]">'.$lang[$val].'<br>';
                  }
                 }
                }

               }
                 return $returned;
              }

              function makeparentlist($fid,$forumscache=false)
              {
                      GLOBAL $DB;
                      if(!is_array($forumscache))
                      {
                        $forumscache=array();
                        $query=$DB->query('select * from '._PREFIX_.'forum');
                        while($forum = $DB->fetch_array($query))
                        {
                           $forumscache[$forum['forumid']][$forum['mainid']]=$forum;
                        }
                      }

                      foreach($forumscache[$fid] as $mainid => $forum)
                      {
                       if($mainid=='-1')
                       {
                        $parentlist = $fid;
                       }
                       else
                       {
                        $parentlist = makeparentlist($mainid,$forumscache).','.$fid;
                       }
                      }

              return $parentlist;

              }

              function build_forumbits($forumarray,$fids,$ii)
              {
                 GLOBAL $TP,$lang,$i,$forum,$show;

                    while(list($dis,$info) = each($forumarray[$fids]))
                    {

                      foreach($info as $fid => $forum)
                      {
                      $i=1;
                      $show['cutoff']=0;

                      $forum['title']=$ii.$forum['title'];
                      $forums .= $TP->GetTemp('forums_manager_forumbit');

                             if(is_array($forumarray[$fid]))
                             {
                               $forums  .= build_forumbits($forumarray,$fid,$ii.'- ');
                             }
                      }
                    }
              return $forums;

              }

              function build_permission_forumsbits($pid='-1')
              {
              GLOBAL $usergroups,$lang,$forums,$forumpermissions,$sid;

              while(list($disporder,$f) = each($forums[$pid]))
              {
                foreach($f as $fid => $forum)
                {
                    $forumbits.=(($pid==-1)&&($forumbits))?"<hr id=\"pers_$fid\" class=\"tdf\" width=\"100%\">":"";
                    $forumbits.="<ul>\n              <li>$forum[title]</li>\n              <ul>";
                   foreach($usergroups as $ugid => $usergroup)
                   {
                    $color='';
                       $ex=explode(',',$forum['parentlist']);
                       $ar=array_sum($ex);
                       $color='';


                       for($i=$ar;$i>=0;$i--)
                       {
                          $fidd = $ex[$i];
                          if(is_array($forumpermissions[$fidd][$ugid]))
                          {
                           if($fidd==$forum['forumid'])
                           {
                              $color='#0000FF';
                           }
                           else
                           {
                              $color='#FF0000';
                           }
                            $permission=$permissions[$fidd][$ugid];
                            $i=0;
                          }
                       }

                       if($color == '')
                       {
                        $color='#000000';
                       }

                       $forumbits .="\n<li><span style=\"color:$color\">$usergroup[title]</span>&nbsp;[<a style=\"color:$color\" href=\"forums.php?sid=$sid&do=editpermissions&fid=$fid&gid=$ugid\">$lang[set_perms]</a>]";
                   }

                     if(is_array($forums[$forum['forumid']]))
                     {
                           $forumbits.=build_permission_forumsbits($forum['forumid']);
                     }
                     $forumbits .="\n</ul></ul>";
                }
              }
               return $forumbits;
              }

              function get_forum_group_permissions($forum,$group)
              {
               GLOBAL $DB,$lang;

                        $parentlist=$forum['parentlist'];

                        $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid in ($parentlist) and usergroupid='$group[usergroupid]'");
                        if($DB->num_rows($forumpermission)>0)
                        {
                           while($nfp=$DB->fetch_array($forumpermission))
                           {
                               $permissions[$nfp['forumid']]=$nfp;
                           }

                             $ex=explode(',',$forum['parentlist']);
                             $ar=array_sum($ex);

                             for($i=$ar;$i>=0;$i--)
                             {
                              $fid = $ex[$i];
                                if(is_array($permissions[$fid]))
                                {
                                 $permission=$permissions[$fid];
                                 $i=0;
                                }
                             }

                        }
                  return $permission;
              }

//# All Done .. Admin Functions File Finished

?>