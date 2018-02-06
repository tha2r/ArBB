<br>
<form action="setting.php" method="get">
<input type="hidden" name="action" value="edit">
<table cellpadding="6" cellspacing="0" border="0" width="90%" class="table_border" align="center">
<tr>
<td class="tcat" colspan="2">$lang[edit_settings]</td>
</tr>
<tr>
<td class="thead" colspan="2">$lang[select_setting_group]</td>
</tr>
<tr>
<td width="30%" class="td1" valign="top">$lang[edit_settings_note]</td>
<td class="td1" width="70%" valign="top">
   <select class="td2" name="sgid" ondblclick="window.location.href='setting.php?action=edit&sgid='+sgid.value" size="11">
   <option value="-1"> --- $lang[edit_all_settings] --- </option>
   
   
   $settingselect
   </select>
</td>
<tr>
<td class="tcat" align="center" colspan="2"> <input type="submit" name="edit_settings" value="$lang[edit_settings]">
</td>
</tr>
</table>
</form>

<br>

<div align="center">
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>

        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>