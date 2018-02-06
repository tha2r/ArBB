<p>
<br>
</p>
<form action="maintenance.php?do=do_dbtools&sid=$sid" method="post" name="tablesform">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="5">$lang[adminmenu_repairoptimize]</td>
    </tr>
<tr class="thead">
<td width="35%">$lang[table_name]</td>
<td width="15%" align="center">$lang[data_length]</td>
<td align="center" width="15%">$lang[index_length]</td>
<td align="center" width="15%">$lang[over_head]</td>
<td align="center" width="5%">
<input type="checkbox"  name="allbox" onclick="checkAll(tablesform);" checked value="ON"></td>
</tr>
$dbtables
    <tr class="thead">
      <td width="200%" colspan="5">
      <p align="center">
      &nbsp;</td>
    </tr>
    </table>
    
<br><br>
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="2">$lang[options]</td>
    </tr>
<tr class="td1">
<td>$lang[repair]</td>
<td><input type=checkbox name="repair" value="1" checked> $lang[yes]</td>
</tr>
<tr class="td2">
<td>$lang[optimize]</td>
<td><input type=checkbox name="optimize" value="1" checked> $lang[yes]</td>
</tr> 
    <tr class="thead">
      <td colspan="2">
      <p align="center">
      <input type=submit value="$lang[adminmenu_repairoptimize]"></td>
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