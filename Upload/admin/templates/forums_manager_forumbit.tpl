<form method="get" action="forums.php">
<input type="hidden" name="fid" value="$forum[forumid]">
<if condition="$show[cutoff]">
<tr class="thead">
<td colspan="3">&nbsp;</td>
</tr>
</if>
	<tr class="td$i">
		<td width="70%">
		<a target="_blank" href="../forumdisplay.php?fid=$forum[forumid]">$forum[title]</a>
		</td>
		<td width="20%">
    		<select name="do" onchange="window.location='forums.php?forumid=$forum[forumid]&do='+this.value" class="select">
    				<option value="edit" selected="selected">$lang[edit_forum]</option>
					<option value="add">$lang[add_subforum]</option>
					<option value="add_mod">$lang[add_moderator]</option>
					<option value="manage_mods">$lang[manage_moderator]</option>
					<option value="delete" style="color:#FF0000;">$lang[delete]</option>
    	</select>
			
			</td>
			<td width="10%">
			<input type="submit" value="$lang[go]">
			</td>
			</tr>
</form>