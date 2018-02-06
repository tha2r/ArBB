<br><br>
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td>$lang[quick_search]</td>
    </tr>
    <tr class="td1">
    <td>
    <ul>
      <li><a href="users.php?do=do_search">Show All Users</a></li>
      <li><a href="users.php?do=do_search&sortby=posts&order=DESC&perpage=30&limited=1">List Top Posters</a> </li>
      <li><a href="users.php?do=do_search&sortby=lastactivity&order=DESC">List Visitors in the Last 24 Hours</a> </li>
      <li><a href="users.php?do=do_search&sortby=joindate&order=DESC&perpage=30&limited=1">List New Registrations</a> </li>
      <li><a href="users.php?do=moderate">List Users Awaiting Moderation</a> </li>
      <li><a href="users.php?do=do_search&user[usergroupid]=4">Show All COPPA Users</a></li>
    </ul>
    </td>
</tr>
</table>
<br><br>
<form action="users.php" method="post">
<input name="do" value="do_search" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center" height="302">
	<tr class="tcat">
	<td colspan="2" height="19">
	$lang[adminmenu_usersearch]</td>
    </tr>
    <tr class="td1">
		<td>$lang[username]</td>
		<td>
        <input type="text" size="35" name="user[username]"></td>
    </tr>
    <tr class="td1">
		<td>$lang[user_group]</td>
		<td><select name="user[usergroupid]">$groupsoptions</select></td>
    </tr>
	<tr class="td1">
		<td>$lang[email]</td>
		<td>
        <input type="text" size="35" name="user[email]"></td>
    </tr>
	<tr>
	<td class="td1">$lang[homepage]</td>
	<td class="td1">
    <input type="text" class="bginput" name="user[homepage]" value="http://" size="25" maxlength="100"></td>
    </tr>
    <tr>
	<td class="td1">$lang[icq_number]</td>
	<td class="td1">
    <input type="text" class="bginput" name="user[icq]" size="25" maxlength="20"></td>
    </tr>
    <tr>
	<td class="td1">$lang[aol]</td>
	<td class="td1">
    <input type="text" class="bginput" name="user[aim]" size="25" maxlength="20"></td>
    </tr>
    <tr>
	<td class="td1">$lang[yahoo]</td>
	<td class="td1">
    <input type="text" class="bginput" name="user[yahoo]" size="25" maxlength="20"></td>
    </tr>
    <tr>
	<td class="td1">$lang[msn]</td>
	<td class="td1">
    <input type="text" class="bginput" name="user[msn]" size="25" maxlength="20"></td>
    </tr>
    <tr class="td1">
        <td class="thead" align="middle" colSpan="2">$lang[sort_by]</td>
      </tr>
      <tr>
        <td class="td1" vAlign="top">$lang[sort_by]</td>
        <td class="td1" vAlign="top"> <select name="sortby">
	<option value="username">$lang[username]</option>
	<option value="joindate">$lang[registration_date]</option>
	<option value="posts">$lang[posts]</option>
	<option value="lastactivity">$lang[last_activity]</option>
	</select> $lang[in] <select name="order">
	<option value="ASC">$lang[asc]</option>
	<option value="DESC">$lang[desc]</option>
	</select> </td>
      </tr>
      <tr>
        <td class="td1" vAlign="top" width="40%">$lang[results_perpage]</td>
        <td class="td1" vAlign="top" width="60%">
        <input class="inputbox" size="25" value="30" name="perpage">
        </td>
      </tr>
	<tr class="thead">
      <td width="100%" align="center" height="25" colspan="2">
      <input type="submit" name="add" value="  $lang[search]  " size="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="back" value="  $lang[back]  " size="30" onclick="window.location='javascript:history.back();'"></td>
	</tr>
    </table>
    &nbsp;</form>
    
    
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>