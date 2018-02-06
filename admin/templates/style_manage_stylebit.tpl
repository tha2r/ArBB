	<tr class="td$i">
		<td><if condition="$show[img]"><img src="../cpstyles/$cpstyle[dir]/default.gif" title='$lang[default_style]'><else>&nbsp;</if></td>
		<td>
				<a href="../index.php?styleid=$st[styleid]" target="_blank" title="$lang[view_forums_using_this_style]">$st[title]</a>
		</td>
		<td>
    		<select name="style_$st[styleid]" id="menu_$st[styleid]" onchange="window.location='style.php?styleid=$st[styleid]&do='+this.value" class="select">
				<optgroup label="$lang[style_options]">
    				<option value="style_all" selected="selected">$lang[style_all_options]</option>
					<option value="style_edit">$lang[style_edit_settings]</option>
					<option value="style_delete" style="color:#FF0000;">$lang[style_delete]</option>
					<option value="down">$lang[style_download]</option>
				</optgroup>
				<optgroup label="$lang[templates_options]">
					<option value="addtemplate">$lang[template_add]</option>
					<option value="style_templates">$lang[edit_templates]</option>
				</optgroup>
				<optgroup label="$lang[css_colors_options]">
					<option value="style_css">$lang[edit_css]</option>
					<option value="style_stylevars">$lang[edit_stylevars]</option>
				</optgroup>
			</select>
			
			</td>
			<td>
			<input type="button" value="$lang[go]" onclick="style_go($st[styleid])">
			</td>
			<td>
					<input type="button" value="&laquo; &raquo;" title="$lang[expand_templates]" onclick="window.location='style.php?styleid=$st[styleid]&do=style_templates'"></td></tr>