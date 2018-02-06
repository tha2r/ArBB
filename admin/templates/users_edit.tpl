  
<form action="users.php?do=do_edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="userid" value="$user[userid]">
  <table class="table_border" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
 <tr>
    <td width="100%" colspan="2" class="tcat"><string>$lang[edit]</strong> : $user[username]</td>
  </tr>
  <tr>
    <td width="50%" class="td1">$lang[username]</td>
    <td width="50%" class="td1">
    <input name="username" size="25" value="$user[username]"></td>
  </tr>
  <tr>
    <td width="50%" class="td1">$lang[new_password]</td>
    <td width="50%" class="td1">
    <input name="new_password" size="25"></td>
  </tr>
    <tr>
    <td width="50%" class="td1">$lang[email]</td>
    <td width="50%" class="td1">
    <input name="email" size="25" type="text" value="$user[email]"></td>
  </tr>
 <tr>
	<td class="td1">$lang[user_group]</td>
	<td class="td1"><font class="smallfont">
	<select name="usergroupid">$groupoptions</select>
	</font></td>
 </tr>
 <tr>
    <td width="50%" class="td1">$lang[posts]</td>
    <td width="50%" class="td1">
    <input name="posts" size="25" type="text" value="$user[posts]"></td>
  </tr>
 <tr>
    <td width="50%" class="td1">$lang[ipaddress]</td>
    <td width="50%" class="td1">
    <input name="ipaddress" size="25" type="text" value="$user[ipaddress]"></td>
  </tr>
<tr>
	<td class="thead" colspan="2">$lang[edit_profile]</td>
</tr>
<tr>
	<td class="td1">$lang[homepage]:</td>
	<td class="td1"><b><input type="text" name="homepage" value="$user[homepage]" size="25" maxlength="100"></b></td>
</tr>
<tr>
	<td class="td1">$lang[icq_number]:</td>
	<td class="td1"><b><input type="text" name="icq" size="25" maxlength="20" value="$user[icq]"></b></td>
</tr>
<tr>
	<td class="td1">$lang[aol]:</td>
	<td class="td1"><b><input type="text" name="aim" size="25" maxlength="20" value="$user[aim]"></b></td>
</tr>
<tr>
	<td class="td1">$lang[yahoo]:</td>
	<td class="td1"><b><input type="text" name="yahoo" size="25" maxlength="20" value="$user[yahoo]"></b></td>
</tr>
<tr>
	<td class="td1">$lang[msn]:</td>
	<td class="td1">
    <b>
    <input type="text" class="bginput" name="msn" size="25" maxlength="20" value="$user[msn]"></b></td>
</tr>
    <tr>
    <td width="100%" colspan="2" class="thead"><string>$lang[edit_signature]</strong></td>
  </tr>
  <tr>
    <td width="100%" colspan="2" class="td1">
    <p align="center"><textarea name="signature" cols="50" rows="6">$user[signature]</textarea></td>
  </tr>
<tr>
	<td  class="thead" colspan="2">$lang[edit_options]</td>
</tr>
<tr>
	<td class="td1">$lang[default_style]:</td>
	<td class="td1"><font class="smallfont">
	<select name="styleid">
		<option value="-1">$lang[use_forum_default]</option>$styleoptions</select>
	</font></td>
</tr>
<tr>
	<td class="td1">$lang[use_email_notify]<br><font class="smallfont">
    $lang[use_email_notify_note]</font></td>
	<td class="td1">
		<input type="radio" name="autosubscribe" value="1" $sel[autosubscribeyes]> 
        $lang[yes]
		<input type="radio" name="autosubscribe" value="0" $sel[autosubscribeno]> 
        $lang[no]</td>
</tr>
<tr>
	<td class="td1">$lang[use_bbcode]?<br>
<font class="smallfont">$lang[use_bbcode_note]</font></td>
	<td class="td1">
		<input type="radio" name="showbbcode" value="1" $sel[showbbcodeyes]> $lang[yes]
		<input type="radio" name="showbbcode" value="0" $sel[showbbcodeno]> $lang[no]</td>
</tr>
<tr>
	<td class="td1">$lang[show_signature]?<br><font class="smallfont">$lang[show_signature_note]</font></td>
	<td class="td1">
		<input type="radio" name="showsignature" value="1" $sel[showsignatureyes]> 
        $lang[yes]
		<input type="radio" name="showsignature" value="0" $sel[showsignatureno]> 
        $lang[no]</td>
</tr>
<tr>
	<td class="td1">$lang[show_birthday]?<br>$lang[show_birthday_note]</td>
	<td class="td1">
		<input type="radio" name="showbirthday" value="1" $sel[showbirthdayyes]> 
        $lang[yes]
		<input type="radio" name="showbirthday" value="0" $sel[showbirthdayno]> 
        $lang[no]</td>
</tr>
<tr>
	<td class="td1">$lang[show_pm_popup]?<br><font class="smallfont">$lang[show_pm_popup_note]</font></td>
	<td class="td1">
		<input type="radio" name="pmpopup" value="1" $sel[pmpopupyes]> $lang[yes]
		<input type="radio" name="pmpopup" value="0" $sel[pmpopupno]> $lang[no]</td>
</tr>

  <tr class="tcat">
    <td align="center">
     <b>
     <input type="submit" value="$lang[submit]"></b>  
     </td>
     <td align="center">
     <input type="reset" value="$lang[reset]">  
    </td>
  </tr>
</table>
  </form>