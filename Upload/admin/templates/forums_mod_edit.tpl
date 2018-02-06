<p><br>
&nbsp;</p>
<form action="forums.php?sid=$sid&do=do_edit_mod" method="post">
  <input type="hidden" value="$mod[modid]" name="modid">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[edit_moderator] : $mod[title]</td>
        </tr>
        <tr>
          <td class="thead" align="middle" colSpan="2">Permissions</td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">Can Edit Posts / Threads</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="caneditpost" $checked[caneditpost1]>&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="caneditpost" $checked[caneditpost0]>&nbsp;No</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">Can Delete  Posts / 
          Threads</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" name="candelposts" $checked[candelposts1]>&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="candelposts" $checked[candelposts0]>&nbsp;No</label></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">Can View IP Addresses</td>
          <td class="td1" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" $checked[canviewips1] name="canviewips">&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canviewips" $checked[canviewips0]>&nbsp;No</label></td>
        </tr>
        <tr>
          <td class="td2" vAlign="top" width="40%">Can Move Threads To Forums 
          That He Does Not Moderate</td>
          <td class="td2" vAlign="top" width="60%"><label>
          <input type="radio" value="yes" $checked[canmovethreads1] name="canmovethreads">&nbsp;Yes</label> 
          &nbsp;&nbsp;<label><input type="radio" value="no" name="canmovethreads" $checked[canmovethreads0]>&nbsp;No</label></td>
        </tr>
        </table>
   <br>
   <br>
   <table width="100%" align="center" class="table_border" cellSpacing="1" cellPadding="4" border="0">
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[edit_moderator]" size="30"></td>
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