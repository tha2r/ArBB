<br>
<br>
<input type="button" value="$lang[add_usergroup]" class="tcat" style='height=30' onclick="window.location.href='usergroups.php?do=add'">
<br>
<br>
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="90%" align="center">
      <tr>
	<td class="tcat" align="center" colspan="5">
	$lang[primary_usergroups]
	</td>
</tr>
$primarygroups
<tr>
	<td class="thead" align="center" colspan="5">
&nbsp;
	</td>
</tr>
</table>
<if condition="$secondarygroups">
<br>
<br>
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="90%" align="center">
      <tr>
	<td class="tcat" align="center" colspan="5">
	$lang[secondary_usergroups]
	</td>
</tr>
$secondarygroups
<tr>
	<td class="thead" align="center" colspan="5">
&nbsp;
	</td>
</tr>
</table>
</if>
<div align="center">
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>

        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>