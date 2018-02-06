<tr class="td1">
		<td>
			$ug[opentag]$ug[title]$ug[closetag]
			<if condition="$ug[description]"><br><font class="smallfont">$ug[description]</font></if>
		</td>
        	<td align="center">
			<input type="button" value="$lang[edit] / $lang[set_perms]" onclick="window.location.href='usergroups.php?do=edit&gid=$ug[usergroupid]'">
		</td>
		<if condition="$show[subgroup]">
		<td align="center">
			<input type="button" value="$lang[delete]" onclick="window.location.href='usergroups.php?do=delete&gid=$ug[usergroupid]'">	
    	        </td>
    	        </if>
		
</tr>