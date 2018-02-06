
<br>
<form action="style.php?do=do_$do&styleid=$styleid" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="3">$lang[manage_moderator] - $forumtitle</td>
    </tr>
$moderators
    <tr class="thead">
      <td width="200%" colspan="3">
      <p align="center">
         <input type="button" value="$lang[add_moderator]" onclick="window.location='forums.php?do=add_mod&forumid=$forumid'" name="addnew">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
         <input type="button" value="$lang[back]" onclick="window.location='javascript:history.back();'" name="back">      
</td>
    </tr>
    </table>
    &nbsp;</form>
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>