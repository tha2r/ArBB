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
#    attachments File started
#
/*
        File name       -> attachment.php
        File Version    -> 1.0.0 Beta 1
        File Programmer -> Thaer
        File type       -> file
*/

// Used Templates list ,,

$templatelist='';

$phrasearray = array('');
chdir('../');
require('global.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Change Language</title>
</head>
<body><?
if(empty($arbb->input['act']))
{
$start=($arbb->input['start'])?$arbb->input['start']:0;
$query = $DB->query('select * from phrase order by pid asc limit '.$start.',100');
Echo "<form action='editphrases.php?act=ed' method='post'><table width=95% bgcolor='#c0c0c0'>";
 Echo "<tr bgcolor='#fcfcfc'>
 <td width=50%>Phrase</td>
 <td width=50%>Main Phrase</td>
 </tr>";
while($ph = $DB->fetch_array($query))
{
 Echo "<tr>
 <td>$ph[text]</td>
 <td><textarea name='id[$ph[pid]]'>".htmlspecialchars($ph[text])."</textarea></td>
 </tr>";
}

Echo "
<tr>
<td colspan='2' align='center'><input type=submit value='-- -- -- -- submit -- -- -- --'></td>
</tr>
</table>";
}
else
{

foreach($arbb->input['id'] as $key => $val)
{
$DB->query("update phrase set text='$val' where pid='$key'");
echo $key.' -> '.$val."\n<br>";
}

}
?>

</body>
</html>