 <table class="table_border" cellSpacing="1" cellPadding="4" width="95%" align="center" border="0" height="137">
    <tr class="tcat">
      <td width="100%" colspan="2" aliogn="center">$lang[style_edit_settings] : $style[styleid] (<b>$style[title]</b>)</td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[default_style]</td>
      <td width="50%"><select name="defaultstyle">$defstyleoptions</select></td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[style_title]</td>
      <td width="50%">
      <input type="text" name="style[title]" value="$style[title]" size="30"></td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[allow_users_to_use]</td>
      <td width="50%">
        <input type="radio" $CHECKED[1] value="1" name="style[userselect]">$lang[yes]
        <input type="radio" $CHECKED[0] value="0" name="style[userselect]">$lang[no]
      </td>
    </tr>
    <tr class="td1">
      <td width="50%">$lang[images_dir]</td>
      <td width="50%">
      <input type="text" name="style[dir]" value="$style[dir]" size="30"></td>
    </tr>
  </table>