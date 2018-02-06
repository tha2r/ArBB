<p>
<br>
</p>
<form action="users.php?do=ban&sid=$sid" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="3">$lang[adminmenu_viewbanedusers]</td>
    </tr>
<tr class="thead">
<td width="40%">$lang[username]</td>
<td width="40%" align="center">$lang[user_group]</td>
<td align="center" width="10%">$lang[lift_ban]</td>
</tr>
$bannedusers
    <tr class="thead">
      <td width="200%" colspan="3">
      <p align="center">
      <input type="submit" value="$lang[adminmenu_banuser]" name="addnew"></td>
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