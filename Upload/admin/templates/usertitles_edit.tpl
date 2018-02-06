<form action="usertitles.php?sid=$sid&do=do_edit" method="post">
<input type="hidden" name="tid" value="$ut[usertitleid]">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[edit] : $ut[title]</td>
    </tr>
	<tr class="td1">
		<td>$lang[title]</td>
		<td>
        <input type="text" size="35" name="title" value="$ut[title]"></td>
    </tr>
    <tr class="td1">
		<td>$lang[min_posts]</td>
		<td>
        <input type="text" size="35" name="minposts" value="$ut[minposts]"></td>
    </tr>
	<tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="add" value="$lang[edit]" size="30"></td>
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