<form action="style.php?do=do_style_delete&styleid=$styleid" method="post"> <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0">
    <tr class="tcat">
      <td width="100%" colspan="2" aliogn="center">$lang[style_delete] : (<b>$style[title]</b>)</td>
    </tr>
    <tr class="td1">
      <td width="100%" colspan="2">$lang[style_delete_confirm]<font color="#FF0000"> <b>$style[title]</b></font> ..<br>
      $lang[style_delete_confirm_note]</td>
      <tr class="thead">
      <td width="50%" align="center">
      <input type="submit" name="delete" value="$lang[delete]" size="30"></td>

      <td width="50%" align="center">
      <input type="button" name="back" value="$lang[back]" size="30" onclick="window.location='javascript:history.back();'"></td>
      <noscript><a href="lang.php?SID=$SID">$lang[back]</a></noscript></td>
      </tr>
  </table>