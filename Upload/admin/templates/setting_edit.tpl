<br>
<form action="setting.php?action=do_edit" method="post">
<table cellpadding="6" cellspacing="0" border="0" width="90%" class="table_border" align="center">
<tr>
<td class="td1" width="70%" valign="top">
   <select class="td2" name="sgid" onchange="window.location.href='setting.php?action=edit&sgid='+sgid.value">
   <option value="-1"> --- $lang[edit_all_settings] --- </option>
   
   $settingselect
   </select>
</td>
</tr>
</table>
$settings
<if condition="!$show[all]">
<table cellpadding="4" cellspacing="0" border="0" width="90%" class="table_border" align="center">
<tr>
<td class="tcat" align="center" colspan="2">
<input type="submit" name="edit_settings" value="$lang[edit_settings]">
<input type="reset" name="reset_settings" title="$lang[reset]" value="$lang[reset]">
</td>
</tr>
</table>
</if>
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