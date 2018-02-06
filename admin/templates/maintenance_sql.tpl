<p><br>
</p>
<form action="maintenance.php" method="post">
<input name="do" value="do_sql" type="hidden">
<table class="table_border" cellpadding="4" cellspacing="1" border="0" width="95%" align="center">
	<tr class="tcat">
	<td colspan="2">
	$lang[adminmenu_sqlquery]</td>
    </tr>
    <tr class="td1">
		<td width="30%">$lang[maintenance_sqlquery]</td>
		<td width="70%">
        <textarea name="querys" rows="6" cols="53"></textarea></td>
    </tr>
	<tr class="thead">
      <td width="100%" align="center" colspan="2">
      <input type="submit" name="add" value="$lang[adminmenu_sqlquery]" size="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="back" value="  $lang[back]  " size="30" onclick="window.location='javascript:history.back();'"></td>
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