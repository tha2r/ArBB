	<tr class="td$i">
	<td>&nbsp;</td>
		<td>
				<a target="_blank" title="$lang[view_forums_using_this_lang]" href="../index.php?langid=$lng[languageid]">$lng[title]</a>
		</td>
		<td>
    		<select name="lang_$lng[languageid]" id="menu_$lng[languageid]" onchange="window.location='lang.php?langid=$lng[languageid]&do='+this.value" class="select">
    				<option value="lang_phrases" selected="selected">$lang[edit_phrases]</option>
					<option value="lang_edit">$lang[language_settings]</option>
					<option value="lang_delete" style="color:#FF0000;">$lang[delete_language]</option>
					<option value="downup">$lang[download_language]</option>
			</select>
			
			</td>
			<td>
			<input type="button" value="$lang[go]" onclick="lang_go($lng[languageid])">
			</td>
			<td>
					<input type="button" value="$lang[set_default]" title="$lang[set_default]" <if condition="$show[disabled]"> disabled="disabled" </if> onclick="window.location='lang.php?langid=$lng[languageid]&do=set_default'"></td></tr>