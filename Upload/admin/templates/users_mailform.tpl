<p><br></p><form action="users.php" method="post">
<input name="do" value="do_sendmail" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[adminmenu_mailusers]</td>
    </tr>
	<tr class="td1">
		<td>$lang[from]</td>
		<td>
        <input type="text" name="from" size="30" maxlength="85" value="$options[sitetitle]"></td>
    </tr>
	<tr class="td1">
		<td>$lang[subject]</td>
		<td><input type="text" name="subject" size="30" maxlength="85">
    </tr>
    </tr>
	<tr class="td1">
		<td>$lang[group]</td>
		<td><select name="group">$groupsoptions</select></tr>
    <tr class="td1">
		<td width="30%">$lang[message]<br><font class="smallfont">$lang[message_send_explain_vars]</font></td>
	<td width="70%"><textarea rows="10" cols="50" name="message"></textarea></td>
    </tr>
	<tr class="td1">
		<td>$lang[users_per_round]</td>
		<td>
        <input type="text" name="perround" size="30" maxlength="85" value="500">
    </tr>
    </tr>
	<tr class="thead">
      <td align="center" colspan="2">
      <input type="submit" name="send" value="$lang[send]" size="30"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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