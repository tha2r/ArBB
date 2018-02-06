<p><br>
&nbsp;</p>
<form action="forums.php?sid=$sid&do=do_add_mod" name="cpugpform" method="post">
  <input type="hidden" value="$forum[forumid]" name="forumid">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[add_moderator] 
          : $forum[title]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[username]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="username" size="20"></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[forum]</td>
          <td class="td2" vAlign="top" width="60%"><select name="forumid" style="width:'200'">
          $forumsoptions</select></td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">Permissions</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">Can Edit Posts / Threads</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditpost" checked>&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="caneditpost">&nbsp;No</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">Can Delete  Posts / 
          Threads</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="candelposts" checked>&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no"name="candelposts">&nbsp;No</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">Can View IP Addresses</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canviewips" checked>&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no"name="canviewips">&nbsp;No</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">Can Move Threads To Forums 
          That He Does Not Moderate</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canmovethreads" checked>&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canmovethreads">&nbsp;No</label></td>
        </tr>
        </table>
   <br>
   <br>
   <table width="100%" align="center" class="table_border" cellSpacing="1" cellPadding="4" border="0">
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[add_moderator]" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="$lang[reset]" size="30"></td>
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