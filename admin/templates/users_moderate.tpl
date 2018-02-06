<p>
<br>
</p>
<form action="users.php?do=do_moderate" method="post">
 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" aliogn="center" colspan="4">lang[adminmenu_listcoppausers]</td>
    </tr>
<tr class="thead">
<td width="40%">$lang[username]</td>
<td width="40%" align="center">$lang[join_date]</td>
<td align="center" width="10%">$lang[active]</td>
<td align="center" width="10%">$lang[delete]</td>
</tr>
$modusers
    <tr class="thead">
      <td colspan="4" align="center"><input type="submit" name="submit" value="$lang[submit]"></td>
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