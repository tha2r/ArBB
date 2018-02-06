<p><br>
&nbsp;</p>
<form action="avatars.php?sid=$sid&do=do_$do" method="post">
<input type=hidden name="catid" value="$cat[catid]">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="2">$lang[avatars] :&nbsp; <if condition="$show[add]">$lang[add_new_cat]<else>$lang[edit_cat] : <font color="red">$cat[title]</font></if></td>
        </tr>
        <tr>
          <td class="td1" vAlign="top" width="40%">$lang[title]</td>
          <td class="td1" vAlign="top" width="60%">
          <input type="text" name="title" size="32" value="$cat[title]"></td>
        </tr>
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$phrase" size="30"></td>
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