<p>
<br>
</p>
<form action="announcement.php?do=add&sid=$sid" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="4">$lang[announcements_manager]</td>
    </tr>
<tr class="thead">
<td width="40%">$lang[announcement_title]</td>
<td width="40%" align="center">$lang[forum] - $lang[adminmenu_addannouncement]</td>
<td align="center" width="10%">$lang[edit]</td>
<td align="center" width="10%">$lang[delete]</td>
</tr>
$announcements
    <tr class="thead">
      <td width="200%" colspan="4">
      <p align="center">
      <input type="submit" value="$lang[adminmenu_addannouncement]" name="addnew"></td>
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