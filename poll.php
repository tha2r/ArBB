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
#    poll File started
#
/*
        File name       -> poll.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'poll_addpoll,poll_addpoll_optionbit,poll_result,poll_results_table';
$phrasearray = array('editor','newpost','forum','poll');

include 'global.php';

$tid=checkval($arbb->input['tid']);
$pollid=checkval($arbb->input['pollid']);

$local['whereurl']='';

if($arbb->input['do']=='addpoll')
{
               $tid               = checkval($arbb->input['tid']);
               $num               = checkval($arbb->input['num']);
               $wheretitle        = $lang['add_poll'];
               $option            = '';
               $optionsbit        = '';
               $question          = $bbcode->clearhtml($arbb->input['question']);
               ($arbb->input['polloptions'])?$num=$arbb->input['polloptions']:$num=$num;
               if($num<2)
               {
                   $num=2;
                       }
               $local['whereurl'] = "poll.php?tid=$tid&do=addpoll&num=$num";

               $numm     = $num;
               $polldate = mydate(TIMENOW,'date');

               while(($numm > 0)&&($num < 11))
               {
                   $optionid         = $numm;
                   $option[$optionid]= $TP->GetTemp('poll_addpoll_optionbit');
                     $numm--;

                       }

                       $i=1;
                       while(isset($option[$i]))
                       {
                           $optionsbit.=$option[$i];
                           $i++;
                               }

                       $query=$DB->query("select * from "._PREFIX_."thread where threadid='$tid'");
                       while($thread = $DB->fetch_array($query))
                       {

                       $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$thread[forumid]' and usergroupid='$local[usergroupid]'");
                       if($DB->num_rows($forumpermission)>0)
                       {
                               $nfp=$DB->fetch_array($forumpermission);

                               foreach($nfp as $f => $p)
                               {
                            if(($f != 'usergroupid')&&($f != 'forumid')&&($f != 'fpid'))
                            {
                                $localgroup[$f]=$p;
                            }
                               }
                       }

                       $thread['pollid']=checkval($thread['pollid']);
                       if($thread['pollid']<1)
                       {
                             if($thread['postuserid'] == $local['userid'])
                             {
                              if($localgroup['canaddpoll']==1)
                              {
                              $TP->webtemp('poll_addpoll');
                               }
                               else
                               {
                                   error_message($lang['you_cant_poll_to_forum']);
                            }
                             }
                             else
                             {
                                error_message($lang['you_cant_add_poll']);
                          }
                       }
                       else
                       {
                          error_message($lang['thread_already_polled']);
                               }
                       }


                     }
                     elseif($arbb->input['do']=='postpoll')
                     {
                          $tid = $arbb->input['tid'];
                          $num = $arbb->input['num'];

                          $question = $bbcode->clearhtml($arbb->input['question']);

                          $timeout  = checkval($arbb->input['timeout']);

                          $polloption  = $arbb->input['polloptions'];
                          $polloptions = "";

                          $i=1;
                          while((isset($polloption[$i]))&&($i < 11))
                          {

                           $polloptions.=$bbcode->clearhtml($polloption[$i])."\n";
                             $i++;
                                  }

                             $inserted = array('question'      => $question,
                                               'options'       => $polloptions,
                                               'dateline'      => TIMENOW,
                                               'numberoptions' => $num,
                                               'active'        => '1',
                                               'timeout'       => $timeout);

                             $query=$DB->query("select * from thread where threadid='$tid'");

                             while($thread=$DB->fetch_array($query))
                             {
                            $canpoll=1;
                             if($thread['postuserid']==$local['userid'])
                             {

                             $forumpermission=$DB->query("select * from "._PREFIX_."forumpermission where forumid='$thread[forumid]' and usergroupid='$local[usergroupid]'");
                             if($DB->num_rows($forumpermission)>0)
                             {
                          $nfp=$DB->fetch_array($forumpermission);

                          foreach($nfp as $f => $p)
                          {
                                  if(($f != 'usergroupid')&&($f != 'forumid')&&($f != 'fpid'))
                                  {
                                      $localgroup[$f]=$p;
                                  }
                          }
                             }
                             if($localgroup['canaddpoll']==0)
                             {
                                 $canpoll=0;
                                 error_message($lang['you_cant_poll_to_forum']);
                          }
                          }
                          else
                          {
                          $canpoll=0;
                             error_message($lang['you_cant_add_poll']);
                                  }

                             if($canpoll==1)
                             {
                             $ins=$DB->multible_insert($inserted,'poll');
                             if(!$ins)
                             {
                                 error_message($lang['poll_ins_error']);
                          }
                          else
                          {
                            $number=$DB->insert_id($ins);
                          $DB->query("update "._PREFIX_."thread set pollid='$number',votenum='0',votetotal='0' where threadid='$tid'");

                          $url='thread.php?tid='.$tid;
                          $redirect_message=$lang['poll_add_ok'];

                            redirect($redirect_message,$url);

                                  }
                                  }
                                  }
                             }
                             elseif($arbb->input['do']=='addvote')
                             {
                                 $pollid=checkval($arbb->input['pollid']);

                                 $local['whereurl']='poll.php?do=addvote&pollid='.$pollid;
                                 $wheretitle=$lang['add_vote'];
                                 $option=checkval($arbb->input['option']);

                                 if(($option > 0)&&($pollid > 0))
                                 {
                                 $query=$DB->query("select userid from pollvote where userid='$local[userid]' and pollid='$pollid'");
                                 if($DB->num_rows($query)<1)
                                 {
                                     $ins = $DB->query("insert into "._PREFIX_."pollvote(`pollid`,`userid`,`date`,`option`) values ('$pollid','$local[userid]','".TIMENOW."','$option')");

                                     if(!$ins)
                                     {
                                         error_message($lang['error_vote_not_accepted']);
                                             }
                                             else
                                             {
                                                    $query=$DB->query("select threadid from "._PREFIX_."thread where pollid='$pollid'");
                                                     while($thread=$DB->fetch_array($query))
                                                     {
                                                            header('location:thread.php?tid='.$thread[threadid]'');
                                                            }
                                                     }

                                     }
                                     else
                                     {
                                         error_message($lang['poll_you_already_voted']);
                                             }
                                 }
                                 else
                                 {
                                     error_message($lang['vote_poll_unsetted']);
                                         }
                                     }
                                     elseif($arbb->input['do']=="showresults")
                                     {
                                                 $pollid=checkval($arbb->input['pollid']);

                                                     $poll_query=$DB->query("select * from "._PREFIX_."poll where pollid='$pollid'");
                                                     while($poll=$DB->fetch_array($poll_query))
                                                     {
                                                         $wheretitle=$lang['showing_poll_result'].$poll['question'];
                                                     $thread_query=$DB->query("select t.forumid,t.title,t.threadid,f.mainid,f.title as forumtitle from "._PREFIX_."thread t LEFT JOIN "._PREFIX_."forum f on (f.forumid=t.forumid) where pollid='$pollid'");

                                                     while($thread=$DB->fetch_array($thread_query))
                                                     {
                                                           build_nav_tree($thread[forumid]);
                                                             }




                                                         if($poll['timeout']>0)
                                                         {

                                                            $timeout=TIMENOW+($poll['timeout']*60*60*24);
                                                            $closedate=mydate($timeout,'last');
                                                            $show['pollenddate']=1;

                                                         }


                                                                         $votes_query=$DB->query("select * from "._PREFIX_."pollvote where pollid='$poll[pollid]'");

                                                                         $votenum=0;
                                                                         $option=array();

                                                                         while($vote=$DB->fetch_array($votes_query))
                                                                         {

                                                                          $option[$vote[option]]['votes']++;
                                                                          $votenum++;

                                                                         }

                                                                                     $opt=explode('\n',$poll['options']);
                                                                                     $i=0;

                                                                                     while(isset($opt[$i])&&(strlen($opt[$i])>0))
                                                                                     {

                                                                                      $option['num']     = $i+1;
                                                                                      $option['option']  = $opt[$i];
                                                                                      $option['votes']   = checkval($option[$option[num]]['votes']);
                                                                                      if($votenum == 0)
                                                                                      {
                                                                                          $option['percent']=0;
                                                                                              }
                                                                                              else
                                                                                              {
                                                                                                     $option['percent'] = ($option['votes'] / $votenum)*100;
                                                                                               }

                                                                                      if($lang['dir']=='ltr')
                                                                                      {
                                                                                         $option['open']  = 'open';
                                                                                         $option['close'] = 'close';
                                                                                      }
                                                                                      else
                                                                                      {
                                                                                         $option['open']  = 'open';
                                                                                         $option['close'] = 'start';
                                                                                      }

                                                                                      $option['barwidth']=$option['percent']*2;


                                                                                      $pollbits.=$TP->GetTemp('poll_result');
                                                                                      $i++;

                                                                                      }

                                                                                      $poll['numbervotes']=$votenum;
                                                                                      $TP->webtemp('poll_results_table');

                                                                }
                                             }



   build_nav_location($wheretitle,$local['whereurl']);

   $titleetc='-> '.$wheretitle;
   print_page();

?>