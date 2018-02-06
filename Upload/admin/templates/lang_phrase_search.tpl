<form action="lang.php" method="post">
<input name="langid" value="$langid" type="hidden">
<input name="do" value="do_search" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[search_for_phrase]</td>
    </tr>
	<tr class="thead">
	<td colspan="2">$lang[search_for_phrase_note]</td>
    </tr>
    <tr class="td1">
		<td>$lang[phrase_title]</td>
		<td><input type="text" name="varname" size="35"></td>
    </tr>
    <tr class="td1">
		<td>$lang[phrase_text]</td>
		<td><input type="text" name="text" size="35"></td>
    </tr>
	<tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="search" value="$lang[search]" size="30"></td>
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