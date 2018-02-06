<form action="users.php?userid=$user[userid]">
<input type="hidden" name="userid" value="$user[userid]">
  <tr class="td1">
    <td><a href="users.php?do=edit&userid=$user[userid]">$user[username]</a></td>
    <td align="center">$user[email]</td>
    <td align="center">$user[joindate]</td>
    <td align="center">$user[posts]</td>
    <td align="center">$user[lastactivity]</td>
    <td>
    <select onchange="window.location.href='users.php?userid=$user[userid]&do='+this.value" name="do">
    <option value="edit" selected>View / Edit User</option>
    <option value="delete">Delete User</option>
    <option value="do_ban">$lang[adminmenu_banuser]</option>
    </select><input type="submit" value="$lang[go]"></td>
</tr>
</form>