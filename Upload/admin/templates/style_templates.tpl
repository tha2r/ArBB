
<br><br>
<form action="style.php" method="get" name="form">
<input type="hidden" name="styleid" value="$styleid">
<input type="hidden" name="do" value="templates">
<input type="hidden" name="op" value="edit">

<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="90%" align="center">
      <tr>
	<td class="tcat" align="center" colspan="3">
	$lang[edit_templates]</td>
</tr>
	  <tr class="td1">
	<td>&nbsp;</td>
		<td colspan="2">
				$lang[select_templatetype_note]
		</td>
		</tr>
	<tr class="td1">
	<td>&nbsp;</td>
		<td>
    		<select name="tpid" style="width:459" ondblclick="window.location='style.php?do=templates&op=edit&styleid=$styleid&tpid='+this.value" class="select" size="20">
            $selectoptions</select>
			
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