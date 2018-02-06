
<br><br>
<form action="lang.php" method="get" name="form">
<input type="hidden" name="do" value="lang_phrases">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="90%" align="center">
      <tr>
	<td class="tcat" align="center" colspan="3">
	$lang[edit_phrases]</td>
</tr>
	  <tr class="td1">
	<td>&nbsp;</td>
		<td colspan="2">
				$lang[select_lang_to_edit]
		</td>
		</tr>
	<tr class="td1">
	<td>&nbsp;</td>
		<td>
    		<select name="langid" style="width:200;" onchange="window.location='lang.php?do=lang_phrases&langid='+this.value" class="select" size="1">		
			
			
			$selectoptions
			</select>
			
			</td>
			<td>
			<input type="submit" value="$lang[go]">
			</td>
</tr>
<tr>
	<td class="thead" align="center" colspan="3">
&nbsp;
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