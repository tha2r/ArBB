<p><br>
&nbsp;</p>
<form action="smilies.php?sid=$sid&do=do_add_multi" method="post" name="smilies">
<input type=hidden name="cat" value="$cat">
      <table class="table_border" cellSpacing="1" cellPadding="6" width="100%" border="0">
        <tr>
          <td class="tcat" align="middle" colSpan="4">$lang[addsmilies_multiple]</td>
        </tr>
        <tr class="thead">
          <td vAlign="top" width="40%">$lang[filename]</td>
          <td vAlign="top" width="60%">$lang[title]</td>
          <td vAlign="top" width="60%">$lang[replacement_text]</td>
          <td vAlign="top" width="40%">
          <input type=checkbox name="allbox" onclick="checkAll(smilies);" value="ON"></td>
        </tr>
$smilies
	<tr class="tcat">
      <td width="50%" align="center" colspan="2">
      <input type="submit" name="add" value="$lang[add]" size="30"></td>
      <td width="50%" align="center" colspan="2">
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