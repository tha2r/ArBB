<br><br>
<form action="forums.php" method="post">
  <input type="hidden" value="do_edit" name="do">
  <input type="hidden" name="fid" value="$forum[forumid]">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[edit] : $forum[title]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[title]</td>
          <td class="td1" vAlign="top" width="60%">
          <input class="inputbox" size="25" name="title" value="$forum[title]"> </td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[description]</td>
          <td class="td2" vAlign="top" width="60%">
          <textarea name="description" rows="4" cols="40">$forum[description]</textarea></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[forum_link]<br><font class="smallfont">$lang[forum_link_description]</font></td>
          <td class="td1" vAlign="top" width="60%">
          <input class="inputbox" size="25" name="link" value="$forum[link]"> </td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[display_order]</td>
          <td class="td2" vAlign="top" width="60%">
          <input class="inputbox" size="4" value="$forum[displayorder]" name="displayorder"> </td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[parent_forum]</td>
          <td class="td1" vAlign="top" width="60%">
          <select name="mainid" style="width='300'">$forumsoptions</select></td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[set_password]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[use_forum_password]<br>
          <font class="smallfont">$lang[forum_password_description]</font></td>
          <td class="td1" vAlign="top" width="60%">
          <input type="radio" value="yes" name="canusepassword" $checked[canusepassword_yes]>&nbsp;$lang[yes]&nbsp;<input type="radio" value="no" name="canusepassword" $checked[canusepassword_no]>&nbsp;&nbsp;$lang[no]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[forum_password]</td>
          <td class="td1" vAlign="top" width="60%">
          <input class="inputbox" size="25" name="password" value="$forum[password]"> </td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[forum_posting_options]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[act_as_forum]<br>
          <font class="smallfont">$lang[act_as_forum_note]</font></td>
          <td class="td1" vAlign="top" width="60%"><input type="radio" $checked[isforum_yes] value="yes" name="isforum">&nbsp;$lang[yes]&nbsp;<input type="radio" value="no" $checked[isforum_no] name="isforum">&nbsp;&nbsp;$lang[no]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[forum_is_active]<br>
          <font class="smallfont">$lang[forum_is_active_note]</font></td>
          <td class="td2" vAlign="top" width="60%"><input type="radio" $checked[active_yes] value="yes" name="active">&nbsp;$lang[yes]&nbsp;<input type="radio" value="no" $checked[active_no] name="active">&nbsp;&nbsp;$lang[no]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[forum_is_open]<br>
          <font class="smallfont">$lang[forum_is_open_note]</font></td>
          <td class="td1" vAlign="top" width="60%"><input type="radio" $checked[open_yes] value="yes" name="open">&nbsp;$lang[yes]&nbsp;<input type="radio" $checked[open_no] value="no" name="open">&nbsp;&nbsp;$lang[no]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[display_options]</td>
          <td class="td1" vAlign="top" width="60%">$lang[sorted_by] - <select name="sortfield" style="width='200'">
                                <option value="lastpost" $sort[lastpost]>$lang[last_post_time]</option>
                                <option value="title" $sort[title]>$lang[thread_title]</option>
                                <option value="dateline" $sort[dateline]>$lang[thread_start_time]</option>
                                <option value="replycount" $sort[replycount]>$lang[thread_replies]</option>
                                <option value="views" $sort[views]>$lang[thread_visits]</option>
                                <option value="postusername" $sort[postusername]>$lang[thread_starter]</option>
                        </select></td>
        </tr>
    </tr>
    <tr class="thead">
    <td colspan="2">&nbsp;</td>
    </tr>
   </table>
   <br>
   <br>
   <table width="100%" align="center" class="table_border" cellSpacing="1" cellPadding="4" border="0">
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[edit]" size="30"></td>
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