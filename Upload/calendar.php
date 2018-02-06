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
#    Calendar File started
#
/*
        File name       -> Calendar.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = "calendar               ,
                 calendar_event_delete  ,
                 calendar_event_edit    ,
                 calendar_daybit        ,
                 calendar_event_view    ,
                 calendar_day           ,
                 calendar_addevent      ,
                 calendar_eventbit";

$phrasearray=array('calendar');

include 'global.php';

$pluginl= 'calendar_start,calendar_getday_start,calendar_getday_event,calendar_getday_complete'
         .',calendar_complete,calendar_main_start,calendar_main_birthday,calendar_main_event'
         .',calendar_main_complete,calendar_add_event,calendar_edit_event,calendar_delete_event';

$plugins->cache($plguinl);


($evalp = $plugins->load('calendar_start'))?eval($evalp):'';


   build_nav_location($lang['calendar'],'calendar.php','add');

if(!$localgroup['canviewcalendar'])
{
 error_permission();
}
if(empty($arbb->input['action']))
{
 $arbb->input['action']='main';
}
$month = checkval($arbb->input['month'])?$arbb->input['month']:mydate("n");
$year  = checkval($arbb->input['year'])?$arbb->input['year']:mydate("Y");
$d     = checkval($arbb->input['day'])?$arbb->input['day']:mydate("d");


$time  = mktime(0, 0, 0, $month, 1, $year);


if($arbb->input['action']=='addevent')
{
if(!$localgroup['canaddevents'])
{
 error_permission();
}

$msel=array();
$msel[$month]=' selected';
$days = date('t', $time);
$dayoptions='';
$day=0;
while($day < $days)
{
   $day++;
      if($day == $d)
      {
       $sel=' selected';
      }
      else
      {
       $sel='';
      }
   $dayoptions.="<option value=\"$day\"$sel>$day</option>\n";
}
        $yearoptions = '';
        for($i = mydate('Y'); $i < (mydate('Y') + 5); $i++)
        {
         if($year == $i)
         {
          $sel=' selected';
         }
         else
         {
          $sel='';
         }
                $yearoptions .= "<option value=\"$i\"$sel>$i</option>\n";
        }


        $local['wheretitle']=$lang['new_event'];
        $local['whereurl']='calendar.php?action=addevent';

        $navtitle=$lang['month_'.$month].' / '.$year;
        $navlink="calendar.php?month=$month&year=$year";
        build_nav_location($navtitle,$navlink,'add');

$TP->webtemp('calendar_addevent');
}
elseif($arbb->input['action']=='do_addevent')
{
if(!$localgroup['canaddevents'])
{
 error_permission();
}
       $title=$bbcode->clearhtml($arbb->input['title']);
       $details=$bbcode->clearhtml($arbb->input['details']);

       $day=checkval($arbb->input['day']);
       $month=checkval($arbb->input['month']);
       $year=checkval($arbb->input['year']);

       $date="$day-$month-$year";
       $ins=$DB->query("insert into "._PREFIX_."events (userid,title,details,date) VALUES('$local[userid]','$title','$details','$date')");

       if(!$ins)
       {
        error_message($lang['event_not_added']);
       }
       else
       {
        redirect($lang['event_added'],"calendar.php?year=$year&month=$month");
       }
}
elseif($arbb->input['action']=='day')
{
($evalp = $plugins->load('calendar_getday_start'))?eval($evalp):'';

        $navtitle=$lang['month_'.$month].' / '.$year;
        $navlink="calendar.php?month=$month&year=$year";
        build_nav_location($navtitle,$navlink,'add');

        $local['wheretitle']=$lang['view_day'];
        $local['whereurl']=$navlink."&day=$day";
$addon="";
$events="";
$birthdays="";
        if($month == 3 && date('L', mktime(0, 0, 0, $month, 1, $year)) != 1)
        {
         $fix=1;
         $addon=" or birthday like '29-2-%'";
        }
$date="$day-$month-$year";

$bd = $DB->query("select u.userid,u.birthday,u.username,u.usergroupid,ug.opentag,ug.closetag from "._PREFIX_."users u LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid) where u.birthday like '%$day-$month-%' $addon");
$eve=$DB->query("select e.*,u.usergroupid,u.username,ug.opentag,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."events e
                 LEFT JOIN "._PREFIX_."users u on (u.userid=e.userid)
                 LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                 where e.date ='$date'");


while($birthday = $DB->fetch_array($bd))
{
 foreach($birthday as $key => $val)
 {
         if($key != 'opentag' && $key != 'closetag')
         {
         $birthday[$key]=$bbcode->clearhtml($val);
         }
 }
$m=explode("-",$birthday['birthday']);


$old=$year-$m[2];
$username="<a href=\"member.php?action=profile&userid=$birthday[userid]\">".$birthday['opentag'].$birthday['username'].$birthday['closetag']."</a>";
$comma=($birthdays)?" , ":"";
$birthdays.=$comma."$username ($old $lang[years_old])";

}

while($event=$DB->fetch_array($eve))
{
($evalp = $plugins->load('calendar_getday_event'))?eval($evalp):'';

 $event['username']=$event['opentag'].$bbcode->clearhtml($event['username']).$event['closetag'];
foreach($event as $key => $val)
{
        if($key != 'username' && $key != 'details')
        {
        $event[$key]=$bbcode->clearhtml($val);
        }

}
$m=explode("-",$event[date]);
$month=$m[1];
$year=$m[2];

$event['details']=$bbcode->build($event['details']);
 $events.=$TP->GetTemp('calendar_event_view');
}
         eval("\$lang[no_events_this_day]=\"".$lang['no_events_this_day']."\";");
($evalp = $plugins->load('calendar_getday_complete'))?eval($evalp):'';

 $TP->webtemp('calendar_day');
}
elseif($arbb->input['action'] == 'main')
{

($evalp = $plugins->load('calendar_main_start'))?eval($evalp):'';
        $days = date('t', $time);
        $local['wheretitle']=$lang['month_'.$month].' / '.$year;
        $local['whereurl']="calendar.php?month=$month&year=$year";
        $count = 0;
        $startblank = date('w',$time)+1;
        if($startblank >6)
        {
         $startblank=$startblank-6;
        }


        // Blank space before first day
        if($startblank)
        {
                $swidth = $startblank * 14;
                $daybits = "<tr>\n";
                $daybits .= "<td width=\"$swidth%\" colspan=\"$startblank\" height=\"90\" class=\"td2\">&nbsp;</td>\n";
                $count = $startblank;
        }
        else
        {
           $daybits = "<tr>\n";
        }

        if($month == 3 && date('L', mktime(0, 0, 0, $month, 1, $year)) != 1)
        {
         $fix=1;
         $addon=" or birthday like '29-2-%'";
        }

        $ev = $DB->query("select * from "._PREFIX_."events where date like '%-$month-$year'");
        $bd = $DB->query("select userid,birthday from "._PREFIX_."users where birthday like '%-$month-%' $addon");
        $bdays=array();
        $events=array();

        while($user = $DB->fetch_array($bd))
        {
$plugins->load('calendar_main_birthday');
        $m=explode('-',$user['birthday']);
        $bday=$m[0];

                if(($fix==1) && ($bday==29) && ($month==3))
                {
                $bdays[1]++;
                }
                else
                {
                $bdays[$bday]++;
                }

        }

        while($event = $DB->fetch_array($ev))
        {

($evalp = $plugins->load('calendar_main_event'))?eval($evalp):'';

        $event['title']     = $bbcode->clearhtml($event['title']);
        $event['titlecut']  = substr($event['title'], 0, 15);
        if($event['title'] != $event['titlecut'])
        {
          $event['titlecut'].= ' ...';
        }

        $m = explode('-',$event['date']);
        $day=$m[0];
        $events[$day] .= $TP->GetTemp('calendar_eventbit');
        }



        for($i = 1; $i <= $days; $i++)
        {
                if((mydate("d") == $i) && (mydate("n") == $month) && (mydate("Y") == $year))
                {
                      $today=2;
                }
                else
                {
                      $today=1;
                }
                       $dayevents=$events[$i];
                       $birthdays=$bdays[$i];
                        $daybits .= $TP->GetTemp('calendar_daybit');

                $count++;

                if($count == 7)
                {
                        if($i != $days)
                        {
                                $daybits .= '</tr><tr>';
                        }
                        else
                        {
                                $daybits .= '</tr>';
                        }
                        $count = 0;
                }
                else
                {
                        $left = $count + 7;
                }

        }


        if($count>0)
        {
                $endblank = 7 - $count;
                $ewidth = $endblank * 14;
                $daybits .= "<td width=\"$ewidth%\" colspan=\"$endblank\" height=\"90\" class=\"td2\" valign=\"top\">&nbsp;</td>\n";
                $daybits .= "</tr>\n";
        }

                $nmonth = $month+1;
                $pmonth = $month-1;
                $nyear = $pyear = $year;

        if($month == 12)
        {
                $nmonth = 1;
                $nyear = $year+1;
        }
        if($month == 1)
        {
                $pmonth = 12;
                $pyear = $year-1;
        }


        $nmonthname=$lang['month_'.$nmonth];
        $pmonthname=$lang['month_'.$pmonth];

        $yearseloptions = '';
        for($i = mydate('Y'); $i < (mydate('Y') + 5); $i++)
        {
                $yearseloptions .= "<option value=\"$i\">$i</option>\n";
        }

        $monthtitle=$lang['month_'.$month];

($evalp = $plugins->load('calendar_main_complete'))?eval($evalp):'';

        $TP->WebTemp('calendar');

}
elseif($arbb->input['action']=='event'||$arbb->input['action']=='edit'||$arbb->input['action']=='delete'||$arbb->input['action']=='do_delete'||$arbb->input['action']=='do_edit')
{

$eid=checkval($arbb->input['eid']);

$eve=$DB->query("select e.*,u.usergroupid,u.username,ug.opentag,ug.usertitle as gusertitle,ug.closetag from  "._PREFIX_."events e
                 LEFT JOIN "._PREFIX_."users u on (u.userid=e.userid)
                 LEFT JOIN "._PREFIX_."usergroup ug on (ug.usergroupid=u.usergroupid)
                 where e.eid='$eid' limit 1");
while($event=$DB->fetch_array($eve))
{

 $event['username']=$event['opentag'].$bbcode->clearhtml($event['username']).$event['closetag'];
foreach($event as $key => $val)
{
        if($key != 'username' && $key != 'details')
        {
        $event[$key]=$bbcode->clearhtml($val);
        }

}
$m=explode("-",$event[date]);
$month=$m[1];
$year=$m[2];
        $navtitle=$lang['month_'.$m[1]]." / ".$m[2];
        $navlink="calendar.php?month=$month&year=$year";
        build_nav_location($navtitle,$navlink,'add');
$event['details']=$bbcode->build($event['details']);
if($arbb->input['action']=='event')
{
($evalp = $plugins->load('calendar_add_event'))?eval($evalp):'';

 $local['wheretitle']=$lang['view_event'].' : '.$event['title'];
 $local['whereurl']= "calendar.php?action=event&eid=$eid";

 $TP->webtemp('calendar_event_view');
}
else
{

 if((!$localgroup['caneditevents'])||($local['userid'] != $event['userid'] && !is_moderator()))
 {
  error_permission();
 }
 else
 {
    if($arbb->input['action']=='edit')
    {
     $local['wheretitle']=$lang['edit_event'].' : '.$event['title'];
     $local['whereurl']= "calendar.php?action=edit&eid=$eid";



    $msel=array();
    $msel[$m[1]]='selected';
    $days = date('t', $time);
    $dayoptions='';
    $day=0;
    while($day < $days)
    {
       $day++;
          if($day == $m[0])
          {
           $sel=' selected';
          }
          else
          {
           $sel='';
          }
       $dayoptions.="<option value=\"$day\"$sel>$day</option>\n";
    }
            $yearoptions = '';
            for($i = mydate('Y'); $i < (mydate('Y') + 5); $i++)
            {
             if($i == $m[2])
             {
              $sel=' selected';
             }
             else
             {
              $sel='';
             }
                    $yearoptions .= "<option value=\"$i\"$sel>$i</option>\n";
            }
($evalp = $plugins->load('calendar_edit_event'))?eval($evalp):'';

     $TP->webtemp('calendar_event_edit');
    }
    elseif($arbb->input['action']=='delete')
    {
     $local['wheretitle']=$lang['delete_event'].' : '.$event['title'];
     $local['whereurl']= "calendar.php?action=delete&eid=$eid";
($evalp = $plugins->load('calendar_delete_event'))?eval($evalp):'';

     $TP->webtemp('calendar_event_delete');
    }
    elseif($arbb->input['action']=='do_delete')
    {
     $query=$DB->query("delete from "._PREFIX_."events where eid='$eid'");
          if(!$query)
          {
             error_message($lang['event_not_deleted']);
          }
          else
          {
             redirect($lang['event_deleted'],"calendar.php?year=$year&month=$month");
          }
    }
    elseif($arbb->input['action']=='do_edit')
    {

       $title=$bbcode->clearhtml($arbb->input['title']);
       $details=$bbcode->clearhtml($arbb->input['details']);

       $day=checkval($arbb->input['day']);
       $month=checkval($arbb->input['month']);
       $year=checkval($arbb->input['year']);

       $date="$day-$month-$year";

       $upda=$DB->query("update "._PREFIX_."events set date='$date',title='$title',details='$details' where eid='$eid'");

       if(!$upda)
       {
         error_message($lang['event_not_updated']);
       }
       else
       {
         redirect($lang['event_updated'],"calendar.php?action=event&eid=$eid");
       }
    }
 }
}
}


}


($evalp = $plugins->load('calendar_complete'))?eval($evalp):'';

   build_nav_location($local['wheretitle'],$local['whereurl'],'add',1);
   $titleetc=$local['wheretitle'].' - ';
        print_page();
?>