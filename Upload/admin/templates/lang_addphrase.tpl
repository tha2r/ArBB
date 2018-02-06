<form action="lang.php" method="post">
<input name="langid" value="$langid" type="hidden">
<input name="do" value="do_add" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[add_phrase]</td>
    </tr>
	<tr class="td1">
		<td>$lang[phrase_type]</td>
		<td><select name="phrasetype" style="width:200;">$phrasetypeoptions</select></td>
    </tr>
    <tr class="td1">
		<td>$lang[phrase_title]</td>
		<td>
        <input type="text" value="$phrase[varname]" size="35" name="varname"></td>
    </tr>
    <tr class="td1">
		<td>$lang[phrase_text]</td>
		<td><textarea rows="5" cols="40" name="text">$phrase[text]</textarea></td>
    </tr>
	<tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="update" value="$lang[add_phrase]" size="30"></td>
      <td width="50%" align="center">
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
</div>