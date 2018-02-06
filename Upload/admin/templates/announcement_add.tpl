<p><br></p><form action="announcement.php" method="post">
<input name="do" value="do_add" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[adminmenu_addannouncement]</td>
    </tr>
	<tr class="td1">
		<td>$lang[announcement_forum]</td>
		<td><select name="forumid" style="width:200;">$forumoptions</select></td>
    </tr>
    <tr class="td1">
		<td>$lang[announcement_title]</td>
		<td>
        <input type="text" size="35" name="title"></td>
    </tr>
    <tr class="td1">
		<td>$lang[startdate]</td>
		<td><table class="tdf"><tr>
		<td dir="ltr" align="center">$lang[month]</td>
        <td dir="ltr" align="center">$lang[day]</td>
        <td dir="ltr" align="center">$lang[year]</td></tr><tr><td>
<select name="startmonth">
<option value="1"$msel[1] >$lang[month_1]</option>
<option value="2"$msel[2] >$lang[month_2]</option>
<option value="3"$msel[3] >$lang[month_3]</option>
<option value="4"$msel[4] >$lang[month_4]</option>
<option value="5"$msel[5] >$lang[month_5]</option>
<option value="6"$msel[6] >$lang[month_6]</option>
<option value="7"$msel[7] >$lang[month_7]</option>
<option value="8"$msel[8] >$lang[month_8]</option>
<option value="9"$msel[9] >$lang[month_9]</option>
<option value="10"$msel[10] >$lang[month_10]</option>
<option value="11"$msel[11] >$lang[month_11]</option>
<option value="12"$msel[12] >$lang[month_12]</option>
</select>
</td><td>
<input type="text" name="startday" size="5" value="$startday">
</td><td>
<input type="text" name="startyear" size="5" value="$startyear"></td>
    </tr></table></td>
    </tr>
    <tr class="td1">
		<td>$lang[enddate]</td>
		<td>
        <table class="tdf"><tr>
		<td align="center">$lang[month]</td><td align="center">$lang[day]</td>
        <td align="center">$lang[year]</td></tr><tr><td>
<select name="endmonth">
<option value="1"$msel2[1] >$lang[month_1]</option>
<option value="2"$msel2[2] >$lang[month_2]</option>
<option value="3"$msel2[3] >$lang[month_3]</option>
<option value="4"$msel2[4] >$lang[month_4]</option>
<option value="5"$msel2[5] >$lang[month_5]</option>
<option value="6"$msel2[6] >$lang[month_6]</option>
<option value="7"$msel2[7] >$lang[month_7]</option>
<option value="8"$msel2[8] >$lang[month_8]</option>
<option value="9"$msel2[9] >$lang[month_9]</option>
<option value="10"$msel2[10] >$lang[month_10]</option>
<option value="11"$msel2[11] >$lang[month_11]</option>
<option value="12"$msel2[12] >$lang[month_12]</option>
</select>
</td><td>
<input type="text" name="endday" size="5" value="$endday">
</td><td>
<input type="text" name="endyear" size="5" value="$endyear"></td>
    </tr></table></td>
    </tr>
    <tr class="td1">
		<td>$lang[announcement_text]</td>
		<td><textarea rows="5" cols="40" name="text"></textarea></td>
    </tr>
	<tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[add]" size="30"></td>
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