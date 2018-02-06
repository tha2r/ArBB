<p>
<br>
</p>
<form action="plugins.php?do=update" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="5">$lang[adminmenu_plugins]</td>
    </tr>
<tr class="thead">
<td width="30%">$lang[title]</td>
<td width="30%" align="center">$lang[location] - $lang[adminmenu_addplugin]</td>
<td align="center" width="10%">$lang[active]</td>
<td align="center" width="10%">$lang[edit]</td>
<td align="center" width="10%">$lang[delete]</td>
</tr>
$plugins
    <tr class="thead">
      <td width="200%" colspan="5">
      <p align="center">
      <input type="submit" value="$lang[update]" name="update"></td>
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