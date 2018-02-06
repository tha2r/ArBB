<form action="style.php" method="get">
<table class="table_border" cellpadding="6" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat"><td colspan=2>
	$lang[adminmenu_stylemanage]</td>
    </tr>
	<tr class="td1">
		<td>
    		<select name="styleid" id="style_select" class="select">
			$styleoptions
			</select></td>
			<td rowspan="2">
			<input type="submit" value="$lang[go]">
			</td>
			</tr>
	<tr class="td1">
		<td>
    		<select name="do" id="do_select" class="select">
				<optgroup label="$lang[style_options]">
    					<option value="style_all" $select[style_all]>$lang[style_all_options]</option>
					<option value="style_edit" $select[style_edit]>$lang[style_edit_settings]</option>
					<option value="style_delete" $select[style_delete] style="color:#FF0000;">$lang[style_delete]</option>
					<option value="down" $select[down]>$lang[style_download]</option>
				</optgroup>
				<optgroup label="$lang[templates_options]">
					<option value="addtemplate" $select[addtemplate]>$lang[template_add]</option>
					<option value="style_templates" $select[style_templates]>$lang[edit_templates]</option>
				</optgroup>
				<optgroup label="$lang[css_colors_options]">
					<option value="style_css" $select[style_css]>$lang[edit_css]</option>
					<option value="style_stylevars" $select[style_stylevars]>$lang[edit_stylevars]</option>
				</optgroup>
			</select></td>
			</tr>
</table>
</form>
<form action="style.php?do=do_$do&styleid=$styleid" method="post">