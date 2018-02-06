<br>
<table cellpadding="6" cellspacing="0" border="0" width="90%" class="table_border" align="center">
<tr>
<td class="tcat" colspan="2">$cat[title]</td>
</tr>
$subsettings
<tr>
<if condition="$show[all]">
<td class="tcat" align="center" colspan="2">
 <input type="submit" name="edit_settings" title="$lang[edit_settings]" value="$lang[save]">
 <input type="reset" name="reset_settings" title="$lang[reset]" value="$lang[reset]">
</td>
<else>
<td class="tcat" align="$cpstyle[right]" colspan="2">
 <input type="submit" name="edit_settings" title="$lang[edit_settings]" value="$lang[save]">
</td>
</if>
</tr>
</table>
<br>