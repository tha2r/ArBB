<p>
<br>
</p>
<form action="maintenance.php?do=do_backups&a=d&sid=$sid" method="post" name="tablesform">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="2">$lang[adminmenu_databasebackup]</td>
    </tr>
<tr class="thead">
<td width="70%">$lang[table_name]</td>
<td align="center" width="30%">
<input type="checkbox"  name="allbox" onclick="checkAll(tablesform);" checked value="ON"></td>
</tr>
$dbtables
<tr class="thead">
<td colspan="2">&nbsp;</td></tr>
    <tr class="td1">
<td width="30%">$lang[save_as]</td>
<td width="70%">
<select name="type">
<option value="gzip">GZip</option>
<option value="sql">Sql</option>
</select></td>
    </tr>
    <tr class="thead">
      <td width="200%" colspan="2">
      <p align="center">
      <input type=submit value="  $lang[go]  ">&nbsp; --&nbsp;
      <input type=reset value="$lang[reset]"></td>
    </tr>
    </table>
    </form>
    
<br><br>
<form action="maintenance.php?do=do_backups&a=u&sid=$sid" method="post" name="up2file">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="2">$lang[backup_on_server_file]</td>
    </tr>
<tr class="td1">
<td colspan="2">$lang[backups_file_note]</td>
</tr>
    <tr class="td2">
<td width="30%">$lang[backups_file_condition]</td>
<td width="70%">
<input type="text" name="newfilename" value="./backup-$code" size="55"></td>
    </tr>
<tr class="td1">
<td width="30%">$lang[save_as]</td>
<td width="70%">
<select name="type">
<option value="gzip">GZip</option>
<option value="sql">Sql</option>
</select></td>
</tr> 
    <tr class="thead">
      <td colspan="2">
      <p align="center">
      <input type=submit value="   $lang[save]   "></td>
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