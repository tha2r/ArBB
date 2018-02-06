<p><br>
&nbsp;</p>
<form action="usergroups.php?sid=$sid&do=do_add" method="post">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[add_usergroup]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[usersgroup_title]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" size="40" name="title"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[usersgroup_description]</td>
          <td class="td1" vAlign="top" width="60%">
          <textarea name="description" rows="4" cols="28"></textarea></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[users_title]<br><font class="smallfont">$lang[user_title_desc]</font></td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" size="40" name="usertitle"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[users_name_html]<br><font class="smallfont">$lang[users_name_html_note]</font></td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" size="15" name="opentag">&nbsp;
          <input type="text" size="15" name="closetag"></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[administration]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[is_forum_team]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" $checked[isforumteam1] name="isforumteam">&nbsp;$lang[yes]</label> &nbsp;&nbsp;<label><input type="radio" $checked[isforumteam0] value="no" name="isforumteam">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[is_moderator]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="ismoderator" $checked[ismoderator1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no"  $checked[ismoderator0] name="ismoderator">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[is_banned_group]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="isbanned"  $checked[isbanned1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no" name="isbanned"  $checked[isbanned0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_use_modcp]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="canusemodcp"  $checked[canusemodcp1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no" name="canusemodcp"  $checked[canusemodcp0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_use_admincp]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="canuseadmincp" $checked[canuseadmincp1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no"  $checked[canuseadmincp0] name="canuseadmincp">&nbsp;$lang[no]</label></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[global]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_use_usercp]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="canuseusercp" $checked[canuseusercp1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no"  $checked[canuseusercp0] name="canuseusercp">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_view_online]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" $checked[canviewonline1] name="canviewonline">&nbsp;$lang[yes]</label> &nbsp;&nbsp;<label><input type="radio" $checked[canviewonline0] value="no" name="canviewonline">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_view_ip]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="canviewip" $checked[canviewip1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no"  $checked[canviewip0] name="canviewip">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_search]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="cansearch"  $checked[cansearch1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no" name="cansearch"  $checked[cansearch0]>&nbsp;$lang[no]</label></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[viewing]</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_view_forum]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" $checked[canviewforum1] name="canviewforum">&nbsp;$lang[yes]</label> &nbsp;&nbsp;<label><input type="radio" $checked[canviewforum0] value="no" name="canviewforum">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_view_forum_threads]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="canviewthreads" $checked[canviewthreads1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no"  $checked[canviewthreads0] name="canviewthreads">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_view_thread_contents]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="canviewcontent"  $checked[canviewcontent1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no" name="canviewcontent"  $checked[canviewcontent0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_download_attachments]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes"  name="candownattach"  $checked[candownattach1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  value="no"  $checked[candownattach0] name="candownattach">&nbsp;$lang[no]</label></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[posting]
          / $lang[rating]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_post] $lang[threads]
          / $lang[posts]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canpost"   $checked[canpost1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"   $checked[canpost0] name="canpost">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_edit] $lang[own_posts_threads]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditpost"   $checked[caneditpost1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"   $checked[caneditpost0] name="caneditpost">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_delete_own_posts]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="candelposts"   $checked[candelposts1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  name="candelposts" $checked[candelposts0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_rate_thread]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canratethread"   $checked[canratethread1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  name="canratethread"  $checked[canratethread0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_post] $lang[attachment]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canpostattach"   $checked[canpostattach1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canpostattach"   $checked[canpostattach0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_edit] $lang[own_attachments]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditattach"  $checked[caneditattach1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio"  $checked[caneditattach0] value="no" name="caneditattach">&nbsp;$lang[no]</label></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[polls]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_post] $lang[polls]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canaddpoll"   $checked[canaddpoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canaddpoll"   $checked[canaddpoll0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_vote_on_polls]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canvotepoll"   $checked[canvotepoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  name="canvotepoll"  $checked[canvotepoll0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_edit_own_polls]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditpoll"   $checked[caneditpoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"   $checked[caneditpoll0] name="caneditpoll">&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_delete_own_polls]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="candelpoll"  $checked[candelpoll1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  name="candelpoll" $checked[candelpoll0]>&nbsp;$lang[no]</label></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: $lang[calendar]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_view_calendar]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canviewcalendar"   $checked[canviewcalendar1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canviewcalendar"   $checked[canviewcalendar0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[can_edit_events]</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditevents"   $checked[caneditevents1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"  name="caneditevents"  $checked[caneditevents0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_add_events]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canaddevents"   $checked[canaddevents1]>&nbsp;$lang[yes]</label>
          &nbsp;&nbsp;<label><input type="radio" value="no"   $checked[canaddevents0] name="canaddevents">&nbsp;$lang[no]</label></td>
        </tr>
  </table><br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: 
          $lang[pm]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[can_use_pm]</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="canusepm"   $checked[canusepm1]>&nbsp;$lang[yes]</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canusepm"   $checked[canusepm0]>&nbsp;$lang[no]</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[pm_max_quota]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" size="40" name="pmquota" value="$ug[pmquota]"></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[pm_max_recipient]</td>
          <td class="td2" vAlign="top" width="60%">
          <input type="text" size="40" name="pmsendmax" value="$ug[pmsendmax]"></td>
        </tr>
        </table>
        <br>
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="thead" align="middle" colSpan="2">$lang[permissions]: 
          $lang[other]</td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[attach_limit]</td>
          <td class="td2" vAlign="top" width="60%">
          <input type="text" size="40" name="attachlimit" value="$ug[attachlimit]"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[avatar_max_width]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" size="40" name="avatarmaxwidth" value="$ug[avatarmaxwidth]"></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[avatar_max_heigh]</td>
          <td class="td2" vAlign="top" width="60%">
          <input type="text" size="40" name="avatarmaxheigh" value="$ug[avatarmaxheigh]"></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[avatar_max_size]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" size="40" name="avatarmaxsize" value="$ug[avatarmaxsize]"></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">$lang[signature_max_images]</td>
          <td class="td2" vAlign="top" width="60%">
          <input type="text" size="40" name="sigmaximages" value="$ug[sigmaximages]"></td>
        </tr>
        </table>
        <br>
   <br>
   <br>
   <table width="100%" align="center" class="table_border" cellSpacing="1" cellPadding="4" border="0">
        <tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[add]" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="$lang[reset]" size="30"></td>
        </tr>
    </table><br>
    &nbsp;</form>
<div align="center">
<br><br>
        <div class="smallfont" align="center">
        $lang[powered_by]
        </div>
        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div></textarea>