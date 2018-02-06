
<br><br>
<form action="style.php?do=templates&op=do_edit&styleid=$styleid&tpid=$tpl[templateid]" method="post" name="form">
<input type="hidden" name="do" value="templates">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="90%" align="center">
      <tr>
	<td class="tcat" align="center" colspan="3">
	$lang[edit_templates] : $tpl[title]</td>
</tr>
	<tr class="td1" align="center">
		<td>
    		<textarea name="template" rows="10" style="width:90%">$tpl[template]</textarea>
			</td>
</tr>
<tr>
	<td class="thead" align="center">
			<input type="submit" value="$lang[save]"> - <input type="reset" value="reset">
</td>
</tr>
<tr>
	<td class="td1" align="center">
&nbsp;
<a href="style.php?do=templates&styleid=$styleid">Go Back</a>

	</td>
</tr>
</table>
</form>
<div align="center">
        <div class="smallfont" align="center">
        $lang[powered_by] 
        </div>

        <div class="smallfont" align="center">
        $options[copyright_text]
        </div>
</div>