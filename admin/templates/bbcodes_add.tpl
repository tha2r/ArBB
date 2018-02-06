<br><br>
<form action="bbcodes.php" method="post">
<input name="do" value="do_add" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[adminmenu_addbbcode]</td>
    </tr>
	<tr class="td1">
		<td>$lang[bbcode_tag]<br>$lang[bbcode_tag_note]</td>
		<td><input type="text" name="tag" size="30"></td>
    </tr>
    <tr class="td1">
		<td>$lang[replacement]</td>
		<td>
        <textarea name="replacement" id="bbcode_replacement" rows="5" cols="50"></textarea>
		<div align="center"> <input type="button" onclick="return increase_textarea('bbcode_replacement');" value="$lang[increase_size]"> - <input type="button" onclick="return decrease_textarea('bbcode_replacement');" value="$lang[decrease_size]"></div>
		</td>
    </tr>
    <tr class="td1">
		<td>$lang[example]</td>
		<td><input type=text name="example" size="30"></td>
    </tr>
    <tr class="td1">
		<td>$lang[explanation]</td>
		<td>
		<textarea name="explanation" id="bbcode_explanation" rows="5"  cols="50"></textarea>
		<div align="center"> <input type="button" onclick="return increase_textarea('bbcode_explanation');" value="$lang[increase_size]"> - <input type="button" onclick="return decrease_textarea('bbcode_explanation');" value="$lang[decrease_size]"></div>
		    </tr>
    <tr class="td1">
		<td>$lang[bbcode_parms]<br>$lang[bbcode_parms_note]</td>
		
		<td>
		<select name="parms" style="width:200"><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>
		</td>
    </tr>
    <tr class="td1">
		<td>$lang[bbcode_image]</td>
		<td><input type=text name="image" size="30"></td>
    </tr>
	<tr class="thead">
      <td width="30%" align="center">
      <input type="submit" name="add" value="$lang[add]" size="30"></td>
      <td width="70%" align="center">
      <input type="button" name="back" value="$lang[back]" size="30" onclick="window.location='javascript:history.back();'"></td>
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
</div></textarea>