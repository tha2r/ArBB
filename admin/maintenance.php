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
#    Admin Maintenance And Tools File Started
#
/*
        File name       -> maintenance.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

$templatelist = 'maintenance_sql         ,
                 maintenance_counter     ,
                 maintenance_dbtools_bit ,
                 maintenance_dbtools     ,
                 maintenance_backups_bit ,
                 maintenance_backups';

$phrasearray=array('admincp');

require('global.php');
build_nav_location($lang['adminmenu_maintenance'],"maintenance.php?sid=$sid");
$arbb->input['do'] = ($arbb->input['do'])?$arbb->input['do']:"manage";

$page=($arbb->input['page'])?$arbb->input['page']:1;
$perpage=($arbb->input['perpage'])?$arbb->input['perpage']:20;
$end=$page*$perpage;
$start=$end-$perpage;
$limit=$start.','.$perpage;
$done=array();

if($arbb->input['do']=='phpinfo')
{
 phpinfo();
 die();
}
elseif($arbb->input['do'] == 'manage')
{
 header("location:index.php?sid=$sid");
}
elseif(($arbb->input['do']=='sql')||($arbb->input['do']=='do_sql'))
{
$titleetc=$lang['adminmenu_sqlquery'].' - ';
if($arbb->input['do']=='sql')
{
$TP->WebTemp('maintenance_sql');
}
else
{
$querys=$arbb->input['querys'];

  if(eregi(';',$querys))
  {
   $ex = explode(';',$querys);
   foreach($ex as $query)
   {
    $DB->query($query);
   }

  }
  else
  {
   $DB->query($querys);
  }

  redirect($lang['querys_executed'],"maintenance.php?sid=$sid&do=sql&");
}

}
elseif($arbb->input['do']=='dbtools')
{
$titleetc=$lang['adminmenu_repairoptimize'].' - ';
$query = $DB->query("SHOW TABLE STATUS FROM `$db_name`");
$tables=array();
$i=1;
while($table = $DB->fetch_array($query))
{

if($i>2)
{
 $i=1;
}
$table['Data_length']=getsize($table['Data_length']);
$table['Index_length']=getsize($table['Index_length']);
$table['Data_free']=getsize($table['Data_free']);
$dbtables.=$TP->GetTemp('maintenance_dbtools_bit');

$i++;

}
$TP->WebTemp('maintenance_dbtools');

}
elseif($arbb->input['do']=='do_dbtools')
{

 $tables="`".implode('`,`',$arbb->input['tables']).'`';

   if($arbb->input['optimize']==1)
   {
     $DB->query("OPTIMIZE TABLE $tables;");
   }
   if($arbb->input['repair']==1)
   {
     $DB->query("REPAIR TABLE $tables;");
   }

   redirect($lang['optimized_and_repaired'],"maintenance.php?do=dbtools&sid=$sid");

}
elseif($arbb->input['do']=='counters')
{
$titleetc=$lang['adminmenu_updatecounters'].' - ';
$TP->WebTemp('maintenance_counter');
}
elseif($arbb->input['do']=='do_counter_stats')
{
$posts=$DB->num_rows($DB->query('select * from '._PREFIX_.'post'));
$threads=$DB->num_rows($DB->query('select * from '._PREFIX_.'thread'));
$users=$DB->num_rows($DB->query('select * from '._PREFIX_.'users'));
$nuser=$DB->query_now('select * from '._PREFIX_.'users order by userid DESC limit 1');

$array=array('threads'    => $threads,
             'users'      => $users,
             'posts'      => $posts,
             'nusersid'   => $nuser['userid'],
             'nusername'  => $nuser['username']);
foreach($array as $key => $val)
{
 $array[$key]=$DB->escape_string($val);
}
$DB->update($array,'stats',' 1=1');

redirect($lang['update'].' - '.$lang['done'],"maintenance.php?do=counters&sid=$sid");
}
elseif($arbb->input['do']=='do_counter_forums')
{
$query=$DB->query("select forumid,title from "._PREFIX_."forum limit $limit");
$query2=$DB->query("select forumid from "._PREFIX_."forum");
$num=$DB->num_rows($query2);
$pages=ceil($num/$perpage);
if($pages > $page)
{
 $nextpage=$page+1;
}
else
{
 $page='no';
}

while($f = $DB->fetch_array($query))
{
  updateforumcount($f[forumid]);
  $done[]="$lang[update] - $f[title] - $lang[done]";
}
$done=implode("<br>\n",$done);

      if($page=='no')
      {
       redirect($done."<br><br><br>$lang[done]","maintenance.php?sid=$sid&do=counters");
      }
      else
      {
       redirect($done,"maintenance.php?sid=$sid&do=do_counter_forums&page=$nextpage&perpage=$perpage");
      }

}
elseif($arbb->input['do']=='do_counter_threads')
{
$query=$DB->query("select threadid,title from "._PREFIX_."thread limit $limit");
$query2=$DB->query("select threadid from "._PREFIX_."thread");
$num=$DB->num_rows($query2);
$pages=ceil($num/$perpage);
if($pages > $page)
{
 $nextpage=$page+1;
}
else
{
 $page='no';
}

while($t = $DB->fetch_array($query))
{
$t=$bbcode->clearhtml($t);
  updatethreadcount($t[threadid]);
  $done[]="$lang[update] - $t[threadid] - $lang[done]";
}
$done=implode("<br>\n",$done);

      if($page=='no')
      {
       redirect($done."<br><br><br>$lang[done]","maintenance.php?sid=$sid&do=counters");
      }
      else
      {
       redirect($done,"maintenance.php?sid=$sid&do=do_counter_threads&page=$nextpage&perpage=$perpage");
      }
}
elseif($arbb->input['do']=='do_counter_posts')
{
$query=$DB->query("select postid,title from "._PREFIX_."post limit $limit");
$query2=$DB->query("select postid from "._PREFIX_."post");
$num=$DB->num_rows($query2);
$pages=ceil($num/$perpage);
if($pages > $page)
{
 $nextpage=$page+1;
}
else
{
 $page='no';
}

while($p = $DB->fetch_array($query))
{
  $p=$bbcode->clearhtml($p);
  updatepostcount($p['postid']);
  $done[]="$lang[update] - $p[postid] - $lang[done]";
}
$done=implode("<br>\n",$done);

      if($page=='no')
      {
       redirect($done."<br><br><br>$lang[done]","maintenance.php?sid=$sid&do=counters");
      }
      else
      {
       redirect($done,"maintenance.php?sid=$sid&do=do_counter_posts&page=$nextpage&perpage=$perpage");
      }
}
elseif($arbb->input['do']=='do_counter_users')
{
$query=$DB->query("select userid,username from "._PREFIX_."users limit $limit");
$query2=$DB->query("select userid from "._PREFIX_."users");
$num=$DB->num_rows($query2);
$pages=ceil($num/$perpage);
if($pages > $page)
{
 $nextpage=$page+1;
}
else
{
 $page='no';
}

while($u = $DB->fetch_array($query))
{
  $u=$bbcode->clearhtml($u);
  updateusercount($u['userid']);
  $done[]="$lang[update] - $u[userid] - $lang[done]";
}
$done=implode("<br>\n",$done);

      if($page=='no')
      {
       redirect($done."<br><br><br>$lang[done]","maintenance.php?sid=$sid&do=counters");
      }
      else
      {
       redirect($done,"maintenance.php?sid=$sid&do=do_counter_posts&page=$nextpage&perpage=$perpage");
      }
}
elseif($arbb->input['do']=='backups')
{
$titleetc=$lang['adminmenu_databasebackup'].' - ';
$query = $DB->query("SHOW TABLE STATUS FROM `$db_name`");
$tables=array();
$i=1;
while($table = $DB->fetch_array($query))
{
 if($i>2)
 {
  $i=1;
 }
$dbtables.=$TP->GetTemp('maintenance_backups_bit');
$i++;
}
$code=mydate('d').'-'.mydate('m').'-'.mydate('Y').'-'.random_string(7);
$TP->WebTemp('maintenance_backups');

}
elseif($arbb->input['do']=='do_backups')
{
$newfilename=$arbb->input['newfilename'];
     if($newfilename=='')
     {
      $newfilename='arbb_backup';
     }

if($arbb->input['a']=='u')
{
   if($arbb->input['type']=='gzip')
   {
     if(!function_exists('gzopen'))
     {
             error_message($lang['gzip_disabled']);
     }
    $fp = gzopen($newfilename.'.sql.gz','w9');
   }
   else
   {
    $fp = fopen($newfilename.'.sql','w');
   }

}
else
{
  if($arbb->input['type'] == 'gzip')
  {
    header('Content-Encoding: x-gzip');
    header('Content-Type: application/x-gzip');
    header('Content-Disposition: attachment; filename="'.$newfilename.'.sql.gz"');
  }
  else
  {
      header('Content-Type: text/x-sql');
      header('Content-Disposition: attachment; filename=arbb_backup.sql"');
  }
}

                $tablesq = $DB->query("show tables from $db_name");
                $tables=array();
                 while($d = $DB->fetch_array($tablesq))
                 {

                  $tables[]=$d['Tables_in_'.$db_name];
                 }

                 $tablesnames=implode(',',$tables);
                $tablesbuff=array();
                foreach($tables as $key => $tablename)
                {
                        $fields_list=array();
                $fieldsquery = $DB->query("SHOW FIELDS FROM ".$tablename.";");
               while($f=$DB->fetch_array($fieldsquery))
                {
                 $fields_list[]=$f['Field'];
                }
                $fields=implode(',',$fields_list);
                $query   = $DB->query("SHOW CREATE TABLE ".$tablename.";");
                $dbtable = $DB->fetch_array($query);
                $tablesbuff[$tablename].="\n\n# ----------- Table $tablename Structure ----------\n"
                                       .$dbtable['Create Table']
                                       .";\n# ----------- Table $tablename Contents ----------\n";

                $query = $DB->query('select * from '.$tablename.';');
                while($row = $DB->fetch_array($query))
                {
                $contents=array();
                 $tablesbuff[$tablename].="\nINSERT INTO `$tablename` VALUES (";
                 foreach($fields_list as $key => $val)
                 {
                  $contents[]="'".addslashes($row[$val])."'";
                 }

                 $tablesbuff[$tablename].=implode(',',$contents).');';
                }

                }
                $datee=date('dS F Y - H:i');
                $buffer ="\n#\tArBB Sql BackUp\n#\tDate : $datee\n";
                $buffer.= implode("",$tablesbuff);

   if($arbb->input['a']=='u')
   {
      if($arbb->input['type'] == 'gzip')
      {
         gzwrite($fp,$buffer);
      }
      else
      {
         fwrite($fp,$buffer);
      }

      redirect($lang['backup_successfully_saved'],"index.php?action=main&sid=$sid");
   }
   else
   {
      if($arbb->input['type'] == 'gzip')
      {
         echo gzencode($buffer);
      }
      else
      {
         echo $buffer;
      }
      die();
   }

}

if(!$titleetc)
{
    $titleetc=$lang['adminmenu_maintenance'].' - ';
}
print_page();
?>