<p><br>
&nbsp;</p>
<form action="avatars.php?sid=$sid&do=do_add_multi" method="post" name="avatarsform">
<input type=hidden name="cat" value="$cat">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="3">$lang[avatars] :&nbsp; <if condition="$show[add]">$lang[add_new_cat]<else>$lang[edit_cat] : <font color="red">$cat[title]</font></if></td>
        </tr>
        <tr class="thead">
          <td vAlign="top" width="40%">$lang[filename]</td>
          <td vAlign="top" width="60%">$lang[title]</td>
          <td vAlign="top" width="40%"><input type=checkbox name="allbox" onclick="checkAll(avatarsform);"></td>
        </tr>
$avatarbits
	<tr class="tcat">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[add]" size="30"></td>
      <td width="50%" align="center">
      <input type="reset" name="reset" value="$lang[reset]" size="30"></td>
      <td></td>
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