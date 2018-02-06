<p><br></p><form action="users.php" method="post">
<input name="do" value="do_ban" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[adminmenu_banuser]</td>
    </tr>
    <tr class="td1">
		<td>$lang[username]</td>
		<td>
        <input type="text" size="35" name="username"></td>
    </tr>
    <tr class="td1">
		<td>$lang[to_user_group]</td>
		<td><select name="groupid" style="width:200;">$groupsoptions</select></td>
    </tr>
	<tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[adminmenu_banuser]" size="30"></td>
      <td width="50%" align="center">
      <input type="button" name="back" value="$lang[back]" size="30" onclick="window.location='javascript:history.back();'"></td>
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