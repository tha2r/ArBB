<script type="text/javascript">
        function check_custom()
        {
            if(document.cpugpform.usecustom[1].checked == false)
            {
                        if(confirm('$lang[usergroup_permissions_edit_confirm]'))
                        {
                     document.cpugpform.usecustom[1].checked=true;
                        }
                        else
                        {
                          return false;
                        }

            }
            else
            {
             return true;
            }

        }
</script>

<p><br>
&nbsp;</p>
<form action="forums.php?sid=$sid&do=do_editpermissions" name="cpugpform" method="post">
  <input type="hidden" value="$forum[forumid]" name="forumid">
  <input type="hidden" value="$group[usergroupid]" name="groupid">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[edit_permissions_for]
          : $group[title] $lang[in] $forum[title]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" colSpan="2"><label>
          <input type="radio" id="usedefaults" value="no" $checked[usecustom0] name="usecustom"> $lang[use_default_inherited_settings]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" colSpan="2"><label>
          <input type="radio" id="usecustom" value="yes" $checked[usecustom1] name="usecustom"> $lang[use_custom_settings]</label></td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[viewing]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_view_forum]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" onclick="check_custom();" $checked[canviewforum1] name="canviewforum">&nbsp;$lang[yes]</label> &nbsp;&nbsp;<label><input type="radio" $checked[canviewforum0] value="no" onclick="check_custom();" name="canviewforum">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_view_forum_threads]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" onclick="check_custom();"  name="canviewthreads" $checked[canviewthreads1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" onclick="check_custom();"  value="no"  $checked[canviewthreads0] name="canviewthreads">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_view_thread_contents]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" onclick="check_custom();"  name="canviewcontent"  $checked[canviewcontent1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" onclick="check_custom();"  value="no" name="canviewcontent"  $checked[canviewcontent0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_download_attachments]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" onclick="check_custom();"  name="candownattach"  $checked[candownattach1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" onclick="check_custom();"  value="no"  $checked[candownattach0] name="candownattach">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[posting]
          / $lang[rating]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_post] $lang[threads]
          / $lang[posts]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canpost" onclick="check_custom();"   $checked[canpost1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" onclick="check_custom();"   $checked[canpost0] name="canpost">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_edit] $lang[own_posts_threads]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditpost" onclick="check_custom();"   $checked[caneditpost1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" onclick="check_custom();"   $checked[caneditpost0] name="caneditpost">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_delete_own_posts]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="candelposts" onclick="check_custom();"   $checked[candelposts1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" onclick="check_custom();"  name="candelposts" $checked[candelposts0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_rate_thread]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canratethread" onclick="check_custom();"   $checked[canratethread1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" onclick="check_custom();"  name="canratethread"  $checked[canratethread0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_post] $lang[attachment]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canpostattach" onclick="check_custom();"   $checked[canpostattach1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canpostattach"  onclick="check_custom();"  $checked[canpostattach0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_edit] $lang[own_attachments]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditattach" onclick="check_custom();"  $checked[caneditattach1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" onclick="check_custom();"  $checked[caneditattach0] value="no" name="caneditattach">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[polls]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_post] $lang[polls]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canaddpoll" onclick="check_custom();"   $checked[canaddpoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canaddpoll" onclick="check_custom();"   $checked[canaddpoll0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_vote_on_polls]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canvotepoll"  onclick="check_custom();"  $checked[canvotepoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  onclick="check_custom();" name="canvotepoll"  $checked[canvotepoll0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_edit_own_polls]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditpoll" onclick="check_custom();"   $checked[caneditpoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  onclick="check_custom();"  $checked[caneditpoll0] name="caneditpoll">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_delete_own_polls]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="candelpoll" onclick="check_custom();"  $checked[candelpoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" onclick="check_custom();"  name="candelpoll" $checked[candelpoll0]>&nbsp;$lang[no]</label></td>
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