<tr class="td$i">
<td>$plugin[title]</td>
<td align="center">
<a title="$plugin[adminmenu_addplugins] - $plugin[place]" href="plugins.php?do=add&place=$plugin[place]">$plugin[place]</a></td>
<td align="center"><input type="checkbox" name="active[$plugin[pid]]" value="1" $checked></td>
<td align="center"><a href="plugins.php?do=edit&pid=$plugin[pid]" title="$lang[edit] - $plugin[title]">$lang[edit]</a></td>
<td align="center"><a href="plugins.php?do=delete&pid=$plugin[pid]" title="$lang[delete] - $plugin[title]">$lang[delete]</a></td></tr>